<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Cart items fetch
$query = "SELECT cart.*, productadd.name, productadd.price, 
          productadd.discount, productadd.product_image
          FROM cart 
          JOIN productadd ON cart.product_id = productadd.id
          WHERE cart.user_id = '$user_id'";
$result = mysqli_query($conn, $query);

$grand_total = 0;
$items = [];

if($result){
    while($row = mysqli_fetch_assoc($result)){
        $price    = $row['price'];
        $discount = $row['discount'];
        $final    = $price - ($price * $discount / 100);
        $subtotal = $final * $row['quantity'];
        $grand_total += $subtotal;
        $row['final_price'] = $final;
        $row['subtotal']    = $subtotal;
        $items[] = $row;
    }
}

if(count($items) == 0){
    header("Location: cart.php");
    exit();
}

// User info fetch
$user_res = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'");
$user = mysqli_fetch_assoc($user_res);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout — Intra Decor Home</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/Footer.css">
    <style>
        body { background: #f5f0f0; }
        .checkout-wrapper {
            max-width: 1100px;
            margin: 30px auto;
            padding: 0 20px 60px;
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 30px;
        }
        @media(max-width: 768px){ .checkout-wrapper { grid-template-columns: 1fr; } }
        h2.page-title {
            color: #4b2c2c;
            font-size: 1.4rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .section-box {
            background: white;
            border-radius: 14px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }
        .section-box h3 {
            color: #4b2c2c;
            font-size: 1rem;
            margin-bottom: 18px;
            padding-bottom: 10px;
            border-bottom: 1px solid #f0e8e8;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        @media(max-width: 500px){ .form-row { grid-template-columns: 1fr; } }
        .form-group { margin-bottom: 15px; }
        .form-group label {
            display: block;
            font-size: 13px;
            color: #555;
            margin-bottom: 6px;
            font-weight: 500;
        }
        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid #e8e0e0;
            border-radius: 8px;
            font-size: 14px;
            color: #333;
            outline: none;
            transition: border 0.2s;
            box-sizing: border-box;
            background: #fdfafa;
        }
        .form-group input:focus,
        .form-group textarea:focus { border-color: #4b2c2c; }
        .payment-options { display: flex; flex-direction: column; gap: 12px; }
        .payment-option {
            border: 2px solid #e8e0e0;
            border-radius: 10px;
            padding: 14px 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.2s;
        }
        .payment-option:hover { border-color: #4b2c2c; }
        .payment-option.selected { border-color: #4b2c2c; background: #fdf5f5; }
        .payment-option input[type="radio"] {
            accent-color: #4b2c2c;
            width: 16px;
            height: 16px;
            cursor: pointer;
        }
        .payment-option .pay-info { flex: 1; }
        .payment-option .pay-name { font-weight: bold; color: #333; font-size: 14px; }
        .payment-option .pay-desc { font-size: 12px; color: #888; margin-top: 2px; }
        .pay-icon { font-size: 1.4rem; }
        .order-summary { position: sticky; top: 20px; }
        .summary-item {
            display: flex;
            gap: 12px;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #f5f0f0;
        }
        .summary-item:last-child { border-bottom: none; }
        .summary-item img { width: 55px; height: 55px; object-fit: cover; border-radius: 8px; }
        .summary-item .s-info { flex: 1; }
        .summary-item .s-name { font-size: 13px; font-weight: bold; color: #333; }
        .summary-item .s-qty { font-size: 12px; color: #888; }
        .summary-item .s-price { font-size: 14px; font-weight: bold; color: #4b2c2c; }
        .total-line { display: flex; justify-content: space-between; padding: 8px 0; font-size: 14px; color: #555; }
        .total-line.grand {
            border-top: 2px solid #f0e8e8;
            margin-top: 5px;
            padding-top: 14px;
            font-size: 1.2rem;
            font-weight: bold;
            color: #4b2c2c;
        }
        .place-btn {
            width: 100%;
            background: #4b2c2c;
            color: white;
            border: none;
            padding: 15px;
            border-radius: 30px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            margin-top: 20px;
            transition: 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .place-btn:hover { background: #6b3d3d; }
        .secure-note {
            text-align: center;
            font-size: 12px;
            color: #aaa;
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
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
            <a href="cart.php" style="position:relative; display:inline-block;">
                <i class="fa-solid fa-cart-shopping"></i>
                <span class="cart-text">Cart</span>
                <?php
                $c = mysqli_query($conn, "SELECT SUM(quantity) as total FROM cart WHERE user_id='$user_id'");
                $cr = mysqli_fetch_assoc($c);
                $cart_count = $cr['total'] ?? 0;
                if($cart_count > 0){ ?>
                <span id="cart-badge" style="position:absolute;top:-8px;right:-10px;background:#e74c3c;color:white;font-size:11px;font-weight:bold;width:18px;height:18px;border-radius:50%;display:flex;align-items:center;justify-content:center;"><?php echo $cart_count; ?></span>
                <?php } ?>
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

<!-- CHECKOUT CONTENT -->
<div class="checkout-wrapper">

    <!-- LEFT SIDE — Form -->
    <div>
        <h2 class="page-title">
            <i class="fa-solid fa-bag-shopping"></i> Checkout
        </h2>

        <div class="section-box">
            <h3><i class="fa-solid fa-location-dot"></i> Delivery Details</h3>

            <form id="checkout-form" action="order_place.php" method="POST">

                <div class="form-row">
                    <div class="form-group">
                        <label>Full Name *</label>
                        <input type="text" name="name" required 
                               value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>"
                               placeholder="Enter your full name">
                    </div>
                    <div class="form-group">
                        <label>Phone Number *</label>
                        <input type="text" name="phone" required 
                               placeholder="03XX-XXXXXXX">
                    </div>
                </div>

                <div class="form-group">
                    <label>Full Address *</label>
                    <textarea name="address" required rows="2" 
                              placeholder="Enter your complete address"></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>City *</label>
                        <input type="text" name="city" required placeholder="Enter your city">
                    </div>
                    <div class="form-group">
                        <label>Postal Code</label>
                        <input type="text" name="postal_code" placeholder="Optional">
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="section-box" style="box-shadow:none; padding: 0; margin-top: 10px;">
                    <h3 style="border-bottom: 1px solid #f0e8e8; padding-bottom: 10px;">
                        <i class="fa-solid fa-credit-card"></i> Payment Method
                    </h3>

                    <div class="payment-options">

                        <label class="payment-option selected" id="safepay-option">
                            <input type="radio" name="payment_method" value="safepay" checked
                                   onchange="selectPayment('safepay')">
                            <span class="pay-icon">💳</span>
                            <div class="pay-info">
                                <div class="pay-name">Card / Wallet (Safepay)</div>
                                <div class="pay-desc">Pay securely via Safepay — sandbox test mode</div>
                            </div>
                        </label>

                    </div>
                </div>

            </form>
        </div>
    </div>

    <!-- RIGHT SIDE — Order Summary -->
    <div class="order-summary">
        <h2 class="page-title">
            <i class="fa-solid fa-receipt"></i> Order Summary
        </h2>

        <div class="section-box">
            <?php foreach($items as $item){ ?>
            <div class="summary-item">
                <img src="uploads/<?php echo htmlspecialchars($item['product_image']); ?>">
                <div class="s-info">
                    <div class="s-name"><?php echo htmlspecialchars($item['name']); ?></div>
                    <div class="s-qty">Qty: <?php echo $item['quantity']; ?></div>
                </div>
                <div class="s-price">Rs. <?php echo number_format($item['subtotal'], 0); ?></div>
            </div>
            <?php } ?>

            <div class="total-line">
                <span>Subtotal</span>
                <span>Rs. <?php echo number_format($grand_total, 0); ?></span>
            </div>
            <div class="total-line">
                <span>Delivery</span>
                <span style="color:#1D9E75">Free</span>
            </div>
            <div class="total-line grand">
                <span>Total</span>
                <span>Rs. <?php echo number_format($grand_total, 0); ?></span>
            </div>

            <button class="place-btn" onclick="placeOrder()">
                <i class="fa-solid fa-check"></i> Place Order
            </button>

            <p class="secure-note">
                <i class="fa-solid fa-lock"></i> Secure Checkout
            </p>
        </div>
    </div>

</div>

<!-- FOOTER -->
<?php include 'Footer.php'; ?>

<script>
function selectPayment(type) {
    // Only one payment method now, but kept for structural consistency
    // in case you add another method back later.
    document.getElementById('safepay-option').classList.add('selected');
}

function placeOrder() {
    const form = document.getElementById('checkout-form');
    if(!form.checkValidity()){
        form.reportValidity();
        return;
    }

    form.action = 'safepay_checkout.php?';
    form.submit();
}
</script>

<script>
const hamburger = document.querySelector('.hamburger');
const nav = document.querySelector('.bottomheader');
hamburger.addEventListener('click', () => {
    nav.classList.toggle('active');
});
</script>

</body>
</html>