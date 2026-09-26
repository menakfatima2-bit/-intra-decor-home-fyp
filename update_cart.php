<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id'])) exit();

$user_id = $_SESSION['user_id'];
$cart_id = intval($_POST['cart_id']);
$action  = $_POST['action'];

// Pehle current quantity lo
$res = mysqli_query($conn, 
    "SELECT cart.*, productadd.price, productadd.discount 
     FROM cart 
     JOIN productadd ON cart.product_id = productadd.id
     WHERE cart.cart_id='$cart_id' AND cart.user_id='$user_id'"
);
$item = mysqli_fetch_assoc($res);

if(!$item){ exit(); }

$qty      = $item['quantity'];
$price    = $item['price'];
$discount = $item['discount'];
$final    = $price - ($price * $discount / 100);

if($action === 'plus'){
    $qty++;
    mysqli_query($conn, 
        "UPDATE cart SET quantity='$qty' 
         WHERE cart_id='$cart_id' AND user_id='$user_id'"
    );
} else if($action === 'minus'){
    $qty--;
    if($qty <= 0){
        mysqli_query($conn, 
            "DELETE FROM cart 
             WHERE cart_id='$cart_id' AND user_id='$user_id'"
        );
        $grand = getGrandTotal($conn, $user_id);
        echo json_encode([
            'status'      => 'removed',
            'grand_total' => $grand
        ]);
        exit();
    }
    mysqli_query($conn, 
        "UPDATE cart SET quantity='$qty' 
         WHERE cart_id='$cart_id' AND user_id='$user_id'"
    );
}

$grand = getGrandTotal($conn, $user_id);

echo json_encode([
    'status'      => 'updated',
    'quantity'    => $qty,
    'subtotal'    => $final * $qty,
    'grand_total' => $grand
]);

function getGrandTotal($conn, $user_id){
    $res = mysqli_query($conn,
        "SELECT cart.quantity, productadd.price, productadd.discount
         FROM cart 
         JOIN productadd ON cart.product_id = productadd.id
         WHERE cart.user_id='$user_id'"
    );
    $total = 0;
    while($r = mysqli_fetch_assoc($res)){
        $f = $r['price'] - ($r['price'] * $r['discount'] / 100);
        $total += $f * $r['quantity'];
    }
    return $total;
}
?>