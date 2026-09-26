<?php
session_start();
include "db.php";
include "mailer.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$name           = mysqli_real_escape_string($conn, $_POST['name']);
$phone          = mysqli_real_escape_string($conn, $_POST['phone']);
$address        = mysqli_real_escape_string($conn, $_POST['address']);
$city           = mysqli_real_escape_string($conn, $_POST['city']);
$payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);

// Cart items fetch with seller info
$cart_query = "SELECT cart.*, productadd.price, productadd.discount, 
               productadd.quantity as stock, productadd.name as product_name,
               productadd.seller_id,
               users.email as seller_email, users.name as seller_name
               FROM cart
               JOIN productadd ON cart.product_id = productadd.id
               JOIN users ON productadd.seller_id = users.id
               WHERE cart.user_id = '$user_id'";
$cart_result = mysqli_query($conn, $cart_query);

if(mysqli_num_rows($cart_result) == 0){
    header("Location: cart.php");
    exit();
}

$grand_total = 0;
$cart_items  = [];

while($row = mysqli_fetch_assoc($cart_result)){
    $price    = $row['price'];
    $discount = $row['discount'];
    $final    = $price - ($price * $discount / 100);
    $subtotal = $final * $row['quantity'];
    $grand_total += $subtotal;
    $cart_items[] = $row;
}

foreach($cart_items as $item){
    $price        = $item['price'];
    $discount     = $item['discount'];
    $final        = $price - ($price * $discount / 100);
    $subtotal     = $final * $item['quantity'];
    $ordered_qty  = $item['quantity'];
    $product_id   = $item['product_id'];
    $seller_email = $item['seller_email'];
    $seller_name  = $item['seller_name'];
    $product_name = $item['product_name'];
    $seller_id    = $item['seller_id'];

    // Order insert
    mysqli_query($conn,
        "INSERT INTO orders (user_id, product_id, quantity, amount, name, phone, address, city, payment_method, status, created_at)
         VALUES ('$user_id', '$product_id', '$ordered_qty', '$subtotal', '$name', '$phone', '$address', '$city', '$payment_method', 'pending', NOW())"
    );

    // Quantity kam karo
    mysqli_query($conn,
        "UPDATE productadd SET quantity = quantity - $ordered_qty 
         WHERE id = '$product_id' AND quantity >= $ordered_qty"
    );

    // Remaining quantity check
    $qty_res   = mysqli_query($conn, "SELECT quantity FROM productadd WHERE id='$product_id'");
    $qty_row   = mysqli_fetch_assoc($qty_res);
    $remaining = $qty_row['quantity'];

    // ===== NEW ORDER EMAIL =====
    $order_body = "
    <div style='font-family:Arial,sans-serif;max-width:600px;margin:auto;border:1px solid #eee;border-radius:12px;overflow:hidden;'>
        <div style='background:#4b2c2c;padding:20px;text-align:center;'>
            <h2 style='color:white;margin:0;'>🛒 New Order Received!</h2>
        </div>
        <div style='padding:25px;'>
            <p>Hello <b>$seller_name</b>,</p>
            <p>You have received a new order on <b>Intra Decor Home</b>!</p>
            <table style='width:100%;border-collapse:collapse;margin:15px 0;'>
                <tr style='background:#f5f0f0;'><td style='padding:10px;font-weight:bold;'>Product</td><td style='padding:10px;'>$product_name</td></tr>
                <tr><td style='padding:10px;font-weight:bold;'>Quantity Ordered</td><td style='padding:10px;'>$ordered_qty</td></tr>
                <tr style='background:#f5f0f0;'><td style='padding:10px;font-weight:bold;'>Remaining Stock</td><td style='padding:10px;'>$remaining</td></tr>
                <tr><td style='padding:10px;font-weight:bold;'>Amount</td><td style='padding:10px;'>Rs. " . number_format($subtotal, 0) . "</td></tr>
                <tr style='background:#f5f0f0;'><td style='padding:10px;font-weight:bold;'>Payment</td><td style='padding:10px;'>$payment_method</td></tr>
            </table>
            <h3 style='color:#4b2c2c;'>Buyer Details:</h3>
            <table style='width:100%;border-collapse:collapse;'>
                <tr style='background:#f5f0f0;'><td style='padding:10px;font-weight:bold;'>Name</td><td style='padding:10px;'>$name</td></tr>
                <tr><td style='padding:10px;font-weight:bold;'>Phone</td><td style='padding:10px;'>$phone</td></tr>
                <tr style='background:#f5f0f0;'><td style='padding:10px;font-weight:bold;'>Address</td><td style='padding:10px;'>$address, $city</td></tr>
            </table>
            <div style='background:#e8f5e9;padding:15px;border-radius:8px;margin-top:15px;'>
                <p style='margin:0;color:#2e7d32;'>✅ Login to your seller dashboard to confirm this order.</p>
            </div>
        </div>
        <div style='background:#f5f0f0;padding:15px;text-align:center;font-size:12px;color:#888;'>Intra Decor Home &copy; 2025</div>
    </div>";

    sendEmail($seller_email, "New Order Received — $product_name", $order_body);

    // ===== OUT OF STOCK EMAIL =====
    if($remaining <= 0){
        $out_body = "
        <div style='font-family:Arial,sans-serif;max-width:600px;margin:auto;border:1px solid #eee;border-radius:12px;overflow:hidden;'>
            <div style='background:#e74c3c;padding:20px;text-align:center;'>
                <h2 style='color:white;margin:0;'>⚠️ Out of Stock Alert!</h2>
            </div>
            <div style='padding:25px;'>
                <p>Hello <b>$seller_name</b>,</p>
                <p>Your product <b>$product_name</b> is now <b style='color:red;'>OUT OF STOCK!</b></p>
                <p>Please update your stock in the seller dashboard.</p>
            </div>
            <div style='background:#f5f0f0;padding:15px;text-align:center;font-size:12px;color:#888;'>Intra Decor Home &copy; 2025</div>
        </div>";

        sendEmail($seller_email, "⚠️ Out of Stock — $product_name", $out_body);

        $out_msg = mysqli_real_escape_string($conn, "⚠️ '$product_name' is OUT OF STOCK!");
        mysqli_query($conn,
            "INSERT INTO notifications (seller_id, message, is_read, created_at)
             VALUES ('$seller_id', '$out_msg', 0, NOW())"
        );
    }

    // ===== LOW STOCK EMAIL (5 ya kam) =====
    elseif($remaining <= 5){
        $low_body = "
        <div style='font-family:Arial,sans-serif;max-width:600px;margin:auto;border:1px solid #eee;border-radius:12px;overflow:hidden;'>
            <div style='background:#f39c12;padding:20px;text-align:center;'>
                <h2 style='color:white;margin:0;'>⚡ Low Stock Alert!</h2>
            </div>
            <div style='padding:25px;'>
                <p>Hello <b>$seller_name</b>,</p>
                <p>Your product <b>$product_name</b> has only <b style='color:orange;'>$remaining items left!</b></p>
                <p>Please restock soon to avoid losing sales.</p>
            </div>
            <div style='background:#f5f0f0;padding:15px;text-align:center;font-size:12px;color:#888;'>Intra Decor Home &copy; 2025</div>
        </div>";

        sendEmail($seller_email, "⚡ Low Stock Alert — $product_name", $low_body);
    }

    // ===== DASHBOARD NOTIFICATION =====
    $notif_msg = mysqli_real_escape_string($conn,
        "🛒 New order for '$product_name' — Ordered: $ordered_qty — Remaining stock: $remaining"
    );
    mysqli_query($conn,
        "INSERT INTO notifications (seller_id, message, is_read, created_at)
         VALUES ('$seller_id', '$notif_msg', 0, NOW())"
    );
}

// Cart khali karo
mysqli_query($conn, "DELETE FROM cart WHERE user_id='$user_id'");

$_SESSION['last_order'] = [
    'name'           => $name,
    'phone'          => $phone,
    'address'        => $address,
    'city'           => $city,
    'payment_method' => $payment_method,
    'grand_total'    => $grand_total,
    'items_count'    => count($cart_items)
];

header("Location: order_confirm.php");
exit();
?>