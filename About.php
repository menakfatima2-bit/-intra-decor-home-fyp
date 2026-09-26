<?php
session_start();
include "db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us — Intra Decor Home</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/Footer.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { background: #faf6f5; }

        /* Scoped Font & Modern Spacing */
        .about-hero, .page-wrapper {
            font-family: 'Outfit', sans-serif !important;
        }

        /* ===== ABOUT HERO ===== */
        .about-hero {
            position: relative;
            height: 380px;
            overflow: hidden;
            border-bottom: 4px solid #c17f4a;
        }
        .about-hero img {
            width: 100%; height: 100%; object-fit: cover;
            filter: brightness(0.45);
            transition: transform 6s ease;
        }
        .about-hero:hover img {
            transform: scale(1.05);
        }
        .about-hero-content {
            position: absolute; top: 0; left: 0; right: 0; bottom: 0;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            text-align: center; color: #fff; padding: 0 20px;
            background: linear-gradient(to bottom, rgba(75,44,44,0.3) 0%, rgba(42,16,16,0.6) 100%);
            animation: fadeInDown 0.8s ease-out;
        }
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .about-hero-content h1 {
            font-size: 2.8rem; font-weight: 800; margin-bottom: 12px;
            text-shadow: 0 4px 10px rgba(0,0,0,0.4);
            letter-spacing: -0.5px;
        }
        .about-hero-content p {
            max-width: 650px; line-height: 1.7; font-size: 16px;
            text-shadow: 0 2px 6px rgba(0,0,0,0.4);
            opacity: 0.95;
        }

        .page-wrapper { max-width: 1140px; margin: 0 auto; padding: 60px 24px 80px; }

        .about-intro {
            text-align: center; max-width: 850px; margin: 0 auto 60px;
            animation: fadeInUp 0.8s ease-out;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .about-intro h2 {
            color: #4b2c2c; font-size: 32px; margin-bottom: 20px; font-weight: 800;
            position: relative; display: inline-block;
        }
        .about-intro h2::after {
            content: ''; display: block; width: 60px; height: 3px; background: #c17f4a;
            margin: 12px auto 0; border-radius: 2px;
        }
        .about-intro p {
            color: #6b5555; line-height: 1.9; font-size: 16px; font-weight: 400;
        }

        /* ===== STORY / MISSION SPLIT ===== */
        .split-row {
            display: flex; align-items: center; gap: 50px;
            margin-bottom: 70px; flex-wrap: wrap;
        }
        .split-row.reverse { flex-direction: row-reverse; }
        .split-img {
            flex: 1 1 420px; border-radius: 24px; overflow: hidden;
            box-shadow: 0 15px 40px rgba(75,44,44,0.08); min-height: 300px;
            border: 1px solid rgba(75,44,44,0.05);
        }
        .split-img img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1); }
        .split-img:hover img { transform: scale(1.06); }
        .split-text { flex: 1 1 420px; }
        .split-text span.tag {
            color: #c17f4a; font-weight: 700; font-size: 12px;
            text-transform: uppercase; letter-spacing: 1.5px;
            background: rgba(193, 127, 74, 0.1); padding: 5px 14px;
            border-radius: 30px; display: inline-block; margin-bottom: 12px;
        }
        .split-text h3 {
            color: #4b2c2c; font-size: 28px; margin: 0 0 18px; font-weight: 800;
            letter-spacing: -0.5px;
        }
        .split-text p { color: #6b5555; line-height: 1.8; font-size: 15px; margin-bottom: 16px; }
        .split-text p:last-child { margin-bottom: 0; }

        /* ===== STATS ===== */
        .stats-bar {
            display: grid; grid-template-columns: repeat(4, 1fr);
            background: linear-gradient(135deg, #4b2c2c 0%, #2a1010 100%);
            border-radius: 24px; padding: 45px 30px; margin-bottom: 70px;
            box-shadow: 0 20px 45px rgba(75, 44, 44, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        @media (max-width: 768px) {
            .stats-bar { grid-template-columns: repeat(2, 1fr); gap: 30px 10px; }
        }
        .stat-item { text-align: center; color: #fff; border-right: 1px solid rgba(255,255,255,0.1); }
        .stat-item:last-child { border-right: none; }
        @media (max-width: 768px) {
            .stat-item:nth-child(2n) { border-right: none; }
        }
        .stat-item h3 { font-size: 38px; font-weight: 800; margin-bottom: 6px; color: #fff; letter-spacing: -1px; }
        .stat-item span { font-size: 14px; opacity: 0.8; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; }

        /* ===== VALUES ===== */
        .values-section { margin-bottom: 70px; }
        .values-section h2 {
            text-align: center; color: #4b2c2c; font-size: 32px;
            margin-bottom: 45px; font-weight: 800;
        }
        .values-grid {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 28px;
        }
        .value-card {
            background: #fff; border-radius: 20px; padding: 36px 26px;
            text-align: center; box-shadow: 0 6px 24px rgba(75,44,44,0.03);
            border: 1px solid rgba(75,44,44,0.04);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }
        .value-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(75,44,44,0.08);
            border-color: rgba(193,127,74,0.25);
        }
        .value-icon {
            width: 64px; height: 64px; border-radius: 50%;
            background: linear-gradient(135deg, #c17f4a 0%, #a86c3c 100%);
            color: #fff; display: flex; align-items: center; justify-content: center;
            font-size: 24px; margin: 0 auto 20px;
            box-shadow: 0 8px 20px rgba(193, 127, 74, 0.35);
        }
        .value-card h4 { color: #4b2c2c; font-size: 18px; margin-bottom: 12px; font-weight: 700; }
        .value-card p { color: #7a6262; font-size: 14.5px; line-height: 1.6; }

        /* ===== WHY CHOOSE US ===== */
        .why-us h2 {
            text-align: center; color: #4b2c2c; font-size: 32px;
            margin-bottom: 45px; font-weight: 800;
        }
        .why-list {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
        }
        .why-item {
            display: flex; gap: 18px; background: #fff; border-radius: 18px;
            padding: 24px; box-shadow: 0 6px 20px rgba(75,44,44,0.02);
            border: 1px solid rgba(75,44,44,0.04);
            transition: all 0.3s ease;
        }
        .why-item:hover {
            transform: translateY(-3px);
            border-color: rgba(193,127,74,0.2);
            box-shadow: 0 12px 28px rgba(75,44,44,0.06);
        }
        .why-item i {
            color: #c17f4a; font-size: 24px; flex-shrink: 0; margin-top: 2px;
        }
        .why-item h4 { color: #4b2c2c; font-size: 16px; margin-bottom: 8px; font-weight: 700; }
        .why-item p { color: #7a6262; font-size: 14px; line-height: 1.6; }
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
    <div class="about-hero">
        <img src="assets/images/hero.png" alt="About Intra Decor Home">
        <div class="about-hero-content">
            <h1>About Intra Decor Home</h1>
            <p>Pakistan's trusted destination for premium paints, tiles, wallpapers, and wall panels — helping homeowners design spaces they love.</p>
        </div>
    </div>

    <div class="page-wrapper">

        <!-- INTRO -->
        <div class="about-intro">
            <h2>Who We Are</h2>
            <p>Intra Decor Home is a home décor platform built for people who want their houses to feel like a reflection of who they are. From premium wall paints and stylish tiles to custom wallpapers and modern panels, we bring every essential décor category together in one place — along with real-time visualization tools and access to verified local service providers who can bring your ideas to life.</p>
        </div>

        <!-- OUR STORY -->
        <div class="split-row">
            <div class="split-img">
                <img src="assets/images/room.jpeg" alt="Our Story">
            </div>
            <div class="split-text">
                <span class="tag">Our Story</span>
                <h3>Built From a Simple Frustration</h3>
                <p>Intra Decor Home started with a common problem faced by homeowners across Pakistan: picking the right paint, tiles, or wallpaper is hard when you can't see how it will actually look in your own space, and finding a reliable service provider is even harder. We set out to fix both problems at once — a single platform where you can browse premium décor products, visualize them in real-time, and connect directly with verified professionals near you.</p>
                <p>What began as a simple product catalog has grown into a complete interior décor ecosystem, combining e-commerce, interactive design tools, and a trusted service-provider network under one roof.</p>
            </div>
        </div>

        <!-- MISSION -->
        <div class="split-row reverse">
            <div class="split-img">
                <img src="assets/images/hero.png" alt="Our Mission">
            </div>
            <div class="split-text">
                <span class="tag">Our Mission</span>
                <h3>Making Great Design Accessible to Every Home</h3>
                <p>Our mission is simple: to make quality interior décor accessible, affordable, and easy to visualize for every household in Pakistan. We believe that transforming a house into a home shouldn't require guesswork, expensive consultants, or endless trial and error.</p>
                <p>By combining curated products, interactive design previews, and a growing network of trusted designers and service providers, we help our customers make confident decisions — from the first color swatch to the final installation.</p>
            </div>
        </div>

        <!-- STATS -->
        <div class="stats-bar">
            <div class="stat-item"><h3>4+</h3><span>Product Categories</span></div>
            <div class="stat-item"><h3>1000+</h3><span>Products Listed</span></div>
            <div class="stat-item"><h3>50+</h3><span>Verified Service Providers</span></div>
            <div class="stat-item"><h3>12+</h3><span>Cities Covered</span></div>
        </div>

        <!-- VALUES -->
        <div class="values-section">
            <h2>What We Stand For</h2>
            <div class="values-grid">
                <div class="value-card">
                    <div class="value-icon"><i class="fa-solid fa-heart"></i></div>
                    <h4>Customer First</h4>
                    <p>Every feature we build starts with one question — does this make the customer's decision easier?</p>
                </div>
                <div class="value-card">
                    <div class="value-icon"><i class="fa-solid fa-award"></i></div>
                    <h4>Quality Products</h4>
                    <p>We only list products and providers that meet our quality and reliability standards.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon"><i class="fa-solid fa-eye"></i></div>
                    <h4>Transparency</h4>
                    <p>Clear pricing, honest descriptions, and no hidden surprises at checkout.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon"><i class="fa-solid fa-lightbulb"></i></div>
                    <h4>Innovation</h4>
                    <p>From AI-assisted room previews to real-time visualizers, we keep pushing how people shop for décor.</p>
                </div>
            </div>
        </div>

        <!-- WHY CHOOSE US -->
        <div class="why-us">
            <h2>Why Choose Intra Decor Home</h2>
            <div class="why-list">
                <div class="why-item">
                    <i class="fa-solid fa-swatchbook"></i>
                    <div>
                        <h4>Everything in One Place</h4>
                        <p>Paints, tiles, wallpapers, and wall panels — no need to visit multiple stores or sites.</p>
                    </div>
                </div>
                <div class="why-item">
                    <i class="fa-solid fa-house-laptop"></i>
                    <div>
                        <h4>Real-Time Visualization</h4>
                        <p>Preview paint colors, tiles, and wallpapers on your own walls before you buy.</p>
                    </div>
                </div>
                <div class="why-item">
                    <i class="fa-solid fa-user-shield"></i>
                    <div>
                        <h4>Verified Service Providers</h4>
                        <p>Every designer and contractor on our platform is reviewed before being listed.</p>
                    </div>
                </div>
                <div class="why-item">
                    <i class="fa-solid fa-truck-fast"></i>
                    <div>
                        <h4>Reliable Delivery</h4>
                        <p>Reliable, tracked delivery on every order, with easy returns if something isn't right.</p>
                    </div>
                </div>
                <div class="why-item">
                    <i class="fa-solid fa-headset"></i>
                    <div>
                        <h4>Always-On Support</h4>
                        <p>Our team is available around the clock to help with orders, questions, or issues.</p>
                    </div>
                </div>
                <div class="why-item">
                    <i class="fa-solid fa-tags"></i>
                    <div>
                        <h4>Fair, Transparent Pricing</h4>
                        <p>What you see is what you pay — clearly marked discounts, no hidden fees.</p>
                    </div>
                </div>
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