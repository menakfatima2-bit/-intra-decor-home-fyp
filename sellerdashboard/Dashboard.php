<?php
session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'seller'){
    header("Location: ../login.php");
    exit();
}

include "db.php";

$seller_id = $_SESSION['user_id'];

// Check approval (ONLY for message, not blocking)
$check = $conn->query("SELECT is_approved FROM users WHERE id = $seller_id");
$row = $check->fetch_assoc();

if(!$row) {
    session_destroy();
    header("Location: ../login.php");
    exit();
}

$isApproved = $row['is_approved'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Seller Dashboard | Intra Decor Home</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="sellerdashboard.css?v=2">
</head>
<body>

<div class="dashboard">

    <!-- Overlay -->
    <div class="overlay" onclick="closeSidebar()"></div>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>Intra Decor</h2>
        <a href="Dashboard.php" class="active"><i class="fa fa-home"></i> Dashboard</a>
        <a href="addproduct.php"><i class="fa fa-plus-circle"></i> Add Product</a>
        <a href="productlist.php"><i class="fa fa-list"></i> Product List</a>
        <a href="seller_orders.php"><i class="fa fa-list"></i> seller orders</a>
        <a href="sellerprofile.php"><i class="fa fa-user"></i> Seller Profile</a>
        <a href="../logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a>
    </div>

    <!-- MAIN -->
    <div class="main-content">

        <div class="top-bar">
            <button class="menu-btn" onclick="toggleSidebar()">
                <i class="fa fa-bars"></i>
            </button>

            <div>
                <h1>Seller Dashboard</h1>
                <p>Welcome back, Seller 👋</p>
            </div>

            <?php include "notifications_bell.php"; ?>
        </div>

        <!-- MESSAGE SHOW -->
        <?php if($isApproved == 0){ ?>
            <p style="color:red; text-align:center; font-weight:bold;">
                ⚠ Your account is not approved yet. Please wait for admin approval.
            </p>
        <?php } ?>

        <!-- CARDS -->
        <div class="cards">
            <div class="card"><i class="fa fa-box"></i><h3>25</h3><p>Total Products</p></div>
            <div class="card"><i class="fa fa-tags"></i><h3>5</h3><p>Categories</p></div>
            <div class="card"><i class="fa fa-shopping-cart"></i><h3>12</h3><p>Orders</p></div>
            <div class="card"><i class="fa fa-star"></i><h3>4.8</h3><p>Rating</p></div>
        </div>

        <div class="content-grid">
            <div>
                <div class="section">
                    <h2>Recent Products</h2>
                    <table>
                        <tr>
                            <th>Image</th>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Price</th>
                        </tr>
                    </table>
                </div>

                <div class="section">
                    <h2>Recent Orders</h2>
                    <table>
                        <tr>
                            <th>Order ID</th>
                            <th>Product</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="right-panel">
                <div class="right-card">
                    <h3>Quick Actions</h3>
                    <a href="sellerprofile.php" class="btn">👤 Seller Profile</a>
                    <a href="addproduct.php" class="btn">➕ Add Product</a>
                    <a href="productlist.php" class="btn">📋 Product List</a>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
function toggleSidebar(){
    document.querySelector(".sidebar").classList.toggle("active");
    document.querySelector(".overlay").classList.toggle("active");
}
function closeSidebar(){
    document.querySelector(".sidebar").classList.remove("active");
    document.querySelector(".overlay").classList.remove("active");
}
</script>

</body>
</html>