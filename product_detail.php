<?php
session_start();
include "db.php";

if(!isset($_GET['id'])){
    echo "Invalid Product!";
    exit();
}

$id = intval($_GET['id']);

$query = "SELECT * FROM productadd WHERE id='$id' AND status='approved'";
$result = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result);

if(!$product){
    echo "Product not found!";
    exit();
}

// Fetch review statistics
$review_stats_q = mysqli_query($conn, "SELECT AVG(rating) as avg_rating, COUNT(*) as review_count FROM product_reviews WHERE product_id = '$id'");
$review_stats = mysqli_fetch_assoc($review_stats_q);
$avg_rating = round($review_stats['avg_rating'] ?? 0, 1);
$review_count = $review_stats['review_count'] ?? 0;

$price    = $product['price'];
$discount = $product['discount'];
$final    = $price - ($price * $discount / 100);

function cmToFtIn($cm) {
    $cm      = floatval($cm);
    $totalIn = $cm / 2.54;
    $ft      = floor($totalIn / 12);
    $in      = round($totalIn - ($ft * 12));
    if ($in == 12) { $ft++; $in = 0; }
    return $in > 0 ? "{$ft} ft {$in} in" : "{$ft} ft";
}

function cmToDecimalFt($cm) {
    return floatval($cm) / 30.48;
}

// Wallpaper data
$widthCm  = floatval($product['roll_width']  ?? 0);
$lengthCm = floatval($product['roll_length'] ?? 0);
$rollWidthFt  = $widthCm  > 0 ? cmToFtIn($widthCm)  : null;
$rollLengthFt = $lengthCm > 0 ? cmToFtIn($lengthCm) : null;
$coveragePerRoll = ($widthCm > 0 && $lengthCm > 0)
    ? round(cmToDecimalFt($widthCm) * cmToDecimalFt($lengthCm), 2) : 0;

// Tiles data
$tileLengthFt = floatval($product['tile_length'] ?? 0);
$tileWidthFt  = floatval($product['tile_width']  ?? 0);
$finishType   = $product['finish_type'] ?? '';
$tileAreaSqft = ($tileLengthFt > 0 && $tileWidthFt > 0)
    ? round($tileLengthFt * $tileWidthFt, 4) : 0;

// Wall Panels data
$panelLengthFt = floatval($product['panel_length'] ?? 0);
$panelWidthFt  = floatval($product['panel_width']  ?? 0);
$panelAreaSqft = ($panelLengthFt > 0 && $panelWidthFt > 0)
    ? round($panelLengthFt * $panelWidthFt, 4) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?> | Intra Decor</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/Footer.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'DM Sans', sans-serif; background: #f6f4f1; color: #2a2118; }

        .detail-outer { max-width: 1120px; margin: 32px auto 60px; padding: 0 20px; }
        .detail-grid {
            display: grid; grid-template-columns: 1fr 1fr; gap: 0;
            background: #fff; border-radius: 24px; overflow: hidden;
            box-shadow: 0 12px 48px rgba(0,0,0,0.10);
        }

        .detail-left {
            position: sticky; top: 0; height: 100vh; max-height: 100vh;
            display: flex; flex-direction: column;
            background: #faf8f5; border-right: 1px solid #f0ece6; overflow: hidden;
        }
        .main-img-wrap { flex: 1; overflow: hidden; position: relative; }
        .main-img-wrap img {
            width: 100%; height: 100%; object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        .main-img-wrap:hover img { transform: scale(1.05); }
        .img-ribbon {
            position: absolute; top: 20px; left: 20px;
            background: #c0392b; color: #fff;
            font-size: 12px; font-weight: 700;
            padding: 6px 14px; border-radius: 20px; letter-spacing: 0.5px;
        }
        .color-thumbs {
            display: flex; gap: 10px; padding: 16px 20px;
            background: #faf8f5; border-top: 1px solid #f0ece6; flex-wrap: wrap;
        }
        .color-thumbs img {
            width: 60px; height: 60px; border-radius: 12px; object-fit: cover;
            border: 2px solid transparent; cursor: pointer; transition: 0.25s; background: #eee;
        }
        .color-thumbs img:hover, .color-thumbs img.active {
            border-color: #b5773a; box-shadow: 0 0 0 3px rgba(181,119,58,0.2);
        }

        .detail-right {
            padding: 44px; overflow-y: auto; max-height: 100vh;
            display: flex; flex-direction: column; gap: 0;
        }
        .cat-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: #f5ede0; color: #8a4e1b;
            padding: 5px 14px; border-radius: 20px;
            font-size: 11px; font-weight: 600; letter-spacing: 0.6px;
            text-transform: uppercase; margin-bottom: 16px; width: fit-content;
        }
        .detail-right h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem; font-weight: 700; color: #1e1712;
            line-height: 1.25; margin-bottom: 20px;
        }
        .divider { height: 1px; background: linear-gradient(to right, #e8dfd4, transparent); margin: 20px 0; }

        .price-block { margin-bottom: 4px; }
        .price-row { display: flex; align-items: baseline; gap: 12px; flex-wrap: wrap; }
        .old-price { color: #bbb; text-decoration: line-through; font-size: 1rem; font-weight: 400; }
        .final-price { font-family: 'Playfair Display', serif; color: #1e1712; font-size: 2.2rem; font-weight: 700; }
        .discount-badge { background: #c0392b; color: #fff; padding: 3px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; }
        .price-note { font-size: 11px; color: #aaa; margin-top: 5px; }

        .stock-pill {
            display: inline-flex; align-items: center; gap: 6px;
            background: #edfaf3; color: #1a7a45; border: 1px solid #b2e8cc;
            padding: 5px 14px; border-radius: 20px; font-size: 12px; font-weight: 600; margin-bottom: 4px;
        }
        .stock-pill .dot {
            width: 7px; height: 7px; background: #2ecc71; border-radius: 50%; animation: pulse 1.8s infinite;
        }
        @keyframes pulse { 0%,100%{ opacity:1; } 50%{ opacity:0.4; } }
        .desc-text { font-size: 14px; color: #6b5d52; line-height: 1.8; }

        /* Roll info box */
        .roll-info-box { background: #fffbf4; border: 1.5px solid #e8d5b0; border-radius: 16px; padding: 20px 22px; margin: 20px 0; }
        .roll-info-box .box-title { font-size: 11px; font-weight: 700; color: #9a6e2a; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
        .roll-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(88px, 1fr)); gap: 10px; }
        .roll-stat { background: #fff; border-radius: 12px; padding: 12px 10px; text-align: center; border: 1px solid #f0e8d8; }
        .roll-stat .rs-label { font-size: 9px; color: #c0a880; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 6px; }
        .roll-stat .rs-value { font-size: 14px; font-weight: 700; color: #2a2118; }
        .roll-note { margin-top: 14px; background: #fff8e8; border-left: 3px solid #e8a020; border-radius: 0 8px 8px 0; padding: 10px 14px; font-size: 12px; color: #7a5800; line-height: 1.6; }

        /* Tiles info box */
        .tile-info-box { background: #f0f8ff; border: 1.5px solid #aed6f1; border-radius: 16px; padding: 20px 22px; margin: 20px 0; }
        .tile-info-box .box-title { font-size: 11px; font-weight: 700; color: #1a5276; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
        .tile-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(88px, 1fr)); gap: 10px; }
        .tile-stat { background: #fff; border-radius: 12px; padding: 12px 10px; text-align: center; border: 1px solid #d6eaf8; }
        .tile-stat .ts-label { font-size: 9px; color: #7fb3d3; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 6px; }
        .tile-stat .ts-value { font-size: 14px; font-weight: 700; color: #2a2118; }

        /* Panel info box */
        .panel-info-box { background: #f0fff4; border: 1.5px solid #a8dfc0; border-radius: 16px; padding: 20px 22px; margin: 20px 0; }
        .panel-info-box .box-title { font-size: 11px; font-weight: 700; color: #1a5c35; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
        .panel-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(88px, 1fr)); gap: 10px; }
        .panel-stat { background: #fff; border-radius: 12px; padding: 12px 10px; text-align: center; border: 1px solid #c3e6cb; }
        .panel-stat .ps-label { font-size: 9px; color: #6abf8a; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 6px; }
        .panel-stat .ps-value { font-size: 14px; font-weight: 700; color: #2a2118; }

        /* Calculator */
        .wall-calc { background: #fafafa; border: 1.5px solid #e8e0d8; border-radius: 18px; padding: 24px; margin: 4px 0 20px; }
        .calc-header { display: flex; align-items: center; gap: 12px; margin-bottom: 4px; }
        .calc-icon { width: 38px; height: 38px; background: linear-gradient(135deg, #b5773a, #e09840); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 17px; }
        .calc-header h4 { font-family: 'Playfair Display', serif; font-size: 17px; font-weight: 700; color: #1e1712; }
        .calc-sub { font-size: 12px; color: #aaa; margin-bottom: 20px; margin-left: 50px; }
        .input-row { display: flex; align-items: center; gap: 14px; margin-bottom: 12px; }
        .input-row > span { font-size: 13px; font-weight: 600; color: #5a4a3a; min-width: 90px; }
        .ft-in-group { display: flex; gap: 8px; flex: 1; }
        .input-unit { display: flex; align-items: center; background: #fff; border: 1.5px solid #e0d8cc; border-radius: 10px; overflow: hidden; flex: 1; transition: 0.2s; }
        .input-unit:focus-within { border-color: #b5773a; box-shadow: 0 0 0 3px rgba(181,119,58,0.12); }
        .input-unit input { border: none; background: transparent; padding: 10px 12px; font-size: 14px; font-weight: 600; color: #2a2118; width: 100%; outline: none; font-family: 'DM Sans', sans-serif; }
        .input-unit .u-label { background: #fff8ee; color: #b5773a; font-size: 10px; font-weight: 800; padding: 0 10px; border-left: 1.5px solid #f0dfc0; align-self: stretch; display: flex; align-items: center; letter-spacing: 0.5px; }
        .pattern-select { display: flex; align-items: center; gap: 14px; margin-bottom: 18px; }
        .pattern-select span { font-size: 13px; font-weight: 600; color: #5a4a3a; min-width: 90px; }
        .pattern-select select { flex: 1; padding: 10px 14px; border-radius: 10px; border: 1.5px solid #e0d8cc; font-size: 13px; background: #fff; cursor: pointer; outline: none; transition: 0.2s; font-family: 'DM Sans', sans-serif; color: #2a2118; }
        .pattern-select select:focus { border-color: #b5773a; }
        .btn-calc { width: 100%; padding: 13px; background: #2a2118; color: #fff; border: none; border-radius: 12px; font-size: 14px; font-weight: 700; cursor: pointer; transition: 0.3s; margin-bottom: 16px; font-family: 'DM Sans', sans-serif; }
        .btn-calc:hover { background: #b5773a; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(181,119,58,0.28); }
        .calc-error { display: none; color: #c0392b; font-size: 12px; margin-bottom: 12px; padding: 8px 14px; background: #fff5f5; border-radius: 8px; border-left: 3px solid #e74c3c; }
        .calc-error.show { display: block; }
        .calc-result { display: none; background: linear-gradient(135deg, #f0fff7, #e6f9ef); border: 1.5px solid #a8dfc0; border-radius: 14px; padding: 20px; }
        .calc-result.show { display: block; animation: popUp 0.3s ease; }
        @keyframes popUp { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: translateY(0); } }
        .result-cards { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 14px; }
        .res-card { background: #fff; border-radius: 12px; padding: 14px; text-align: center; }
        .res-card .rc-label { font-size: 9px; color: #aaa; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 6px; }
        .res-card .rc-val { font-size: 22px; font-weight: 800; color: #2a2118; font-family: 'Playfair Display', serif; }
        .res-card .rc-unit { font-size: 10px; color: #aaa; margin-top: 2px; }
        .res-card.amber .rc-val { color: #c0780a; }
        .res-card.forest .rc-val { color: #1a7a45; }
        .result-note { font-size: 12px; color: #1a5c35; background: #d4f5e2; border-radius: 8px; padding: 10px 14px; line-height: 1.8; }

        /* CTA */
        .btn-row { display: flex; gap: 12px; margin-top: 24px; }
        .btn-cart { flex: 2; background: #2a2118; color: #fff; padding: 15px 24px; border: none; border-radius: 50px; font-size: 14px; font-weight: 700; cursor: pointer; transition: 0.3s; display: flex; align-items: center; justify-content: center; gap: 9px; font-family: 'DM Sans', sans-serif; }
        .btn-cart:hover { background: #b5773a; transform: translateY(-2px); box-shadow: 0 10px 24px rgba(181,119,58,0.30); }
        .btn-fav { flex: 1; background: transparent; color: #2a2118; padding: 15px 20px; border: 2px solid #d0c8be; border-radius: 50px; font-size: 14px; font-weight: 700; cursor: pointer; text-decoration: none; transition: 0.3s; display: flex; align-items: center; justify-content: center; gap: 8px; font-family: 'DM Sans', sans-serif; }
        .btn-fav:hover { border-color: #2a2118; background: #2a2118; color: #fff; transform: translateY(-2px); }
        .btn-fav i { color: #c0392b; transition: 0.3s; }
        .btn-fav:hover i { color: #fff; }
        .back-link { display: inline-flex; align-items: center; gap: 7px; margin: 20px 0 16px; color: #6b5d52; text-decoration: none; font-size: 13px; font-weight: 600; transition: 0.2s; font-family: 'DM Sans', sans-serif; }
        .back-link:hover { color: #2a2118; gap: 10px; }

        @media (max-width: 860px) {
            .detail-grid { grid-template-columns: 1fr; }
            .detail-left { position: relative; height: auto; max-height: none; }
            .main-img-wrap { height: 320px; flex: none; }
            .detail-right { max-height: none; overflow-y: visible; padding: 28px 22px; }
            .result-cards { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 520px) {
            .input-row { flex-direction: column; align-items: flex-start; }
            .input-row > span { min-width: unset; }
            .btn-row { flex-direction: column; }
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
        <?php
        $cart_count = 0;
        if(isset($_SESSION['user_id'])){
            $c  = mysqli_query($conn, "SELECT SUM(quantity) as total FROM cart WHERE user_id='{$_SESSION['user_id']}'");
            $cr = mysqli_fetch_assoc($c);
            $cart_count = $cr['total'] ?? 0;
        }
        ?>
        <div class="cart-box">
            <a href="cart.php" style="position:relative; display:inline-block;">
                <i class="fa-solid fa-cart-shopping"></i>
                <span class="cart-text">Cart</span>
                <?php if($cart_count > 0){ ?>
                <span id="cart-badge" style="position:absolute;top:-8px;right:-10px;background:#c0392b;color:white;font-size:11px;font-weight:bold;width:18px;height:18px;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                    <?php echo $cart_count; ?>
                </span>
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

<div class="detail-outer">
    <a href="javascript:history.back()" class="back-link">
        <i class="fa-solid fa-arrow-left"></i> Back to Products
    </a>

    <div class="detail-grid">

        <!-- LEFT IMAGE -->
        <div class="detail-left">
            <div class="main-img-wrap">
                <img id="main-product-img"
                     src="uploads/<?php echo htmlspecialchars($product['product_image']); ?>"
                     alt="<?php echo htmlspecialchars($product['name']); ?>">
                <?php if($discount > 0): ?>
                <div class="img-ribbon"><?php echo $discount; ?>% OFF</div>
                <?php endif; ?>
            </div>
            <?php
            $variants = [];
            if(!empty($product['product_image'])) $variants[] = $product['product_image'];
            if(!empty($product['color_image2']))  $variants[] = $product['color_image2'];
            if(!empty($product['color_image3']))  $variants[] = $product['color_image3'];
            if(!empty($product['color_image4']))  $variants[] = $product['color_image4'];
            if(!empty($product['color_image5']))  $variants[] = $product['color_image5'];
            if(count($variants) > 1): ?>
            <div class="color-thumbs">
                <?php foreach($variants as $i => $img): ?>
                <img src="uploads/<?php echo htmlspecialchars($img); ?>"
                     class="<?php echo $i===0 ? 'active' : ''; ?>"
                     onclick="switchColor(this, 'uploads/<?php echo htmlspecialchars($img); ?>')"
                     alt="Variant <?php echo $i+1; ?>">
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- RIGHT INFO -->
        <div class="detail-right">

            <span class="cat-badge">
                <i class="fa-solid fa-tag" style="font-size:9px;"></i>
                <?php echo htmlspecialchars($product['category']); ?>
                &nbsp;/&nbsp;
                <?php echo htmlspecialchars($product['product_type']); ?>
            </span>

            <h2><?php echo htmlspecialchars($product['name']); ?></h2>

            <!-- RATING SUMMARY -->
            <div class="rating-summary-top" style="margin-top: -12px; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
                <?php if ($review_count > 0): ?>
                    <span style="color:#ffa502; font-size:15px; display: inline-flex; gap: 2px;">
                        <?php 
                        $full_stars = floor($avg_rating);
                        $half_star = ($avg_rating - $full_stars) >= 0.5 ? 1 : 0;
                        $empty_stars = 5 - $full_stars - $half_star;
                        echo str_repeat('<i class="fa-solid fa-star"></i>', $full_stars);
                        if ($half_star) echo '<i class="fa-solid fa-star-half-stroke"></i>';
                        echo str_repeat('<i class="fa-regular fa-star"></i>', $empty_stars);
                        ?>
                    </span>
                    <span style="font-size:13px; font-weight:700; color:#1e1712;"><?php echo $avg_rating; ?>/5.0</span>
                    <span style="font-size:13px; color:#777;">(<?php echo $review_count; ?> <?php echo $review_count == 1 ? 'review' : 'reviews'; ?>)</span>
                <?php else: ?>
                    <span style="color:#ddd; font-size:15px; display: inline-flex; gap: 2px;"><?php echo str_repeat('<i class="fa-regular fa-star"></i>', 5); ?></span>
                    <span style="font-size:13px; color:#777;">No reviews yet</span>
                <?php endif; ?>
            </div>

            <!-- PRICE -->
            <div class="price-block">
                <div class="price-row">
                    <?php if($discount > 0): ?>
                        <span class="old-price">Rs. <?php echo number_format($price); ?></span>
                        <span class="final-price">Rs. <?php echo number_format($final, 0); ?></span>
                        <span class="discount-badge"><?php echo $discount; ?>% OFF</span>
                    <?php else: ?>
                        <span class="final-price">Rs. <?php echo number_format($price); ?></span>
                    <?php endif; ?>
                </div>
                <div class="price-note">
                    <?php
                    if($product['category'] == 'tiles') echo 'Price per tile · inclusive of all taxes';
                    elseif($product['category'] == 'paneling') echo 'Price per panel/sheet · inclusive of all taxes';
                    else echo 'Price per roll · inclusive of all taxes';
                    ?>
                </div>
            </div>

            <div class="divider"></div>

            <!-- STOCK -->
            <span class="stock-pill">
                <span class="dot"></span>
                <?php echo htmlspecialchars($product['quantity']); ?>
                <?php
                if($product['category'] == 'tiles') echo 'tiles';
                elseif($product['category'] == 'paneling') echo 'panels';
                else echo 'rolls';
                ?> in stock
            </span>

            <!-- DESCRIPTION -->
            <div style="margin-top:16px; margin-bottom:8px;">
                <p style="font-size:11px;font-weight:700;color:#9a8878;text-transform:uppercase;letter-spacing:1px;margin-bottom:6px;">Description</p>
                <p class="desc-text"><?php echo htmlspecialchars($product['description']); ?></p>
            </div>

            <!-- ══ WALLPAPER ══ -->
            <?php if($product['category'] == 'wallpaper' && ($widthCm > 0 || $lengthCm > 0 || $product['material'])): ?>
            <div class="roll-info-box">
                <div class="box-title"><i class="fa-solid fa-ruler-combined"></i> Roll Specifications</div>
                <div class="roll-stats">
                    <?php if($rollWidthFt): ?>
                    <div class="roll-stat"><div class="rs-label">Width</div><div class="rs-value"><?php echo $rollWidthFt; ?></div></div>
                    <?php endif; ?>
                    <?php if($rollLengthFt): ?>
                    <div class="roll-stat"><div class="rs-label">Length</div><div class="rs-value"><?php echo $rollLengthFt; ?></div></div>
                    <?php endif; ?>
                    <?php if($product['material']): ?>
                    <div class="roll-stat"><div class="rs-label">Material</div><div class="rs-value"><?php echo htmlspecialchars($product['material']); ?></div></div>
                    <?php endif; ?>
                    <?php if($coveragePerRoll > 0): ?>
                    <div class="roll-stat"><div class="rs-label">Coverage</div><div class="rs-value"><?php echo $coveragePerRoll; ?> sq ft</div></div>
                    <?php endif; ?>
                </div>
                <?php if($rollWidthFt && $rollLengthFt): ?>
                <div class="roll-note">⚠️ <strong>1 roll = <?php echo $rollWidthFt; ?> × <?php echo $rollLengthFt; ?></strong> — Use the Wall Calculator below.</div>
                <?php endif; ?>
            </div>

            <?php if($coveragePerRoll > 0): ?>
            <div class="wall-calc">
                <div class="calc-header"><div class="calc-icon">🧮</div><h4>Wall Calculator</h4></div>
                <p class="calc-sub">Enter your wall size — we'll calculate exactly how many rolls you need.</p>
                <div class="input-row">
                    <span>Wall Height</span>
                    <div class="ft-in-group">
                        <div class="input-unit"><input type="number" id="wall_h_ft" placeholder="9" min="0" max="50"><span class="u-label">ft</span></div>
                        <div class="input-unit"><input type="number" id="wall_h_in" placeholder="0" min="0" max="11"><span class="u-label">in</span></div>
                    </div>
                </div>
                <div class="input-row">
                    <span>Wall Width</span>
                    <div class="ft-in-group">
                        <div class="input-unit"><input type="number" id="wall_w_ft" placeholder="12" min="0" max="200"><span class="u-label">ft</span></div>
                        <div class="input-unit"><input type="number" id="wall_w_in" placeholder="0" min="0" max="11"><span class="u-label">in</span></div>
                    </div>
                </div>
                <div class="pattern-select">
                    <span>Pattern Waste</span>
                    <select id="pattern_waste">
                        <option value="0">No Pattern — 0% waste</option>
                        <option value="10" selected>Small Pattern — 10% extra</option>
                        <option value="15">Large Pattern — 15% extra</option>
                        <option value="20">Very Large Pattern — 20% extra</option>
                    </select>
                </div>
                <div class="calc-error" id="calc-error">⚠️ Please enter wall height and width first.</div>
                <button class="btn-calc" onclick="calculateRolls()">Calculate Rolls Needed &nbsp;→</button>
                <div class="calc-result" id="calc-result">
                    <div class="result-cards">
                        <div class="res-card"><div class="rc-label">Wall Area</div><div class="rc-val" id="res-area">—</div><div class="rc-unit">sq ft</div></div>
                        <div class="res-card"><div class="rc-label">Coverage / Roll</div><div class="rc-val"><?php echo $coveragePerRoll; ?></div><div class="rc-unit">sq ft</div></div>
                        <div class="res-card amber"><div class="rc-label">Rolls Needed</div><div class="rc-val" id="res-rolls">—</div><div class="rc-unit">rolls</div></div>
                        <div class="res-card forest"><div class="rc-label">Total Price</div><div class="rc-val" id="res-price">—</div><div class="rc-unit">PKR</div></div>
                    </div>
                    <div class="result-note" id="res-note"></div>
                </div>
            </div>
            <script>
            const COVERAGE   = <?php echo $coveragePerRoll; ?>;
            const PRICE_ROLL = <?php echo round($final, 2); ?>;
            function calculateRolls() {
                const hFt = parseFloat(document.getElementById('wall_h_ft').value) || 0;
                const hIn = parseFloat(document.getElementById('wall_h_in').value) || 0;
                const wFt = parseFloat(document.getElementById('wall_w_ft').value) || 0;
                const wIn = parseFloat(document.getElementById('wall_w_in').value) || 0;
                const errBox = document.getElementById('calc-error');
                const resultBox = document.getElementById('calc-result');
                if ((hFt + hIn) === 0 || (wFt + wIn) === 0) { errBox.classList.add('show'); resultBox.classList.remove('show'); return; }
                errBox.classList.remove('show');
                const heightDec = hFt + (hIn / 12);
                const widthDec  = wFt + (wIn / 12);
                const wallArea  = heightDec * widthDec;
                const wastePercent  = parseFloat(document.getElementById('pattern_waste').value);
                const areaWithWaste = wallArea * (1 + wastePercent / 100);
                const rollsNeeded   = Math.ceil(areaWithWaste / COVERAGE);
                const totalPrice    = rollsNeeded * PRICE_ROLL;
                document.getElementById('res-area').textContent  = wallArea.toFixed(1);
                document.getElementById('res-rolls').textContent = rollsNeeded;
                document.getElementById('res-price').textContent = 'Rs. ' + totalPrice.toLocaleString('en-PK');
                const hLabel = (hFt > 0 ? hFt+'ft ' : '') + (hIn > 0 ? hIn+'in' : '');
                const wLabel = (wFt > 0 ? wFt+'ft ' : '') + (wIn > 0 ? wIn+'in' : '');
                let note = `You need <strong>${rollsNeeded} roll${rollsNeeded>1?'s':''}</strong> for a ${hLabel.trim()} × ${wLabel.trim()} wall.`;
                if (wastePercent > 0) note += ` Includes <strong>${wastePercent}% extra</strong> for pattern matching.`;
                note += ` Total: <strong>Rs. ${totalPrice.toLocaleString('en-PK')}</strong> at Rs. ${PRICE_ROLL.toLocaleString()}/roll.`;
                document.getElementById('res-note').innerHTML = note;
                resultBox.classList.add('show');
            }
            </script>
            <?php endif; ?>
            <?php endif; ?>

            <!-- ══ TILES ══ -->
            <?php if($product['category'] == 'tiles' && $tileAreaSqft > 0): ?>
            <div class="tile-info-box">
                <div class="box-title"><i class="fa-solid fa-border-all"></i> Tile Specifications</div>
                <div class="tile-stats">
                    <div class="tile-stat"><div class="ts-label">Tile Length</div><div class="ts-value"><?php echo $tileLengthFt; ?> ft</div></div>
                    <div class="tile-stat"><div class="ts-label">Tile Width</div><div class="ts-value"><?php echo $tileWidthFt; ?> ft</div></div>
                    <div class="tile-stat"><div class="ts-label">1 Tile Area</div><div class="ts-value"><?php echo $tileAreaSqft; ?> sq ft</div></div>
                    <?php if($finishType): ?>
                    <div class="tile-stat"><div class="ts-label">Finish</div><div class="ts-value"><?php echo htmlspecialchars($finishType); ?></div></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="wall-calc">
                <div class="calc-header"><div class="calc-icon">🧮</div><h4>Floor Calculator</h4></div>
                <p class="calc-sub">Enter your room size — we'll calculate the tiles and total price.</p>
                <div class="input-row">
                    <span>Room Length</span>
                    <div class="ft-in-group">
                        <div class="input-unit"><input type="number" id="room_l_ft" placeholder="12" min="0" max="200"><span class="u-label">ft</span></div>
                        <div class="input-unit"><input type="number" id="room_l_in" placeholder="0" min="0" max="11"><span class="u-label">in</span></div>
                    </div>
                </div>
                <div class="input-row">
                    <span>Room Width</span>
                    <div class="ft-in-group">
                        <div class="input-unit"><input type="number" id="room_w_ft" placeholder="10" min="0" max="200"><span class="u-label">ft</span></div>
                        <div class="input-unit"><input type="number" id="room_w_in" placeholder="0" min="0" max="11"><span class="u-label">in</span></div>
                    </div>
                </div>
                <div class="calc-error" id="tile-calc-error">⚠️ Please enter room length and width first.</div>
                <button class="btn-calc" onclick="calculateTiles()">Calculate Tiles Needed &nbsp;→</button>
                <div class="calc-result" id="tile-calc-result">
                    <div class="result-cards">
                        <div class="res-card"><div class="rc-label">Room Area</div><div class="rc-val" id="tile-res-area">—</div><div class="rc-unit">sq ft</div></div>
                        <div class="res-card"><div class="rc-label">1 Tile Area</div><div class="rc-val"><?php echo $tileAreaSqft; ?></div><div class="rc-unit">sq ft</div></div>
                        <div class="res-card amber"><div class="rc-label">Tiles Needed</div><div class="rc-val" id="tile-res-count">—</div><div class="rc-unit">tiles</div></div>
                        <div class="res-card forest"><div class="rc-label">Total Price</div><div class="rc-val" id="tile-res-price">—</div><div class="rc-unit">PKR</div></div>
                    </div>
                    <div class="result-note" id="tile-res-note"></div>
                </div>
            </div>
            <script>
            const TILE_AREA       = <?php echo $tileAreaSqft; ?>;
            const TILE_PRICE_EACH = <?php echo round($final, 2); ?>;
            function calculateTiles() {
                const lFt = parseFloat(document.getElementById('room_l_ft').value) || 0;
                const lIn = parseFloat(document.getElementById('room_l_in').value) || 0;
                const wFt = parseFloat(document.getElementById('room_w_ft').value) || 0;
                const wIn = parseFloat(document.getElementById('room_w_in').value) || 0;
                const errBox = document.getElementById('tile-calc-error');
                const resultBox = document.getElementById('tile-calc-result');
                if ((lFt + lIn) === 0 || (wFt + wIn) === 0) { errBox.classList.add('show'); resultBox.classList.remove('show'); return; }
                errBox.classList.remove('show');
                const lengthDec   = lFt + (lIn / 12);
                const widthDec    = wFt + (wIn / 12);
                const roomArea    = lengthDec * widthDec;
                const tilesNeeded = Math.ceil(roomArea / TILE_AREA);
                const totalPrice  = tilesNeeded * TILE_PRICE_EACH;
                document.getElementById('tile-res-area').textContent  = roomArea.toFixed(1);
                document.getElementById('tile-res-count').textContent = tilesNeeded;
                document.getElementById('tile-res-price').textContent = 'Rs. ' + totalPrice.toLocaleString('en-PK');
                const lLabel = (lFt > 0 ? lFt+'ft ' : '') + (lIn > 0 ? lIn+'in' : '');
                const wLabel = (wFt > 0 ? wFt+'ft ' : '') + (wIn > 0 ? wIn+'in' : '');
                document.getElementById('tile-res-note').innerHTML =
                    `You need <strong>${tilesNeeded} tiles</strong> for a ${lLabel.trim()} × ${wLabel.trim()} room. Total: <strong>Rs. ${totalPrice.toLocaleString('en-PK')}</strong> at Rs. ${TILE_PRICE_EACH.toLocaleString()}/tile.`;
                resultBox.classList.add('show');
            }
            </script>
            <?php endif; ?>

            <!-- ══ WALL PANELS ══ -->
            <?php if($product['category'] == 'paneling' && $panelAreaSqft > 0): ?>
            <div class="panel-info-box">
                <div class="box-title"><i class="fa-solid fa-table-cells-large"></i> Panel Specifications</div>
                <div class="panel-stats">
                    <div class="panel-stat"><div class="ps-label">Panel Length</div><div class="ps-value"><?php echo $panelLengthFt; ?> ft</div></div>
                    <div class="panel-stat"><div class="ps-label">Panel Width</div><div class="ps-value"><?php echo $panelWidthFt; ?> ft</div></div>
                    <div class="panel-stat"><div class="ps-label">1 Panel Area</div><div class="ps-value"><?php echo $panelAreaSqft; ?> sq ft</div></div>
                    <div class="panel-stat"><div class="ps-label">Type</div><div class="ps-value"><?php echo htmlspecialchars($product['product_type']); ?></div></div>
                </div>
            </div>

            <!-- WALL PANELS CALCULATOR -->
            <div class="wall-calc">
                <div class="calc-header"><div class="calc-icon">🧮</div><h4>Wall Calculator</h4></div>
                <p class="calc-sub">Enter your wall size — we'll calculate the panels and total price.</p>
                <div class="input-row">
                    <span>Wall Height</span>
                    <div class="ft-in-group">
                        <div class="input-unit"><input type="number" id="pwall_h_ft" placeholder="9" min="0" max="50"><span class="u-label">ft</span></div>
                        <div class="input-unit"><input type="number" id="pwall_h_in" placeholder="0" min="0" max="11"><span class="u-label">in</span></div>
                    </div>
                </div>
                <div class="input-row">
                    <span>Wall Width</span>
                    <div class="ft-in-group">
                        <div class="input-unit"><input type="number" id="pwall_w_ft" placeholder="12" min="0" max="200"><span class="u-label">ft</span></div>
                        <div class="input-unit"><input type="number" id="pwall_w_in" placeholder="0" min="0" max="11"><span class="u-label">in</span></div>
                    </div>
                </div>
                <div class="calc-error" id="panel-calc-error">⚠️ Please enter wall height and width first.</div>
                <button class="btn-calc" onclick="calculatePanels()">Calculate Panels Needed &nbsp;→</button>
                <div class="calc-result" id="panel-calc-result">
                    <div class="result-cards">
                        <div class="res-card"><div class="rc-label">Wall Area</div><div class="rc-val" id="panel-res-area">—</div><div class="rc-unit">sq ft</div></div>
                        <div class="res-card"><div class="rc-label">1 Panel Area</div><div class="rc-val"><?php echo $panelAreaSqft; ?></div><div class="rc-unit">sq ft</div></div>
                        <div class="res-card amber"><div class="rc-label">Panels Needed</div><div class="rc-val" id="panel-res-count">—</div><div class="rc-unit">panels</div></div>
                        <div class="res-card forest"><div class="rc-label">Total Price</div><div class="rc-val" id="panel-res-price">—</div><div class="rc-unit">PKR</div></div>
                    </div>
                    <div class="result-note" id="panel-res-note"></div>
                </div>
            </div>
            <script>
            const PANEL_AREA       = <?php echo $panelAreaSqft; ?>;
            const PANEL_PRICE_EACH = <?php echo round($final, 2); ?>;
            function calculatePanels() {
                const hFt = parseFloat(document.getElementById('pwall_h_ft').value) || 0;
                const hIn = parseFloat(document.getElementById('pwall_h_in').value) || 0;
                const wFt = parseFloat(document.getElementById('pwall_w_ft').value) || 0;
                const wIn = parseFloat(document.getElementById('pwall_w_in').value) || 0;
                const errBox    = document.getElementById('panel-calc-error');
                const resultBox = document.getElementById('panel-calc-result');
                if ((hFt + hIn) === 0 || (wFt + wIn) === 0) { errBox.classList.add('show'); resultBox.classList.remove('show'); return; }
                errBox.classList.remove('show');
                const heightDec    = hFt + (hIn / 12);
                const widthDec     = wFt + (wIn / 12);
                const wallArea     = heightDec * widthDec;
                const panelsNeeded = Math.ceil(wallArea / PANEL_AREA);
                const totalPrice   = panelsNeeded * PANEL_PRICE_EACH;
                document.getElementById('panel-res-area').textContent  = wallArea.toFixed(1);
                document.getElementById('panel-res-count').textContent = panelsNeeded;
                document.getElementById('panel-res-price').textContent = 'Rs. ' + totalPrice.toLocaleString('en-PK');
                const hLabel = (hFt > 0 ? hFt+'ft ' : '') + (hIn > 0 ? hIn+'in' : '');
                const wLabel = (wFt > 0 ? wFt+'ft ' : '') + (wIn > 0 ? wIn+'in' : '');
                document.getElementById('panel-res-note').innerHTML =
                    `You need <strong>${panelsNeeded} panels</strong> for a ${hLabel.trim()} × ${wLabel.trim()} wall. Total: <strong>Rs. ${totalPrice.toLocaleString('en-PK')}</strong> at Rs. ${PANEL_PRICE_EACH.toLocaleString()}/panel.`;
                resultBox.classList.add('show');
            }
            </script>
            <?php endif; ?>
            <!-- ══ END PANELS ══ -->

            <!-- ══ PAINT ══ -->
            <?php if($product['category'] == 'paint'): ?>
            <div class="tile-info-box">
                <div class="box-title"><i class="fa-solid fa-paint-roller"></i> Paint Specifications</div>
                <div class="tile-stats">
                    <div class="tile-stat"><div class="ts-label">Color</div><div class="ts-value"><?php echo htmlspecialchars($product['product_type']); ?></div></div>
                    <?php if(!empty($product['finish_type'])): ?>
                    <div class="tile-stat"><div class="ts-label">Shade</div><div class="ts-value"><?php echo htmlspecialchars($product['finish_type']); ?></div></div>
                    <?php endif; ?>
                    <?php if(!empty($product['material'])): ?>
                    <div class="tile-stat"><div class="ts-label">Finish</div><div class="ts-value"><?php echo htmlspecialchars($product['material']); ?></div></div>
                    <?php endif; ?>
                    <div class="tile-stat"><div class="ts-label">Coverage</div><div class="ts-value">~120 sq ft / L</div></div>
                    <div class="tile-stat"><div class="ts-label">Sold As</div><div class="ts-value">Per Litre</div></div>
                </div>
            </div>
            <div class="wall-calc">
                <div class="calc-header"><div class="calc-icon">🧮</div><h4>Paint Calculator</h4></div>
                <p class="calc-sub">Enter your room size — we'll calculate the paint (litres) and total price.</p>
                <div class="input-row">
                    <span>Room Length</span>
                    <div class="ft-in-group">
                        <div class="input-unit"><input type="number" id="paint_l_ft" placeholder="12" min="0" max="200"><span class="u-label">ft</span></div>
                        <div class="input-unit"><input type="number" id="paint_l_in" placeholder="0" min="0" max="11"><span class="u-label">in</span></div>
                    </div>
                </div>
                <div class="input-row">
                    <span>Room Width</span>
                    <div class="ft-in-group">
                        <div class="input-unit"><input type="number" id="paint_w_ft" placeholder="10" min="0" max="200"><span class="u-label">ft</span></div>
                        <div class="input-unit"><input type="number" id="paint_w_in" placeholder="0" min="0" max="11"><span class="u-label">in</span></div>
                    </div>
                </div>
                <div class="input-row">
                    <span>Wall Height</span>
                    <div class="ft-in-group">
                        <div class="input-unit"><input type="number" id="paint_h_ft" placeholder="9" min="0" max="30"><span class="u-label">ft</span></div>
                        <div class="input-unit"><input type="number" id="paint_h_in" placeholder="0" min="0" max="11"><span class="u-label">in</span></div>
                    </div>
                </div>
                <div class="input-row">
                    <span>Coats</span>
                    <select id="paint_coats" style="padding:10px 14px; border-radius:10px; border:1.5px solid #e8e0d8; font-family:'DM Sans',sans-serif; font-size:14px;">
                        <option value="1">1 Coat</option>
                        <option value="2" selected>2 Coats (Recommended)</option>
                    </select>
                </div>
                <div class="calc-error" id="paint-calc-error">⚠️ Please enter room length, width and height first.</div>
                <button class="btn-calc" onclick="calculatePaint()">Calculate Paint Needed &nbsp;→</button>
                <div class="calc-result" id="paint-calc-result">
                    <div class="result-cards">
                        <div class="res-card"><div class="rc-label">Wall Area</div><div class="rc-val" id="paint-res-area">—</div><div class="rc-unit">sq ft</div></div>
                        <div class="res-card"><div class="rc-label">Coverage</div><div class="rc-val">120</div><div class="rc-unit">sq ft/L</div></div>
                        <div class="res-card amber"><div class="rc-label">Paint Needed</div><div class="rc-val" id="paint-res-count">—</div><div class="rc-unit">litres</div></div>
                        <div class="res-card forest"><div class="rc-label">Total Price</div><div class="rc-val" id="paint-res-price">—</div><div class="rc-unit">PKR</div></div>
                    </div>
                    <div class="result-note" id="paint-res-note"></div>
                </div>
            </div>
            <script>
            const PAINT_COVERAGE_PER_L = 120; // sq ft per litre per coat (standard estimate)
            const PAINT_PRICE_PER_L    = <?php echo round($final, 2); ?>;
            function calculatePaint() {
                const lFt = parseFloat(document.getElementById('paint_l_ft').value) || 0;
                const lIn = parseFloat(document.getElementById('paint_l_in').value) || 0;
                const wFt = parseFloat(document.getElementById('paint_w_ft').value) || 0;
                const wIn = parseFloat(document.getElementById('paint_w_in').value) || 0;
                const hFt = parseFloat(document.getElementById('paint_h_ft').value) || 0;
                const hIn = parseFloat(document.getElementById('paint_h_in').value) || 0;
                const coats = parseInt(document.getElementById('paint_coats').value) || 1;
                const errBox = document.getElementById('paint-calc-error');
                const resultBox = document.getElementById('paint-calc-result');
                if ((lFt + lIn) === 0 || (wFt + wIn) === 0 || (hFt + hIn) === 0) { errBox.classList.add('show'); resultBox.classList.remove('show'); return; }
                errBox.classList.remove('show');
                const lengthDec = lFt + (lIn / 12);
                const widthDec  = wFt + (wIn / 12);
                const heightDec = hFt + (hIn / 12);
                const wallArea  = 2 * (lengthDec + widthDec) * heightDec;
                const litresNeeded = Math.ceil((wallArea * coats) / PAINT_COVERAGE_PER_L);
                const totalPrice   = litresNeeded * PAINT_PRICE_PER_L;
                document.getElementById('paint-res-area').textContent  = wallArea.toFixed(1);
                document.getElementById('paint-res-count').textContent = litresNeeded;
                document.getElementById('paint-res-price').textContent = 'Rs. ' + totalPrice.toLocaleString('en-PK');
                document.getElementById('paint-res-note').innerHTML =
                    `You need <strong>${litresNeeded} litres</strong> of paint (${coats} coat${coats>1?'s':''}) for a ${lengthDec}ft × ${widthDec}ft room with ${heightDec}ft walls. Total: <strong>Rs. ${totalPrice.toLocaleString('en-PK')}</strong> at Rs. ${PAINT_PRICE_PER_L.toLocaleString()}/litre.`;
                resultBox.classList.add('show');
            }
            </script>
            <?php endif; ?>
            <!-- ══ END PAINT ══ -->

            <!-- CTA BUTTONS -->
            <div class="btn-row">
                <button class="btn-cart" onclick="addToCart(<?php echo $product['id']; ?>)">
                    <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                </button>
                <a href="add_favorite.php?item_id=<?php echo $product['id']; ?>&type=product" class="btn-fav">
                    <i class="fa-solid fa-heart"></i> Wishlist
                </a>
            </div>

        </div>
    </div>

    <!-- CUSTOMER REVIEWS -->
    <div class="reviews-section" style="margin-top: 40px; background: white; padding: 35px; border-radius: 24px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
        <h3 style="font-family: 'Playfair Display', serif; font-size: 1.6rem; color: #4b2c2c; margin-bottom: 25px; border-bottom: 2px solid #f5ede0; padding-bottom: 15px;">
            <i class="fa-solid fa-comments" style="margin-right: 8px; color: #ffa502;"></i> Customer Reviews
        </h3>
        
        <div class="reviews-summary-layout" style="display: flex; gap: 40px; margin-bottom: 40px; flex-wrap: wrap; background: #faf8f5; padding: 25px; border-radius: 16px; align-items: center;">
            <div class="rating-huge" style="text-align: center; min-width: 150px;">
                <div style="font-size: 3.5rem; font-weight: 800; color: #4b2c2c; line-height: 1;"><?php echo $avg_rating; ?></div>
                <div style="color: #ffa502; font-size: 18px; margin: 8px 0 5px; display: flex; justify-content: center; gap: 3px;">
                    <?php 
                    $full_stars = floor($avg_rating);
                    $half_star = ($avg_rating - $full_stars) >= 0.5 ? 1 : 0;
                    $empty_stars = 5 - $full_stars - $half_star;
                    echo str_repeat('<i class="fa-solid fa-star"></i>', $full_stars);
                    if ($half_star) echo '<i class="fa-solid fa-star-half-stroke"></i>';
                    echo str_repeat('<i class="fa-regular fa-star"></i>', $empty_stars);
                    ?>
                </div>
                <div style="font-size: 12px; color: #777;">Based on <?php echo $review_count; ?> <?php echo $review_count == 1 ? 'review' : 'reviews'; ?></div>
            </div>
            
            <div class="rating-bars" style="flex: 1; min-width: 250px;">
                <?php
                $star_counts = [5=>0, 4=>0, 3=>0, 2=>0, 1=>0];
                $counts_q = mysqli_query($conn, "SELECT rating, COUNT(*) as cnt FROM product_reviews WHERE product_id='$id' GROUP BY rating");
                while ($c_row = mysqli_fetch_assoc($counts_q)) {
                    $star_counts[intval($c_row['rating'])] = intval($c_row['cnt']);
                }
                for ($star = 5; $star >= 1; $star--):
                    $count = $star_counts[$star];
                    $percentage = $review_count > 0 ? ($count / $review_count) * 100 : 0;
                ?>
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px; font-size: 13px;">
                    <span style="min-width: 60px; text-align: right; color:#555;"><?php echo $star; ?> Star</span>
                    <div style="flex: 1; background: #eee; height: 8px; border-radius: 4px; overflow: hidden;">
                        <div style="background: #ffa502; width: <?php echo $percentage; ?>%; height: 100%;"></div>
                    </div>
                    <span style="min-width: 30px; color: #777;"><?php echo $count; ?></span>
                </div>
                <?php endfor; ?>
            </div>
        </div>

        <!-- REVIEWS LIST -->
        <div class="reviews-list" style="display: flex; flex-direction: column; gap: 20px;">
            <?php
            $reviews_q = mysqli_query($conn, "SELECT r.*, u.name as user_name FROM product_reviews r JOIN users u ON r.user_id = u.id WHERE r.product_id = '$id' ORDER BY r.created_at DESC");
            if (mysqli_num_rows($reviews_q) > 0):
                while ($rev = mysqli_fetch_assoc($reviews_q)):
                    $rev_rating = intval($rev['rating']);
            ?>
            <div class="review-item" style="border: 1px solid #f0ece6; padding: 20px; border-radius: 16px; transition: 0.2s;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px; flex-wrap: wrap; gap: 10px;">
                    <div>
                        <strong style="color: #4b2c2c; font-size: 14.5px;"><?php echo htmlspecialchars($rev['user_name']); ?></strong>
                        <span style="font-size: 12px; color: #999; margin-left: 10px;"><i class="fa-regular fa-calendar" style="margin-right: 4px;"></i><?php echo date('d M Y', strtotime($rev['created_at'])); ?></span>
                    </div>
                    <div style="color: #ffa502; font-size: 13px; display: inline-flex; gap: 2px;">
                        <?php 
                        echo str_repeat('<i class="fa-solid fa-star"></i>', $rev_rating);
                        echo str_repeat('<i class="fa-regular fa-star"></i>', 5 - $rev_rating);
                        ?>
                    </div>
                </div>
                <p style="color: #5a4a3a; font-size: 14px; line-height: 1.6; margin: 0;"><?php echo nl2br(htmlspecialchars($rev['feedback'])); ?></p>
            </div>
            <?php 
                endwhile;
            else:
            ?>
            <div style="text-align: center; padding: 40px; background: #faf8f5; border-radius: 16px; color: #888;">
                <i class="fa-regular fa-comment-dots" style="font-size: 2.5rem; color: #ccc; margin-bottom: 12px; display: block;"></i>
                <p style="font-size: 14px; margin: 0;">Be the first to review this product!</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- FOOTER -->
<?php include 'Footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function switchColor(thumb, src) {
    document.getElementById('main-product-img').src = src;
    document.querySelectorAll('.color-thumbs img').forEach(img => img.classList.remove('active'));
    thumb.classList.add('active');
}
function addToCart(productId) {
    $.ajax({
        url: 'add_to_cart.php', method: 'POST',
        data: { product_id: productId, quantity: 1 },
        success: function(response) {
            if(response.trim() === 'login'){
                alert('Please login first!');
                window.location.href = 'login.php';
                return;
            }
            try {
                const data = JSON.parse(response);
                if(data.status === 'success'){
                    let badge = $('#cart-badge');
                    if(badge.length === 0){
                        $('.cart-box a').append('<span id="cart-badge" style="position:absolute;top:-8px;right:-10px;background:#c0392b;color:white;font-size:11px;font-weight:bold;width:18px;height:18px;border-radius:50%;display:flex;align-items:center;justify-content:center;">' + data.cart_count + '</span>');
                    } else { badge.text(data.cart_count); }
                    alert('Product added to cart successfully!');
                } else if(data.message){
                    alert(data.message);
                } else {
                    alert('Something went wrong, please try again.');
                }
            } catch(e) { alert('Something went wrong, please try again.'); }
        },
        error: function(){ alert('Connection error!'); }
    });
}
document.querySelector('.hamburger').addEventListener('click', () => {
    document.querySelector('.bottomheader').classList.toggle('active');
});
</script>
</body>
</html>