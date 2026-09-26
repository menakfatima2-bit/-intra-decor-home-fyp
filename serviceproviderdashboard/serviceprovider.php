<?php
session_start();
include "../db.php";

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'service_provider'){
    header("Location: ../login.php");
    exit();
}

$provider_id = $_SESSION['user_id'];
$provider_name = $_SESSION['user_name'];

$chk_res = mysqli_query($conn, "SELECT id FROM users WHERE id='$provider_id'");
if(!$chk_res || mysqli_num_rows($chk_res) == 0){
    session_destroy();
    header("Location: ../login.php");
    exit();
}

/* Total Services */

$q1 = "SELECT COUNT(*) as total_services FROM addservice WHERE serviceprovider_id='$provider_id'";
$r1 = mysqli_query($conn,$q1);
$data1 = mysqli_fetch_assoc($r1);

/* Recent Services */

$q2 = "SELECT * FROM addservice WHERE serviceprovider_id='$provider_id' ORDER BY service_id DESC LIMIT 5";
$services = mysqli_query($conn,$q2);

?>

<!DOCTYPE html>
<html>
<head>

<title>Service Provider Dashboard</title>

<link rel="stylesheet" href="serviceprovider.css?v=2">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body>

<?php include "notifications_bell.php"; ?>

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


<!-- Main Content -->
<div class="main">

<h1>Welcome, <?php echo $provider_name; ?> 👋</h1>
<p class="subtext">Manage your services and connect with customers.</p>

<!-- Cards -->

<div class="cards">

<div class="card">
<i class="fa-solid fa-list"></i>
<h3>Total Services</h3>
<p><?php echo $data1['total_services']; ?></p>
</div>

<div class="card">
<i class="fa-solid fa-star"></i>
<h3>Active Services</h3>
<p><?php echo $data1['total_services']; ?></p>
</div>

<div class="card">
<i class="fa-solid fa-user-check"></i>
<h3>Status</h3>
<p>Active</p>
</div>

</div>


<!-- Recent Services -->

<h2 class="table-title">Recent Services</h2>

<table>

<tr>
<th>Service</th>
<th>Price</th>
<th>City</th>
<th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($services)){ ?>

<tr>

<td><?php echo $row['service_name']; ?></td>
<td>Rs <?php echo $row['started_at']; ?></td>
<td><?php echo $row['city']; ?></td>

<td>

<a class="edit" href="editservice.php?id=<?php echo $row['service_id']; ?>">Edit</a>

<a class="delete" href="deleteservice.php?id=<?php echo $row['service_id']; ?>">Delete</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>