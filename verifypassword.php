<?php
include "db.php";
session_start();

if (!isset($_SESSION['reset_email'])) {
    header("Location: forgotpassword.php");
    exit();
}

$email   = $_SESSION['reset_email'];
$error   = "";

if (isset($_POST['verify'])) {

    // Collect 6 individual digit inputs
    $otp = '';
    for ($i = 1; $i <= 6; $i++) {
        $otp .= isset($_POST['d' . $i]) ? trim($_POST['d' . $i]) : '';
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND otp_code = ? AND otp_expire > NOW()");
    $stmt->bind_param("ss", $email, $otp);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        header("Location: newpassword.php"); // ✅ Fixed: was new_password.php
        exit();
    } else {
        $error = "Incorrect or expired OTP. Please try again.";
    }
}

// Mask email for display
$parts  = explode('@', $email);
$masked = substr($parts[0], 0, 3) . '***@' . $parts[1];

// Calculate time left from DB
$timeRes = $conn->prepare("SELECT otp_expire FROM users WHERE email = ?");
$timeRes->bind_param("s", $email);
$timeRes->execute();
$timeData   = $timeRes->get_result()->fetch_assoc();
$time_left  = 0;
if ($timeData && $timeData['otp_expire']) {
    $expire_ts = strtotime($timeData['otp_expire']);
    $time_left = max(0, $expire_ts - time());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter OTP — Intra Decor Home</title>
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

        .otp-header {
            background: linear-gradient(135deg, #4b2c2c, #6b3d3d);
            padding: 32px 36px 24px;
            text-align: center;
        }
        .otp-header .icon-ring {
            width: 64px; height: 64px;
            background: rgba(255,255,255,0.15);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 14px;
        }
        .otp-header .icon-ring i { font-size: 28px; color: #fff; }
        .otp-header h2 { color: #fff; font-size: 20px; font-weight: 700; }
        .otp-header p  { color: #e8c9a0; font-size: 13px; margin-top: 6px; line-height: 1.5; }

        .otp-body { padding: 32px 36px 28px; }

        .email-badge {
            display: flex; align-items: center; gap: 10px;
            background: #f7f0eb; border: 1px solid #e2cfc3;
            border-radius: 10px; padding: 12px 16px;
            margin-bottom: 26px;
        }
        .email-badge i    { color: #4b2c2c; font-size: 15px; }
        .email-badge span { font-size: 13px; color: #555; }
        .email-badge strong { color: #4b2c2c; }

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
        }
        .otp-boxes input:focus {
            border-color: #4b2c2c;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(75,44,44,0.12);
            transform: scale(1.06);
        }
        .otp-boxes input.filled { border-color: #4b2c2c; background: #f7f0eb; }
        .otp-boxes input.error-box {
            border-color: #e74c3c; background: #fff5f5;
            animation: shake 0.4s ease;
        }
        @keyframes shake {
            0%,100% { transform: translateX(0); }
            20%      { transform: translateX(-6px); }
            60%      { transform: translateX(6px); }
        }

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
        .timer-badge.expired { background: #f8d7da; border-color: #f5c6cb; color: #721c24; }
        .resend-link { font-size: 13px; color: #4b2c2c; font-weight: 600; text-decoration: none; }
        .resend-link:hover { text-decoration: underline; }
        .resend-link.disabled { color: #999; pointer-events: none; }

        .msg {
            padding: 10px 14px; border-radius: 8px;
            font-size: 13px; margin-bottom: 18px;
        }
        .msg.error { background:#fdecea; color:#c0392b; border:1px solid #f5b7b1; }

        .verify-btn {
            width: 100%; padding: 14px;
            background: linear-gradient(135deg, #4b2c2c, #6b3d3d);
            color: #fff; border: none; border-radius: 12px;
            font-size: 15px; font-weight: 700; cursor: pointer;
            transition: all 0.3s ease;
        }
        .verify-btn:hover {
            background: linear-gradient(135deg, #3a1f1f, #4b2c2c);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(75,44,44,0.35);
        }

        .otp-footer {
            text-align: center; padding: 14px 36px 20px;
            border-top: 1px solid #f0e8e2;
        }
        .otp-footer a { font-size: 13px; color: #4b2c2c; font-weight: 500; text-decoration: none; }
        .otp-footer a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="otp-card">

    <div class="otp-header">
        <div class="icon-ring">
            <i class="fa-solid fa-lock"></i>
        </div>
        <h2>Enter Your OTP</h2>
        <p>We sent a 6-digit code to your email.<br>Enter it below to reset your password.</p>
    </div>

    <div class="otp-body">

        <div class="email-badge">
            <i class="fa-solid fa-envelope"></i>
            <span>OTP sent to <strong><?php echo htmlspecialchars($masked); ?></strong></span>
        </div>

        <?php if (!empty($error)): ?>
        <div class="msg error"><i class="fa-solid fa-circle-exclamation"></i> <?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="verifypassword.php" id="otpForm">
            <div class="otp-label">Enter 6-Digit OTP</div>

            <div class="otp-boxes">
                <input type="text" name="d1" id="d1" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="off" required>
                <input type="text" name="d2" id="d2" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="off" required>
                <input type="text" name="d3" id="d3" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="off" required>
                <input type="text" name="d4" id="d4" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="off" required>
                <input type="text" name="d5" id="d5" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="off" required>
                <input type="text" name="d6" id="d6" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="off" required>
            </div>

            <div class="timer-row">
                <div class="timer-badge" id="timerBadge">
                    <i class="fa-regular fa-clock"></i>
                    <span id="timerText">Expires in <span id="countdown"><?php echo gmdate('i:s', $time_left); ?></span></span>
                </div>
                <a href="forgotpassword.php" class="resend-link" id="resendLink" style="<?php echo $time_left > 0 ? 'color:#999;pointer-events:none;' : ''; ?>">
                    Resend OTP
                </a>
            </div>

            <button type="submit" name="verify" class="verify-btn">
                <i class="fa-solid fa-shield-halved"></i> &nbsp;Verify OTP
            </button>
        </form>

    </div>

    <div class="otp-footer">
        <a href="forgotpassword.php"><i class="fa-solid fa-arrow-left"></i> Back to Forgot Password</a>
    </div>

</div>

<script>
// ── Auto-advance between OTP boxes ──────────────────────────
const inputs = document.querySelectorAll('.otp-boxes input');

inputs.forEach((input, idx) => {
    input.addEventListener('input', () => {
        input.value = input.value.replace(/[^0-9]/g, '');
        if (input.value.length === 1) {
            input.classList.add('filled');
            if (idx < inputs.length - 1) inputs[idx + 1].focus();
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

// ── Countdown timer ──────────────────────────────────────────
let seconds    = <?php echo $time_left; ?>;
const cdEl     = document.getElementById('countdown');
const badge    = document.getElementById('timerBadge');
const timerTxt = document.getElementById('timerText');
const resendEl = document.getElementById('resendLink');

function tick() {
    if (seconds <= 0) {
        badge.classList.add('expired');
        timerTxt.innerHTML = '<i class="fa-solid fa-triangle-exclamation"></i> OTP Expired';
        resendEl.style.color = '#4b2c2c';
        resendEl.style.pointerEvents = 'auto';
        return;
    }
    const m = String(Math.floor(seconds / 60)).padStart(2,'0');
    const s = String(seconds % 60).padStart(2,'0');
    cdEl.textContent = `${m}:${s}`;
    seconds--;
    setTimeout(tick, 1000);
}

tick();
inputs[0].focus();
</script>

</body>
</html>