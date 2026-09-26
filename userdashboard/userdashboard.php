<?php
session_start();
include "../db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$userRes  = mysqli_query($conn, "SELECT name, email FROM users WHERE id='$user_id'");
$userData = mysqli_fetch_assoc($userRes);

if(!$userData) {
    // Session user_id is invalid/deleted from DB, clear session and redirect to login
    session_destroy();
    header("Location: ../login.php");
    exit();
}

$ordersRes   = mysqli_query($conn, "SELECT * FROM orders WHERE user_id='$user_id'");
$totalOrders = $ordersRes ? mysqli_num_rows($ordersRes) : 0;

$cartRes   = mysqli_query($conn, "SELECT * FROM cart WHERE user_id='$user_id'");
$totalCart = $cartRes ? mysqli_num_rows($cartRes) : 0;

$favRes    = mysqli_query($conn, "SELECT * FROM favorites WHERE user_id='$user_id'");
$totalFavs = $favRes ? mysqli_num_rows($favRes) : 0;

$bookingsRes   = mysqli_query($conn, "SELECT * FROM booking WHERE user_id='$user_id'");
$totalBookings = $bookingsRes ? mysqli_num_rows($bookingsRes) : 0;

$recentOrders = mysqli_query($conn,
    "SELECT orders.*, productadd.name, productadd.product_image
     FROM orders
     JOIN productadd ON orders.product_id = productadd.id
     WHERE orders.user_id='$user_id'
     ORDER BY orders.id DESC LIMIT 5"
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="userdashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<?php include "notifications_bell.php"; ?>

<div class="dashboard-wrapper">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>Intra Decor</h2>
        <a href="userdashboard.php" class="active">
            <i class="fa fa-home"></i> Dashboard
        </a>
        <a href="../cart.php">
            <i class="fa fa-cart-shopping"></i> My Cart
            <?php if($totalCart > 0){ ?>
            <span class="badge-count"><?php echo $totalCart; ?></span>
            <?php } ?>
        </a>
        <a href="favorites.php">
            <i class="fa fa-heart"></i> Favorites
            <?php if($totalFavs > 0){ ?>
            <span class="badge-count"><?php echo $totalFavs; ?></span>
            <?php } ?>
        </a>
        <a href="myorders.php">
            <i class="fa fa-box"></i> My Orders
            <?php if($totalOrders > 0){ ?>
            <span class="badge-count"><?php echo $totalOrders; ?></span>
            <?php } ?>
        </a>
        <a href="MybookingUser.php">
            <i class="fa fa-calendar-check"></i> My Bookings
            <?php if($totalBookings > 0){ ?>
            <span class="badge-count"><?php echo $totalBookings; ?></span>
            <?php } ?>
        </a>
        <a href="userprofile.php">
            <i class="fa fa-user"></i> Profile
        </a>
        <a href="notifications.php">
            <i class="fa fa-bell"></i> Notifications
        </a>
        <a href="../services.php">
            <i class="fa fa-screwdriver-wrench"></i> Services
        </a>
        <a href="../index.php">
            <i class="fa fa-store"></i> Go to Shop
        </a>
        <a href="../logout.php">
            <i class="fa fa-sign-out-alt"></i> Logout
        </a>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <!-- TOP BAR -->
        <div class="top-bar">
            <div>
                <h1>Welcome, <?php echo htmlspecialchars($userData['name']); ?>! 👋</h1>
                <p><?php echo htmlspecialchars($userData['email']); ?></p>
            </div>
            <a href="../index.php" class="shop-btn">
                <i class="fa fa-store"></i> Continue Shopping
            </a>
        </div>

        <!-- STATS CARDS -->
        <div class="stats-cards">

            <div class="stat-card" onclick="window.location.href='myorders.php'" style="cursor:pointer">
                <div class="stat-icon orders">
                    <i class="fa fa-box"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $totalOrders; ?></h3>
                    <p>My Orders</p>
                </div>
            </div>

            <div class="stat-card" onclick="window.location.href='MybookingUser.php'" style="cursor:pointer">
                <div class="stat-icon" style="background:#e8f5e9;">
                    <i class="fa fa-calendar-check" style="color:#2ecc71;"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $totalBookings; ?></h3>
                    <p>My Bookings</p>
                </div>
            </div>

            <div class="stat-card" onclick="window.location.href='../cart.php'" style="cursor:pointer">
                <div class="stat-icon cart">
                    <i class="fa fa-cart-shopping"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $totalCart; ?></h3>
                    <p>Cart Items</p>
                </div>
            </div>

            <div class="stat-card" onclick="window.location.href='favorites.php'" style="cursor:pointer">
                <div class="stat-icon favs">
                    <i class="fa fa-heart"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $totalFavs; ?></h3>
                    <p>Favorites</p>
                </div>
            </div>

        </div>

        <!-- RECENT ORDERS -->
        <div class="section-box">
            <div class="section-header">
                <h2>Recent Orders</h2>
                <a href="myorders.php">View All →</a>
            </div>

            <?php if($recentOrders && mysqli_num_rows($recentOrders) > 0){ ?>
            <table class="orders-table">
                <tr>
                    <th>Image</th>
                    <th>Product</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
                <?php while($row = mysqli_fetch_assoc($recentOrders)){ ?>
                <tr>
                    <td>
                        <img src="../uploads/<?php echo htmlspecialchars($row['product_image']); ?>"
                             style="width:50px; height:50px; object-fit:cover; border-radius:8px;">
                    </td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td>Rs. <?php echo $row['amount']; ?></td>
                    <td>
                        <?php
                        $status = $row['status'];
                        $color  = $status == 'pending'   ? '#856404' :
                                 ($status == 'delivered' ? '#155724' : '#721c24');
                        $bg     = $status == 'pending'   ? '#fff3cd' :
                                 ($status == 'delivered' ? '#d4edda' : '#f8d7da');
                        ?>
                        <span style="background:<?php echo $bg; ?>; color:<?php echo $color; ?>;
                                     padding:4px 12px; border-radius:20px; font-size:12px;">
                            <?php echo ucfirst($status); ?>
                        </span>
                    </td>
                    <td style="color:#888; font-size:13px;">
                        <?php echo date('d M Y', strtotime($row['created_at'])); ?>
                    </td>
                </tr>
                <?php } ?>
            </table>

            <?php } else { ?>
            <div class="empty-box">
                <i class="fa fa-box"></i>
                <p>No orders yet!</p>
                <a href="../index.php">Start Shopping →</a>
            </div>
            <?php } ?>
        </div>

        <!-- QUICK LINKS -->
        <div class="quick-links">
            <h2>Quick Actions</h2>
            <div class="quick-grid">
                <a href="../cart.php" class="quick-card">
                    <i class="fa fa-cart-shopping"></i>
                    <span>My Cart</span>
                </a>
                <a href="favorites.php" class="quick-card">
                    <i class="fa fa-heart"></i>
                    <span>Favorites</span>
                </a>
                <a href="myorders.php" class="quick-card">
                    <i class="fa fa-box"></i>
                    <span>My Orders</span>
                </a>
                <a href="MybookingUser.php" class="quick-card">
                    <i class="fa fa-calendar-check"></i>
                    <span>My Bookings</span>
                </a>
                <a href="../services.php" class="quick-card">
                    <i class="fa fa-screwdriver-wrench"></i>
                    <span>Services</span>
                </a>
                <a href="userprofile.php" class="quick-card">
                    <i class="fa fa-user"></i>
                    <span>My Profile</span>
                </a>
            </div>
        </div>

    </div>
</div>

</body>
</html>