<?php
session_start();
include "db.php";

// If no pending user in session, redirect to signup
if (!isset($_SESSION['pending_user'])) {
    header("Location: signup.php");
    exit();
}

$pending  = $_SESSION['pending_user'];
$email    = $pending['email'];
$error    = "";
$success  = "";

// ── RESEND OTP ────────────────────────────────────────────────────
if (isset($_GET['resend'])) {
    include "mailer.php";

    $new_otp = rand(100000, 999999);
    $_SESSION['pending_user']['otp']      = $new_otp;
    $_SESSION['pending_user']['otp_time'] = time();

    $name    = $pending['name'];
    $subject = "Intra Decor Home — New OTP for Email Verification";
    $body    = "
    <div style='font-family:Arial,sans-serif;max-width:480px;margin:auto;background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,0.1);'>
        <div style='background:#4b2c2c;padding:28px 30px;text-align:center;'>
            <h2 style='color:#fff;margin:0;font-size:22px;'>🏠 Intra Decor Home</h2>
            <p style='color:#e8c9a0;margin:6px 0 0;font-size:13px;'>Email Verification</p>
        </div>
        <div style='padding:32px 30px;'>
            <p style='color:#333;font-size:15px;margin:0 0 8px;'>Hello <strong>" . htmlspecialchars($name) . "</strong>,</p>
            <p style='color:#555;font-size:14px;line-height:1.6;'>Your new OTP is below. It expires in <strong>5 minutes</strong>.</p>
            <div style='text-align:center;margin:28px 0;'>
                <div style='display:inline-block;background:#f7f0eb;border:2px dashed #4b2c2c;border-radius:12px;padding:18px 36px;'>
                    <span style='font-size:38px;font-weight:900;letter-spacing:12px;color:#4b2c2c;'>" . $new_otp . "</span>
                </div>
            </div>
            <p style='color:#999;font-size:12px;text-align:center;'>If you did not request this, please ignore.</p>
        </div>
        <div style='background:#f7f0eb;padding:14px 30px;text-align:center;'>
            <p style='color:#a08060;font-size:12px;margin:0;'>&copy; " . date('Y') . " Intra Decor Home</p>
        </div>
    </div>";

    sendEmail($email, $subject, $body);
    $success = "A new OTP has been sent to <strong>" . htmlspecialchars($email) . "</strong>.";
}

// ── VERIFY OTP ────────────────────────────────────────────────────
if (isset($_POST['verify'])) {

    // Collect 6 individual digit inputs and combine
    $entered_otp = '';
    for ($i = 1; $i <= 6; $i++) {
        $entered_otp .= isset($_POST['d' . $i]) ? trim($_POST['d' . $i]) : '';
    }

    $stored_otp  = $_SESSION['pending_user']['otp'];
    $otp_time    = $_SESSION['pending_user']['otp_time'];
    $expired     = (time() - $otp_time) > 300; // 5 minutes = 300 seconds

    if ($expired) {
        $error = "Your OTP has expired. Please <a href='verify_signup_otp.php?resend=1'>resend a new one</a>.";

    } elseif ($entered_otp == $stored_otp) {

        // ── OTP correct → Insert user into DB ──────────────────
        $name     = $pending['name'];
        $em       = $pending['email'];
        $password = $pending['password'];   // already hashed
        $role     = $pending['role'];
        $city     = $pending['city'];

        $sql = $conn->prepare("INSERT INTO users (name, email, password, role, city) VALUES (?, ?, ?, ?, ?)");
        $sql->bind_param("sssss", $name, $em, $password, $role, $city);

        if ($sql->execute()) {
            $user_id = $conn->insert_id;

            // Auto-create providerprofile entry if service_provider
            if ($role === 'service_provider') {
                $pstmt = $conn->prepare("INSERT INTO providerprofile (provider_id, name, email, city) VALUES (?, ?, ?, ?)");
                $pstmt->bind_param("isss", $user_id, $name, $em, $city);
                $pstmt->execute();
            }

            // Notify all admins about new seller / service provider signups
            if ($role === 'seller' || $role === 'service_provider') {
                $role_label = $role === 'seller' ? 'seller' : 'service provider';
                $notif_msg  = $conn->real_escape_string("New $role_label registered: $name ($em) - pending approval");
                $admins_res = $conn->query("SELECT id FROM admins");
                if ($admins_res) {
                    while ($admin_row = $admins_res->fetch_assoc()) {
                        $aid = intval($admin_row['id']);
                        $conn->query("INSERT INTO notifications (admin_id, seller_id, message, is_read, created_at)
                                      VALUES ($aid, 0, '$notif_msg', 0, NOW())");
                    }
                }
            }

            // Clear pending user from session
            unset($_SESSION['pending_user']);

            // Redirect to login with success flag
            header("Location: login.php?registered=1");
            exit();

        } else {
            $error = "Registration failed. Please try again.";
        }

    } else {
        $error = "Incorrect OTP. Please try again.";
    }
}

// Mask email for display: abc***@gmail.com
$parts      = explode('@', $email);
$masked     = substr($parts[0], 0, 3) . '***@' . $parts[1];
$time_left  = max(0, 300 - (time() - $pending['otp_time']));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email — Intra Decor Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', Arial, sans-serif;
            background: linear-gradient(135deg, #f7f0eb 0%, #ede0d4 50%, #e2cfc3 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        /* ── CARD ─────────────────────────────── */
        .otp-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(75, 44, 44, 0.18);
            width: 100%;
            max-width: 440px;
            overflow: hidden;
            animation: slideUp 0.5s ease;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── HEADER ───────────────────────────── */
        .otp-header {
            background: linear-gradient(135deg, #4b2c2c, #6b3d3d);
            padding: 32px 36px 24px;
            text-align: center;
            position: relative;
        }
        .otp-header .icon-ring {
            width: 64px; height: 64px;
            background: rgba(255,255,255,0.15);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 14px;
            backdrop-filter: blur(4px);
        }
        .otp-header .icon-ring i {
            font-size: 28px; color: #fff;
        }
        .otp-header h2 {
            color: #fff; font-size: 20px; font-weight: 700;
        }
        .otp-header p {
            color: #e8c9a0; font-size: 13px; margin-top: 6px; line-height: 1.5;
        }

        /* ── BODY ─────────────────────────────── */
        .otp-body { padding: 32px 36px 28px; }

        .email-badge {
            display: flex; align-items: center; gap: 10px;
            background: #f7f0eb; border: 1px solid #e2cfc3;
            border-radius: 10px; padding: 12px 16px;
            margin-bottom: 26px;
        }
        .email-badge i { color: #4b2c2c; font-size: 15px; }
        .email-badge span { font-size: 13px; color: #555; }
        .email-badge strong { color: #4b2c2c; }

        /* ── OTP INPUT BOXES ──────────────────── */
        .otp-label {
            font-size: 13px; font-weight: 600; color: #4b2c2c;
            margin-bottom: 14px; text-transform: uppercase; letter-spacing: 0.5px;
        }

        .otp-boxes {
            display: flex; gap: 10px; justify-content: center;
            margin-bottom: 8px;
        }

        .otp-boxes input {
            width: 52px; height: 58px;
            border: 2px solid #ddd;
            border-radius: 12px;
            text-align: center;
            font-size: 24px; font-weight: 800;
            color: #4b2c2c;
            background: #faf8f6;
            transition: all 0.2s ease;
            outline: none;
            caret-color: #4b2c2c;
        }
        .otp-boxes input:focus {
            border-color: #4b2c2c;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(75,44,44,0.12);
            transform: scale(1.06);
        }
        .otp-boxes input.filled {
            border-color: #4b2c2c;
            background: #f7f0eb;
        }
        .otp-boxes input.error-box {
            border-color: #e74c3c;
            background: #fff5f5;
            animation: shake 0.4s ease;
        }

        @keyframes shake {
            0%,100% { transform: translateX(0); }
            20%      { transform: translateX(-6px); }
            60%      { transform: translateX(6px); }
        }

        /* ── TIMER ────────────────────────────── */
        .timer-row {
            display: flex; align-items: center; justify-content: space-between;
            margin: 18px 0 24px;
        }
        .timer-badge {
            display: flex; align-items: center; gap: 6px;
            background: #fff3cd; border: 1px solid #ffc107;
            border-radius: 20px; padding: 5px 12px;
            font-size: 12px; font-weight: 600; color: #856404;
        }
        .timer-badge.expired {
            background: #f8d7da; border-color: #f5c6cb; color: #721c24;
        }
        .resend-link {
            font-size: 13px; color: #4b2c2c; font-weight: 600;
            text-decoration: none; cursor: pointer;
        }
        .resend-link:hover { text-decoration: underline; }
        .resend-link.disabled { color: #999; pointer-events: none; }

        /* ── MESSAGES ─────────────────────────── */
        .msg {
            padding: 10px 14px; border-radius: 8px;
            font-size: 13px; margin-bottom: 18px; line-height: 1.5;
        }
        .msg.error   { background:#fdecea; color:#c0392b; border:1px solid #f5b7b1; }
        .msg.success { background:#d5f5e3; color:#1e8449; border:1px solid #a9dfbf; }

        /* ── BUTTON ───────────────────────────── */
        .verify-btn {
            width: 100%; padding: 14px;
            background: linear-gradient(135deg, #4b2c2c, #6b3d3d);
            color: #fff; border: none; border-radius: 12px;
            font-size: 15px; font-weight: 700; cursor: pointer;
            transition: all 0.3s ease;
            letter-spacing: 0.3px;
        }
        .verify-btn:hover {
            background: linear-gradient(135deg, #3a1f1f, #4b2c2c);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(75,44,44,0.35);
        }
        .verify-btn:active { transform: translateY(0); }

        /* ── FOOTER ───────────────────────────── */
        .otp-footer {
            text-align: center; padding: 14px 36px 20px;
            border-top: 1px solid #f0e8e2;
        }
        .otp-footer a {
            font-size: 13px; color: #4b2c2c; font-weight: 500;
            text-decoration: none;
        }
        .otp-footer a:hover { text-decoration: underline; }

        /* ── WARNING BANNER ───────────────────── */
        .warn-banner {
            background: #fff3cd; border: 1px solid #ffc107;
            border-radius: 10px; padding: 10px 14px;
            font-size: 13px; color: #856404;
            margin-bottom: 18px;
        }
    </style>
</head>
<body>

<div class="otp-card">

    <!-- HEADER -->
    <div class="otp-header">
        <div class="icon-ring">
            <i class="fa-solid fa-envelope-open-text"></i>
        </div>
        <h2>Verify Your Email</h2>
        <p>We've sent a 6-digit OTP to your email.<br>Enter it below to complete registration.</p>
    </div>

    <!-- BODY -->
    <div class="otp-body">

        <?php if (isset($_GET['warn'])): ?>
        <div class="warn-banner">
            ⚠️ Email could not be sent. Please check your email address or try later. You can still try to <a href="verify_signup_otp.php?resend=1">resend</a>.
        </div>
        <?php endif; ?>

        <!-- Email badge -->
        <div class="email-badge">
            <i class="fa-solid fa-envelope"></i>
            <span>OTP sent to <strong><?php echo htmlspecialchars($masked); ?></strong></span>
        </div>

        <!-- Error / Success messages -->
        <?php if (!empty($error)): ?>
        <div class="msg error"><i class="fa-solid fa-circle-exclamation"></i> <?php echo $error; ?></div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
        <div class="msg success"><i class="fa-solid fa-circle-check"></i> <?php echo $success; ?></div>
        <?php endif; ?>

        <!-- OTP Form -->
        <form method="POST" action="verify_signup_otp.php" id="otpForm">
            <div class="otp-label">Enter 6-Digit OTP</div>

            <div class="otp-boxes">
                <input type="text" name="d1" id="d1" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="off" required>
                <input type="text" name="d2" id="d2" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="off" required>
                <input type="text" name="d3" id="d3" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="off" required>
                <input type="text" name="d4" id="d4" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="off" required>
                <input type="text" name="d5" id="d5" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="off" required>
                <input type="text" name="d6" id="d6" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="off" required>
            </div>

            <!-- Timer + Resend -->
            <div class="timer-row">
                <div class="timer-badge" id="timerBadge">
                    <i class="fa-regular fa-clock"></i>
                    <span id="timerText">Expires in <span id="countdown"><?php echo gmdate('i:s', $time_left); ?></span></span>
                </div>
                <a href="verify_signup_otp.php?resend=1" class="resend-link <?php echo ($time_left > 0) ? 'disabled' : ''; ?>" id="resendLink">
                    Resend OTP
                </a>
            </div>

            <button type="submit" name="verify" class="verify-btn">
                <i class="fa-solid fa-shield-halved"></i> &nbsp;Verify & Complete Registration
            </button>
        </form>

    </div>

    <!-- FOOTER -->
    <div class="otp-footer">
        <a href="signup.php"><i class="fa-solid fa-arrow-left"></i> Back to Signup</a>
    </div>

</div>

<script>
// ── Auto-advance between OTP boxes ──────────────────────────────────────
const inputs = document.querySelectorAll('.otp-boxes input');

inputs.forEach((input, idx) => {
    input.addEventListener('input', (e) => {
        // Allow only digits
        input.value = input.value.replace(/[^0-9]/g, '');

        if (input.value.length === 1) {
            input.classList.add('filled');
            if (idx < inputs.length - 1) {
                inputs[idx + 1].focus();
            }
        } else {
            input.classList.remove('filled');
        }
    });

    input.addEventListener('keydown', (e) => {
        if (e.key === 'Backspace' && input.value === '' && idx > 0) {
            inputs[idx - 1].focus();
            inputs[idx - 1].classList.remove('filled');
        }
    });

    // Allow paste of full 6-digit code
    input.addEventListener('paste', (e) => {
        e.preventDefault();
        const pasted = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '');
        if (pasted.length === 6) {
            inputs.forEach((inp, i) => {
                inp.value = pasted[i] || '';
                if (pasted[i]) inp.classList.add('filled');
            });
            inputs[5].focus();
        }
    });
});

// ── Countdown timer ──────────────────────────────────────────────────────
let seconds = <?php echo $time_left; ?>;
const countdownEl = document.getElementById('countdown');
const timerBadge  = document.getElementById('timerBadge');
const resendLink  = document.getElementById('resendLink');
const timerText   = document.getElementById('timerText');

function updateTimer() {
    if (seconds <= 0) {
        timerBadge.classList.add('expired');
        timerText.innerHTML = '<i class="fa-solid fa-triangle-exclamation"></i> OTP Expired';
        resendLink.classList.remove('disabled');
        return;
    }
    const m = String(Math.floor(seconds / 60)).padStart(2, '0');
    const s = String(seconds % 60).padStart(2, '0');
    countdownEl.textContent = `${m}:${s}`;
    seconds--;
    setTimeout(updateTimer, 1000);
}

updateTimer();

// Auto-focus first box
inputs[0].focus();
</script>

</body>
</html>