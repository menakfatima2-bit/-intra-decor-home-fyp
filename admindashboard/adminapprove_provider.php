<?php
session_start();
include "../db.php";

if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin'){
    die("Access denied");
}

if(!isset($_GET['id']) || !isset($_GET['action'])){
    die("Invalid request");
}

$id     = intval($_GET['id']);
$action = $_GET['action'];

if($action == 'approve'){
    mysqli_query($conn, "UPDATE users SET is_approved=1 WHERE id=$id AND role='service_provider'");
    // Let the provider know on their dashboard
    mysqli_query($conn, "INSERT INTO notifications (seller_id, provider_id, message, is_read, created_at)
                         VALUES (0, $id, 'Your service provider account has been approved by the admin. You can now log in and add your services.', 0, NOW())");
    header("Location: adminprovider.php?status=pending&msg=approved");
} elseif($action == 'block'){
    mysqli_query($conn, "UPDATE users SET is_approved=0 WHERE id=$id AND role='service_provider'");
    header("Location: adminprovider.php?status=approved&msg=blocked");
} else {
    header("Location: adminprovider.php");
}
exit();
?>
