<?php session_start(); include "db.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Decor</title>
    <link rel="stylesheet" href="assets/css/style.css?v=20">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/Footer.css">
</head>
<body>

<div class="container">

    <!-- TOP HEADER -->
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
                    <a class="login" href="signup.php">Login/Signup</a>
                <?php } ?>
                <a class="my-account" href="userdashboard/userdashboard.php"><i class="fa-solid fa-user"></i> My Account</a>
            </div>
            <?php
            $cart_count = 0;
            if(isset($_SESSION['user_id'])){
                $c = mysqli_query($conn,
                    "SELECT SUM(quantity) as total FROM cart WHERE user_id='{$_SESSION['user_id']}'"
                );
                $cr = mysqli_fetch_assoc($c);
                $cart_count = $cr['total'] ?? 0;
            }
            ?>
            <div class="cart-box">
                <a href="cart.php" style="position:relative;display:inline-block;">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="cart-text">Cart</span>
                    <?php if($cart_count > 0){ ?>
                    <span id="cart-badge" style="position:absolute;top:-8px;right:-10px;background:#e74c3c;color:white;font-size:11px;font-weight:bold;width:18px;height:18px;border-radius:50%;display:flex;align-items:center;justify-content:center;"><?php echo $cart_count; ?></span>
                    <?php } ?>
                </a>
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
        <a href="services.php" class="nav-btn">Services</a>  <!-- ✅ NEW: Services link -->
        <a href="room-preview.php" class="nav-btn">AI Room Designer</a>
    </div>

    <!-- HERO (magazine-style split) -->
    <div class="mag-hero">
        <div class="mag-hero-color">
            <span class="mag-hero-vertical">INTRA DECOR</span>
            <div class="mag-hero-bottom">
                <p>Home Decor Marketplace</p>
                <a href="#categories" class="mag-btn">Shop Now</a>
            </div>
        </div>
        <div class="mag-hero-photo">
            <img src="assets/images/hero.png" alt="Hero Image">
            <div class="mag-hero-text">
                <h1>Transform Your Spaces with Interactive Designs</h1>
                <p>Explore premium wall paints, stylish tiles, custom wallpapers, and modern panels. Visualize styles in real-time and hire verified local service providers to bring your home decor vision to life seamlessly.</p>
            </div>
        </div>
    </div>

    <!-- CATEGORIES (magazine-style asymmetric grid) -->
    <h2 class="section-title reveal" id="categories">Categories</h2>
    <p class="section-subtitle reveal">Pick a category to start designing your space</p>
    <div class="mag-categories reveal">
        <a href="paint.php" class="mag-cat-tile photo">
            <img src="assets/images/paint-colors.png" alt="Paint">
            <div class="mag-cat-body">
                <div class="mag-cat-label">01 &nbsp;·&nbsp; Paint</div>
                <div class="mag-cat-title">Premium Wall Paints</div>
                <span class="mag-cat-link">Explore <i class="fa-solid fa-arrow-right"></i></span>
            </div>
        </a>
        <a href="Tiles.php" class="mag-cat-tile photo">
            <img src="assets/images/Tiles.png" alt="Tiles">
            <div class="mag-cat-body">
                <div class="mag-cat-label">02 &nbsp;·&nbsp; Tiles</div>
                <div class="mag-cat-title">Simple Tiles,<br>Stylish Look</div>
                <span class="mag-cat-link">Explore <i class="fa-solid fa-arrow-right"></i></span>
            </div>
        </a>
        <a href="wallpaper.php" class="mag-cat-tile photo">
            <img src="assets/images/wall wapaper.png" alt="Wallpaper">
            <div class="mag-cat-body">
                <div class="mag-cat-label">03 &nbsp;·&nbsp; Wallpaper</div>
                <div class="mag-cat-title">Premium Quality<br>Wallpapers</div>
                <span class="mag-cat-link">Explore <i class="fa-solid fa-arrow-right"></i></span>
            </div>
        </a>
        <a href="wallpenals.php" class="mag-cat-tile photo">
            <img src="assets/images/wall penal.png" alt="Wall Panels">
            <div class="mag-cat-body">
                <div class="mag-cat-label">04 &nbsp;·&nbsp; Panelling</div>
                <div class="mag-cat-title">Stylish Wall Panels</div>
                <span class="mag-cat-link">Explore <i class="fa-solid fa-arrow-right"></i></span>
            </div>
        </a>
    </div>

    <h2 class="section-title reveal">Latest Products</h2>
    <p class="section-subtitle reveal">Fresh arrivals picked for your home</p>
    <div id="active-products" class="reveal">
        <div class="skeleton-row">
            <div class="skeleton-card"><div class="skeleton-img"></div><div class="skeleton-line"></div><div class="skeleton-line short"></div></div>
            <div class="skeleton-card"><div class="skeleton-img"></div><div class="skeleton-line"></div><div class="skeleton-line short"></div></div>
            <div class="skeleton-card"><div class="skeleton-img"></div><div class="skeleton-line"></div><div class="skeleton-line short"></div></div>
            <div class="skeleton-card"><div class="skeleton-img"></div><div class="skeleton-line"></div><div class="skeleton-line short"></div></div>
        </div>
    </div>

    <!-- ═══════════════════════════════════
         PROFESSIONAL FOOTER
    ═══════════════════════════════════ -->
    <?php include 'Footer.php'; ?>

</div><!-- end .container -->

<script>
    const hamburger = document.querySelector('.hamburger');
    const nav = document.querySelector('.bottomheader');
    hamburger.addEventListener('click', ()=>{ nav.classList.toggle('active'); });

    // Sticky navbar shrink + shadow on scroll
    const topheader = document.querySelector('.topheader');
    window.addEventListener('scroll', ()=>{
        topheader.classList.toggle('scrolled', window.scrollY > 30);
    });

    // Scroll-reveal animation
    const revealEls = document.querySelectorAll('.reveal');
    const revealObserver = new IntersectionObserver((entries)=>{
        entries.forEach(entry=>{
            if(entry.isIntersecting){
                entry.target.classList.add('active');
                revealObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });
    revealEls.forEach(el => revealObserver.observe(el));

    // Animated stat counters
    const statNums = document.querySelectorAll('.stat-num');
    const statObserver = new IntersectionObserver((entries)=>{
        entries.forEach(entry=>{
            if(entry.isIntersecting){
                const el = entry.target;
                const target = parseFloat(el.dataset.count);
                const isDecimal = el.dataset.decimal === 'true';
                let current = 0;
                const step = target / 60;
                const tick = ()=>{
                    current += step;
                    if(current >= target){
                        el.textContent = (isDecimal ? (target/10).toFixed(1) : target) + (isDecimal ? '' : '+');
                    } else {
                        el.textContent = isDecimal ? (current/10).toFixed(1) : Math.floor(current) + '+';
                        requestAnimationFrame(tick);
                    }
                };
                tick();
                statObserver.unobserve(el);
            }
        });
    }, { threshold: 0.5 });
    statNums.forEach(el => statObserver.observe(el));
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        $.ajax({
            url: "fetch_product.php",
            method: "GET",
            success: function(data){
                $("#active-products").html(data);
                // Re-trigger reveal for newly injected content's parent
                document.getElementById('active-products').classList.add('active');
            }
        });
    });
</script>
</body>
</html>