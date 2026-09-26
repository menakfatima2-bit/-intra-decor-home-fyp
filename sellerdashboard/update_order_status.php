<?php
session_start();
include "db.php";
include "../mailer.php";

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'seller'){
    header("Location: ../login.php");
    exit();
}

$order_id  = intval($_POST['order_id']);
$seller_id = intval($_SESSION['user_id']);

// Only these statuses are allowed
$allowed = ['pending', 'confirmed', 'delivered', 'cancelled'];
$status  = strtolower(trim($_POST['status'] ?? ''));
if(!in_array($status, $allowed)){
    header("Location: seller_orders.php?error=invalid_status");
    exit();
}

// A seller can only change orders for their OWN products
$own = mysqli_query($conn, "SELECT o.id FROM orders o
                            JOIN productadd p ON o.product_id = p.id
                            WHERE o.id='$order_id' AND p.seller_id='$seller_id'");
if(mysqli_num_rows($own) == 0){
    header("Location: seller_orders.php?error=not_allowed");
    exit();
}

// Update order status
mysqli_query($conn, "UPDATE orders SET status='$status' WHERE id='$order_id'");

// Notify the customer about the status change
$order_res = mysqli_query($conn, "SELECT o.user_id, p.name AS product_name, u.name AS user_name, u.email AS user_email
                                   FROM orders o
                                   LEFT JOIN productadd p ON o.product_id = p.id
                                   LEFT JOIN users u ON o.user_id = u.id
                                   WHERE o.id='$order_id'");
if($order_row = mysqli_fetch_assoc($order_res)){
    $notif_user_id = intval($order_row['user_id']);
    $product_name  = $order_row['product_name'] ? $order_row['product_name'] : 'your order';
    $notif_message = mysqli_real_escape_string($conn, "Your order for \"$product_name\" is now: $status");
    mysqli_query($conn, "INSERT INTO notifications (user_id, seller_id, message, is_read, created_at)
                          VALUES ($notif_user_id, 0, '$notif_message', 0, NOW())");

    // NEW: Email the customer about the order status change
    if(!empty($order_row['user_email'])){
        $subject = "Order #$order_id Update — Intra Decor Home";
        $body = "
        <div style='font-family:Arial,sans-serif;max-width:600px;margin:0 auto;'>
            <div style='background:#4b2c2c;padding:20px;border-radius:10px 10px 0 0;'>
                <h2 style='color:#fff;margin:0;'>📦 Order Status Updated</h2>
            </div>
            <div style='background:#f9f4ef;padding:24px;border-radius:0 0 10px 10px;'>
                <p style='color:#555;font-size:15px;'>Hi {$order_row['user_name']},</p>
                <p style='color:#555;font-size:15px;'>Your order status has been updated.</p>

                <table style='width:100%;border-collapse:collapse;margin-top:16px;'>
                    <tr style='background:#fff;'>
                        <td style='padding:10px 14px;font-weight:bold;color:#4b2c2c;border-bottom:1px solid #edddd4;'>Order ID</td>
                        <td style='padding:10px 14px;color:#555;border-bottom:1px solid #edddd4;'>#$order_id</td>
                    </tr>
                    <tr style='background:#fff;'>
                        <td style='padding:10px 14px;font-weight:bold;color:#4b2c2c;border-bottom:1px solid #edddd4;'>Product</td>
                        <td style='padding:10px 14px;color:#555;border-bottom:1px solid #edddd4;'>$product_name</td>
                    </tr>
                    <tr style='background:#fff;'>
                        <td style='padding:10px 14px;font-weight:bold;color:#4b2c2c;'>New Status</td>
                        <td style='padding:10px 14px;color:#c17f4a;font-weight:bold;'>$status</td>
                    </tr>
                </table>

                <p style='margin-top:20px;color:#aaa;font-size:12px;text-align:center;'>
                    Intra Decor Home — Professional Home Decor Services
                </p>
            </div>
        </div>
        ";

        sendEmail($order_row['user_email'], $subject, $body);
    }
}

header("Location: seller_orders.php?msg=updated");
exit();
?>