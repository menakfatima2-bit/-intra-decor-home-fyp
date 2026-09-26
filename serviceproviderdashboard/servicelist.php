<?php
session_start();
include "../db.php";

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'service_provider'){
    header("Location: ../login.php");
    exit();
}

$provider_id = $_SESSION['user_id'];

$query = "SELECT a.*, p.phone 
          FROM addservice a
          LEFT JOIN providerprofile p ON a.serviceprovider_id = p.provider_id
          WHERE a.serviceprovider_id='$provider_id' 
          ORDER BY a.service_id DESC";

$result = mysqli_query($conn,$query);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>My Services</title>

<link rel="stylesheet" href="servicelist.css?v=2">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body>

<!-- SIDEBAR -->

<div class="sidebar">

<h2><i class="fa-solid fa-user-gear"></i> Service Provider</h2>

<ul>
<li><a href="serviceprovider.php"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>
<li><a href="addservice.php"><i class="fa-solid fa-plus"></i> Add Service</a></li>
<li><a href="servicelist.php" class="active"><i class="fa-solid fa-list"></i> My Services</a></li>
<li><a href="mybookings.php"><i class="fa-solid fa-calendar-check"></i> My Bookings</a></li>
<li><a href="providerprofile.php"><i class="fa-solid fa-user"></i> Profile</a></li>
<li><a href="../logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
</ul>

</div>

<!-- MAIN DASHBOARD AREA -->

<div class="main">

<div class="container">

<h2>My Services</h2>

<div class="service-grid">

<?php while($row=mysqli_fetch_assoc($result)){ 

$service_id=$row['service_id'];

?>

<div class="service-card">

<!-- SERVICE IMAGES -->

<div class="service-images">

<?php

$img_query="SELECT * FROM service_gallery 
            WHERE service_id='$service_id'";

$img_result=mysqli_query($conn,$img_query);

$images=[];

while($img=mysqli_fetch_assoc($img_result)){
$images[]=$img['image_path'];
}

?>

<img class="main-img"
id="main<?php echo $service_id;?>"
src="../uploads/<?php echo $images[0] ?? 'noimage.jpg'; ?>">

<?php if(count($images)>1){ ?>

<div class="thumbs">

<?php foreach($images as $img){ ?>

<img 
onclick="changeImg(this,'main<?php echo $service_id;?>')"
src="../uploads/<?php echo $img; ?>">

<?php } ?>

</div>

<?php } ?>

</div>


<!-- SERVICE INFO -->

<div class="service-info">

<h3><?php echo $row['service_name']; ?></h3>

<p>
<?php echo substr($row['service_description'],0,90); ?>...
</p>

<div class="meta">

<span>
<i class="fa-solid fa-money-bill"></i>
From Rs <?php echo $row['started_at']; ?>
</span>

<span>
<i class="fa-solid fa-location-dot"></i>
<?php echo $row['city']; ?>
</span>

<span>
<i class="fa-solid fa-star"></i>
<?php echo $row['experience']; ?> yrs
</span>

<span>
<i class="fa-solid fa-phone"></i>
<?php echo $row['phone'] ?? 'Not provided'; ?>
</span>

<span>
<i class="fa-solid fa-circle"></i>
<span class="status-<?php echo strtolower($row['status']); ?>">
<?php echo $row['status']; ?>
</span>

</div>

<div class="actions">

<a href="service_detail.php?id=<?php echo $service_id; ?>" class="view">
<i class="fa-solid fa-eye"></i> View
</a>

<a href="editservice.php?id=<?php echo $service_id; ?>" class="edit">
<i class="fa-solid fa-pen"></i> Edit
</a>

<a href="deleteservice.php?id=<?php echo $service_id; ?>" 
class="delete"
onclick="return confirm('Delete this service?')">

<i class="fa-solid fa-trash"></i> Delete

</a>

</div>

</div>

</div>

<?php } ?>

</div>

</div>


<script>

function changeImg(img,mainId){
document.getElementById(mainId).src = img.src;
}

</script>

</body>
</html>