<?php
session_start();
include "../db.php"; // root folder me db.php

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$item_id = $_GET['item_id'];
$type = $_GET['type']; // "product" or "service"

// check duplicate
$check = "SELECT * FROM favorites 
          WHERE user_id='$user_id' AND item_id='$item_id' AND type='$type'";
$result = mysqli_query($conn, $check);

if(mysqli_num_rows($result) == 0){
    $query = "INSERT INTO favorites (user_id, item_id, type) 
              VALUES ('$user_id', '$item_id', '$type')";
    mysqli_query($conn, $query);
}

// back to previous page
header("Location: ".$_SERVER['HTTP_REFERER']);
exit();
?>