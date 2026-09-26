<?php
session_start();
include "db.php";

// Make sure only seller can access
if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'seller'){
    header("Location: ../login.php");
    exit();
}

// ✅ Get product ID from URL
if(isset($_GET['id'])){
    $id = intval($_GET['id']);
    $seller_id = $_SESSION['user_id'];

    // ✅ Delete only if product belongs to logged-in seller
    $query = "DELETE FROM productadd WHERE id='$id' AND seller_id='$seller_id'";
    $result = mysqli_query($conn, $query);

    if($result){
        header("Location: productlist.php"); // Redirect back to product list
        exit();
    } else {
        die("Error deleting product: " . mysqli_error($conn));
    }

} else {
    // No ID provided
    header("Location: productlist.php");
    exit();
}
?>