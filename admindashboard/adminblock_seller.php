<?php
session_start();
include "../db.php";

if($_SESSION['user_role'] != 'admin'){
    die("Access denied");
}

// ✅ ID check
if(!isset($_GET['id'])){
    die("Invalid request");
}

$id = intval($_GET['id']);

mysqli_query($conn, "UPDATE users SET is_approved=0 WHERE id=$id");

header("Location: adminseller.php?msg=blocked");
exit();
?>