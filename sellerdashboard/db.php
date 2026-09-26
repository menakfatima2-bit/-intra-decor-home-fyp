<?php
$servername = "YOUR_DB_HOST";
$username = "if0_42479335";
$password = "YOUR_DB_PASSWORD";
$dbname = "if0_42479335_intradecorhome";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>