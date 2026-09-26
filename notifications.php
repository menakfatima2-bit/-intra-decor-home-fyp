<?php
// notifications.php — seller dashboard bell icon ke liye
session_start();
include "db.php";

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'seller'){
    header("Location: ../login.php");
    exit();
}

$seller_id = $_SESSION['user_id'];

// Sab notifications mark as read
if(isset($_GET['mark_read'])){
    mysqli_query($conn, "UPDATE notifications SET is_read=1 WHERE seller_id='$seller_id'");
    header("Location: notifications.php");
    exit();
}

// Notifications fetch
$notifs = mysqli_query($conn,
    "SELECT * FROM notifications WHERE seller_id='$seller_id' ORDER BY created_at DESC"
);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Notifications | Seller Dashboard</title>
    <link rel="stylesheet" href="productlist.css?v=3">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .notif-list { list-style: none; padding: 0; }
        .notif-item {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 10px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            font-size: 14px;
        }
        .notif-item.unread { background: #fff8f0; border-left: 4px solid #ffa502; }
        .notif-item.read   { background: #f9f9f9; border-left: 4px solid #ddd; color: #888; }
        .notif-icon { font-size: 1.4rem; margin-top: 2px; }
        .notif-time { font-size: 11px; color: #aaa; margin-top: 4px; }
        .mark-btn {
            background: #4b2c2c;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
            margin-bottom: 20px;
            text-decoration: none;
            display: inline-block;
        }
        .mark-btn:hover { background: #6b3d3d; }
        .empty-notif { text-align: center; padding: 50px; color: #aaa; }
        .empty-notif i { font-size: 3rem; display: block; margin-bottom: 10px; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Seller Dashboard</h2>
    <a href="Dashboard.php">Dashboard</a>
    <a href="addproduct.php">Add Product</a>
    <a href="productlist.php">My Products</a>
    <a href="seller_orders.php">Orders</a>
    <a href="notifications.php" class="active">🔔 Notifications</a>
    <a href="sellerprofile.php">Seller Profile</a>
    <a href="../logout.php">Logout</a>
</div>

<div class="main-content">
    <div class="container">
        <h2>🔔 Notifications</h2>

        <?php if(mysqli_num_rows($notifs) > 0){ ?>

        <a href="notifications.php?mark_read=1" class="mark-btn">
            ✅ Mark All as Read
        </a>

        <ul class="notif-list">
            <?php while($n = mysqli_fetch_assoc($notifs)){ ?>
            <li class="notif-item <?php echo $n['is_read'] == 0 ? 'unread' : 'read'; ?>">
                <span class="notif-icon">
                    <?php
                    if(strpos($n['message'], 'OUT OF STOCK') !== false) echo '⚠️';
                    elseif(strpos($n['message'], 'Low Stock') !== false) echo '⚡';
                    else echo '🛒';
                    ?>
                </span>
                <div>
                    <div><?php echo htmlspecialchars($n['message']); ?></div>
                    <div class="notif-time">
                        <?php echo date('d M Y, h:i A', strtotime($n['created_at'])); ?>
                    </div>
                </div>
            </li>
            <?php } ?>
        </ul>

        <?php } else { ?>
        <div class="empty-notif">
            <i class="fa fa-bell-slash"></i>
            <p>No notifications yet!</p>
        </div>
        <?php } ?>
    </div>
</div>

</body>
</html>