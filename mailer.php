<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/PHPMailer/Exception.php';
require_once __DIR__ . '/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/SMTP.php';

function sendEmail($to, $subject, $body, $replyTo = '', $replyName = '') {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'ef91646@gmail.com';
        $mail->Password   = 'YOUR_GMAIL_APP_PASSWORD';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // ── Fix for XAMPP: Disable SSL cert verification ──────────
        // XAMPP ships with outdated CA certificates that cannot verify
        // Gmail's SSL cert. Safe to disable on localhost/development.
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer'       => false,
                'verify_peer_name'  => false,
                'allow_self_signed' => true,
            ]
        ];

        $mail->setFrom('ef91646@gmail.com', 'Intra Decor Home');
        $mail->addAddress($to);
        // If a reply address is given, pressing "Reply" in Gmail answers that person directly
        if (!empty($replyTo)) {
            $mail->addReplyTo($replyTo, $replyName);
        }

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>