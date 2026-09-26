<?php
session_start();
include "db.php";
include "mailer.php";

if (isset($_POST['signup'])) {

    $name     = mysqli_real_escape_string($conn, $_POST['name']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];
    $role     = mysqli_real_escape_string($conn, $_POST['role']);
    $city     = isset($_POST['city']) ? mysqli_real_escape_string($conn, $_POST['city']) : ''; // City field removed from form; kept for DB compatibility

    // ── 1. Password match check ──────────────────────────────────
    if ($password !== $confirm) {
        echo "<script>alert('Passwords do not match!'); window.location.href='signup.php';</script>";
        exit();
    }

    // ── 2. Role validation ───────────────────────────────────────
    $allowed_roles = ['user', 'seller', 'service_provider'];
    if (empty($role) || !in_array($role, $allowed_roles)) {
        echo "<script>alert('Please select a valid account type!'); window.location.href='signup.php';</script>";
        exit();
    }

    // ── 3. Duplicate email check ─────────────────────────────────
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        echo "<script>alert('Email already registered!'); window.location.href='signup.php';</script>";
        exit();
    }
    $check->close();

    // ── 4. Generate 6-digit OTP ──────────────────────────────────
    $otp = rand(100000, 999999);

    // ── 5. Store pending user data in session ─────────────────────
    $_SESSION['pending_user'] = [
        'name'     => $name,
        'email'    => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'role'     => $role,
        'city'     => $city,
        'otp'      => $otp,
        'otp_time' => time()   // Unix timestamp for expiry check
    ];

    // ── 6. Send OTP email ─────────────────────────────────────────
    $subject = "Intra Decor Home — Email Verification OTP";
    $body = "
    <div style='font-family:Arial,sans-serif;max-width:480px;margin:auto;background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,0.1);'>
        <div style='background:#4b2c2c;padding:28px 30px;text-align:center;'>
            <h2 style='color:#fff;margin:0;font-size:22px;'>🏠 Intra Decor Home</h2>
            <p style='color:#e8c9a0;margin:6px 0 0;font-size:13px;'>Email Verification</p>
        </div>
        <div style='padding:32px 30px;'>
            <p style='color:#333;font-size:15px;margin:0 0 8px;'>Hello <strong>" . htmlspecialchars($name) . "</strong>,</p>
            <p style='color:#555;font-size:14px;line-height:1.6;'>Thank you for signing up! Use the OTP below to verify your email address. It expires in <strong>5 minutes</strong>.</p>
            <div style='text-align:center;margin:28px 0;'>
                <div style='display:inline-block;background:#f7f0eb;border:2px dashed #4b2c2c;border-radius:12px;padding:18px 36px;'>
                    <span style='font-size:38px;font-weight:900;letter-spacing:12px;color:#4b2c2c;'>" . $otp . "</span>
                </div>
            </div>
            <p style='color:#999;font-size:12px;text-align:center;'>If you did not create this account, please ignore this email.</p>
        </div>
        <div style='background:#f7f0eb;padding:14px 30px;text-align:center;'>
            <p style='color:#a08060;font-size:12px;margin:0;'>&copy; " . date('Y') . " Intra Decor Home &mdash; Made with ❤️ in Pakistan</p>
        </div>
    </div>";

    $sent = sendEmail($email, $subject, $body);

    if ($sent) {
        header("Location: verify_signup_otp.php");
        exit();
    } else {
        // If email fails, still redirect but show warning
        header("Location: verify_signup_otp.php?warn=1");
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Signup — Intra Decor Home</title>
    <link rel="stylesheet" href="signup.css?v=3">
</head>
<body>

<div class="container">
    <div class="form-box">

        <h2 style="text-align:center; margin-bottom: 20px;">Create Account</h2>

        <!-- SIGNUP FORM -->
        <form method="POST" action="signup.php" id="signupForm">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email Address" required>

            <!-- Password Field -->
            <div class="password-wrapper">
                <input type="password" id="password" name="password" placeholder="Enter Password" required>
                <span id="togglePassword">👁</span>
            </div>

            <!-- Confirm Password Field -->
            <div class="password-wrapper">
                <input type="password" id="confirmPassword" name="confirm_password" placeholder="Confirm Password" required>
                <span id="toggleConfirmPassword">👁</span>
            </div>

            <select name="role" required>
                <option value="">Select Account Type</option>
                <option value="user">User</option>
                <option value="seller">Seller</option>
                <option value="service_provider">Service Provider</option>
            </select>

            <button type="submit" name="signup">Create Account &amp; Send OTP</button>
        </form>

        <p style="text-align:center; margin-top:10px;">
            Already have an account? <a href="login.php">Login here</a>
        </p>

    </div>
</div>

<script>
const togglePassword = document.querySelector("#togglePassword");
const password = document.querySelector("#password");

const toggleConfirmPassword = document.querySelector("#toggleConfirmPassword");
const confirmPassword = document.querySelector("#confirmPassword");

togglePassword.addEventListener("click", function () {
    const type = password.getAttribute("type") === "password" ? "text" : "password";
    password.setAttribute("type", type);
});

toggleConfirmPassword.addEventListener("click", function () {
    const type = confirmPassword.getAttribute("type") === "password" ? "text" : "password";
    confirmPassword.setAttribute("type", type);
});
</script>

</body>
</html>