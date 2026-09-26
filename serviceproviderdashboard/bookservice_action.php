<?php
session_start();
include "../db.php";
include "../mailer.php";

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'user'){
    header("Location: ../login.php");
    exit();
}

if(isset($_POST['book_now'])){

    $user_id      = $_SESSION['user_id'];
    $service_id   = intval($_POST['service_id']);
    $provider_id  = intval($_POST['provider_id']);
    $service_name = $_POST['service_name'];
    $booking_date = $_POST['booking_date'];
    $address      = $_POST['address'];

    // Map data
    $latitude  = !empty($_POST['latitude'])  ? $_POST['latitude']  : NULL;
    $longitude = !empty($_POST['longitude']) ? $_POST['longitude'] : NULL;
    $map_link  = !empty($_POST['map_link'])  ? $_POST['map_link']  : NULL;

    // Booking save
    $query = "INSERT INTO booking 
              (user_id, provider_id, service_id, service_name, booking_date, address, status, latitude, longitude, map_link)
              VALUES 
              ('$user_id','$provider_id','$service_id','$service_name','$booking_date','$address','Pending',
               ".($latitude ? "'$latitude'" : "NULL").",
               ".($longitude ? "'$longitude'" : "NULL").",
               ".($map_link ? "'$map_link'" : "NULL").")";

    if(mysqli_query($conn, $query)){
        $booking_id = mysqli_insert_id($conn);

        // User info fetch
        $userQ = mysqli_query($conn, "SELECT name, email, phone FROM users WHERE id='$user_id'");
        $user  = mysqli_fetch_assoc($userQ);

        // Provider email fetch
        $provQ = mysqli_query($conn, "SELECT email FROM users WHERE id='$provider_id'");
        $prov  = mysqli_fetch_assoc($provQ);

        // NEW: Create a dashboard notification for the provider (bell icon)
        $notif_message = mysqli_real_escape_string($conn, "New booking for \"$service_name\" from {$user['name']} on $booking_date.");
        mysqli_query($conn, "INSERT INTO notifications (provider_id, message) VALUES ('$provider_id', '$notif_message')");

        // Map link for email
        $map_html = '';
        if($map_link){
            $map_html = "
            <tr style='background:#fff;'>
                <td style='padding:10px 14px;font-weight:bold;color:#4b2c2c;border-bottom:1px solid #edddd4;'>📍 Location</td>
                <td style='padding:10px 14px;color:#555;border-bottom:1px solid #edddd4;'>
                    <a href='$map_link' target='_blank' style='color:#c17f4a;font-weight:600;'>
                        View on Google Maps
                    </a>
                </td>
            </tr>";
        }

        // Email provider ko bhejo
        if($prov && !empty($prov['email'])){
            $subject = "New Booking Received — Intra Decor Home";
            $body = "
            <div style='font-family:Arial,sans-serif;max-width:600px;margin:0 auto;'>
                <div style='background:#4b2c2c;padding:20px;border-radius:10px 10px 0 0;'>
                    <h2 style='color:#fff;margin:0;'>🔔 New Booking Received!</h2>
                </div>
                <div style='background:#f9f4ef;padding:24px;border-radius:0 0 10px 10px;'>
                    <p style='color:#555;font-size:15px;'>A new booking has been made for your service on <b>Intra Decor Home</b>.</p>

                    <table style='width:100%;border-collapse:collapse;margin-top:16px;'>
                        <tr style='background:#fff;'>
                            <td style='padding:10px 14px;font-weight:bold;color:#4b2c2c;border-bottom:1px solid #edddd4;'>Service</td>
                            <td style='padding:10px 14px;color:#555;border-bottom:1px solid #edddd4;'>$service_name</td>
                        </tr>
                        <tr style='background:#fff;'>
                            <td style='padding:10px 14px;font-weight:bold;color:#4b2c2c;border-bottom:1px solid #edddd4;'>Customer Name</td>
                            <td style='padding:10px 14px;color:#555;border-bottom:1px solid #edddd4;'>{$user['name']}</td>
                        </tr>
                        <tr style='background:#fff;'>
                            <td style='padding:10px 14px;font-weight:bold;color:#4b2c2c;border-bottom:1px solid #edddd4;'>Customer Email</td>
                            <td style='padding:10px 14px;color:#555;border-bottom:1px solid #edddd4;'>{$user['email']}</td>
                        </tr>
                        <tr style='background:#fff;'>
                            <td style='padding:10px 14px;font-weight:bold;color:#4b2c2c;border-bottom:1px solid #edddd4;'>Customer Phone</td>
                            <td style='padding:10px 14px;color:#555;border-bottom:1px solid #edddd4;'>{$user['phone']}</td>
                        </tr>
                        <tr style='background:#fff;'>
                            <td style='padding:10px 14px;font-weight:bold;color:#4b2c2c;border-bottom:1px solid #edddd4;'>Booking Date</td>
                            <td style='padding:10px 14px;color:#555;border-bottom:1px solid #edddd4;'>$booking_date</td>
                        </tr>
                        <tr style='background:#fff;'>
                            <td style='padding:10px 14px;font-weight:bold;color:#4b2c2c;border-bottom:1px solid #edddd4;'>Address</td>
                            <td style='padding:10px 14px;color:#555;border-bottom:1px solid #edddd4;'>$address</td>
                        </tr>
                        $map_html
                    </table>

                    <div style='margin-top:20px;padding:14px;background:#fff3cd;border-radius:8px;border-left:4px solid #f39c12;'>
                        <p style='margin:0;color:#856404;font-size:14px;'>
                            ⚡ Please login to your dashboard to <b>Accept or Reject</b> this booking.
                        </p>
                    </div>

                    <p style='margin-top:20px;color:#aaa;font-size:12px;text-align:center;'>
                        Intra Decor Home — Professional Home Decor Services
                    </p>
                </div>
            </div>
            ";

            sendEmail($prov['email'], $subject, $body);
        }

        header("Location: confirm_booking.php?id=$booking_id");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>