<?php
session_start();
include "db.php";

// Login check
if(!isset($_SESSION['user_id'])){
    echo "login";
    exit();
}

$user_id    = $_SESSION['user_id'];
$product_id = intval($_POST['product_id']);
$quantity   = intval($_POST['quantity']);

if($quantity < 1) $quantity = 1;

// Stock check: product must be approved and have enough quantity left
$p_res = mysqli_query($conn, "SELECT quantity FROM productadd WHERE id='$product_id' AND status='approved'");
$p_row = $p_res ? mysqli_fetch_assoc($p_res) : null;
if(!$p_row){
    echo json_encode(['status' => 'error', 'message' => 'This product is not available.']);
    exit();
}
$stock = intval($p_row['quantity']);

$in_cart_res = mysqli_query($conn, "SELECT quantity FROM cart WHERE user_id='$user_id' AND product_id='$product_id'");
$in_cart_row = $in_cart_res ? mysqli_fetch_assoc($in_cart_res) : null;
$in_cart     = $in_cart_row ? intval($in_cart_row['quantity']) : 0;

if($stock <= 0){
    echo json_encode(['status' => 'out_of_stock', 'message' => 'Sorry, this product is out of stock.']);
    exit();
}
if($in_cart + $quantity > $stock){
    echo json_encode(['status' => 'out_of_stock', 'message' => "Only $stock item(s) are available in stock, and you already have $in_cart in your cart."]);
    exit();
}

// Check karo — product pehle se cart mein hai?
$check = mysqli_query($conn, 
    "SELECT * FROM cart 
     WHERE user_id='$user_id' AND product_id='$product_id'"
);

if(mysqli_num_rows($check) > 0){
    // Pehle se hai — quantity update karo
    mysqli_query($conn,
        "UPDATE cart SET quantity = quantity + $quantity 
         WHERE user_id='$user_id' AND product_id='$product_id'"
    );
} else {
    // Naya add karo
    mysqli_query($conn,
        "INSERT INTO cart (user_id, product_id, quantity) 
         VALUES ('$user_id', '$product_id', '$quantity')"
    );
}

// Cart count nikalo
$count_res = mysqli_query($conn,
    "SELECT SUM(quantity) as total 
     FROM cart WHERE user_id='$user_id'"
);
$count_row = mysqli_fetch_assoc($count_res);
$cart_count = $count_row['total'] ?? 0;

echo json_encode([
    'status' => 'success',
    'cart_count' => $cart_count
]);
?>