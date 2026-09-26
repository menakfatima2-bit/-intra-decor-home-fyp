<?php
session_start();
include "../db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM favorites WHERE user_id='$user_id'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Favorites</title>
    <link rel="stylesheet" href="favorites.css">
</head>
<body>

<?php include "notifications_bell.php"; ?>

<h2>My Favorites ❤️</h2>

<div class="fav-container">

<?php while($row = mysqli_fetch_assoc($result)) { 

    $item_id = $row['item_id'];
    $type = $row['type'];

    // PRODUCT
    if($type == "product"){
        $q = "SELECT * FROM productadd WHERE id='$item_id'";
        $res = mysqli_query($conn,$q);
        $data = mysqli_fetch_assoc($res);

        if($data){
?>

    <div class="card">
        <img src="../uploads/<?php echo $data['product_image']; ?>">
        <h3><?php echo $data['name']; ?></h3>
        <p>Price: Rs <?php echo $data['price']; ?></p>

        <a href="remove_favorite.php?fav_id=<?php echo $row['id']; ?>" class="remove-btn">
            ❌ Remove
        </a>
    </div>

<?php } }

    // SERVICE
    if($type == "service"){
        $q = "SELECT * FROM addservice WHERE service_id='$item_id'";
        $res = mysqli_query($conn,$q);
        $data = mysqli_fetch_assoc($res);

        if($data){
?>

    <div class="card">
        <h3><?php echo $data['service_name']; ?></h3>
        <p>Starting Price: Rs <?php echo $data['price_start']; ?></p>
        <p>City: <?php echo $data['city']; ?></p>

        <a href="remove_favorite.php?fav_id=<?php echo $row['id']; ?>" class="remove-btn">
            ❌ Remove
        </a>
    </div>

<?php } } } ?>

</div>

</body>
</html>