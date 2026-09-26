<?php
session_start();
include "db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiles | Intra Decor Home</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/Footer.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #f7f4f0;
            color: #2a2a2a;
        }

        /* ── HERO BANNER ── */
        .tiles-hero {
            background: linear-gradient(135deg, #4b2c2c 0%, #7a4040 50%, #2c1a1a 100%);
            padding: 70px 40px 50px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .tiles-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .tiles-hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            color: #fff;
            letter-spacing: 2px;
            position: relative;
        }
        .tiles-hero p {
            color: rgba(255,255,255,0.7);
            font-size: 1rem;
            margin-top: 10px;
            position: relative;
        }
        .hero-line {
            width: 60px;
            height: 3px;
            background: #d4a96a;
            margin: 18px auto 0;
            border-radius: 2px;
            position: relative;
        }

        /* ── SECTION TITLE ── */
        .section-title {
            text-align: center;
            padding: 50px 20px 10px;
        }
        .section-title h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: #4b2c2c;
        }
        .section-title p {
            color: #888;
            font-size: 0.9rem;
            margin-top: 6px;
        }

        /* ── GRID ── */
        .tiles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 28px;
            padding: 30px 40px 60px;
            max-width: 1300px;
            margin: 0 auto;
        }

        /* ── CARD ── */
        .tile-card {
            background: #fff;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(75,44,44,0.08);
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
            position: relative;
        }
        .tile-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 16px 40px rgba(75,44,44,0.18);
        }
        .tile-card-img {
            width: 100%;
            height: 190px;
            object-fit: cover;
            display: block;
            transition: transform 0.4s;
        }
        .tile-card:hover .tile-card-img {
            transform: scale(1.06);
        }
        .tile-card-img-wrap {
            overflow: hidden;
            position: relative;
        }
        .tile-card-img-wrap::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(75,44,44,0.35) 0%, transparent 60%);
            opacity: 0;
            transition: opacity 0.3s;
        }
        .tile-card:hover .tile-card-img-wrap::after {
            opacity: 1;
        }

        .tile-card-body {
            padding: 18px 20px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .tile-card-body h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.05rem;
            color: #2a2a2a;
            font-weight: 600;
        }
        .tile-card-body span {
            font-size: 11px;
            color: #888;
            margin-top: 3px;
            display: block;
        }
        .tile-view-btn {
            background: #4b2c2c;
            color: #fff;
            border: none;
            padding: 9px 18px;
            border-radius: 25px;
            font-size: 12px;
            font-family: 'DM Sans', sans-serif;
            font-weight: 500;
            cursor: pointer;
            white-space: nowrap;
            transition: background 0.3s, transform 0.2s;
            letter-spacing: 0.5px;
        }
        .tile-view-btn:hover {
            background: #7a4040;
            transform: scale(1.05);
        }

        /* Footer styling now in assets/css/Footer.css (shared) */

        @media(max-width: 600px) {
            .tiles-hero h1 { font-size: 2rem; }
            .tiles-grid { padding: 20px; gap: 16px; }
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
                <a class="login" href="signup.php">Login/Signup</a>
            <?php } ?>
            <a class="my-account" href="userdashboard/userdashboard.php"><i class="fa-solid fa-user"></i> My Account</a>
        </div>
        <?php
        $cart_count = 0;
        if(isset($_SESSION['user_id'])){
            $c = mysqli_query($conn, "SELECT SUM(quantity) as total FROM cart WHERE user_id='{$_SESSION['user_id']}'");
            $cr = mysqli_fetch_assoc($c);
            $cart_count = $cr['total'] ?? 0;
        }
        ?>
        <div class="cart-box">
            <a href="cart.php" style="position:relative; display:inline-block;">
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
<div class="tiles-hero">
    <h1>Tiles Collection</h1>
    <p>Premium quality tiles for every space</p>
    <div class="hero-line"></div>
</div>

<!-- SECTION TITLE -->
<div class="section-title">
    <h2>Browse by Category</h2>
    <p>Select a tile type to explore our curated collection</p>
</div>

<!-- TILES GRID -->
<div class="tiles-grid">

    <div class="tile-card" onclick="window.location.href='category_products.php?category=tiles&type=Granite Tiles'">
        <div class="tile-card-img-wrap">
            <img src="assets/images/Granite (2).jpeg" alt="Granite" class="tile-card-img">
        </div>
        <div class="tile-card-body">
            <div>
                <h3>Granite Tiles</h3>
                <span>Durable & Natural</span>
            </div>
            <button class="tile-view-btn">Explore</button>
        </div>
    </div>

    <div class="tile-card" onclick="window.location.href='category_products.php?category=tiles&type=Limestone Tiles'">
        <div class="tile-card-img-wrap">
            <img src="assets/images/Limestone Tiles.jpeg" alt="Limestone" class="tile-card-img">
        </div>
        <div class="tile-card-body">
            <div>
                <h3>Limestone Tiles</h3>
                <span>Classic & Elegant</span>
            </div>
            <button class="tile-view-btn">Explore</button>
        </div>
    </div>

    <div class="tile-card" onclick="window.location.href='category_products.php?category=tiles&type=Marble Tiles'">
        <div class="tile-card-img-wrap">
            <img src="assets/images/merbal Tiles.jpeg" alt="Marble" class="tile-card-img">
        </div>
        <div class="tile-card-body">
            <div>
                <h3>Marble Tiles</h3>
                <span>Luxury & Premium</span>
            </div>
            <button class="tile-view-btn">Explore</button>
        </div>
    </div>

    <div class="tile-card" onclick="window.location.href='category_products.php?category=tiles&type=Quarry Tiles'">
        <div class="tile-card-img-wrap">
            <img src="assets/images/quarry.png" alt="Quarry" class="tile-card-img">
        </div>
        <div class="tile-card-body">
            <div>
                <h3>Quarry Tiles</h3>
                <span>Rustic & Strong</span>
            </div>
            <button class="tile-view-btn">Explore</button>
        </div>
    </div>

    <div class="tile-card" onclick="window.location.href='category_products.php?category=tiles&type=Sandstone Tiles'">
        <div class="tile-card-img-wrap">
            <img src="assets/images/Sandstone.jpeg" alt="Sandstone" class="tile-card-img">
        </div>
        <div class="tile-card-body">
            <div>
                <h3>Sandstone Tiles</h3>
                <span>Warm & Textured</span>
            </div>
            <button class="tile-view-btn">Explore</button>
        </div>
    </div>

    <div class="tile-card" onclick="window.location.href='category_products.php?category=tiles&type=Slate Tiles'">
        <div class="tile-card-img-wrap">
            <img src="assets/images/Slate.jpeg" alt="Slate" class="tile-card-img">
        </div>
        <div class="tile-card-body">
            <div>
                <h3>Slate Tiles</h3>
                <span>Bold & Natural</span>
            </div>
            <button class="tile-view-btn">Explore</button>
        </div>
    </div>

    <div class="tile-card" onclick="window.location.href='category_products.php?category=tiles&type=Terrazzo Tiles'">
        <div class="tile-card-img-wrap">
            <img src="assets/images/Terrazzo tiles.jpeg" alt="Terrazzo" class="tile-card-img">
        </div>
        <div class="tile-card-body">
            <div>
                <h3>Terrazzo Tiles</h3>
                <span>Modern & Artistic</span>
            </div>
            <button class="tile-view-btn">Explore</button>
        </div>
    </div>

    <div class="tile-card" onclick="window.location.href='category_products.php?category=tiles&type=Travertine Tiles'">
        <div class="tile-card-img-wrap">
            <img src="assets/images/Travertine.jpeg" alt="Travertine" class="tile-card-img">
        </div>
        <div class="tile-card-body">
            <div>
                <h3>Travertine Tiles</h3>
                <span>Timeless & Refined</span>
            </div>
            <button class="tile-view-btn">Explore</button>
        </div>
    </div>

    <div class="tile-card" onclick="window.location.href='category_products.php?category=tiles&type=Glass Tiles'">
        <div class="tile-card-img-wrap">
            <img src="assets/images/Glass Tiles.jpeg" alt="Glass" class="tile-card-img">
        </div>
        <div class="tile-card-body">
            <div>
                <h3>Glass Tiles</h3>
                <span>Sleek & Modern</span>
            </div>
            <button class="tile-view-btn">Explore</button>
        </div>
    </div>



</div>

<!-- FOOTER -->
<?php include 'Footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
const hamburger = document.querySelector('.hamburger');
const nav = document.querySelector('.bottomheader');
hamburger.addEventListener('click', ()=>{ nav.classList.toggle('active'); });
</script>
</body>
</html>