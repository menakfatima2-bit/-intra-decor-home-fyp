<?php
include "db.php";

// ✅ Check product ID from URL
if(!isset($_GET['id'])){
    die("Product not found.");
}

$id = intval($_GET['id']);

// ✅ Fetch product from database
$query = "SELECT * FROM productadd WHERE id='$id'";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) == 0){
    die("Product not found.");
}

$product = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Details</title>
    <link rel="stylesheet" href="viewdetail.css?v=4">
</head>
<body>

<div class="sidebar">
    <h2>Seller Panel</h2>
    <a href="Dashboard.php">Dashboard</a>
    <a href="addproduct.php">Add Product</a>
    <a href="productlist.php" class="active">View Products</a>
    <a href="profile.php">Profile</a>
    <a href="../logout.php">Logout</a>
</div>

<div class="main-content">
    <div class="details-card">
        <h2>Product Details</h2>

        <div class="product-image">
            <img src="../uploads/<?php echo $product['product_image']; ?>" alt="Product Image">
        </div>

        <div class="info-grid">
            <div class="info-item">
                <strong>Name</strong>
                <?php echo $product['name']; ?>
            </div>

            <div class="info-item">
                <strong>Category</strong>
                <?php echo $product['category']; ?>
            </div>

            <div class="info-item">
                <strong>Type</strong>
                <span class="type-badge"><?php echo ucfirst($product['product_type']); ?></span>
            </div>

            <div class="info-item">
                <strong>Price</strong>
                Rs <?php echo $product['price']; ?>
            </div>

            <div class="info-item">
                <strong>Quantity</strong>
                <?php echo $product['quantity']; ?>
            </div>

            <div class="info-item">
                <strong>Discount</strong>
                <?php echo $product['discount']; ?>%
            </div>

            <?php if($product['category'] == 'wallpaper'): ?>
            <div class="info-item">
                <strong>Roll Width</strong>
                <?php echo $product['roll_width'] ? $product['roll_width'] . ' cm' : 'N/A'; ?>
            </div>

            <div class="info-item">
                <strong>Roll Length</strong>
                <?php echo $product['roll_length'] ? $product['roll_length'] . ' cm' : 'N/A'; ?>
            </div>

            <div class="info-item">
                <strong>Material</strong>
                <?php echo $product['material'] ? $product['material'] : 'N/A'; ?>
            </div>
            <?php endif; ?>

            <div class="info-item">
                <strong>Status</strong>
                <span class="<?php echo ($product['status']=='Active') ? 'status-active' : 'status-out'; ?>">
                    <?php echo $product['status']; ?>
                </span>
            </div>
        </div>

        <div class="description">
            <strong>Description</strong>
            <p><?php echo $product['description']; ?></p>
        </div>
        
        <?php if($product['category'] == 'wallpaper' && $product['roll_width'] && $product['roll_length']): ?>
        <div class="wallpaper-note">
            ⚠️ <strong>Customer Note:</strong> 1 roll = <?php echo $product['roll_width']; ?>cm × <?php echo $product['roll_length']; ?>cm — Please measure your wall before ordering.
        </div>
        <?php endif; ?>

        <a href="productlist.php" class="back-btn">Back</a>
    </div>
</div>

</body>
</html>