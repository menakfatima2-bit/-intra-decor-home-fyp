<?php
session_start();
include "../db.php";

if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin'){
    header("Location: adminlogin.php");
    exit();
}

$users            = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users"));
$sellers          = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE role='seller'"));
$pending_sellers  = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE role='seller' AND is_approved=0"));
$products         = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM productadd"));
$pending_products = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM productadd WHERE status='pending'"));
$providers        = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE role='service_provider'"));
$pending_providers= mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE role='service_provider' AND is_approved=0"));
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<link rel="stylesheet" href="admindashboard.css">
</head>
<body>

<?php include "notifications_bell.php"; ?>

<div class="dashboard">

<div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="admindashboard.php" class="active">Dashboard</a>
    <a href="adminseller.php">Manage Sellers</a>
    <a href="adminprovider.php">Manage Providers</a>
    <a href="adminproduct.php">Manage Products</a>
    <a href="notifications.php">Notifications</a>
    <a href="../logout.php">Logout</a>
</div>

<div class="main-content">

<h1>Admin Dashboard</h1>

<div class="cards">

<div class="card">
    <h3><?php echo $sellers; ?></h3>
    <p>Total Sellers</p>
</div>

<div class="card">
    <h3><?php echo $pending_sellers; ?></h3>
    <p>Pending Sellers</p>
</div>

<div class="card">
    <h3><?php echo $providers; ?></h3>
    <p>Total Providers</p>
</div>

<div class="card" style="border-left: 4px solid #e74c3c;">
    <h3><?php echo $pending_providers; ?></h3>
    <p>Pending Providers</p>
</div>

<div class="card">
    <h3><?php echo $products; ?></h3>
    <p>Total Products</p>
</div>

<div class="card">
    <h3><?php echo $pending_products; ?></h3>
    <p>Pending Products</p>
</div>

<div class="card">
    <h3><?php echo $users; ?></h3>
    <p>Total Users</p>
</div>

</div>

</div>
</div>

</body>
</html>