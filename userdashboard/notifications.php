<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

include "../db.php";

$user_id = intval($_SESSION['user_id']);

// Mark all as read when the user opens this page
mysqli_query($conn, "UPDATE notifications SET is_read=1 WHERE user_id=$user_id");

$result = mysqli_query($conn, "SELECT * FROM notifications WHERE user_id=$user_id ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
<title>Notifications</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="userdashboard.css">
<style>
.notif-list-page{ max-width:700px; margin:30px auto; }
.notif-list-item{ background:#fff; border:1px solid #eee; border-radius:8px; padding:14px 18px; margin-bottom:10px; }
.notif-list-item .notif-msg{ font-size:14px; color:#333; }
.notif-list-item .notif-time{ font-size:12px; color:#999; margin-top:5px; }
</style>
</head>
<body>

<div class="dashboard-wrapper">
    <div class="sidebar">
        <h2>Intra Decor</h2>
        <a href="userdashboard.php"><i class="fa fa-home"></i> Dashboard</a>
        <a href="../cart.php"><i class="fa fa-cart-shopping"></i> My Cart</a>
        <a href="favorites.php"><i class="fa fa-heart"></i> Favorites</a>
        <a href="myorders.php"><i class="fa fa-box"></i> My Orders</a>
        <a href="MybookingUser.php"><i class="fa fa-calendar-check"></i> My Bookings</a>
        <a href="userprofile.php"><i class="fa fa-user"></i> Profile</a>
        <a href="notifications.php" class="active"><i class="fa fa-bell"></i> Notifications</a>
        <a href="../logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="main-content">
        <h1>All Notifications</h1>

        <div class="notif-list-page">
            <?php if(mysqli_num_rows($result) == 0){ ?>
                <p>No notifications.</p>
            <?php } else { ?>
                <?php while($n = mysqli_fetch_assoc($result)){ ?>
                    <div class="notif-list-item">
                        <div class="notif-msg"><?php echo htmlspecialchars($n['message']); ?></div>
                        <div class="notif-time"><?php echo date("d M Y, h:i A", strtotime($n['created_at'])); ?></div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>

</body>
</html>