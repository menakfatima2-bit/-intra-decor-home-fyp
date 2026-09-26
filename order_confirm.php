<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id']) || !isset($_SESSION['last_order'])){
    header("Location: index.php");
    exit();
}

$order = $_SESSION['last_order'];
unset($_SESSION['last_order']); // Ek baar dikhao phir hatao

$payment_labels = [
    'cod'       => 'Cash on Delivery',
    'jazzcash'  => 'JazzCash',
    'easypaisa' => 'Easypaisa',
    'safepay'   => 'Safepay (Card/Wallet)'
];
$payment_label = $payment_labels[$order['payment_method']] ?? $order['payment_method'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmed — Intra Decor Home</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { background: #f5f0f0; }

        .confirm-wrapper {
            max-width: 600px;
            margin: 60px auto;
            padding: 0 20px;
            text-align: center;
        }

        .order-id-box {
            background: #fff8e1;
            border: 1px dashed #d4a96a;
            border-radius: 12px;
            padding: 16px 18px;
            margin: 0 0 20px;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .order-id-box .oid-label { font-size: 12px; text-transform: uppercase; letter-spacing: 1px; color: #8a6d3b; }
        .order-id-box .oid-value { font-size: 1.8rem; font-weight: 700; color: #4b2c2c; }
        .order-id-box .oid-note  { font-size: 13px; color: #666; line-height: 1.5; }
        .order-id-box .oid-note a { color: #4b2c2c; font-weight: 600; }

        .confirm-box {
            background: white;
            border-radius: 20px;
            padding: 50px 40px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.1);
        }

        .check-icon {
            width: 80px;
            height: 80px;
            background: #e8f8f1;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2.5rem;
            animation: popIn 0.5s ease;
        }

        @keyframes popIn {
            0%   { transform: scale(0); opacity: 0; }
            70%  { transform: scale(1.2); }
            100% { transform: scale(1); opacity: 1; }
        }

        .confirm-box h1 {
            color: #1D9E75;
            font-size: 1.8rem;
            margin-bottom: 8px;
        }

        .confirm-box p.sub {
            color: #888;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .order-details {
            background: #fdf8f8;
            border-radius: 12px;
            padding: 20px;
            text-align: left;
            margin-bottom: 30px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 14px;
            border-bottom: 1px solid #f0e8e8;
        }

        .detail-row:last-child { border-bottom: none; }

        .detail-row .label { color: #888; }
        .detail-row .value { color: #333; font-weight: 500; }
        .detail-row .value.total { color: #4b2c2c; font-size: 1.1rem; font-weight: bold; }

        .payment-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #fff3cd;
            color: #856404;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
        }

        .btn-row {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-primary {
            background: #4b2c2c;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 25px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary:hover { background: #6b3d3d; }

        .btn-outline {
            background: white;
            color: #4b2c2c;
            padding: 12px 30px;
            border: 2px solid #4b2c2c;
            border-radius: 25px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-outline:hover {
            background: #4b2c2c;
            color: white;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<div class="topheader">
    <div class="headerleftside">
        <div class="logo-box">
            <img src="assets/images/logo.png" alt="Logo"/>
        </div>
        <div class="search-box">
            <form action="search.php" method="GET" style="display:contents;">
                <input type="text" name="q" placeholder="Search products & services..." value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>" autocomplete="off">
                <i class="fa-solid fa-magnifying-glass" style="cursor:pointer;" onclick="this.closest('form').submit()"></i>
            </form>
        </div>
    </div>
    <div class="headerrightside">
        <div class="user-menu">
            <?php if (isset($_SESSION['user_id'])) { ?>
                <a class="login" href="logout.php">Logout</a>
            <?php } else { ?>
                <a class="login" href="login.php">Login/Signup</a>
            <?php } ?>
            <a class="my-account" href="userdashboard/userdashboard.php"><i class="fa-solid fa-user"></i> My Account</a>
        </div>
        <div class="cart-box">
            <a href="cart.php">
                <i class="fa-solid fa-cart-shopping"></i>
                <span class="cart-text">Cart</span>
            </a>
        </div>
    </div>
    <div class="hamburger"><i class="fa-solid fa-bars"></i></div>
</div>

<div class="bottomheader">
    <a href="index.php" class="nav-btn">Home</a>
    <a href="paint.php" class="nav-btn">Paint Visualizer</a>
    <a href="Tiles.php" class="nav-btn">Tiles</a>
    <a href="wallpaper.php" class="nav-btn">Wallpaper</a>
    <a href="wallpenals.php" class="nav-btn">Wall Panelling</a>
    <a href="services.php" class="nav-btn">Services</a>
    <a href="room-preview.php" class="nav-btn">AI Room Designer</a>
</div>

<!-- CONFIRMATION -->
<div class="confirm-wrapper">
    <div class="confirm-box">

        <div class="check-icon">✅</div>

       <h1>Order Placed Successfully!</h1>
<p class="sub">Thank you, <?php echo htmlspecialchars($order['name']); ?>! Your order has been received.</p>
        <?php if(!empty($order['order_ids'])){ ?>
        <div class="order-id-box">
            <span class="oid-label">Your Order ID<?php echo count($order['order_ids']) > 1 ? 's' : ''; ?></span>
            <span class="oid-value">#<?php echo implode(', #', array_map('intval', $order['order_ids'])); ?></span>
            <span class="oid-note">
                <i class="fa fa-circle-info"></i>
                Save this ID. You can track your order anytime from
                <a href="Track-order.php">Track Order</a> using this ID and your phone number.
                A copy has also been sent to your email.
            </span>
        </div>
        <?php } ?>

        <div class="order-details">
            <div class="detail-row">
                <span class="label">Name</span>
                <span class="value"><?php echo htmlspecialchars($order['name']); ?></span>
            </div>
            <div class="detail-row">
                <span class="label">Phone</span>
                <span class="value"><?php echo htmlspecialchars($order['phone']); ?></span>
            </div>
            <div class="detail-row">
                <span class="label">Address</span>
                <span class="value"><?php echo htmlspecialchars($order['address']); ?>, <?php echo htmlspecialchars($order['city']); ?></span>
            </div>
            <div class="detail-row">
                <span class="label">Products</span>
                <span class="value"><?php echo $order['items_count']; ?> item(s)</span>
            </div>
            <div class="detail-row">
                <span class="label">Payment</span>
                <span class="value">
                    <span class="payment-badge">
                        <?php if($order['payment_method'] == 'cod'){ echo '💵'; }
                              elseif($order['payment_method'] == 'jazzcash'){ echo '📱'; }
                              elseif($order['payment_method'] == 'safepay'){ echo '💳'; }
                              else { echo '💚'; } ?>
                        <?php echo $payment_label; ?>
                    </span>
                </span>
            </div>
            <div class="detail-row">
                <span class="label">Total Amount</span>
                <span class="value total">Rs. <?php echo number_format($order['grand_total'], 0); ?></span>
            </div>
        </div>

        <div class="btn-row">
            <a href="userdashboard/myorders.php" class="btn-primary">
                <i class="fa fa-list"></i> My Orders
            </a>
            <a href="index.php" class="btn-outline">
                <i class="fa fa-home"></i> Home
            </a>
        </div>

    </div>
</div>

<script>
const hamburger = document.querySelector('.hamburger');
const nav = document.querySelector('.bottomheader');
hamburger.addEventListener('click', () => {
    nav.classList.toggle('active');
});
</script>

</body>
</html>