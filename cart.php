<?php
error_reporting(0);
ini_set('display_errors', 0);
session_start();
include "db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT cart.*, productadd.name, productadd.price, 
          productadd.discount, productadd.product_image,
          productadd.category, productadd.product_type
          FROM cart 
          JOIN productadd ON cart.product_id = productadd.id
          WHERE cart.user_id = '$user_id'";

$result = mysqli_query($conn, $query);

$grand_total = 0;
$items = [];

if($result){
    while($row = mysqli_fetch_assoc($result)){
        $price    = $row['price'];
        $discount = $row['discount'];
        $final    = $price - ($price * $discount / 100);
        $subtotal = $final * $row['quantity'];
        $grand_total += $subtotal;
        $row['final_price'] = $final;
        $row['subtotal']    = $subtotal;
        $items[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/Footer.css">
    <style>
        body { background: #f5f0f0; }
        .cart-wrapper {
            max-width: 950px;
            margin: 30px auto;
            padding: 0 20px;
        }
        .cart-wrapper h2 {
            color: #4b2c2c;
            margin-bottom: 20px;
            font-size: 1.5rem;
        }
        .cart-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .cart-table th {
            background: #4b2c2c;
            color: white;
            padding: 14px;
            text-align: left;
            font-size: 14px;
        }
        .cart-table td {
            padding: 14px;
            border-bottom: 1px solid #eee;
            color: #333;
            vertical-align: middle;
            font-size: 14px;
        }
        .cart-table img {
            width: 65px;
            height: 65px;
            object-fit: cover;
            border-radius: 8px;
        }
        .product-name { font-weight: bold; margin-bottom: 4px; }
        .product-sub  { font-size: 12px; color: #888; }
        .qty-box {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .qty-btn {
            width: 30px;
            height: 30px;
            border: 1px solid #ddd;
            background: #f9f9f9;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1rem;
            transition: 0.2s;
        }
        .qty-btn:hover {
            background: #4b2c2c;
            color: white;
            border-color: #4b2c2c;
        }
        .qty-num {
            min-width: 25px;
            text-align: center;
            font-weight: bold;
        }
        .remove-btn {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 7px 14px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            transition: 0.2s;
        }
        .remove-btn:hover { background: #c0392b; }
        .total-box {
            background: white;
            border-radius: 12px;
            padding: 20px 25px;
            margin-top: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            text-align: right;
        }
        .total-box h3 {
            color: #4b2c2c;
            font-size: 1.4rem;
            margin-bottom: 15px;
        }
        .checkout-btn {
            background: #4b2c2c;
            color: white;
            padding: 12px 35px;
            border: none;
            border-radius: 25px;
            font-size: 1rem;
            cursor: pointer;
            transition: 0.3s;
        }
        .checkout-btn:hover { background: #6b3d3d; }
        .empty-cart {
            text-align: center;
            padding: 60px 20px;
            color: #888;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .empty-cart i {
            font-size: 3rem;
            color: #ddd;
            margin-bottom: 15px;
            display: block;
        }
        .empty-cart a { color: #4b2c2c; }
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
                <a class="login" href="login.php">Login/Signup</a>
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

<!-- CART -->
<div class="cart-wrapper">
    <h2><i class="fa-solid fa-cart-shopping"></i> My Cart</h2>

    <?php if(count($items) > 0){ ?>

    <table class="cart-table">
        <tr>
            <th>Image</th>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Subtotal</th>
            <th>Action</th>
        </tr>

        <?php foreach($items as $item){ ?>
        <tr id="row-<?php echo $item['cart_id']; ?>">
            <td>
                <img src="uploads/<?php echo htmlspecialchars($item['product_image']); ?>">
            </td>
            <td>
                <div class="product-name"><?php echo htmlspecialchars($item['name']); ?></div>
                <div class="product-sub">
                    <?php echo htmlspecialchars($item['category']); ?> → 
                    <?php echo htmlspecialchars($item['product_type']); ?>
                </div>
            </td>
            <td>Rs. <?php echo number_format($item['final_price'], 0); ?></td>
            <td>
                <div class="qty-box">
                    <button class="qty-btn" onclick="updateQty(<?php echo $item['cart_id']; ?>, 'minus')">-</button>
                    <span class="qty-num" id="qty-<?php echo $item['cart_id']; ?>">
                        <?php echo $item['quantity']; ?>
                    </span>
                    <button class="qty-btn" onclick="updateQty(<?php echo $item['cart_id']; ?>, 'plus')">+</button>
                </div>
            </td>
            <td id="sub-<?php echo $item['cart_id']; ?>">
                Rs. <?php echo number_format($item['subtotal'], 0); ?>
            </td>
            <td>
                <button class="remove-btn" onclick="removeItem(<?php echo $item['cart_id']; ?>)">
                    <i class="fa fa-trash"></i> Remove
                </button>
            </td>
        </tr>
        <?php } ?>
    </table>

    <div class="total-box">
        <h3>Total: Rs. <span id="grand-total"><?php echo number_format($grand_total, 0, '.', ''); ?></span></h3>
        <button class="checkout-btn" onclick="window.location.href='checkout.php'">
            Proceed to Checkout
        </button>
    </div>

    <?php } else { ?>
        <div class="empty-cart">
            <i class="fa-solid fa-cart-shopping"></i>
            <h3>Your cart is empty!</h3>
            <p style="margin:10px 0">Add some products first.</p>
            <a href="index.php">Continue Shopping →</a>
        </div>
    <?php } ?>
</div>

<!-- FOOTER -->
<?php include 'Footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function updateQty(cartId, action) {
    $.ajax({
        url: 'update_cart.php',
        method: 'POST',
        data: { cart_id: cartId, action: action },
        success: function(response) {
            try {
                const data = JSON.parse(response);
                if(data.status === 'removed'){
                    $('#row-' + cartId).remove();
                } else {
                    $('#qty-' + cartId).text(data.quantity);
                    $('#sub-' + cartId).text('Rs. ' + parseInt(data.subtotal));
                }
                $('#grand-total').text(parseInt(data.grand_total));
            } catch(e) {
                console.log('Parse error:', e, response);
                location.reload();
            }
        },
        error: function(xhr, status, error){
            console.log('AJAX Error:', error);
            alert('Connection error!');
        }
    });
}

function removeItem(cartId) {
    if(!confirm('Remove this item?')) return;
    $.ajax({
        url: 'remove_from_cart.php',
        method: 'POST',
        data: { cart_id: cartId },
        success: function(response) {
            try {
                const data = JSON.parse(response);
                $('#row-' + cartId).remove();
                $('#grand-total').text(parseInt(data.grand_total));
            } catch(e) {
                location.reload();
            }
        }
    });
}
</script>

<script>
const hamburger = document.querySelector('.hamburger');
const nav = document.querySelector('.bottomheader');
hamburger.addEventListener('click', () => {
    nav.classList.toggle('active');
});
</script>

</body>
</html>