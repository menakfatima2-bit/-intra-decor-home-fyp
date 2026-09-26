<?php
session_start();
include "../db.php";

if(!isset($_SESSION['user_id'])){
    die("Access denied");
}

$id = intval($_GET['id']);
$user_id = intval($_SESSION['user_id']);

mysqli_query($conn, "UPDATE notifications SET is_read=1 WHERE id=$id AND user_id=$user_id");

echo "ok";
?>