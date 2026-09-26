<?php
session_start();
include "db.php";

// Check if user is logged in
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch all approved products
$query = "SELECT * FROM productadd WHERE status='approved' ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Products | Intra Decor Home</title>
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
        .products-hero {
            background: linear-gradient(135deg, #4b2c2c 0%, #7a4040 50%, #2c1a1a 100%);
            padding: 70px 40px 50px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .products-hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            color: #fff;
            letter-spacing: 2px;
            position: relative;
        }
        .products-hero p {
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
        }

        /* ── GRID ── */
        .products-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            padding: 50px 24px 80px;
        }
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 28px;
        }

        .product-card {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 18px rgba(75,44,44,0.08);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }
        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 28px rgba(75,44,44,0.15);
        }
        .product-card img {
            width: 100%;
            height: 190px;
            object-fit: cover;
        }
        .product-card-body {
            padding: 16px 18px 18px;
        }
        .product-card-body h3 {
            font-size: 15.5px;
            color: #4b2c2c;
            margin-bottom: 6px;
            font-weight: 700;
        }
        .product-card-body .p-category {
            font-size: 12px;
            color: #999;
            text-transform: capitalize;
            margin-bottom: 8px;
        }
        .product-card-body .p-price {
            font-size: 16px;
            font-weight: 700;
            color: #c17f4a;
            margin-bottom: 14px;
        }
        .card-actions {
            display: flex;
            gap: 8px;
        }
        .btn-view {
            flex: 1;
            text-align: center;
            background: #4b2c2c;
            color: #fff;
            padding: 9px 0;
            border-radius: 10px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: 0.2s;
        }
        .btn-view:hover { background: #6b3d3d; }

        .btn-fav {
            width: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            background: #fdeeee;
            color: #e74c3c;
            text-decoration: none;
            font-size: 15px;
            transition: 0.2s;
        }
        .btn-fav:hover { background: #fddede; }
        .btn-fav.is-fav { background: #e74c3c; color: #fff; }

        .no-products {
            text-align: center;
            padding: 80px 20px;
            color: #888;
        }
        .no-products i { font-size: 3rem; color: #ddd; display: block; margin-bottom: 16px; }
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
<div class="products-hero">
    <h1>All Products</h1>
    <p>Browse our full collection of premium décor products</p>
    <div class="hero-line"></div>
</div>

<div class="products-wrapper">

    <?php if(mysqli_num_rows($result) > 0){ ?>
    <div class="products-grid">
        <?php while($row = mysqli_fetch_assoc($result)){

            // Check if product is already in favorites
            $prod_id = $row['id'];
            $fav_check = mysqli_query($conn, "SELECT * FROM favorites WHERE user_id='$user_id' AND item_id='$prod_id' AND type='product'");
            $is_favorite = mysqli_num_rows($fav_check) > 0;
        ?>
        <div class="product-card">
            <a href="product_detail.php?id=<?php echo $row['id']; ?>">
                <img src="uploads/<?php echo htmlspecialchars($row['product_image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
            </a>
            <div class="product-card-body">
                <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                <div class="p-category"><?php echo htmlspecialchars($row['category']); ?></div>
                <div class="p-price">Rs. <?php echo number_format($row['price'], 0); ?></div>
                <div class="card-actions">
                    <a href="product_detail.php?id=<?php echo $row['id']; ?>" class="btn-view">View Details</a>
                    <?php if($is_favorite){ ?>
                        <span class="btn-fav is-fav"><i class="fa-solid fa-heart"></i></span>
                    <?php } else { ?>
                        <a href="add_favorite.php?item_id=<?php echo $row['id']; ?>&type=product" class="btn-fav"><i class="fa-regular fa-heart"></i></a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
    <?php } else { ?>
        <div class="no-products">
            <i class="fa-solid fa-box-open"></i>
            <h3>No products found!</h3>
        </div>
    <?php } ?>

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