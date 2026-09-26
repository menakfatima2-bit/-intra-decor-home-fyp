<?php
/**
 * newsletter.php
 * Newsletter subscription handler
 * Apne config.php / db connection file ka path update karo
 */

include 'db.php'; // Ya apna database connection file

header('Content-Type: text/plain');

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $email = trim($_POST['email'] ?? '');

    // Basic validation
    if(empty($email)){
        echo "Please enter your email.";
        exit;
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        echo "Invalid email address.";
        exit;
    }

    $email = mysqli_real_escape_string($conn, $email);

    // Check if already subscribed
    $check = mysqli_query($conn, "SELECT id FROM newsletter_subscribers WHERE email='$email'");
    if(mysqli_num_rows($check) > 0){
        echo "You are already subscribed!";
        exit;
    }

    // Insert into DB
    $sql = "INSERT INTO newsletter_subscribers (email, subscribed_at) VALUES ('$email', NOW())";
    if(mysqli_query($conn, $sql)){
        echo "Thank you for subscribing!";
    } else {
        echo "Something went wrong. Please try again.";
    }

} else {
    echo "Invalid request.";
}
?>