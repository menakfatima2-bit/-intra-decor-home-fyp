<?php session_start(); include "db.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wallpaper</title>

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/wallpaper.css?v=2">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/Footer.css">
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

<h1>Wallpaper Categories</h1>

<!-- SUBCATEGORY CARDS -->
<div class="wallpaper-category">

    <div class="wallpaper-card">
        <img src="assets/images/floral.jpeg" alt="floral">
        <h3>Floral Wallpaper</h3>
       <button onclick="window.location.href=
      'category_products.php?category=wallpaper&type=Floral Wallpaper'">
           View Products
        </button>
    </div>

    <div class="wallpaper-card">
        <img src="assets/images/Abstract wallpaper.jpeg" alt="Abstract">
        <h3>Abstract Wallpaper</h3>
        <button onclick="window.location.href=
        'category_products.php?category=wallpaper&type=Abstract Wallpaper'">
          View Products
        </button>
    </div>

    <div class="wallpaper-card">
        <img src="assets/images/kids wallpaper.jpeg" alt="kids">
        <h3>Kids Wallpaper</h3>
       <button onclick="window.location.href=
        'category_products.php?category=wallpaper&type=Kids Wallpaper'">
          View Products
        </button>
    </div>

    <div class="wallpaper-card">
        <img src="assets/images/Geomeric wallpaper.jpeg" alt="Geometric">
        <h3>Geometric Wallpaper</h3>
        <button onclick="window.location.href=
        'category_products.php?category=wallpaper&type=Geometric Wallpaper'">
          View Products
        </button>
    </div>

    <div class="wallpaper-card">
        <img src="assets/images/wood wallpaper.jpeg" alt="wood">
        <h3>Wood Wallpaper</h3>
        <button onclick="window.location.href=
        'category_products.php?category=wallpaper&type=wood Wallpaper'">
          View Products
        </button>
    </div>

</div>
<!-- SUBCATEGORY CARDS END -->

<!-- PRODUCTS YAHAN SHOW HONGE — cards div ke BAHAR -->
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
            category: 'wallpaper',
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