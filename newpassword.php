<?php
include "db.php";
session_start();

if(!isset($_SESSION['reset_email'])){
    header("Location: forgot_password.php");
    exit();
}

$email = $_SESSION['reset_email'];

if(isset($_POST['update'])){

    $new_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $update = $conn->prepare("UPDATE users SET password=?, otp_code=NULL, otp_expire=NULL WHERE email=?");
    $update->bind_param("ss", $new_password, $email);
    $update->execute();

    session_destroy();
    echo "Password Updated Successfully!";
    exit();
}
?>

<form method="POST">
    <input type="password" name="password" required placeholder="New Password">
    <button type="submit" name="update">Update Password</button>
</form>