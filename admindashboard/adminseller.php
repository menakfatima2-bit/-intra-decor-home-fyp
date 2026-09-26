<?php
session_start();
include "../db.php";

if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin'){
    die("Access denied");
}

$result = mysqli_query($conn, "SELECT * FROM users WHERE role='seller'");
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Sellers</title>
<link rel="stylesheet" href="adminseller.css">
</head>
<body>

<?php include "notifications_bell.php"; ?>

<div class="dashboard">

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="admindashboard.php">Dashboard</a>
    <a href="adminseller.php" class="active">Manage Sellers</a>
    <a href="adminproduct.php">Manage Products</a>
    <a href="adminprovider.php">Manage Providers</a>
    <a href="../logout.php">Logout</a>
</div>

<!-- MAIN CONTENT -->
<div class="main-content">

<h2>Manage Sellers</h2>

<table>

<tr>
<th>Name</th>
<th>Email</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>

<td><?php echo $row['name']; ?></td>
<td><?php echo $row['email']; ?></td>

<td>
<?php
if($row['is_approved'] == 1){
    echo "<span class='active'>Active</span>";
} else {
    echo "<span class='blocked'>Blocked</span>";
}
?>
</td>

<td>
<a class="approve-btn"
href="adminapprove_seller.php?id=<?php echo $row['id']; ?>"
onclick="return confirm('Approve this seller?')">Approve</a>

<a class="block-btn"
href="adminblock_seller.php?id=<?php echo $row['id']; ?>"
onclick="return confirm('Block this seller?')">Block</a>
</td>

</tr>
<?php } ?>

</table>

</div>
</div>

</body>
</html>