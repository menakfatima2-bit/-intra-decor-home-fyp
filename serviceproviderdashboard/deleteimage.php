<?php
session_start();  // ✅ Fix 1: session start
include "../db.php";

// ✅ Fix 2: login check
if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'service_provider'){
    header("Location: ../login.php");
    exit();
}

$id = $_GET['id'];

// ✅ Fix 3: first check that this image belongs to this provider
$provider_id = $_SESSION['user_id'];

$query = "SELECT sg.* FROM service_gallery sg 
          JOIN addservice a ON sg.service_id = a.service_id 
          WHERE sg.gallery_id='$id' AND a.serviceprovider_id='$provider_id'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

// ✅ Fix 4: if the image doesn't belong to this provider, block it
if(!$row){
    die("Unauthorized!");
}

$file = "../uploads/".$row['image_path'];

if(file_exists($file)){
    unlink($file);
}

mysqli_query($conn, "DELETE FROM service_gallery WHERE gallery_id='$id'");

header("Location: ".$_SERVER['HTTP_REFERER']);
?>