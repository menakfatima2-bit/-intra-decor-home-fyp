<?php
session_start();
include "../db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

if(!isset($_GET['product_id'])){
    die("Product ID missing"); // DEBUG
}

$user_id = $_SESSION['user_id'];
$product_id = intval($_GET['product_id']);

// Check duplicate
$check = "SELECT * FROM cart WHERE user_id='$user_id' AND product_id='$product_id'";
$res = mysqli_query($conn,$check);

if(!$res){
    die("Query Error: ".mysqli_error($conn)); // DEBUG
}

if(mysqli_num_rows($res) == 0){
    $query = "INSERT INTO cart (user_id, product_id) VALUES ('$user_id','$product_id')";
    mysqli_query($conn,$query);
}

header("Location: ".$_SERVER['HTTP_REFERER']);
exit();
?>