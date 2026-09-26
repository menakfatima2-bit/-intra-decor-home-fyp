<?php
/**
 * ─────────────────────────────────────────────
 *  PHPMailer DEBUG TEST — Delete this file after testing!
 *  Visit: http://localhost/fyp-home/test_mail.php
 * ─────────────────────────────────────────────
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/PHPMailer/Exception.php';
require_once __DIR__ . '/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/SMTP.php';

$result = "";
$success = false;

if (isset($_POST['test'])) {
    $to = trim($_POST['to_email']);

    $mail = new PHPMailer(true);

    try {
        // ── Enable full SMTP debug output ──
        $mail->SMTPDebug  = SMTP::DEBUG_SERVER;   // Shows full SMTP conversation
        $mail->Debugoutput = function($str, $level) {
            echo "<pre style='background:#1a1a1a;color:#0f0;padding:4px 8px;margin:2px 0;font-size:12px;border-radius:4px;'>"
                 . htmlspecialchars($str) . "</pre>";
        };

        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'ef91646@gmail.com';
        $mail->Password   = 'hukkfxseuezwnmyk';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->Timeout    = 15;

        // Bypassing SSL check for XAMPP local server
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer'       => false,
                'verify_peer_name'  => false,
                'allow_self_signed' => true,
            ]
        ];

        $mail->setFrom('ef91646@gmail.com', 'Intra Decor Home');
        $mail->addAddress($to);
        $mail->isHTML(true);
        $mail->Subject = 'Test Email — Intra Decor Home';
        $mail->Body    = '<h2 style="color:#4b2c2c;">✅ Email is working!</h2><p>If you see this, PHPMailer + Gmail is configured correctly.</p>';

        $mail->send();
        $success = true;
        $result  = "✅ Email sent successfully to <strong>" . htmlspecialchars($to) . "</strong>!";

    } catch (Exception $e) {
        $result = "❌ <strong>Error:</strong> " . htmlspecialchars($mail->ErrorInfo);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mail Debug Test</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 40px; }
        .card { background: #fff; border-radius: 12px; padding: 30px; max-width: 700px; margin: auto; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
        h2   { color: #4b2c2c; margin-bottom: 6px; }
        .badge { display: inline-block; background: #fff3cd; color: #856404; border: 1px solid #ffc107; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; margin-bottom: 20px; }
        input[type=email] { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; margin-bottom: 12px; box-sizing: border-box; }
        button { background: #4b2c2c; color: #fff; border: none; padding: 12px 24px; border-radius: 8px; font-size: 14px; cursor: pointer; }
        button:hover { background: #3a1f1f; }
        .result { margin-top: 20px; padding: 14px; border-radius: 8px; font-size: 14px; }
        .result.ok  { background: #d5f5e3; color: #1e8449; border: 1px solid #a9dfbf; }
        .result.err { background: #fdecea; color: #c0392b; border: 1px solid #f5b7b1; }
        .debug-box { margin-top: 20px; background: #111; border-radius: 8px; padding: 16px; }
        .debug-box h4 { color: #0f0; margin: 0 0 10px; font-size: 13px; }
        hr { border: none; border-top: 1px solid #eee; margin: 24px 0; }
        .checklist { list-style: none; padding: 0; }
        .checklist li { padding: 8px 0; font-size: 13px; color: #555; border-bottom: 1px solid #f0f0f0; }
        .checklist li span { font-weight: 600; color: #333; }
    </style>
</head>
<body>
<div class="card">
    <h2>📧 PHPMailer Debug Test</h2>
    <span class="badge">⚠️ Delete this file after testing!</span>

    <form method="POST">
        <label style="font-size:13px;font-weight:600;color:#333;display:block;margin-bottom:6px;">Send test email to:</label>
        <input type="email" name="to_email" placeholder="your-test@gmail.com" value="<?php echo isset($_POST['to_email']) ? htmlspecialchars($_POST['to_email']) : ''; ?>" required>
        <button type="submit" name="test">Send Test Email</button>
    </form>

    <?php if (!empty($result)): ?>
    <div class="result <?php echo $success ? 'ok' : 'err'; ?>">
        <?php echo $result; ?>
    </div>
    <?php endif; ?>

    <?php if (isset($_POST['test'])): ?>
    <div class="debug-box">
        <h4>🔍 SMTP Debug Log:</h4>
    <?php endif; ?>

    <hr>
    <h3 style="color:#4b2c2c;font-size:15px;">📋 Common Fixes Checklist</h3>
    <ul class="checklist">
        <li>1️⃣ <span>Gmail App Password</span> — Go to <a href="https://myaccount.google.com/apppasswords" target="_blank">myaccount.google.com/apppasswords</a> and generate a fresh 16-char app password. Paste it in mailer.php</li>
        <li>2️⃣ <span>2-Factor Auth must be ON</span> — App passwords only work if Google 2FA is enabled on ef91646@gmail.com</li>
        <li>3️⃣ <span>Port 587 blocked?</span> — Some ISPs/antivirus block outgoing port 587. Try port 465 with SSL instead.</li>
        <li>4️⃣ <span>Firewall / Antivirus</span> — Windows Defender or antivirus may block XAMPP's outgoing connections</li>
        <li>5️⃣ <span>Check spam folder</span> — Email may be delivered but land in spam</li>
    </ul>

    <?php if (isset($_POST['test'])): ?>
    </div>
    <?php endif; ?>

</div>
</body>
</html>
