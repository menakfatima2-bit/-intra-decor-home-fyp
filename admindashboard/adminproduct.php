<?php
session_start();
include "../db.php";

if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin'){
    die("Access denied");
}

// FILTER
$status = "pending";
if(isset($_GET['status'])){
    $status = $_GET['status'];
}

// SEARCH
$search = "";
if(isset($_GET['search'])){
    $search = mysqli_real_escape_string($conn, $_GET['search']);
}

// QUERY
$query = "SELECT productadd.*, users.name as seller_name 
FROM productadd 
JOIN users ON productadd.seller_id = users.id
WHERE productadd.status='$status'";

if($search != ""){
    $query .= " AND productadd.name LIKE '%$search%'";
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Products</title>
<link rel="stylesheet" href="adminproduct.css">
</head>
<body>

<?php include "notifications_bell.php"; ?>

<div class="dashboard">

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="admindashboard.php">Dashboard</a>
    <a href="adminseller.php">Manage Sellers</a>
    <a href="adminprovider.php">Manage Providers</a>
    <a href="adminproduct.php" class="active">Manage Products</a>
    <a href="../logout.php">Logout</a>
</div>

<!-- MAIN -->
<div class="main-content">

<h2>Manage Products</h2>

<?php if(isset($_GET['msg'])){ ?>
<p class="success-msg">✔ Action successful!</p>
<?php } ?>

<!-- SEARCH -->
<form method="GET" class="search-bar">
<input type="hidden" name="status" value="<?php echo $status; ?>">
<input type="text" name="search" placeholder="Search product...">
<button type="submit">Search</button>
</form>

<!-- FILTERS -->
<div class="filters">
<a href="adminproduct.php?status=pending">Pending</a>
<a href="adminproduct.php?status=approved">Approved</a>
<a href="adminproduct.php?status=rejected">Rejected</a>
</div>

<table>

<tr>
<th>Image</th>
<th>Product</th>
<th>Seller</th>
<th>Price</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>

<td>
<img src="../uploads/<?php echo $row['product_image']; ?>" width="100">
</td>


<td><?php echo $row['name']; ?></td>

<td><?php echo $row['seller_name']; ?></td>

<td>Rs. <?php echo $row['price']; ?></td>

<td>
<?php
if($row['status'] == 'pending'){
    echo "<span class='badge pending'>Pending</span>";
}
elseif($row['status'] == 'approved'){
    echo "<span class='badge approved'>Approved</span>";
}
else{
    echo "<span class='badge rejected'>Rejected</span>";
}

?>
</td>

<td class="actions">
<a class="approve-btn"
href="adminapprove_product.php?id=<?php echo $row['id']; ?>&status=approved"
onclick="return confirm('Approve this product?')">Approve</a>

<a class="reject-btn"
href="#"
onclick="return rejectProduct(<?php echo $row['id']; ?>)">Reject</a>
</td>

</tr>
<?php } ?>

</table>

<script>
function rejectProduct(id){
    var reason = prompt("Enter the reason for rejection (this will be shown to the seller):");
    if(reason === null || reason.trim() === ""){
        alert("Rejection reason is required.");
        return false;
    }
    window.location.href = "adminapprove_product.php?id=" + id + "&status=rejected&reason=" + encodeURIComponent(reason);
    return false;
}
</script>

</div>
</div>

</body>
</html>