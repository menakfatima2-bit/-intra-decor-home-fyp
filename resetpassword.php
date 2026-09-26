<?php
include "db.php";

if(!isset($_GET['token'])){
    die("Invalid request");
}

$token = $_GET['token'];

$stmt = $conn->prepare("SELECT * FROM users WHERE reset_token=? AND token_expire > NOW()");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows == 0){
    die("Token expired or invalid");
}

if(isset($_POST['update'])){

    $new_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $update = $conn->prepare("UPDATE users SET password=?, reset_token=NULL, token_expire=NULL WHERE reset_token=?");
    $update->bind_param("ss", $new_password, $token);
    $update->execute();

    echo "Password Updated Successfully!";
    exit();
}
?>

<form method="POST">
    <input type="password" name="password" required placeholder="New Password">
    <button type="submit" name="update">Update Password</button>
</form>