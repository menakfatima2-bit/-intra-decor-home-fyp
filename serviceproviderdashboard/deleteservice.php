<?php
session_start();
include "../db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

if(isset($_GET['id'])){

$service_id = $_GET['id'];

/* delete gallery images first */

$img_query="SELECT * FROM service_gallery WHERE service_id='$service_id'";
$img_result=mysqli_query($conn,$img_query);

while($img=mysqli_fetch_assoc($img_result)){

$file="../uploads/".$img['image_path'];

if(file_exists($file)){
unlink($file);
}

}

/* delete gallery records */

mysqli_query($conn,"DELETE FROM service_gallery WHERE service_id='$service_id'");

/* delete service */

mysqli_query($conn,"DELETE FROM addservice WHERE service_id='$service_id'");

header("Location: servicelist.php");

}
?>