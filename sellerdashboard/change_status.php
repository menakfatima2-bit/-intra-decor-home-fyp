<?php
session_start();

if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin'){
    die("Access denied");
}

include "db.php";

$id = $_GET['id'];
$status = $_GET['status'];

$update = "UPDATE productadd SET status='$status' WHERE id='$id'";
mysqli_query($conn,$update);

header("Location: viewdetail.php?id=$id");
?>