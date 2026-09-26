<?php
session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'service_provider'){
    header("Location: ../login.php");
    exit();
}

include "../db.php";

$provider_id = intval($_SESSION['user_id']);

// Mark all as read when the provider opens this page
mysqli_query($conn, "UPDATE notifications SET is_read=1 WHERE provider_id=$provider_id");

$result = mysqli_query($conn, "SELECT * FROM notifications WHERE provider_id=$provider_id ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
<title>Notifications</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="serviceprovider.css?v=2">
<style>
.notif-list-page{ max-width:700px; margin:30px auto; }
.notif-list-item{ background:#fff; border:1px solid #eee; border-radius:8px; padding:14px 18px; margin-bottom:10px; }
.notif-list-item .notif-msg{ font-size:14px; color:#333; }
.notif-list-item .notif-time{ font-size:12px; color:#999; margin-top:5px; }
</style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
<h2><i class="fa-solid fa-user-gear"></i> Service Provider</h2>

<ul>
<li><a href="serviceprovider.php"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>
<li><a href="addservice.php"><i class="fa-solid fa-plus"></i> Add Service</a></li>
<li><a href="servicelist.php"><i class="fa-solid fa-list"></i> My Services</a></li>
<li><a href="mybookings.php"><i class="fa-solid fa-calendar-check"></i> My Bookings</a></li>
<li><a href="providerprofile.php"><i class="fa-solid fa-user"></i> Profile</a></li>
<li><a href="../logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
</ul>
</div>

<div class="main">
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

</body>
</html>