<?php
/**
 * contact_submit.php
 * Handles Contact Us form submissions:
 *  1. Validates input
 *  2. Saves message into `contact_messages` table
 *  3. Emails the business inbox via PHPMailer (mailer.php)
 */

include 'db.php';
include 'mailer.php';

header('Content-Type: application/json');

function respond($status, $message) {
    echo json_encode(['status' => $status, 'message' => $message]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond('error', 'Invalid request.');
}

$name    = trim($_POST['name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

if (empty($name) || empty($email) || empty($subject) || empty($message)) {
    respond('error', 'Please fill in all fields.');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    respond('error', 'Please enter a valid email address.');
}

$nameEsc    = mysqli_real_escape_string($conn, $name);
$emailEsc   = mysqli_real_escape_string($conn, $email);
$subjectEsc = mysqli_real_escape_string($conn, $subject);
$messageEsc = mysqli_real_escape_string($conn, $message);

// 1) Save to database
$sql = "INSERT INTO contact_messages (name, email, subject, message, created_at)
        VALUES ('$nameEsc', '$emailEsc', '$subjectEsc', '$messageEsc', NOW())";

if (!mysqli_query($conn, $sql)) {
    respond('error', 'Something went wrong while saving your message. Please try again.');
}

// 2) Send notification email to the business inbox (best-effort; do not block success on failure)
$emailBody = "
    <h3>New Contact Form Message</h3>
    <p><strong>Name:</strong> " . htmlspecialchars($name) . "</p>
    <p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>
    <p><strong>Subject:</strong> " . htmlspecialchars($subject) . "</p>
    <p><strong>Message:</strong><br>" . nl2br(htmlspecialchars($message)) . "</p>
";

sendEmail('ef91646@gmail.com', 'New Contact Message: ' . $subject, $emailBody, $email, $name);

respond('success', 'Thank you! Your message has been sent. We will get back to you soon.');