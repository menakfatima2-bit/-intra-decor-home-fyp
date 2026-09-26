<?php
session_start();
error_reporting(0);
ini_set('display_errors', 0);
include "db.php";

$category = isset($_GET['category']) ? mysqli_real_escape_string($conn, $_GET['category']) : '';
$type     = isset($_GET['type'])     ? mysqli_real_escape_string($conn, $_GET['type'])     : '';
$sort     = isset($_GET['sort'])     ? $_GET['sort'] : 'new';

if(empty($category) || empty($type)){
    header("Location: index.php");
    exit();
}

// FIXED QUERY — LIKE se match hoga
$orderBy = "id DESC";
if($sort == 'low')  $orderBy = "price ASC";
if($sort == 'high') $orderBy = "price DESC";

$query = "SELECT * FROM productadd 
          WHERE status='approved' 
          AND category='$category' 
          AND (product_type='$type' OR product_type LIKE '%$type%')
          ORDER BY $orderBy";

$result        = mysqli_query($conn, $query);
$totalProducts = mysqli_num_rows($result);

$cart_count = 0;
if(isset($_SESSION['user_id'])){
    $c  = mysqli_query($conn, "SELECT SUM(quantity) as total FROM cart WHERE user_id='{$_SESSION['user_id']}'");
    $cr = mysqli_fetch_assoc($c);
    $cart_count = $cr['total'] ?? 0;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($type); ?> | Intra Decor Home</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/Footer.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'DM Sans',sans-serif; background:#f7f4f0; color:#2a2a2a; }

        /* ── HERO ── */
        .cat-hero {
            background: linear-gradient(135deg,#4b2c2c 0%,#7a4040 60%,#2c1a1a 100%);
            padding: 55px 40px 40px;
            position: relative;
            overflow: hidden;
        }
        .cat-hero::before {
            content:'';
            position:absolute; inset:0;
            background:url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .breadcrumb {
            position:relative;
            font-size:12px;
            color:rgba(255,255,255,0.55);
            margin-bottom:14px;
        }
        .breadcrumb a { color:rgba(255,255,255,0.55); text-decoration:none; }
        .breadcrumb a:hover { color:#d4a96a; }
        .breadcrumb span { color:rgba(255,255,255,0.9); }
        .cat-hero h1 {
            font-family:'Playfair Display',serif;
            font-size:2.5rem;
            color:#fff;
            position:relative;
        }
        .cat-hero-sub {
            color:rgba(255,255,255,0.65);
            font-size:0.9rem;
            margin-top:8px;
            position:relative;
        }
        .hero-line {
            width:50px; height:3px;
            background:#d4a96a;
            margin-top:16px;
            border-radius:2px;
            position:relative;
        }

        /* ── TOOLBAR ── */
        .toolbar {
            max-width:1300px;
            margin:30px auto 0;
            padding:0 30px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            flex-wrap:wrap;
            gap:12px;
        }
        .toolbar-left {
            display:flex;
            align-items:center;
            gap:14px;
        }
        .back-btn {
            display:inline-flex;
            align-items:center;
            gap:7px;
            color:#4b2c2c;
            text-decoration:none;
            font-size:13px;
            font-weight:500;
            border:1.5px solid #4b2c2c;
            padding:7px 18px;
            border-radius:25px;
            transition:all 0.3s;
        }
        .back-btn:hover { background:#4b2c2c; color:#fff; }
        .results-count { font-size:13px; color:#888; }

        .sort-select {
            padding:8px 18px;
            border-radius:25px;
            border:1.5px solid #ddd;
            background:#fff;
            font-size:13px;
            font-family:'DM Sans',sans-serif;
            color:#2a2a2a;
            outline:none;
            cursor:pointer;
            transition:border 0.3s;
        }
        .sort-select:focus { border-color:#4b2c2c; }

        /* ── PRODUCTS GRID ── */
        .products-section {
            max-width:1300px;
            margin:24px auto 60px;
            padding:0 30px;
        }
        .products-grid {
            display:grid;
            grid-template-columns:repeat(auto-fill,minmax(240px,1fr));
            gap:26px;
        }

        /* ── PRODUCT CARD ── */
        .prod-card {
            background:#fff;
            border-radius:16px;
            overflow:hidden;
            box-shadow:0 4px 18px rgba(75,44,44,0.08);
            transition:transform 0.3s,box-shadow 0.3s;
            cursor:pointer;
        }
        .prod-card:hover {
            transform:translateY(-7px);
            box-shadow:0 18px 40px rgba(75,44,44,0.16);
        }
        .prod-img-wrap {
            position:relative;
            height:210px;
            overflow:hidden;
        }
        .prod-img-wrap img {
            width:100%; height:100%;
            object-fit:cover;
            transition:transform 0.4s;
        }
        .prod-card:hover .prod-img-wrap img { transform:scale(1.07); }

        .prod-badge {
            position:absolute;
            top:12px; left:12px;
            background:#e74c3c;
            color:#fff;
            font-size:11px;
            font-weight:700;
            padding:4px 10px;
            border-radius:20px;
        }

        .prod-body { padding:16px 18px 18px; }
        .prod-type {
            font-size:10px;
            color:#b08060;
            text-transform:uppercase;
            letter-spacing:1.2px;
            margin-bottom:5px;
            font-weight:500;
        }
        .prod-name {
            font-family:'Playfair Display',serif;
            font-size:1rem;
            color:#2a2a2a;
            margin-bottom:12px;
            white-space:nowrap;
            overflow:hidden;
            text-overflow:ellipsis;
        }
        .prod-price {
            display:flex;
            align-items:center;
            gap:8px;
            margin-bottom:14px;
        }
        .prod-old { text-decoration:line-through; color:#bbb; font-size:12px; }
        .prod-final { font-size:1.2rem; font-weight:700; color:#4b2c2c; }

        .prod-btn {
            width:100%;
            background:#4b2c2c;
            color:#fff;
            border:none;
            padding:10px;
            border-radius:25px;
            font-size:13px;
            font-family:'DM Sans',sans-serif;
            font-weight:500;
            cursor:pointer;
            transition:background 0.3s;
        }
        .prod-btn:hover { background:#7a4040; }

        /* ── EMPTY STATE ── */
        .empty-state {
            text-align:center;
            padding:80px 20px;
            grid-column:1/-1;
            background:#fff;
            border-radius:16px;
            box-shadow:0 4px 18px rgba(75,44,44,0.06);
        }
        .empty-state i { font-size:4rem; color:#ddd; margin-bottom:20px; display:block; }
        .empty-state h3 {
            font-family:'Playfair Display',serif;
            font-size:1.4rem;
            color:#999;
            margin-bottom:8px;
        }
        .empty-state p { color:#bbb; font-size:13px; margin-bottom:20px; }
        .empty-state a {
            display:inline-flex; align-items:center; gap:6px;
            background:#4b2c2c; color:#fff;
            padding:10px 24px; border-radius:25px;
            text-decoration:none; font-size:13px;
            transition:background 0.3s;
        }
        .empty-state a:hover { background:#7a4040; }

        /* ── FOOTER ── */
        .footer { background:#2c1a1a; color:rgba(255,255,255,0.75); padding:50px 40px 20px; }
        .footer-top { display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:30px; margin-bottom:35px; }
        .footer-block h3 { color:#fff; font-family:'Playfair Display',serif; font-size:1.1rem; margin-bottom:14px; padding-bottom:8px; border-bottom:2px solid #d4a96a; display:inline-block; }
        .footer-block p,.footer-block ul li { font-size:13px; line-height:2; list-style:none; }
        .footer-block ul li a { color:rgba(255,255,255,0.65); text-decoration:none; transition:color 0.2s; }
        .footer-block ul li a:hover { color:#d4a96a; }
        .footer-bottom { border-top:1px solid rgba(255,255,255,0.1); padding-top:18px; text-align:center; font-size:12px; color:rgba(255,255,255,0.4); }

        @media(max-width:600px){
            .cat-hero h1 { font-size:1.7rem; }
            .cat-hero { padding:40px 20px 30px; }
            .products-section { padding:0 16px; }
            .toolbar { padding:0 16px; }
            .products-grid { grid-template-columns:repeat(auto-fill,minmax(160px,1fr)); gap:14px; }
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
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
<div class="cat-hero">
    <div class="breadcrumb">
        <a href="index.php">Home</a> &rsaquo;
        <a href="Tiles.php">Tiles</a> &rsaquo;
        <span><?php echo htmlspecialchars($type); ?></span>
    </div>
    <h1><?php echo htmlspecialchars($type); ?></h1>
    <p class="cat-hero-sub"><?php echo $totalProducts; ?> product<?php echo $totalProducts!=1?'s':''; ?> found</p>
    <div class="hero-line"></div>
</div>

<!-- TOOLBAR -->
<div class="toolbar">
    <div class="toolbar-left">
        <a href="Tiles.php" class="back-btn">
            <i class="fa-solid fa-arrow-left"></i> Back to Tiles
        </a>
        <span class="results-count">
            Showing <strong><?php echo $totalProducts; ?></strong> result<?php echo $totalProducts!=1?'s':''; ?> for "<strong><?php echo htmlspecialchars($type); ?></strong>"
        </span>
    </div>
    <select class="sort-select" onchange="sortProducts(this.value)">
        <option value="new"  <?php echo $sort=='new' ?'selected':''; ?>>Newest First</option>
        <option value="low"  <?php echo $sort=='low' ?'selected':''; ?>>Price: Low to High</option>
        <option value="high" <?php echo $sort=='high'?'selected':''; ?>>Price: High to Low</option>
    </select>
</div>

<!-- PRODUCTS -->
<div class="products-section">
    <div class="products-grid">
        <?php if($totalProducts == 0): ?>
        <div class="empty-state">
            <i class="fa-regular fa-box-open"></i>
            <h3>No Products Found</h3>
            <p>There are no products in this category yet.</p>
            <a href="Tiles.php"><i class="fa-solid fa-arrow-left"></i> Back to Tiles</a>
        </div>

        <?php else: ?>
        <?php while($row = mysqli_fetch_assoc($result)):
            $price    = $row['price'];
            $discount = $row['discount'];
            $final    = $price - ($price * $discount / 100);
            $id       = $row['id'];
            $img      = "uploads/" . htmlspecialchars($row['product_image']);
            $name     = htmlspecialchars($row['name']);
            $ptype    = htmlspecialchars($row['product_type']);
        ?>
        <div class="prod-card" onclick="window.location.href='product_detail.php?id=<?php echo $id; ?>'">
            <div class="prod-img-wrap">
                <img src="<?php echo $img; ?>" alt="<?php echo $name; ?>">
                <?php if($discount > 0): ?>
                <span class="prod-badge"><?php echo $discount; ?>% OFF</span>
                <?php endif; ?>
            </div>
            <div class="prod-body">
                <p class="prod-type"><?php echo $ptype; ?></p>
                <h3 class="prod-name"><?php echo $name; ?></h3>
                <div class="prod-price">
                    <?php if($discount > 0): ?>
                    <span class="prod-old">Rs. <?php echo $price; ?></span>
                    <?php endif; ?>
                    <span class="prod-final">Rs. <?php echo number_format($final,0); ?></span>
                </div>
                <button class="prod-btn"
                    onclick="event.stopPropagation();window.location.href='product_detail.php?id=<?php echo $id; ?>'">
                    View Details
                </button>
            </div>
        </div>
        <?php endwhile; ?>
        <?php endif; ?>
    </div>
</div>

<!-- FOOTER -->
<?php include 'Footer.php'; ?>

<script>
function sortProducts(sortBy){
    const category = '<?php echo $category; ?>';
    const type     = '<?php echo addslashes($type); ?>';
    window.location.href = `category_products.php?category=${category}&type=${encodeURIComponent(type)}&sort=${sortBy}`;
}
const hamburger = document.querySelector('.hamburger');
const nav       = document.querySelector('.bottomheader');
hamburger.addEventListener('click',()=>{ nav.classList.toggle('active'); });
</script>
</body>
</html>