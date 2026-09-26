<?php
session_start();
include "../db.php";

if($_SESSION['user_role'] != 'admin'){
    die("Access denied");
}

$id = intval($_GET['id']);
$status = $_GET['status'];
$reason = isset($_GET['reason']) ? mysqli_real_escape_string($conn, $_GET['reason']) : '';

$allowed = ['approved','rejected','pending'];

if(!in_array($status, $allowed)){
    die("Invalid status");
}

$prod_res = mysqli_query($conn, "SELECT name, seller_id FROM productadd WHERE id=$id");
$product = mysqli_fetch_assoc($prod_res);

if($status == 'rejected'){
    mysqli_query($conn, "UPDATE productadd SET status='$status', reject_reason='$reason' WHERE id=$id");
} else {
    mysqli_query($conn, "UPDATE productadd SET status='$status', reject_reason=NULL WHERE id=$id");
}

if($product){
    $seller_id = intval($product['seller_id']);
    $product_name = mysqli_real_escape_string($conn, $product['name']);

    if($status == 'approved'){
        $message = "Your product \"$product_name\" has been approved.";
    } elseif($status == 'rejected'){
        $message = "Your product \"$product_name\" was rejected." . ($reason != '' ? " Reason: $reason" : "");
    } else {
        $message = "Your product \"$product_name\" status changed to $status.";
    }

      mysqli_query($conn, "INSERT INTO notifications (seller_id, message) VALUES ($seller_id, '$message')");
}

header("Location: adminproduct.php?msg=success");
exit();
?>