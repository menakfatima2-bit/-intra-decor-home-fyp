<?php
$host = "YOUR_DB_HOST";
$user = "if0_42479335";
$pass = "YOUR_DB_PASSWORD";
$db   = "if0_42479335_intradecorhome";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Database connection failed");
}
?>