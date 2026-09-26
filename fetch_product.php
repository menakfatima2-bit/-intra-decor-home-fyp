<?php
error_reporting(0);
ini_set('display_errors', 0);
include "db.php";

function getProducts($conn, $category, $limit = 8) {
    $category = mysqli_real_escape_string($conn, $category);
    $query = "SELECT * FROM productadd 
              WHERE status='approved' 
              AND category='$category'
              ORDER BY id DESC 
              LIMIT $limit";
    return mysqli_query($conn, $query);
}

function renderCards($result, $category) {
    if(mysqli_num_rows($result) == 0){
        echo '<p style="color:#999; padding:20px; font-size:14px;">
                No products yet in this category.
              </p>';
        return;
    }
    while($row = mysqli_fetch_assoc($result)){
        $price    = $row['price'];
        $discount = $row['discount'];
        $final    = $price - ($price * $discount / 100);
        $id       = $row['id'];
        $img      = "uploads/" . htmlspecialchars($row['product_image']);
        $name     = htmlspecialchars($row['name']);
        $type     = htmlspecialchars($row['product_type']);

        echo "
        <div class='slider-card' 
             onclick=\"window.location.href='product_detail.php?id=$id'\">
            <div class='sc-image'>
                <img src='$img' alt='$name'>
                " . ($discount > 0 ? "<span class='sc-badge'>{$discount}% OFF</span>" : "") . "
            </div>
            <div class='sc-body'>
                <p class='sc-cat'>$type</p>
                <h3 class='sc-name'>$name</h3>
                <div class='sc-price'>
                    " . ($discount > 0 ? "<span class='sc-old'>Rs. $price</span>" : "") . "
                    <span class='sc-final'>Rs. " . number_format($final, 0) . "</span>
                </div>
                <button class='sc-btn' 
                    onclick=\"event.stopPropagation(); 
                    window.location.href='product_detail.php?id=$id'\">
                    View Details
                </button>
            </div>
        </div>";
    }
}

// Har category ke products
$newArrivals = mysqli_query($conn, 
    "SELECT * FROM productadd 
     WHERE status='approved' 
     ORDER BY id DESC LIMIT 8"
);
$wallpapers  = getProducts($conn, 'wallpaper');
$tiles       = getProducts($conn, 'tiles');
$panels      = getProducts($conn, 'paneling');

?>

<style>
.sections-wrapper { padding: 0 20px; }

.product-section { margin-bottom: 40px; }

.ps-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.ps-title {
    font-size: 1.3rem;
    font-weight: bold;
    color: #4b2c2c;
    margin: 0;
}

.ps-see-all {
    font-size: 13px;
    color: #4b2c2c;
    text-decoration: none;
    border: 1.5px solid #4b2c2c;
    padding: 5px 15px;
    border-radius: 20px;
    transition: 0.3s;
}

.ps-see-all:hover {
    background: #4b2c2c;
    color: white;
}

.slider-container {
    position: relative;
}

.slider-track {
    display: flex;
    gap: 20px;
    overflow-x: scroll;
    scroll-behavior: smooth;
    padding: 5px 5px 15px;
    scrollbar-width: none;
}

.slider-track::-webkit-scrollbar {
    display: none;
}

.slider-card {
    min-width: 230px;
    max-width: 230px;
}
.slider-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

.sc-image {
    position: relative;
    height: 160px;
    overflow: hidden;
}

.sc-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
}

.slider-card:hover .sc-image img {
    transform: scale(1.05);
}

.sc-badge {
    position: absolute;
    top: 8px;
    left: 8px;
    background: #e74c3c;
    color: white;
    font-size: 11px;
    font-weight: bold;
    padding: 3px 8px;
    border-radius: 20px;
}

.sc-body { padding: 12px; }

.sc-cat {
    font-size: 11px;
    color: #999;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    margin-bottom: 4px;
}

.sc-name {
    font-size: 14px;
    font-weight: bold;
    color: #333;
    margin-bottom: 8px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.sc-price {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 10px;
}

.sc-old {
    text-decoration: line-through;
    color: #bbb;
    font-size: 12px;
}

.sc-final {
    color: #4b2c2c;
    font-size: 16px;
    font-weight: bold;
}

.sc-btn {
    width: 100%;
    background: #4b2c2c;
    color: white;
    border: none;
    padding: 8px;
    border-radius: 20px;
    font-size: 13px;
    cursor: pointer;
    transition: 0.3s;
}

.sc-btn:hover { background: #6b3d3d; }

.arrow-btn {
    position: absolute;
    top: 40%;
    transform: translateY(-50%);
    background: #4b2c2c;
    color: white;
    border: none;
    width: 35px;
    height: 35px;
    border-radius: 50%;
    font-size: 18px;
    cursor: pointer;
    z-index: 10;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    transition: 0.3s;
}

.arrow-btn:hover { background: #6b3d3d; }
.arrow-left { left: -15px; }
.arrow-right { right: -15px; }

.section-divider {
    height: 1px;
    background: #f0e8e8;
    margin: 0 0 35px;
}
</style>

<div class="sections-wrapper">

<!-- NEW ARRIVALS -->
<div class="product-section">
    <div class="ps-header">
        <h2 class="ps-title">🔥 New Arrivals</h2>
        <a href="index.php" class="ps-see-all">See All</a>
    </div>
    <div class="slider-container">
        <button class="arrow-btn arrow-left" 
                onclick="slideLeft('new-arrivals')">&#8249;</button>
        <div class="slider-track" id="new-arrivals">
            <?php renderCards($newArrivals, 'all'); ?>
        </div>
        <button class="arrow-btn arrow-right" 
                onclick="slideRight('new-arrivals')">&#8250;</button>
    </div>
</div>

<div class="section-divider"></div>

<!-- WALLPAPERS -->
<div class="product-section">
    <div class="ps-header">
        <h2 class="ps-title">🎨 Wallpapers</h2>
        <a href="wallpaper.php" class="ps-see-all">See All</a>
    </div>
    <div class="slider-container">
        <button class="arrow-btn arrow-left" 
                onclick="slideLeft('wallpapers')">&#8249;</button>
        <div class="slider-track" id="wallpapers">
            <?php renderCards($wallpapers, 'wallpaper'); ?>
        </div>
        <button class="arrow-btn arrow-right" 
                onclick="slideRight('wallpapers')">&#8250;</button>
    </div>
</div>

<div class="section-divider"></div>

<!-- TILES -->
<div class="product-section">
    <div class="ps-header">
        <h2 class="ps-title">🏔️ Tiles</h2>
        <a href="Tiles.php" class="ps-see-all">See All</a>
    </div>
    <div class="slider-container">
        <button class="arrow-btn arrow-left" 
                onclick="slideLeft('tiles')">&#8249;</button>
        <div class="slider-track" id="tiles">
            <?php renderCards($tiles, 'tiles'); ?>
        </div>
        <button class="arrow-btn arrow-right" 
                onclick="slideRight('tiles')">&#8250;</button>
    </div>
</div>

<div class="section-divider"></div>

<!-- WALL PANELS -->
<div class="product-section">
    <div class="ps-header">
        <h2 class="ps-title">🪵 Wall Panels</h2>
        <a href="wallpenals.php" class="ps-see-all">See All</a>
    </div>
    <div class="slider-container">
        <button class="arrow-btn arrow-left" 
                onclick="slideLeft('panels')">&#8249;</button>
        <div class="slider-track" id="panels">
            <?php renderCards($panels, 'paneling'); ?>
        </div>
        <button class="arrow-btn arrow-right" 
                onclick="slideRight('panels')">&#8250;</button>
    </div>
</div>

</div>

<script>
function slideLeft(id){
    document.getElementById(id).scrollLeft -= 230;
}
function slideRight(id){
    document.getElementById(id).scrollLeft += 230;
}
</script>