<?php
session_start();
include "../db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$orders = mysqli_query($conn, 
    "SELECT orders.*, productadd.name, productadd.product_image 
     FROM orders 
     JOIN productadd ON orders.product_id = productadd.id
     WHERE orders.user_id = '$user_id'
     ORDER BY orders.id DESC"
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Orders</title>
    <link rel="stylesheet" href="userdashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .order-card {
            background: white;
            border-radius: 14px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            padding: 20px;
            margin-bottom: 20px;
        }
        .order-card-top {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }
        .order-card-top img {
            width: 64px;
            height: 64px;
            object-fit: cover;
            border-radius: 10px;
            flex-shrink: 0;
        }
        .order-card-info { flex: 1; min-width: 180px; }
        .order-card-info h3 { color: #4b2c2c; font-size: 16px; margin-bottom: 4px; }
        .order-card-info .order-sub { color: #888; font-size: 12.5px; }
        .order-card-right { text-align: right; }
        .order-card-right .order-amount { color: #4b2c2c; font-weight: bold; font-size: 15px; }
        .order-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12.5px;
            font-weight: 600;
            margin-top: 4px;
        }
        .badge-pending   { background: #fff3cd; color: #856404; }
        .badge-confirmed { background: #d1e7dd; color: #0a3622; }
        .badge-delivered { background: #cfe2ff; color: #084298; }
        .badge-cancelled { background: #f8d7da; color: #842029; }

        /* Status Tracker */
        .status-track {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin: 26px 6px 8px;
        }
        .status-track::before {
            content: '';
            position: absolute;
            top: 18px; left: 8%; right: 8%;
            height: 4px;
            background: #eee;
            z-index: 0;
            border-radius: 2px;
        }
        .status-step { flex: 1; text-align: center; position: relative; z-index: 1; }
        .status-step .dot {
            width: 38px; height: 38px; border-radius: 50%;
            background: #fff; color: #aaa;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 8px; font-size: 14px;
            border: 3px solid #eee;
        }
        .status-step.done .dot {
            background: #4b2c2c; color: #fff; border-color: #4b2c2c;
        }
        .status-step span {
            font-size: 12px; color: #999; font-weight: 500;
        }
        .status-step.done span { color: #4b2c2c; font-weight: 700; }

        .cancelled-banner {
            background: #fdecea; color: #c0392b;
            padding: 10px 16px; border-radius: 10px;
            font-size: 13px; margin-top: 18px; text-align: center;
        }

        .order-feedback { margin-top: 16px; text-align: right; }
        .feedback-btn {
            background: #ffa502; color: white; padding: 6px 14px;
            border-radius: 20px; text-decoration: none; font-size: 12px;
            font-weight: bold; display: inline-block;
        }
        .feedback-stars { color: #ffa502; font-size: 14px; font-weight: bold; }
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
        <h2 style="color:#4b2c2c; margin-bottom:20px;">My Orders</h2>

        <?php if(mysqli_num_rows($orders) > 0){ ?>

            <?php
            $stepOrder = ['pending', 'confirmed', 'delivered'];

            while($row = mysqli_fetch_assoc($orders)){
                $prod_id = $row['product_id'];
                $status  = strtolower($row['status']);

                $review_q = mysqli_query($conn, "SELECT rating FROM product_reviews WHERE user_id = '$user_id' AND product_id = '$prod_id' LIMIT 1");
                $has_reviewed = mysqli_num_rows($review_q) > 0;
                $rating_stars = "";
                if ($has_reviewed) {
                    $review_data = mysqli_fetch_assoc($review_q);
                    $rating_stars = str_repeat("★", $review_data['rating']) . str_repeat("☆", 5 - $review_data['rating']);
                }

                $badgeClass = 'badge-pending';
                if($status == 'confirmed') $badgeClass = 'badge-confirmed';
                elseif($status == 'delivered') $badgeClass = 'badge-delivered';
                elseif($status == 'cancelled') $badgeClass = 'badge-cancelled';

                $currentIndex = array_search($status, $stepOrder);
            ?>
            <div class="order-card">
                <div class="order-card-top">
                    <img src="../uploads/<?php echo htmlspecialchars($row['product_image']); ?>">
                    <div class="order-card-info">
                        <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                        <div class="order-sub">Order #<?php echo $row['id']; ?> &nbsp;•&nbsp; <?php echo date('d M Y', strtotime($row['created_at'])); ?></div>
                    </div>
                    <div class="order-card-right">
                        <div class="order-amount">Rs. <?php echo number_format($row['amount'], 0); ?></div>
                        <span class="order-badge <?php echo $badgeClass; ?>"><?php echo ucfirst($status); ?></span>
                    </div>
                </div>

                <?php if($status == 'cancelled'){ ?>
                    <div class="cancelled-banner">
                        <i class="fa-solid fa-circle-xmark"></i> This order has been cancelled.
                    </div>
                <?php } else { ?>
                    <div class="status-track">
                        <div class="status-step <?php echo ($currentIndex !== false && $currentIndex >= 0) ? 'done' : ''; ?>">
                            <div class="dot"><i class="fa-solid fa-receipt"></i></div>
                            <span>Order Placed</span>
                        </div>
                        <div class="status-step <?php echo ($currentIndex !== false && $currentIndex >= 1) ? 'done' : ''; ?>">
                            <div class="dot"><i class="fa-solid fa-box"></i></div>
                            <span>Confirmed</span>
                        </div>
                        <div class="status-step <?php echo ($currentIndex !== false && $currentIndex >= 2) ? 'done' : ''; ?>">
                            <div class="dot"><i class="fa-solid fa-house"></i></div>
                            <span>Delivered</span>
                        </div>
                    </div>
                <?php } ?>

                <?php if ($status == 'delivered') { ?>
                    <div class="order-feedback">
                        <?php if ($has_reviewed) { ?>
                            <span class="feedback-stars"><?php echo $rating_stars; ?></span>
                        <?php } else { ?>
                            <a href="give_feedback.php?product_id=<?php echo $row['product_id']; ?>" class="feedback-btn">Give Feedback</a>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
            <?php } ?>

        <?php } else { ?>
            <div style="text-align:center; padding:60px; background:white; border-radius:12px;">
                <i class="fa fa-box" style="font-size:3rem; color:#ccc;"></i>
                <h3 style="color:#888; margin-top:15px;">No orders yet!</h3>
                <a href="../index.php" style="color:#ffa502;">Start Shopping →</a>
            </div>
        <?php } ?>
    </div>
</div>
</body>
</html>