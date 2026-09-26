<?php
session_start();

$reason = $_GET['reason'] ?? 'cancelled';

$messages = [
    'cancelled'       => ['title' => 'Payment Cancelled', 'text' => "You cancelled the payment before it completed. Your cart is untouched — you can try again anytime."],
    'payment_failed'  => ['title' => 'Payment Failed', 'text' => "Safepay reported that this payment didn't go through. No order was placed and your cart is untouched."],
    'init_failed'     => ['title' => 'Payment Gateway Unavailable', 'text' => "We couldn't reach Safepay to start the payment session right now. Please try again in a moment, or choose a different payment method at checkout."],
    'cannot_confirm'  => ['title' => 'Couldn\'t Confirm Payment', 'text' => "We couldn't confirm this payment's status with Safepay just now. If you were charged, please contact us with your reference before retrying — otherwise your cart is untouched and no order was placed."],
    'bad_signature'   => ['title' => 'Verification Failed', 'text' => "We couldn't verify that this response actually came from Safepay, so no order was placed. Please try again."],
    'tracker_mismatch'=> ['title' => 'Session Mismatch', 'text' => "This payment session doesn't match your current checkout attempt. Please start checkout again."],
];

$info = $messages[$reason] ?? $messages['cancelled'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($info['title']); ?> — Intra Decor Home</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { background: #f5f0f0; }
        .confirm-wrapper { max-width: 600px; margin: 60px auto; padding: 0 20px; text-align: center; }
        .confirm-box { background: white; border-radius: 20px; padding: 50px 40px; box-shadow: 0 8px 30px rgba(0,0,0,0.1); }
        .check-icon {
            width: 80px; height: 80px; background: #fdeaea; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 20px; font-size: 2.5rem;
        }
        .confirm-box h1 { color: #c0392b; font-size: 1.6rem; margin-bottom: 10px; }
        .confirm-box p.sub { color: #666; font-size: 14px; margin-bottom: 30px; line-height: 1.6; }
        .btn-row { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
        .btn-primary {
            background: #4b2c2c; color: white; padding: 12px 30px; border: none;
            border-radius: 25px; font-size: 14px; cursor: pointer; text-decoration: none;
            display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-outline {
            background: white; color: #4b2c2c; padding: 12px 30px; border: 2px solid #4b2c2c;
            border-radius: 25px; font-size: 14px; cursor: pointer; text-decoration: none;
            display: inline-flex; align-items: center; gap: 8px;
        }
    </style>
</head>
<body>

<div class="confirm-wrapper">
    <div class="confirm-box">
        <div class="check-icon">⚠️</div>
        <h1><?php echo htmlspecialchars($info['title']); ?></h1>
        <p class="sub"><?php echo htmlspecialchars($info['text']); ?></p>
        <div class="btn-row">
            <a href="checkout.php" class="btn-primary"><i class="fa fa-rotate-left"></i> Back to Checkout</a>
            <a href="cart.php" class="btn-outline"><i class="fa fa-cart-shopping"></i> View Cart</a>
        </div>
    </div>
</div>

</body>
</html>
