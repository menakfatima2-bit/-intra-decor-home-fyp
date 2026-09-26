<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'seller'){
    die("Access denied");
}

$id = intval($_GET['id']);
$seller_id = intval($_SESSION['user_id']);

mysqli_query($conn, "UPDATE notifications SET is_read=1 WHERE id=$id AND seller_id=$seller_id");

echo "ok";
?>