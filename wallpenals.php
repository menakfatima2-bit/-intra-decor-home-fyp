<?php session_start(); include "db.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wall Panels</title>

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/wallpenals.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/Footer.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        /* ── HERO BANNER (matches Tiles page) ── */
        .wallpenals-hero {
            background: linear-gradient(135deg, #4b2c2c 0%, #7a4040 50%, #2c1a1a 100%);
            padding: 70px 40px 50px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .wallpenals-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .wallpenals-hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            color: #fff;
            letter-spacing: 2px;
            position: relative;
            margin: 0;
        }
        .wallpenals-hero p {
            color: rgba(255,255,255,0.7);
            font-size: 1rem;
            margin-top: 10px;
            position: relative;
        }
        .wallpenals-hero .hero-line {
            width: 60px;
            height: 3px;
            background: #d4a96a;
            margin: 18px auto 0;
            border-radius: 2px;
            position: relative;
        }
        .wpn-section-title {
            text-align: center;
            padding: 50px 20px 10px;
            font-family: 'DM Sans', sans-serif;
        }
        .wpn-section-title h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: #4b2c2c;
        }
        .wpn-section-title p {
            color: #888;
            font-size: 0.9rem;
            margin-top: 6px;
        }

        /* ── GRID (overrides old card styles) ── */
        .wallpenals-category {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 28px;
            padding: 30px 40px 60px;
            max-width: 1300px;
            margin: 0 auto;
        }

        /* ── CARD ── */
        .wallpenal-card {
            width: auto;
            background: #fff;
            border: none;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(75,44,44,0.08);
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
            position: relative;
            padding: 0;
            text-align: left;
            font-family: 'DM Sans', sans-serif;
        }
        .wallpenal-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 16px 40px rgba(75,44,44,0.18);
        }
        .wallpenal-card img {
            width: 100%;
            height: 190px;
            object-fit: cover;
            border-radius: 0;
            display: block;
            transition: transform 0.4s;
        }
        .wallpenal-card:hover img {
            transform: scale(1.06);
        }
        .wallpenal-card h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.05rem;
            color: #2a2a2a;
            font-weight: 600;
            padding: 18px 20px 12px;
            margin: 0;
        }
        .wallpenal-card .wpn-btn-wrap {
            padding: 0 20px 20px;
        }
        .wallpenal-card button {
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
        .wallpenal-card button:hover {
            background: #7a4040;
            transform: scale(1.05);
        }

        @media(max-width: 600px) {
            .wallpenals-hero h1 { font-size: 2rem; }
            .wallpenals-category { padding: 20px; gap: 16px; }
        }
    </style>
</head>
<body>

<!-- NAVBAR START -->
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
        "SELECT SUM(quantity) as total 
         FROM cart WHERE user_id='{$_SESSION['user_id']}'"
    );
    $cr = mysqli_fetch_assoc($c);
    $cart_count = $cr['total'] ?? 0;
}
?>

<div class="cart-box">
    <a href="cart.php" style="position:relative; display:inline-block;">
        <i class="fa-solid fa-cart-shopping"></i>
        <span class="cart-text">Cart</span>
        <?php if($cart_count > 0){ ?>
        <span id="cart-badge" style="
            position: absolute;
            top: -8px;
            right: -10px;
            background: #e74c3c;
            color: white;
            font-size: 11px;
            font-weight: bold;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        "><?php echo $cart_count; ?></span>
        <?php } ?>
    </a>
</div>

    </div>

    <div class="hamburger">
        <i class="fa-solid fa-bars"></i>
    </div>
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
<!-- NAVBAR END -->

<!-- HERO -->
<div class="wallpenals-hero">
    <h1>Wall Panels Collection</h1>
    <p>Premium quality wall panelling for every space</p>
    <div class="hero-line"></div>
</div>

<div class="wpn-section-title">
    <h2>Browse by Category</h2>
    <p>Select a panel style to explore our curated collection</p>
</div>

<!-- SUBCATEGORY CARDS -->
<div class="wallpenals-category">

    <div class="wallpenal-card" onclick="window.location.href='category_products.php?category=paneling&type=Brick Veneer'">
        <img src="assets/images/Brick or stone Veneer penals.png" alt="Brick Veneer">
        <h3>Brick Veneer Panels</h3>
        <div class="wpn-btn-wrap"><button>Explore</button></div>
    </div>

    <div class="wallpenal-card" onclick="window.location.href='category_products.php?category=paneling&type=Metal'">
        <img src="assets/images/Metal wall penals.png" alt="Metal">
        <h3>Metal Panels</h3>
        <div class="wpn-btn-wrap"><button>Explore</button></div>
    </div>

    <div class="wallpenal-card" onclick="window.location.href='category_products.php?category=paneling&type=Mirror'">
        <img src="assets/images/Mirror  penals.png" alt="Mirror">
        <h3>Mirror Panels</h3>
        <div class="wpn-btn-wrap"><button>Explore</button></div>
    </div>

    <div class="wallpenal-card" onclick="window.location.href='category_products.php?category=paneling&type=MDF'">
        <img src="assets/images/MVC wall penals.jpeg" alt="MDF">
        <h3>MDF Panels</h3>
        <div class="wpn-btn-wrap"><button>Explore</button></div>
    </div>

    <div class="wallpenal-card" onclick="window.location.href='category_products.php?category=paneling&type=PVC'">
        <img src="assets/images/PVC wall  penals.jpeg" alt="PVC">
        <h3>PVC Panels</h3>
        <div class="wpn-btn-wrap"><button>Explore</button></div>
    </div>

    <div class="wallpenal-card" onclick="window.location.href='category_products.php?category=paneling&type=Wood'">
        <img src="assets/images/wood wall penals.png" alt="Wood">
        <h3>Wood Panels</h3>
        <div class="wpn-btn-wrap"><button>Explore</button></div>
    </div>


</div>
<!-- SUBCATEGORY CARDS END -->

<!-- PRODUCTS YAHAN SHOW HONGE -->
<h2 id="products-heading" style="display:none; padding:20px 25px 0;"></h2>
<div id="subcategory-products" style="
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
    padding: 20px 25px;
"></div>

<!-- FOOTER -->
<?php include 'Footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function loadProducts(type) {
    $('#subcategory-products').html('<p style="padding:10px">Loading...</p>');

    $.ajax({
        url: 'fetch_by_subcategory.php',
        method: 'GET',
        data: {
            category: 'paneling',
            type: type
        },
        success: function(data) {
            $('#products-heading').show().text(type + ' Products');
            $('#subcategory-products').html(data);
            document.getElementById('subcategory-products')
                    .scrollIntoView({ behavior: 'smooth' });
        }
    });
}
</script>

<script>
const hamburger = document.querySelector('.hamburger');
const nav = document.querySelector('.bottomheader');
hamburger.addEventListener('click', ()=>{
    nav.classList.toggle('active');
});
</script>

</body>
</html>