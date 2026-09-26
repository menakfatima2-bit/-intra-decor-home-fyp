<?php
session_start();
include "../db.php";

if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin'){
    header("Location: adminlogin.php");
    exit();
}

$admin_id = intval($_SESSION['user_id']);

// Mark all as read when the admin opens this page
mysqli_query($conn, "UPDATE notifications SET is_read=1 WHERE admin_id=$admin_id");

$result = mysqli_query($conn, "SELECT * FROM notifications WHERE admin_id=$admin_id ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
<title>Notifications</title>
<link rel="stylesheet" href="admindashboard.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
.notif-list-page{ max-width:700px; margin:30px auto; }
.notif-list-item{ background:#fff; border:1px solid #eee; border-radius:8px; padding:14px 18px; margin-bottom:10px; }
.notif-list-item .notif-msg{ font-size:14px; color:#333; }
.notif-list-item .notif-time{ font-size:12px; color:#999; margin-top:5px; }
</style>
</head>
<body>

<div class="dashboard">
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="admindashboard.php">Dashboard</a>
        <a href="adminseller.php">Manage Sellers</a>
        <a href="adminprovider.php">Manage Providers</a>
        <a href="adminproduct.php">Manage Products</a>
        <a href="notifications.php" class="active">Notifications</a>
        <a href="../logout.php">Logout</a>
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