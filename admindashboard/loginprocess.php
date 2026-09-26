<?php
session_start();
include "../db.php";

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Prepared statement: username is never pasted directly into the SQL query
$stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        $_SESSION['admin']     = $row['username'];
        $_SESSION['user_id']   = $row['id'];
        $_SESSION['user_role'] = 'admin';
        header("Location: admindashboard.php");
        exit();
    } else {
        echo "Wrong Password";
    }
} else {
    echo "User not found";
}
?>
