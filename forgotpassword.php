<?php
include "db.php";
include "mailer.php";
session_start();

$message = "";
$msg_type = ""; // 'success' or 'error'

if (isset($_POST['submit'])) {

    $email = trim($_POST['email']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $user   = $result->fetch_assoc();
        $name   = $user['name'];
        $otp    = rand(100000, 999999);
        $expire = date("Y-m-d H:i:s", strtotime("+5 minutes"));

        // Save OTP to DB
        $update = $conn->prepare("UPDATE users SET otp_code = ?, otp_expire = ? WHERE email = ?");
        $update->bind_param("sss", $otp, $expire, $email);
        $update->execute();

        $_SESSION['reset_email'] = $email;

        // Send OTP email
        $subject = "Intra Decor Home — Password Reset OTP";
        $body = "
        <div style='font-family:Arial,sans-serif;max-width:480px;margin:auto;background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,0.1);'>
            <div style='background:#4b2c2c;padding:28px 30px;text-align:center;'>
                <h2 style='color:#fff;margin:0;font-size:22px;'>🏠 Intra Decor Home</h2>
                <p style='color:#e8c9a0;margin:6px 0 0;font-size:13px;'>Password Reset Request</p>
            </div>
            <div style='padding:32px 30px;'>
                <p style='color:#333;font-size:15px;margin:0 0 8px;'>Hello <strong>" . htmlspecialchars($name) . "</strong>,</p>
                <p style='color:#555;font-size:14px;line-height:1.6;'>We received a request to reset your password. Use the OTP below. It expires in <strong>5 minutes</strong>.</p>
                <div style='text-align:center;margin:28px 0;'>
                    <div style='display:inline-block;background:#f7f0eb;border:2px dashed #4b2c2c;border-radius:12px;padding:18px 36px;'>
                        <span style='font-size:38px;font-weight:900;letter-spacing:12px;color:#4b2c2c;'>" . $otp . "</span>
                    </div>
                </div>
                <p style='color:#999;font-size:12px;text-align:center;'>If you did not request a password reset, please ignore this email.</p>
            </div>
            <div style='background:#f7f0eb;padding:14px 30px;text-align:center;'>
                <p style='color:#a08060;font-size:12px;margin:0;'>&copy; " . date('Y') . " Intra Decor Home &mdash; Made with ❤️ in Pakistan</p>
            </div>
        </div>";

        $sent = sendEmail($email, $subject, $body);

        if ($sent) {
            $message  = "OTP sent to <strong>" . htmlspecialchars($email) . "</strong>. Check your inbox (and spam folder).";
            $msg_type = "success";
        } else {
            $message  = "Could not send email. Please try again later.";
            $msg_type = "error";
        }

    } else {
        $message  = "No account found with this email address.";
        $msg_type = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password — Intra Decor Home</title>
    <link rel="stylesheet" href="login.css?v=3">
    <style>
        .msg { padding:10px 14px; border-radius:8px; font-size:13px; margin-top:14px; text-align:center; }
        .msg.success { background:#d4edda; color:#155724; border:1px solid #c3e6cb; }
        .msg.error   { background:#f8d7da; color:#721c24; border:1px solid #f5c6cb; }
        .back-link   { display:block; text-align:center; margin-top:14px; font-size:13px; color:#4b2c2c; text-decoration:none; }
        .back-link:hover { text-decoration:underline; }
    </style>
</head>
<body>

<div class="container">
    <div class="form-box">

        <h2 style="text-align:center; margin-bottom:6px;">🔐 Forgot Password</h2>
        <p style="text-align:center; color:#777; font-size:13px; margin-bottom:20px;">
            Enter your registered email and we'll send you a 6-digit OTP.
        </p>

        <form method="POST" action="forgotpassword.php">
            <input type="email" name="email" placeholder="Enter your email address" required>
            <button type="submit" name="submit">Send OTP</button>
        </form>

        <?php if (!empty($message)) { ?>
        <div class="msg <?php echo $msg_type; ?>">
            <?php echo $message; ?>
        </div>
        <?php if ($msg_type === 'success') { ?>
        <div style="text-align:center; margin-top:16px;">
            <a href="verifypassword.php" style="display:inline-block; background:#4b2c2c; color:#fff; padding:10px 28px; border-radius:8px; text-decoration:none; font-size:14px; font-weight:600;">
                Enter OTP →
            </a>
        </div>
        <?php } ?>
        <?php } ?>

        <a href="login.php" class="back-link">← Back to Login</a>

    </div>
</div>

</body>
</html>