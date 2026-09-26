<?php
session_start();

// Prevent browser caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Check if user logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Intra Decor Home - Admin Dashboard</title>
    <link rel="stylesheet" href="admindashboard.css">
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h2>Intra Decor Home</h2>
    <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="Customers.php">Customers</a></li>
        <li><a href="Wallpapers.php">Wallpapers</a></li>
        <li><a href="Wall Panels.php">Wall Panels</a></li>
        <li><a href="Tiles.php">Tiles</a></li>
        <li><a href="Paint Colors.php">Paint Colors</a></li>
        <li><a href="Orders.php">Orders</a></li>
        <li><a href="Messages.php">Messages</a></li>
        <li><a href="Logout.php">Logout</a></li>
    </ul>
</div>

<!-- Main Content -->
<div class="main">

    <!-- Top Bar -->
    <div class="topbar">
        <h3>Admin Dashboard</h3>
        <span>Welcome, Admin</span>
    </div>

    <!-- Cards -->
    <div class="cards">
        <div class="card">
            <h4>Total Customers</h4>
            <h2>120</h2>
        </div>
        <div class="card">
            <h4>Wallpapers</h4>
            <h2>45</h2>
        </div>
        <div class="card">
            <h4>Wall Panels</h4>
            <h2>30</h2>
        </div>
        <div class="card">
            <h4>Tiles</h4>
            <h2>60</h2>
        </div>
        <div class="card">
            <h4>Paint Colors</h4>
            <h2>80</h2>
        </div>
    </div>

    <!-- Customers Table -->
    <div class="table-box">
        <h3>Customers</h3>
        <table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>City</th>
                <th>Action</th>
            </tr>
            <tr>
                <td>Ali Khan</td>
                <td>ali@gmail.com</td>
                <td>Lahore</td>
                <td>
                    <button class="btn view">View</button>
                    <button class="btn edit">Edit</button>
                    <button class="btn delete">Delete</button>
                </td>
            </tr>
        </table>
    </div>

    <!-- Orders Table -->
    <div class="table-box">
        <h3>Orders</h3>
        <table>
            <tr>
                <th>Customer</th>
                <th>Product</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <tr>
                <td>Sara</td>
                <td>Wallpaper</td>
                <td>Pending</td>
                <td>
                    <button class="btn view">View</button>
                    <button class="btn edit">Approve</button>
                    <button class="btn delete">Reject</button>
                </td>
            </tr>
        </table>
    </div>

</div>

</body>
</html>

