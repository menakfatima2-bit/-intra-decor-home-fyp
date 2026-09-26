<?php
session_start();
include "../db.php";

if(!isset($_SESSION['user_id'])){
header("Location: ../login.php");
exit();
}

$service_id = $_GET['id'];

$query = "SELECT * FROM addservice WHERE service_id='$service_id'";
$result = mysqli_query($conn,$query);
$row = mysqli_fetch_assoc($result);


if(isset($_POST['update'])){

$service_name = $_POST['service_name'];
$description = $_POST['description'];
$price = $_POST['price_start'];
$experience = $_POST['experience'];
$city = $_POST['city'];
$status = $_POST['status'];

$update="UPDATE addservice SET

service_name='$service_name',
service_description='$description',
started_at='$price',
experience='$experience',
city='$city',
status='$status'

WHERE service_id='$service_id'";

mysqli_query($conn,$update);

header("Location: servicelist.php");
exit();

}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Edit Service</title>

<link rel="stylesheet" href="editservice.css?v=2">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body>

<div class="container">

    <!-- Sidebar -->
<div class="sidebar">
<h2><i class="fa-solid fa-user-gear"></i> Service Provider</h2>

<ul>
<li><a href="serviceprovider.php"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>
<li><a href="addservice.php" class="active"><i class="fa-solid fa-plus"></i> Add Service</a></li>
<li><a href="servicelist.php"><i class="fa-solid fa-list"></i> My Services</a></li>
<li><a href="providerprofile.php"><i class="fa-solid fa-user"></i> Profile</a></li>
<li><a href="../logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
</ul>
</div>

<!-- MAIN AREA -->

<div class="main">

<div class="form-card">

<form method="POST">

<h2 class="form-title">Edit Service</h2>


<div class="form-group">

<label>Service Name</label>

<input type="text" name="service_name" 
value="<?php echo $row['service_name']; ?>" required>

</div>


<div class="form-group">

<label>Description</label>

<textarea name="description" required><?php echo $row['service_description']; ?></textarea>

</div>

<div class="form-group">

<label>Price Start</label>

<input type="number" name="price_start" 
value="<?php echo $row['started_at']; ?>" required>

</div>

<div class="form-group">
<label>Service Images</label>

<div class="gallery">
<?php
$img_query="SELECT * FROM service_gallery WHERE service_id='$service_id'";
$img_result=mysqli_query($conn,$img_query);

while($img=mysqli_fetch_assoc($img_result)){
?>
<div class="img-box">
<img src="../uploads/<?php echo $img['image_path']; ?>">
<a href="deleteimage.php?id=<?php echo $img['gallery_id']; ?>"
class="delete-img"
onclick="return confirm('Delete this image?')">
<i class="fa fa-trash"></i>
</a>
</div>
<?php } ?>
</div>

</div>

<div class="form-group">

<label>Experience</label>

<input type="text" name="experience" 
value="<?php echo $row['experience']; ?>" required>

</div>

<div class="form-group">

<label>City</label>

<input type="text" name="city" 
value="<?php echo $row['city']; ?>" required>

</div>

<div class="form-group">

<label>Status</label>

<select name="status">

<option value="Active"
<?php if($row['status']=="Active") echo "selected"; ?>>
Active
</option>

<option value="Inactive"
<?php if($row['status']=="Inactive") echo "selected"; ?>>
Inactive
</option>

</select>

</div>

<button type="submit" name="update">
Update Service
</button>

</form>
</div>

</div> <!-- MAIN END -->

</body>
</html>