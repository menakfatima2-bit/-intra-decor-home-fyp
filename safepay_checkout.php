<?php
session_start();
include "db.php";
require_once __DIR__ . '/safepay/SafepayClient.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$name    = trim($_POST['name'] ?? '');
$phone   = trim($_POST['phone'] ?? '');
$address = trim($_POST['address'] ?? '');
$city    = trim($_POST['city'] ?? '');

if ($name === '' || $phone === '' || $address === '' || $city === '') {
    header("Location: checkout.php");
    exit();
}

// Snapshot the cart the same way checkout.php / order_place.php do
$cart_query = "SELECT cart.*, productadd.price, productadd.discount,
               productadd.quantity as stock, productadd.name as product_name,
               productadd.seller_id,
               users.email as seller_email, users.name as seller_name
               FROM cart
               JOIN productadd ON cart.product_id = productadd.id
               JOIN users ON productadd.seller_id = users.id
               WHERE cart.user_id = '$user_id'";
$cart_result = mysqli_query($conn, $cart_query);

if (!$cart_result || mysqli_num_rows($cart_result) == 0) {
    header("Location: cart.php");
    exit();
}

$grand_total = 0;
$cart_items  = [];

while ($row = mysqli_fetch_assoc($cart_result)) {
    $final    = $row['price'] - ($row['price'] * $row['discount'] / 100);
    $subtotal = $final * $row['quantity'];
    $grand_total += $subtotal;
    $cart_items[] = $row;
}

if ($grand_total <= 0) {
    header("Location: cart.php");
    exit();
}

// Save everything we'll need once the shopper comes back from Safepay.
// We deliberately do NOT touch the orders table / stock / cart yet —
// that only happens once safepay_return.php confirms the payment actually went through.
$_SESSION['safepay_pending_order'] = [
    'name'        => $name,
    'phone'       => $phone,
    'address'     => $address,
    'city'        => $city,
    'grand_total' => $grand_total,
    'cart_items'  => $cart_items,
];

$order_ref = 'IDH-' . $user_id . '-' . time();

$sfpyConfig = require __DIR__ . '/safepay/config.php';
$safepay    = new SafepayClient($sfpyConfig);

$sessionResp = $safepay->createSession($grand_total, $sfpyConfig['currency'], 'CYBERSOURCE');

if (isset($_GET['debug'])) {
    header('Content-Type: text/plain');
    echo "Session create response:\n";
    print_r($sessionResp);
}

if (!$sessionResp['ok'] || empty($sessionResp['data']['data']['tracker']['token'])) {
    error_log('[Safepay] session create failed: ' . ($sessionResp['error'] ?? 'unknown') . ' | raw: ' . ($sessionResp['raw'] ?? ''));
    unset($_SESSION['safepay_pending_order']);
    if (isset($_GET['debug'])) { exit(); }
    header("Location: safepay_cancel.php?reason=init_failed");
    exit();
}

$tracker_token = $sessionResp['data']['data']['tracker']['token'];

$passportResp = $safepay->createPassportToken();

if (isset($_GET['debug'])) {
    echo "\n\nPassport token response:\n";
    print_r($passportResp);
}

if (!$passportResp['ok'] || empty($passportResp['data']['data'])) {
    error_log('[Safepay] passport token failed: ' . ($passportResp['error'] ?? 'unknown') . ' | raw: ' . ($passportResp['raw'] ?? ''));
    unset($_SESSION['safepay_pending_order']);
    if (isset($_GET['debug'])) { exit(); }
    header("Location: safepay_cancel.php?reason=init_failed");
    exit();
}

$tbt = $passportResp['data']['data'];

// Log the attempt so you can show/reconcile it during your defense
$amt_esc   = mysqli_real_escape_string($conn, $grand_total);
$tok_esc   = mysqli_real_escape_string($conn, $tracker_token);
$raw_esc   = mysqli_real_escape_string($conn, $sessionResp['raw']);
mysqli_query($conn, "INSERT INTO payments (user_id, tracker_token, amount, currency, status, raw_response, created_at)
    VALUES ('$user_id', '$tok_esc', '$amt_esc', '{$sfpyConfig['currency']}', 'initiated', '$raw_esc', NOW())");

$_SESSION['safepay_pending_order']['tracker_token'] = $tracker_token;

$redirect_url = site_url('safepay_return.php');
$cancel_url   = site_url('safepay_cancel.php');

$checkout_url = $safepay->buildCheckoutUrl($tracker_token, $tbt, $order_ref, $redirect_url, $cancel_url);

if (isset($_GET['debug'])) {
    echo "\n\nTracker token: $tracker_token\n";
    echo "TBT: $tbt\n";
    echo "\nFinal checkout URL:\n$checkout_url\n";
    exit();
}

error_log('[Safepay] redirecting to: ' . $checkout_url);

header("Location: " . $checkout_url);
exit();

function site_url($path)
{
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host   = $_SERVER['HTTP_HOST'];
    $dir    = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
    return "$scheme://$host$dir/$path";
}
