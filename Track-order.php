<?php
session_start();
include "db.php";

// Logged-in users already have a full order history in their dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: userdashboard/myorders.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Order — Intra Decor Home</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/Footer.css">
    <style>
        body { background: #faf6f5; }

        /* Scoped Font */
        .track-hero, .page-wrapper {
            font-family: 'Outfit', sans-serif !important;
        }

        .track-hero { position: relative; height: 260px; overflow: hidden; border-bottom: 4px solid #c17f4a; }
        .track-hero img { width: 100%; height: 100%; object-fit: cover; filter: brightness(0.45); }
        .track-hero-content {
            position: absolute; top: 0; left: 0; right: 0; bottom: 0;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            text-align: center; color: #fff; padding: 0 20px;
            background: linear-gradient(to bottom, rgba(75,44,44,0.3) 0%, rgba(42,16,16,0.6) 100%);
            animation: fadeIn 0.8s ease-out;
        }
        .track-hero-content h1 { font-size: 2.5rem; font-weight: 800; text-shadow: 0 4px 10px rgba(0,0,0,0.4); letter-spacing: -0.5px; }
        .track-hero-content p { font-size: 15.5px; opacity: 0.95; margin-top: 8px; max-width: 550px; text-shadow: 0 2px 6px rgba(0,0,0,0.4); }

        .page-wrapper { max-width: 740px; margin: 0 auto; padding: 60px 24px 80px; }

        .track-note {
            background: #fff9e6; color: #8a6d1c; padding: 16px 20px; border-radius: 16px;
            font-size: 14.5px; margin-bottom: 35px; display: flex; align-items: center; gap: 12px;
            border: 1px solid #f9ebcc;
        }
        .track-note i { color: #c17f4a; font-size: 18px; }
        .track-note a { color: #4b2c2c; font-weight: 700; text-decoration: underline; }

        .track-form-panel {
            background: #fff; border-radius: 24px; padding: 40px 35px;
            box-shadow: 0 10px 35px rgba(75, 44, 44, 0.04);
            border: 1px solid rgba(75, 44, 44, 0.04);
            margin-bottom: 35px;
        }
        .track-form-panel h3 { color: #4b2c2c; font-size: 22px; margin-bottom: 6px; font-weight: 800; letter-spacing: -0.5px; }
        .track-form-panel > p { color: #7a6262; font-size: 14px; margin-bottom: 28px; }

        .form-row { display: flex; gap: 20px; margin-bottom: 22px; flex-wrap: wrap; }
        .form-group { flex: 1 1 200px; display: flex; flex-direction: column; }
        .form-group label { font-size: 14px; color: #4b2c2c; font-weight: 600; margin-bottom: 8px; }
        .form-group input {
            padding: 13px 16px; border-radius: 12px; border: 2px solid #e2d5d5;
            font-size: 14.5px; font-family: inherit; outline: none; color: #333;
            transition: all 0.3s ease;
            background: #fdfcfc;
        }
        .form-group input:focus {
            border-color: #c17f4a;
            background: #fff;
            box-shadow: 0 0 15px rgba(193, 127, 74, 0.15);
        }

        .track-btn {
            background: #4b2c2c; color: #fff; border: none; padding: 14px 34px;
            border-radius: 30px; font-size: 15px; font-weight: 600; cursor: pointer;
            transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 8px;
            box-shadow: 0 6px 20px rgba(75, 44, 44, 0.15);
        }
        .track-btn:hover { background: #6b3d3d; transform: translateY(-2px); box-shadow: 0 8px 25px rgba(75, 44, 44, 0.25); }
        .track-btn:active { transform: translateY(0); }

        #track-status {
            margin-top: 20px; font-size: 14px; padding: 12px 16px; border-radius: 10px; display: none; font-weight: 500;
        }
        #track-status.error { background: #fdecea; color: #c0392b; display: block; border-left: 4px solid #e74c3c; }

        /* Result card */
        #result-card {
            background: #fff; border-radius: 24px; padding: 40px 35px;
            box-shadow: 0 15px 40px rgba(75, 44, 44, 0.06);
            border: 1px solid rgba(75, 44, 44, 0.04);
            display: none;
            animation: fadeInUp 0.5s ease-out;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .result-top { display: flex; gap: 20px; align-items: center; margin-bottom: 30px; }
        .result-top img { width: 90px; height: 90px; object-fit: cover; border-radius: 16px; border: 1px solid rgba(75,44,44,0.08); }
        .result-top h4 { color: #4b2c2c; font-size: 18px; font-weight: 800; margin-bottom: 6px; letter-spacing: -0.5px; }
        .result-top p { color: #7a6262; font-size: 14px; }

        .status-track { display: flex; justify-content: space-between; position: relative; margin: 40px 0 20px; }
        .status-track::before {
            content: ''; position: absolute; top: 22px; left: 8%; right: 8%; height: 4px; background: #eee; z-index: 0;
            border-radius: 2px;
        }
        .status-step { flex: 1; text-align: center; position: relative; z-index: 1; }
        .status-step .dot {
            width: 46px; height: 46px; border-radius: 50%; background: #fff; color: #aaa;
            display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; font-size: 16px;
            border: 3px solid #eee; transition: all 0.4s ease;
            box-shadow: 0 4px 10px rgba(0,0,0,0.03);
        }
        .status-step.done .dot { background: #4b2c2c; color: #fff; border-color: #4b2c2c; box-shadow: 0 4px 15px rgba(75, 44, 44, 0.25); }
        .status-step span { font-size: 13px; color: #999; font-weight: 500; transition: color 0.4s ease; }
        .status-step.done span { color: #4b2c2c; font-weight: 700; }

        .order-meta { margin-top: 35px; border-top: 1px solid #f2eaea; padding-top: 25px; }
        .order-meta-row { display: flex; justify-content: space-between; font-size: 14.5px; color: #6b5555; margin-bottom: 14px; padding-bottom: 10px; border-bottom: 1px dashed #f5eded; }
        .order-meta-row:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
        .order-meta-row strong { color: #4b2c2c; font-weight: 600; text-align: right; max-width: 60%; }
    </style>
</head>
<body>

<div class="container">

    <!-- TOP HEADER -->
    <div class="topheader">
        <div class="headerleftside">
            <div class="logo-box"><img src="assets/images/logo.png" alt="Logo"/></div>
            <div class="search-box">
                <form action="search.php" method="GET" style="display:contents;">
                    <input type="text" name="q" placeholder="Search products & services..." value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>" autocomplete="off">
                    <i class="fa-solid fa-magnifying-glass" style="cursor:pointer;" onclick="this.closest('form').submit()"></i>
                </form>
            </div>
        </div>
        <div class="headerrightside">
            <div class="user-menu">
                <a class="login" href="signup.php">Login/Signup</a>
                <a class="my-account" href="userdashboard/userdashboard.php"><i class="fa-solid fa-user"></i> My Account</a>
            </div>
            <div class="cart-box">
                <a href="cart.php"><i class="fa-solid fa-cart-shopping"></i><span class="cart-text">Cart</span></a>
            </div>
        </div>
        <div class="hamburger"><i class="fa-solid fa-bars"></i></div>
    </div>

    <!-- NAVIGATION -->
    <div class="bottomheader">
        <a href="index.php" class="nav-btn">Home</a>
        <a href="paint.php" class="nav-btn">Paint Visualizer</a>
        <a href="Tiles.php" class="nav-btn">Tiles</a>
        <a href="wallpaper.php" class="nav-btn">Wallpaper</a>
        <a href="wallpenals.php" class="nav-btn">Wall Panelling</a>
        <a href="services.php" class="nav-btn">Services</a>
        <a href="room-preview.php" class="nav-btn">AI Room Designer</a>
    </div>

    <!-- HERO -->
    <div class="track-hero">
        <img src="assets/images/hero.png" alt="Track Order">
        <div class="track-hero-content">
            <h1>Track Your Order</h1>
            <p>Enter your Order ID and phone number to check your delivery status.</p>
        </div>
    </div>

    <div class="page-wrapper">

        <div class="track-note">
            <i class="fa-solid fa-circle-info"></i>
            <span>Already have an account? <a href="login.php">Log in</a> to see your full order history in one place.</span>
        </div>

        <div class="track-form-panel">
            <h3>Find Your Order</h3>
            <p>Your Order ID and phone number were provided in your order confirmation.</p>

            <form id="trackForm">
                <div class="form-row">
                    <div class="form-group">
                        <label for="t-order-id">Order ID</label>
                        <input type="text" id="t-order-id" name="order_id" placeholder="e.g. 1024" required>
                    </div>
                    <div class="form-group">
                        <label for="t-phone">Phone Number</label>
                        <input type="text" id="t-phone" name="phone" placeholder="e.g. 03001234567" required>
                    </div>
                </div>
                <button type="submit" class="track-btn">
                    Track Order <i class="fa-solid fa-magnifying-glass"></i>
                </button>
                <div id="track-status"></div>
            </form>
        </div>

        <!-- RESULT -->
        <div id="result-card">
            <div class="result-top">
                <img id="r-image" src="" alt="Product">
                <div>
                    <h4 id="r-name"></h4>
                    <p id="r-date"></p>
                </div>
            </div>

            <div class="status-track" id="statusTrack">
                <div class="status-step" data-step="pending"><div class="dot"><i class="fa-solid fa-receipt"></i></div><span>Order Placed</span></div>
                <div class="status-step" data-step="confirmed"><div class="dot"><i class="fa-solid fa-box"></i></div><span>Confirmed</span></div>
                <div class="status-step" data-step="delivered"><div class="dot"><i class="fa-solid fa-house"></i></div><span>Delivered</span></div>
            </div>
            <div id="cancelled-banner" style="display:none; background:#fdecea; color:#c0392b; padding:12px 16px; border-radius:10px; font-size:13.5px; margin-top:16px; text-align:center;">
                <i class="fa-solid fa-circle-xmark"></i> This order has been cancelled.
            </div>

            <div class="order-meta">
                <div class="order-meta-row"><span>Order ID</span><strong id="r-id"></strong></div>
                <div class="order-meta-row"><span>Amount</span><strong id="r-amount"></strong></div>
                <div class="order-meta-row"><span>Payment Method</span><strong id="r-payment"></strong></div>
                <div class="order-meta-row"><span>Delivery Address</span><strong id="r-address"></strong></div>
                <div class="order-meta-row"><span>Current Status</span><strong id="r-status"></strong></div>
            </div>
        </div>

    </div><!-- end .page-wrapper -->

    <?php include 'Footer.php'; ?>

</div><!-- end .container -->

<script>
    const hamburger = document.querySelector('.hamburger');
    const nav = document.querySelector('.bottomheader');
    if (hamburger) hamburger.addEventListener('click', ()=>{ nav.classList.toggle('active'); });

    const trackForm   = document.getElementById('trackForm');
    const statusBox   = document.getElementById('track-status');
    const resultCard  = document.getElementById('result-card');

    // Maps DB statuses to our 3-step visual track
    const stepOrder = ['pending', 'confirmed', 'delivered'];

    trackForm.addEventListener('submit', function(e){
        e.preventDefault();
        statusBox.className = '';
        statusBox.style.display = 'none';
        resultCard.style.display = 'none';

        const formData = new FormData(trackForm);
        const submitBtn = trackForm.querySelector('.track-btn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Searching... <i class="fa-solid fa-spinner fa-spin"></i>';

        fetch('Track_order_lookup.php', { method: 'POST', body: formData })
            .then(res => res.json())
            .then(data => {
                if (data.status !== 'success') {
                    statusBox.className = 'error';
                    statusBox.style.display = 'block';
                    statusBox.textContent = data.message;
                    return;
                }

                const order = data.order;
                document.getElementById('r-image').src   = order.image;
                document.getElementById('r-name').textContent = order.product_name;
                document.getElementById('r-date').textContent = 'Placed on ' + order.created_at;
                document.getElementById('r-id').textContent = '#' + order.id;
                document.getElementById('r-amount').textContent = 'Rs. ' + order.amount;
                document.getElementById('r-payment').textContent = order.payment_method;
                document.getElementById('r-address').textContent = order.address + ', ' + order.city;
                document.getElementById('r-status').textContent = order.status_label;

                const cancelledBanner = document.getElementById('cancelled-banner');
                const statusTrack = document.getElementById('statusTrack');

                if (order.status.toLowerCase() === 'cancelled') {
                    statusTrack.style.display = 'none';
                    cancelledBanner.style.display = 'block';
                } else {
                    statusTrack.style.display = 'flex';
                    cancelledBanner.style.display = 'none';
                    // Update visual step track
                    const currentIndex = stepOrder.indexOf(order.status.toLowerCase());
                    document.querySelectorAll('.status-step').forEach((el, i) => {
                        el.classList.toggle('done', currentIndex >= 0 && i <= currentIndex);
                    });
                }

                resultCard.style.display = 'block';
            })
            .catch(() => {
                statusBox.className = 'error';
                statusBox.style.display = 'block';
                statusBox.textContent = 'Something went wrong. Please try again.';
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Track Order <i class="fa-solid fa-magnifying-glass"></i>';
            });
    });
</script>
</body>
</html>