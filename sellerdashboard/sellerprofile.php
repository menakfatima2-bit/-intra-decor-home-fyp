<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* ---------------- USER TABLE SE NAME + EMAIL FETCH ---------------- */
$userQuery = "SELECT name, email FROM users WHERE id='$user_id'";
$userResult = mysqli_query($conn, $userQuery);
$userData = mysqli_fetch_assoc($userResult);

/* ---------------- SELLER PROFILE FETCH ---------------- */
$query = "SELECT * FROM sellerprofile WHERE userid='$user_id'";
$result = mysqli_query($conn, $query);
$profileData = mysqli_fetch_assoc($result);

/* ---------------- FORM SUBMIT ---------------- */
if(isset($_POST['phone'])){
    $phone = $_POST['phone'];
    $storename = $_POST['storename'];
    $storeaddress = $_POST['storeaddress'];
    $storedescription = $_POST['storedescription'];
    $city = $_POST['city'];

    if($profileData){
        // UPDATE
        $update = "UPDATE sellerprofile 
                   SET phone='$phone',
                       storename='$storename',
                       storeaddress='$storeaddress',
                       storedescription='$storedescription',
                       city='$city'
                   WHERE userid='$user_id'";
        mysqli_query($conn, $update);
    } else {
        // INSERT
        $insert = "INSERT INTO sellerprofile 
                   (userid, phone, storename, storeaddress, storedescription, city)
                   VALUES 
                   ('$user_id', '$phone', '$storename', '$storeaddress', '$storedescription', '$city')";
        mysqli_query($conn, $insert);
    }

    header("Location: sellerprofile.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Seller Profile</title>
    <link rel="stylesheet" href="sellerprofile.css?v=2">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div class="sidebar">
    <h2>Seller Dashboard</h2>
    <a href="Dashboard.php">Dashboard</a>
    <a href="addproduct.php">Add Product</a>
    <a href="productlist.php">My Products</a>
    <a href="sellerprofile.php" class="active">Profile</a>
    <a href="seller_orders.php">Orders</a>
    <a href="../logout.php">Logout</a>
</div>

<div class="main-content">
    <div class="container">
        <form method="POST">
            <h2>Seller Profile</h2>

            <div class="input-group">
                <i class="fa fa-user"></i>
                <input type="text" value="<?php echo $userData['name']; ?>" readonly>
            </div>

            <div class="input-group">
                <i class="fa fa-envelope"></i>
                <input type="email" value="<?php echo $userData['email']; ?>" readonly>
            </div>

            <div class="input-group">
                <i class="fa fa-phone"></i>
                <input type="tel" name="phone" value="<?php echo isset($profileData['phone']) ? $profileData['phone'] : ''; ?>" required>
            </div>

            <div class="input-group">
                <i class="fa fa-city"></i>
                <input type="text" name="city" value="<?php echo isset($profileData['city']) ? $profileData['city'] : ''; ?>" required>
            </div>

            <div class="input-group">
                <i class="fa fa-location-dot"></i>
                <input type="text" name="storeaddress" value="<?php echo isset($profileData['storeaddress']) ? $profileData['storeaddress'] : ''; ?>" required>
            </div>

            <div class="input-group textarea-group">
                <i class="fa fa-pen"></i>
                <textarea name="storedescription" rows="4" required><?php echo isset($profileData['storedescription']) ? $profileData['storedescription'] : ''; ?></textarea>
            </div>

            <button type="submit">Save Profile</button>
        </form>
    </div>
</div>

</body>
</html>