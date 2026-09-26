<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'seller'){
    header("Location: ../login.php");
    exit();
}

$seller_id = $_SESSION['user_id'];

if(!isset($_GET['id'])){
    die("Product not found.");
}

$id = intval($_GET['id']);

/* FETCH PRODUCT (ONLY SELLER OWN PRODUCT) */
$query = "SELECT * FROM productadd 
          WHERE id='$id' AND seller_id='$seller_id'";
$result = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result);

if(!$product){
    die("Unauthorized access.");
}

/* UPDATE PRODUCT */
if(isset($_POST['updateproduct'])){

    $name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $image = $product['product_image']; // old image default

    /* If new image uploaded */
    if(isset($_FILES['image']) && $_FILES['image']['error'] === 0){

        $newImage = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];

        $newImage = preg_replace("/[^a-zA-Z0-9\.\-_]/", "_", $newImage);

        $uploadDir = __DIR__ . "/uploads/";

        if(file_exists($uploadDir . $newImage)){
            $newImage = time() . "_" . $newImage;
        }

        move_uploaded_file($tmp, $uploadDir . $newImage);

        $image = $newImage; // replace old image
    }

    // NEW: any edit sends the product back for admin review (status resets to pending,
    // old rejection reason is cleared so the seller's product list shows it as fresh again)
    $update = "UPDATE productadd SET
                name='$name',
                price='$price',
                category='$category',
                product_type='$type',
                description='$description',
                product_image='$image',
                status='pending',
                reject_reason=NULL
               WHERE id='$id' AND seller_id='$seller_id'";

    if(mysqli_query($conn, $update)){
        header("Location: productlist.php?resubmitted=1");
        exit();
    } else {
        die("Update failed.");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <link rel="stylesheet" href="editproduct.css">
</head>
<body>

<div class="sidebar">
    <h2>Intra Decor</h2>
    <a href="Dashboard.php">Dashboard</a>
    <a href="addproduct.php">Add Product</a>
    <a href="productlist.php" class="active">Product List</a>
    <a href="sellerprofile.php">Seller Profile</a>
    <a href="../logout.php">Logout</a>
</div>

<div class="main-content">
    <div class="container">
        <h2>Edit Product</h2>

        <?php if($product['status'] == 'rejected'){ ?>
            <p style="background:#fdecea; color:#c0392b; padding:10px 14px; border-radius:6px; font-size:14px;">
                ⚠ This product was rejected. Updating it will resend it to the admin for review.
            </p>
        <?php } ?>

        <form method="POST" enctype="multipart/form-data">

            <div>
                <label>Product Name</label>
                <input type="text" name="product_name"
                       value="<?php echo $product['name']; ?>" required>
            </div>

            <div>
                <label>Price</label>
                <input type="number" name="price"
                       value="<?php echo $product['price']; ?>" required>
            </div>

            <div>
                <label>Category</label>
                <input type="text" name="category"
                       value="<?php echo $product['category']; ?>" required>
            </div>

            <div>
                <label>Product Type</label>
                <input type="text" name="type"
                       value="<?php echo $product['product_type']; ?>" required>
            </div>

            <div class="full-width">
                <label>Description</label>
                <textarea name="description"><?php echo $product['description']; ?></textarea>
            </div>

            <div class="full-width">
                <label>Change Image (Optional)</label>
                <input type="file" name="image">
                <p>Current Image: <?php echo $product['product_image']; ?></p>
            </div>

            <button type="submit" name="updateproduct">Update Product</button>

        </form>
    </div>
</div>

</body>
</html>