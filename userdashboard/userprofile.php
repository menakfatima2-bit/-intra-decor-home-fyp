<?php
session_start();
include "../db.php";

// Check login
if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user data safely
$query = "SELECT * FROM users WHERE id='$user_id'";
$result = mysqli_query($conn, $query);

if($result && mysqli_num_rows($result) > 0){
    $user = mysqli_fetch_assoc($result);
} else {
    $user = null; // prevent errors
}

// Update profile
if(isset($_POST['update'])){
    $name = $_POST['name'];
    $email = $_POST['email'];

    $update = "UPDATE users SET name='$name', email='$email' WHERE id='$user_id'";
    mysqli_query($conn, $update);

    $_SESSION['user_name'] = $name;

    echo "<script>alert('Profile Updated'); window.location='profile.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>
    <link rel="stylesheet" href="userprofile.css?v=2">
</head>
<body>

<?php include "notifications_bell.php"; ?>

<div class="profile-container">

    <div class="profile-card">

        <div class="profile-header">
            <div class="avatar">👤</div>
            <h2><?php echo isset($user['name']) ? $user['name'] : 'User'; ?></h2>
            <p><?php echo isset($user['email']) ? $user['email'] : 'No Email'; ?></p>
        </div>

        <form method="POST" class="profile-form">

            <div class="input-group">
                <label>Name</label>
                <input type="text" name="name" 
                value="<?php echo isset($user['name']) ? $user['name'] : ''; ?>" required>
            </div>

            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" 
                value="<?php echo isset($user['email']) ? $user['email'] : ''; ?>" required>
            </div>

            <button type="submit" name="update">Update Profile</button>

        </form>

    </div>

</div>

</body>
</html>