<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id'])) exit();

$user_id = $_SESSION['user_id'];
$cart_id = intval($_POST['cart_id']);

mysqli_query($conn, 
   "DELETE FROM cart WHERE cart_id='$cart_id' AND user_id='$user_id'"
    
);

// Grand total recalculate
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

echo json_encode(['grand_total' => $total]);
?>