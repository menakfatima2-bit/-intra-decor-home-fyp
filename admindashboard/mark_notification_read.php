<?php
session_start();
include "../db.php";

if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin'){
    die("Access denied");
}

$id = intval($_GET['id']);
$admin_id = intval($_SESSION['user_id']);

mysqli_query($conn, "UPDATE notifications SET is_read=1 WHERE id=$id AND admin_id=$admin_id");

echo "ok";
?>