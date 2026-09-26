<?php
session_start();
include "db.php";
include "mailer.php";
require_once __DIR__ . '/safepay/SafepayClient.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['safepay_pending_order'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$pending = $_SESSION['safepay_pending_order'];

$tracker   = $_GET['tracker'] ?? $_POST['tracker'] ?? '';
$signature = $_GET['sig']     ?? $_POST['sig']     ?? '';

$sfpyConfig = require __DIR__ . '/safepay/config.php';
$safepay    = new SafepayClient($sfpyConfig);

// The tracker Safepay redirected back with must match the one we opened,
// and it must match the one stored in this shopper's own session.
if ($tracker === '' || $tracker !== ($pending['tracker_token'] ?? null)) {
    header("Location: safepay_cancel.php?reason=tracker_mismatch");
    exit();
}

// A signature may not always be present depending on the Safepay account
// config — if it is present, it MUST be valid. If it's absent, we still
// rely on the server-to-server fetchTracker() call below as the real check.
if ($signature !== '' && !$safepay->verifySignature($tracker, $signature)) {
    error_log("[Safepay] signature mismatch for tracker $tracker");
    header("Location: safepay_cancel.php?reason=bad_signature");
    exit();
}

$statusResp = $safepay->fetchTracker($tracker);

$paid = false;
$state = null;
// The reporter/v2 response puts the tracker's fields directly under `data`
// (data.state, data.token, ...) — there is no nested data.data.tracker
// object. The old path here silently found nothing (!empty() on a
// non-existent key is just false), so a genuinely successful payment was
// being treated as unpaid. Confirmed against a real captured payment's raw
// response during testing.
if ($statusResp['ok'] && !empty($statusResp['data']['data']['state'])) {
    $state = $statusResp['data']['data']['state'];
    $paid  = ($state === 'TRACKER_ENDED');
}

$tok_esc = mysqli_real_escape_string($conn, $tracker);
$raw_esc = mysqli_real_escape_string($conn, $statusResp['raw'] ?? '');

if (!$statusResp['ok']) {
    // Couldn't confirm with Safepay (e.g. outbound request blocked on this
    // host). Do NOT mark the order paid on a guess — send the shopper to a
    // clear "couldn't confirm" page instead of silently trusting the redirect.
    error_log('[Safepay] fetchTracker failed for ' . $tracker . ': ' . ($statusResp['error'] ?? 'unknown'));
    mysqli_query($conn, "UPDATE payments SET status='unconfirmed', raw_response='$raw_esc' WHERE tracker_token='$tok_esc'");
    header("Location: safepay_cancel.php?reason=cannot_confirm");
    exit();
}

if (!$paid) {
    mysqli_query($conn, "UPDATE payments SET status='failed', raw_response='$raw_esc' WHERE tracker_token='$tok_esc'");
    header("Location: safepay_cancel.php?reason=payment_failed");
    exit();
}

mysqli_query($conn, "UPDATE payments SET status='paid', raw_response='$raw_esc' WHERE tracker_token='$tok_esc'");

// ---- Payment confirmed: now actually place the orders (mirrors order_place.php) ----

$name    = mysqli_real_escape_string($conn, $pending['name']);
$phone   = mysqli_real_escape_string($conn, $pending['phone']);
$address = mysqli_real_escape_string($conn, $pending['address']);
$city    = mysqli_real_escape_string($conn, $pending['city']);

$order_ids   = [];   // new order IDs, shown to the customer so they can track later
$order_lines = [];

foreach ($pending['cart_items'] as $item) {
    $price        = $item['price'];
    $discount     = $item['discount'];
    $final        = $price - ($price * $discount / 100);
    $subtotal     = $final * $item['quantity'];
    $ordered_qty  = (int) $item['quantity'];
    $product_id   = (int) $item['product_id'];
    $seller_email = $item['seller_email'];
    $seller_name  = $item['seller_name'];
    $product_name = $item['product_name'];
    $seller_id    = $item['seller_id'];

    mysqli_query($conn,
        "INSERT INTO orders (user_id, product_id, quantity, amount, name, phone, address, city, payment_method, payment_status, transaction_ref, status, created_at)
         VALUES ('$user_id', '$product_id', '$ordered_qty', '$subtotal', '$name', '$phone', '$address', '$city', 'safepay', 'paid', '$tok_esc', 'confirmed', NOW())"
    );

    $new_order_id  = mysqli_insert_id($conn);
    $order_ids[]   = $new_order_id;
    $order_lines[] = ['id' => $new_order_id, 'product' => $product_name, 'qty' => $ordered_qty, 'amount' => $subtotal];

    mysqli_query($conn,
        "UPDATE productadd SET quantity = quantity - $ordered_qty
         WHERE id = '$product_id' AND quantity >= $ordered_qty"
    );

    $qty_res   = mysqli_query($conn, "SELECT quantity FROM productadd WHERE id='$product_id'");
    $qty_row   = mysqli_fetch_assoc($qty_res);
    $remaining = $qty_row['quantity'];

    $order_body = "
    <div style='font-family:Arial,sans-serif;max-width:600px;margin:auto;border:1px solid #eee;border-radius:12px;overflow:hidden;'>
        <div style='background:#4b2c2c;padding:20px;text-align:center;'>
            <h2 style='color:white;margin:0;'>🛒 New Order Received (Paid via Safepay)!</h2>
        </div>
        <div style='padding:25px;'>
            <p>Hello <b>$seller_name</b>,</p>
            <p>You have received a new <b>paid</b> order on <b>Intra Decor Home</b>!</p>
            <table style='width:100%;border-collapse:collapse;margin:15px 0;'>
                <tr style='background:#f5f0f0;'><td style='padding:10px;font-weight:bold;'>Product</td><td style='padding:10px;'>$product_name</td></tr>
                <tr><td style='padding:10px;font-weight:bold;'>Quantity Ordered</td><td style='padding:10px;'>$ordered_qty</td></tr>
                <tr style='background:#f5f0f0;'><td style='padding:10px;font-weight:bold;'>Remaining Stock</td><td style='padding:10px;'>$remaining</td></tr>
                <tr><td style='padding:10px;font-weight:bold;'>Amount</td><td style='padding:10px;'>Rs. " . number_format($subtotal, 0) . "</td></tr>
                <tr style='background:#f5f0f0;'><td style='padding:10px;font-weight:bold;'>Payment</td><td style='padding:10px;'>Safepay (Paid)</td></tr>
            </table>
            <h3 style='color:#4b2c2c;'>Buyer Details:</h3>
            <table style='width:100%;border-collapse:collapse;'>
                <tr style='background:#f5f0f0;'><td style='padding:10px;font-weight:bold;'>Name</td><td style='padding:10px;'>{$pending['name']}</td></tr>
                <tr><td style='padding:10px;font-weight:bold;'>Phone</td><td style='padding:10px;'>{$pending['phone']}</td></tr>
                <tr style='background:#f5f0f0;'><td style='padding:10px;font-weight:bold;'>Address</td><td style='padding:10px;'>{$pending['address']}, {$pending['city']}</td></tr>
            </table>
            <div style='background:#e8f5e9;padding:15px;border-radius:8px;margin-top:15px;'>
                <p style='margin:0;color:#2e7d32;'>✅ Login to your seller dashboard to confirm this order.</p>
            </div>
        </div>
        <div style='background:#f5f0f0;padding:15px;text-align:center;font-size:12px;color:#888;'>Intra Decor Home &copy; 2025</div>
    </div>";

    sendEmail($seller_email, "New Paid Order Received — $product_name", $order_body);

    $notif_msg = mysqli_real_escape_string($conn,
        "💳 New PAID (Safepay) order for '$product_name' — Ordered: $ordered_qty — Remaining stock: $remaining"
    );
    mysqli_query($conn,
        "INSERT INTO notifications (seller_id, message, is_read, created_at)
         VALUES ('$seller_id', '$notif_msg', 0, NOW())"
    );
}

mysqli_query($conn, "DELETE FROM cart WHERE user_id='$user_id'");

// ---- Send the customer an order confirmation with their Order ID(s) ----
$cust_res   = mysqli_query($conn, "SELECT email FROM users WHERE id='" . intval($user_id) . "'");
$cust_row   = $cust_res ? mysqli_fetch_assoc($cust_res) : null;
$cust_email = $cust_row['email'] ?? '';

$scheme    = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$base_path = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
$track_url = $scheme . '://' . $_SERVER['HTTP_HOST'] . $base_path . '/Track-order.php';

if ($cust_email !== '' && !empty($order_lines)) {
    $rows = '';
    foreach ($order_lines as $i => $ol) {
        $bg    = ($i % 2 == 0) ? "background:#f5f0f0;" : "";
        $rows .= "<tr style='$bg'><td style='padding:10px;font-weight:bold;'>#{$ol['id']}</td>"
               . "<td style='padding:10px;'>" . htmlspecialchars($ol['product']) . " &times; {$ol['qty']}</td>"
               . "<td style='padding:10px;'>Rs. " . number_format($ol['amount'], 0) . "</td></tr>";
    }
    $cust_body = "
    <div style='font-family:Arial,sans-serif;max-width:600px;margin:auto;border:1px solid #eee;border-radius:12px;overflow:hidden;'>
        <div style='background:#4b2c2c;padding:20px;text-align:center;'>
            <h2 style='color:white;margin:0;'>✅ Your Order is Confirmed!</h2>
        </div>
        <div style='padding:25px;'>
            <p>Hello <b>" . htmlspecialchars($pending['name']) . "</b>,</p>
            <p>Thank you for shopping with <b>Intra Decor Home</b>. Your payment was received through Safepay.</p>
            <table style='width:100%;border-collapse:collapse;margin:15px 0;'>
                <tr style='background:#4b2c2c;color:white;'><td style='padding:10px;'>Order ID</td><td style='padding:10px;'>Product</td><td style='padding:10px;'>Amount</td></tr>
                $rows
            </table>
            <div style='background:#fff8e1;padding:15px;border-radius:8px;'>
                <p style='margin:0 0 6px;'><b>Track your order anytime:</b></p>
                <p style='margin:0;'>Open <a href='$track_url'>Track Order</a> and enter your <b>Order ID</b> and phone number <b>" . htmlspecialchars($pending['phone']) . "</b>.</p>
            </div>
        </div>
        <div style='background:#f5f0f0;padding:15px;text-align:center;font-size:12px;color:#888;'>Intra Decor Home</div>
    </div>";
    sendEmail($cust_email, "Order Confirmed — Order #" . implode(', #', $order_ids), $cust_body);
}

// Reuse the exact structure order_confirm.php already expects
$_SESSION['last_order'] = [
    'name'           => $pending['name'],
    'phone'          => $pending['phone'],
    'address'        => $pending['address'],
    'city'           => $pending['city'],
    'payment_method' => 'safepay',
    'grand_total'    => $pending['grand_total'],
    'items_count'    => count($pending['cart_items']),
    'order_ids'      => $order_ids,
];

unset($_SESSION['safepay_pending_order']);

header("Location: order_confirm.php");
exit();