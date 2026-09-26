<?php
session_start();
include "db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sitemap — Intra Decor Home</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/Footer.css">
    <style>
        body { background: #f5f0f0; }

        .sitemap-hero { position: relative; height: 200px; overflow: hidden; }
        .sitemap-hero img { width: 100%; height: 100%; object-fit: cover; filter: brightness(0.5); }
        .sitemap-hero-content {
            position: absolute; top: 0; left: 0; right: 0; bottom: 0;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            text-align: center; color: #fff; padding: 0 20px;
        }
        .sitemap-hero-content h1 { font-size: 1.9rem; text-shadow: 1px 1px 4px rgba(0,0,0,0.6); }
        .sitemap-hero-content p { font-size: 13px; opacity: 0.9; margin-top: 6px; }

        .page-wrapper { max-width: 1100px; margin: 0 auto; padding: 50px 20px 70px; }

        .sitemap-grid {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 24px;
        }
        .sitemap-block {
            background: #fff; border-radius: 16px; padding: 26px 24px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.06);
        }
        .sitemap-block h3 {
            color: #4b2c2c; font-size: 15px; font-weight: 700; margin-bottom: 16px;
            display: flex; align-items: center; gap: 10px; padding-bottom: 12px;
            border-bottom: 2px solid #f0e0e0;
        }
        .sitemap-block h3 i { color: #c17f4a; font-size: 15px; }
        .sitemap-block ul { list-style: none; padding: 0; margin: 0; }
        .sitemap-block li { margin-bottom: 4px; }
        .sitemap-block a {
            display: flex; align-items: center; gap: 8px;
            color: #6b5555; text-decoration: none; font-size: 13.5px;
            padding: 8px 6px; border-radius: 8px; transition: 0.2s;
        }
        .sitemap-block a i { font-size: 10px; color: #c17f4a; }
        .sitemap-block a:hover { background: #f9f0ec; color: #4b2c2c; padding-left: 12px; }
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
                <?php if (isset($_SESSION['user_id'])) { ?>
                    <a class="login" href="logout.php">Logout</a>
                <?php } else { ?>
                    <a class="login" href="signup.php">Login/Signup</a>
                <?php } ?>
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
    <div class="sitemap-hero">
        <img src="assets/images/hero.png" alt="Sitemap">
        <div class="sitemap-hero-content">
            <h1>Sitemap</h1>
            <p>A complete directory of every page on Intra Decor Home</p>
        </div>
    </div>

    <div class="page-wrapper">
        <div class="sitemap-grid">

            <!-- MAIN PAGES -->
            <div class="sitemap-block">
                <h3><i class="fa-solid fa-house"></i> Main Pages</h3>
                <ul>
                    <li><a href="index.php"><i class="fa-solid fa-caret-right"></i> Home</a></li>
                    <li><a href="About.php"><i class="fa-solid fa-caret-right"></i> About Us</a></li>
                    <li><a href="Contact.php"><i class="fa-solid fa-caret-right"></i> Contact Us</a></li>
                    <li><a href="services.php"><i class="fa-solid fa-caret-right"></i> Services</a></li>
                    <li><a href="room-preview.php"><i class="fa-solid fa-caret-right"></i> AI Room Designer</a></li>
                </ul>
            </div>

            <!-- SHOP BY CATEGORY -->
            <div class="sitemap-block">
                <h3><i class="fa-solid fa-swatchbook"></i> Shop by Category</h3>
                <ul>
                    <li><a href="paint.php"><i class="fa-solid fa-caret-right"></i> Wall Paints</a></li>
                    <li><a href="Tiles.php"><i class="fa-solid fa-caret-right"></i> Tiles</a></li>
                    <li><a href="wallpaper.php"><i class="fa-solid fa-caret-right"></i> Wallpapers</a></li>
                    <li><a href="wallpenals.php"><i class="fa-solid fa-caret-right"></i> Wall Panels</a></li>
                    <li><a href="products.php"><i class="fa-solid fa-caret-right"></i> All Products</a></li>
                </ul>
            </div>

            <!-- SHOPPING -->
            <div class="sitemap-block">
                <h3><i class="fa-solid fa-cart-shopping"></i> Shopping</h3>
                <ul>
                    <li><a href="cart.php"><i class="fa-solid fa-caret-right"></i> My Cart</a></li>
                    <li><a href="checkout.php"><i class="fa-solid fa-caret-right"></i> Checkout</a></li>
                    <li><a href="Track-order.php"><i class="fa-solid fa-caret-right"></i> Track Order</a></li>
                </ul>
            </div>

            <!-- MY ACCOUNT -->
            <div class="sitemap-block">
                <h3><i class="fa-solid fa-user"></i> My Account</h3>
                <ul>
                    <li><a href="login.php"><i class="fa-solid fa-caret-right"></i> Login</a></li>
                    <li><a href="signup.php"><i class="fa-solid fa-caret-right"></i> Sign Up</a></li>
                    <li><a href="userdashboard/userdashboard.php"><i class="fa-solid fa-caret-right"></i> Account Dashboard</a></li>
                    <li><a href="userdashboard/myorders.php"><i class="fa-solid fa-caret-right"></i> My Orders</a></li>
                    <li><a href="userdashboard/favorites.php"><i class="fa-solid fa-caret-right"></i> Favorites</a></li>
                    <li><a href="userdashboard/userprofile.php"><i class="fa-solid fa-caret-right"></i> My Profile</a></li>
                    <li><a href="forgotpassword.php"><i class="fa-solid fa-caret-right"></i> Forgot Password</a></li>
                </ul>
            </div>

            <!-- SERVICE PROVIDERS -->
            <div class="sitemap-block">
                <h3><i class="fa-solid fa-user-tie"></i> Service Providers</h3>
                <ul>
                    <li><a href="services.php"><i class="fa-solid fa-caret-right"></i> Find a Service Provider</a></li>
                    <li><a href="apply-designer.php"><i class="fa-solid fa-caret-right"></i> Apply as a Designer</a></li>
                </ul>
            </div>

            <!-- COMPANY & LEGAL -->
            <div class="sitemap-block">
                <h3><i class="fa-solid fa-scale-balanced"></i> Company &amp; Legal</h3>
                <ul>
                    <li><a href="faq.php"><i class="fa-solid fa-caret-right"></i> FAQ</a></li>
                    <li><a href="Privacy-policy.php"><i class="fa-solid fa-caret-right"></i> Privacy Policy</a></li>
                    <li><a href="Terms.php"><i class="fa-solid fa-caret-right"></i> Terms of Use</a></li>
                    <li><a href="Returns-policy.php"><i class="fa-solid fa-caret-right"></i> Returns Policy</a></li>
                </ul>
            </div>

        </div>
    </div><!-- end .page-wrapper -->

    <?php include 'Footer.php'; ?>

</div><!-- end .container -->

<script>
    const hamburger = document.querySelector('.hamburger');
    const nav = document.querySelector('.bottomheader');
    if (hamburger) hamburger.addEventListener('click', ()=>{ nav.classList.toggle('active'); });
</script>
</body>
</html>