<?php
session_start();
include "../db.php";

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'service_provider'){
    die("Access denied");
}

$id = intval($_GET['id']);
$provider_id = intval($_SESSION['user_id']);

mysqli_query($conn, "UPDATE notifications SET is_read=1 WHERE id=$id AND provider_id=$provider_id");

echo "ok";
?>