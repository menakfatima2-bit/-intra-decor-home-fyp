<?php
session_start();
include "../db.php";

if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin'){
    die("Access denied");
}

if(!isset($_GET['id'])){
    die("Invalid request");
}

$id = intval($_GET['id']);

$result = mysqli_query($conn, "UPDATE users SET is_approved=1 WHERE id=$id");

if(!$result){
    die("Query Failed: " . mysqli_error($conn));
}

header("Location: adminseller.php?msg=approved");
exit();
?>