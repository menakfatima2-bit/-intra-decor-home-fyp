<?php
session_start();
include "../db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$fav_id  = $_GET['fav_id'];

$query = "DELETE FROM favorites WHERE id='$fav_id' AND user_id='$user_id'";
mysqli_query($conn, $query);

header("Location: favorites.php");
exit();
?>