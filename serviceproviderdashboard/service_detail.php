<?php
session_start();  // ✅ Fix 1: session start
include "../db.php";

// ✅ Fix 2: login check — service_provider hi dekh sake
if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'service_provider'){
    header("Location: ../login.php");
    exit();
}

$service_id = $_GET['id'];

/* service data */
$q = "SELECT * FROM addservice WHERE service_id='$service_id'";
$result = mysqli_query($conn,$q);
$data = mysqli_fetch_assoc($result);

/* gallery images */
$gallery = mysqli_query($conn,"SELECT * FROM service_gallery WHERE service_id='$service_id'");

$images = [];

while($img = mysqli_fetch_assoc($gallery)){
    $images[] = $img['image_path'];
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Service Detail</title>
<link rel="stylesheet" href="service_detail.css">
</head>
<body>

<div class="container">

<!-- LEFT SIDE DETAILS -->
<div class="details">

<h2><?php echo $data['service_name']; ?></h2>

<div class="price">
Rs <?php echo $data['started_at']; ?>
</div>

<p class="desc">
<?php echo $data['service_description']; ?>
</p>

<div class="info">
<p><b>City:</b> <?php echo $data['city']; ?></p>
<p><b>Experience:</b> <?php echo $data['experience']; ?> Years</p>
</div>

<a href="servicelist.php" class="btn">Back to Services</a>

</div>

<!-- RIGHT SIDE IMAGES -->
<div class="image-box">

<img id="mainImg" class="main-img"
src="../uploads/<?php echo $images[0] ?? 'noimage.jpg'; ?>">  <!-- ✅ Fix 3: path -->

<div class="thumbs">

<?php foreach($images as $img){ ?>
<img onclick="changeImg(this)"
src="../uploads/<?php echo $img; ?>">
<?php } ?>

</div>

</div>

</div>

<script>
function changeImg(img){
    document.getElementById("mainImg").src = img.src;
}
</script>

</body>
</html>