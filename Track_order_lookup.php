<?php
/**
 * track_order_lookup.php
 * Guest order tracking: looks up an order by Order ID + Phone number
 * (both were collected at checkout in order_place.php), without requiring login.
 */

include 'db.php';
header('Content-Type: application/json');

function respond($status, $message, $order = null) {
    $out = ['status' => $status, 'message' => $message];
    if ($order !== null) $out['order'] = $order;
    echo json_encode($out);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond('error', 'Invalid request.');
}

$order_id = trim($_POST['order_id'] ?? '');
$phone    = trim($_POST['phone'] ?? '');

if (empty($order_id) || empty($phone)) {
    respond('error', 'Please enter both Order ID and phone number.');
}

if (!ctype_digit($order_id)) {
    respond('error', 'Order ID should contain numbers only.');
}

$order_id_esc = mysqli_real_escape_string($conn, $order_id);

// Normalize phone by stripping spaces/dashes for a more forgiving match
$phone_digits = preg_replace('/\D/', '', $phone);

$query = "SELECT orders.*, productadd.name AS product_name, productadd.product_image
          FROM orders
          JOIN productadd ON orders.product_id = productadd.id
          WHERE orders.id = '$order_id_esc'";

$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    respond('error', 'No order found with that Order ID.');
}

$row = mysqli_fetch_assoc($result);
$stored_phone_digits = preg_replace('/\D/', '', $row['phone']);

if ($stored_phone_digits !== $phone_digits) {
    respond('error', 'Order ID and phone number do not match our records.');
}

$statusLabels = [
    'pending'   => 'Pending',
    'confirmed' => 'Confirmed',
    'delivered' => 'Delivered',
    'cancelled' => 'Cancelled',
];
$status = strtolower($row['status']);
$statusLabel = $statusLabels[$status] ?? ucfirst($row['status']);

$order = [
    'id'             => $row['id'],
    'product_name'   => $row['product_name'],
    'image'          => 'uploads/' . $row['product_image'],
    'amount'         => number_format($row['amount'], 0),
    'payment_method' => ucfirst($row['payment_method']),
    'address'        => htmlspecialchars($row['address']),
    'city'           => htmlspecialchars($row['city']),
    'status'         => $status,
    'status_label'   => $statusLabel,
    'created_at'     => date('d M Y', strtotime($row['created_at'])),
];

respond('success', 'Order found.', $order);