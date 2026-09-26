<?php
session_start();
include "../db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (!isset($_GET['product_id'])) {
    echo "Invalid Product!";
    exit();
}

$product_id = intval($_GET['product_id']);

// Fetch product details
$product_query = mysqli_query($conn, "SELECT name, product_image FROM productadd WHERE id = '$product_id'");
$product = mysqli_fetch_assoc($product_query);

if (!$product) {
    echo "Product not found!";
    exit();
}

// Verify if user actually purchased this product and it has been delivered
$order_check = mysqli_query($conn, "SELECT * FROM orders WHERE user_id = '$user_id' AND product_id = '$product_id' AND status = 'delivered' LIMIT 1");
if (mysqli_num_rows($order_check) == 0) {
    echo "<div style='text-align:center; padding:50px; font-family:sans-serif; color:#333;'>
            <h2>Access Denied</h2>
            <p>You can only leave feedback for products you have purchased and that have been delivered to you.</p>
            <a href='myorders.php' style='color:#4b2c2c; font-weight:bold;'>Go Back to My Orders</a>
          </div>";
    exit();
}

// Check if review already exists
$review_check = mysqli_query($conn, "SELECT * FROM product_reviews WHERE user_id = '$user_id' AND product_id = '$product_id'");
$already_reviewed = mysqli_num_rows($review_check) > 0;

$success_msg = "";
$error_msg = "";

if (isset($_POST['submit_feedback'])) {
    if ($already_reviewed) {
        $error_msg = "You have already submitted feedback for this product.";
    } else {
        $rating = intval($_POST['rating']);
        $feedback = mysqli_real_escape_string($conn, trim($_POST['feedback']));

        if ($rating < 1 || $rating > 5) {
            $error_msg = "Please select a rating between 1 and 5 stars.";
        } elseif (empty($feedback)) {
            $error_msg = "Please write a review comment.";
        } else {
            $insert_query = "INSERT INTO product_reviews (user_id, product_id, rating, feedback) VALUES ('$user_id', '$product_id', '$rating', '$feedback')";
            if (mysqli_query($conn, $insert_query)) {
                echo "<script>alert('Thank you for your feedback!'); window.location='myorders.php';</script>";
                exit();
            } else {
                $error_msg = "Something went wrong. Please try again.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Give Feedback - <?php echo htmlspecialchars($product['name']); ?></title>
    <link rel="stylesheet" href="userdashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .feedback-card {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            max-width: 550px;
            margin: 40px auto;
        }
        .product-info {
            display: flex;
            align-items: center;
            gap: 15px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .product-info img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 8px;
        }
        .product-info h3 {
            color: #4b2c2c;
            margin: 0;
            font-size: 1.1rem;
        }
        .rating-stars {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center;
            gap: 8px;
            margin: 15px 0 25px;
        }
        .rating-stars input {
            display: none;
        }
        .rating-stars label {
            font-size: 2.2rem;
            color: #ddd;
            cursor: pointer;
            transition: color 0.15s ease;
        }
        .rating-stars input:checked ~ label,
        .rating-stars label:hover,
        .rating-stars label:hover ~ label {
            color: #ffaa00;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #4b2c2c;
            font-size: 14px;
        }
        .form-group textarea {
            width: 100%;
            height: 120px;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-family: inherit;
            resize: none;
            outline: none;
            transition: border-color 0.2s;
        }
        .form-group textarea:focus {
            border-color: #4b2c2c;
        }
        .btn-submit {
            background: #4b2c2c;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 25px;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
            transition: background 0.2s;
        }
        .btn-submit:hover {
            background: #6b3d3d;
        }
        .alert {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 14px;
        }
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>

<?php include "notifications_bell.php"; ?>

<div class="dashboard-wrapper">
    <div class="sidebar">
        <h2>Intra Decor</h2>
        <a href="userdashboard.php"><i class="fa fa-home"></i> Dashboard</a>
        <a href="../cart.php"><i class="fa fa-cart-shopping"></i> My Cart</a>
        <a href="favorites.php"><i class="fa fa-heart"></i> Favorites</a>
        <a href="myorders.php" class="active"><i class="fa fa-box"></i> My Orders</a>
        <a href="userprofile.php"><i class="fa fa-user"></i> Profile</a>
        <a href="../logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="main-content">
        <div class="feedback-card">
            <h2 style="color: #4b2c2c; margin-bottom: 15px; text-align: center;">Product Feedback</h2>
            
            <div class="product-info">
                <img src="../uploads/<?php echo htmlspecialchars($product['product_image']); ?>" alt="Product">
                <div>
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p style="color:#777; font-size:12px; margin-top:4px;">Share your experience with this product</p>
                </div>
            </div>

            <?php if ($error_msg != ""): ?>
                <div class="alert alert-error"><?php echo $error_msg; ?></div>
            <?php endif; ?>

            <?php if ($already_reviewed): ?>
                <div style="text-align: center; padding: 20px;">
                    <i class="fa-solid fa-circle-check" style="font-size: 3rem; color: #2ecc71; margin-bottom: 15px;"></i>
                    <h3 style="color:#333;">Feedback Submitted</h3>
                    <p style="color:#777; margin-top:8px;">You have already reviewed this product. Thank you!</p>
                    <a href="myorders.php" class="shop-btn" style="display:inline-block; margin-top:20px;">Back to My Orders</a>
                </div>
            <?php else: ?>
                <form method="POST">
                    <div class="form-group" style="text-align: center;">
                        <label>Select Rating</label>
                        <div class="rating-stars">
                            <input type="radio" id="star5" name="rating" value="5" required><label for="star5" title="5 stars"><i class="fa-solid fa-star"></i></label>
                            <input type="radio" id="star4" name="rating" value="4"><label for="star4" title="4 stars"><i class="fa-solid fa-star"></i></label>
                            <input type="radio" id="star3" name="rating" value="3"><label for="star3" title="3 stars"><i class="fa-solid fa-star"></i></label>
                            <input type="radio" id="star2" name="rating" value="2"><label for="star2" title="2 stars"><i class="fa-solid fa-star"></i></label>
                            <input type="radio" id="star1" name="rating" value="1"><label for="star1" title="1 star"><i class="fa-solid fa-star"></i></label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="feedback">Your Review</label>
                        <textarea id="feedback" name="feedback" placeholder="Write your honest experience here..." required></textarea>
                    </div>

                    <button type="submit" name="submit_feedback" class="btn-submit">Submit Feedback</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>
