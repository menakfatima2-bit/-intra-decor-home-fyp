<?php
session_start();
include "../db.php";
include "../mailer.php";

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'service_provider'){
    header("Location: ../login.php");
    exit();
}

$provider_id = $_SESSION['user_id'];

// Bookings fetch with user info
$query = "SELECT b.*, u.name as user_name, u.email as user_email, u.phone as user_phone
          FROM booking b
          LEFT JOIN users u ON b.user_id = u.id
          WHERE b.provider_id='$provider_id'
          ORDER BY b.booking_id DESC";
$result = mysqli_query($conn, $query);

// Status update
if(isset($_GET['action']) && isset($_GET['id'])){
    $bid    = intval($_GET['id']);
    $action = $_GET['action'];
    $new_status = null;
    if($action == 'accept'){
        mysqli_query($conn, "UPDATE booking SET status='Accepted' WHERE booking_id='$bid' AND provider_id='$provider_id'");
        $new_status = 'Accepted';
    } elseif($action == 'reject'){
        mysqli_query($conn, "UPDATE booking SET status='Rejected' WHERE booking_id='$bid' AND provider_id='$provider_id'");
        $new_status = 'Rejected';
    }

    // Notify the customer about the booking status change
    if($new_status){
        $b_res = mysqli_query($conn, "SELECT b.user_id, b.service_name, b.booking_date, u.name AS user_name, u.email AS user_email
                                       FROM booking b
                                       LEFT JOIN users u ON b.user_id = u.id
                                       WHERE b.booking_id='$bid'");
        if($b_row = mysqli_fetch_assoc($b_res)){
            $notif_user_id = intval($b_row['user_id']);
            $notif_message = "Your service booking #$bid has been $new_status";
            mysqli_query($conn, "INSERT INTO notifications (user_id, message, is_read, created_at)
                                  VALUES ($notif_user_id, '$notif_message', 0, NOW())");

            // NEW: Email the customer about the booking status change
            if(!empty($b_row['user_email'])){
                $is_accept  = ($new_status === 'Accepted');
                $color      = $is_accept ? '#2ecc71' : '#e74c3c';
                $icon       = $is_accept ? '✅' : '❌';
                $intro_line = $is_accept
                    ? "Great news! Your service booking has been <b>accepted</b> by the provider."
                    : "Unfortunately, your service booking has been <b>rejected</b> by the provider.";

                $subject = "Booking #$bid $new_status — Intra Decor Home";
                $body = "
                <div style='font-family:Arial,sans-serif;max-width:600px;margin:0 auto;'>
                    <div style='background:#4b2c2c;padding:20px;border-radius:10px 10px 0 0;'>
                        <h2 style='color:#fff;margin:0;'>$icon Booking $new_status</h2>
                    </div>
                    <div style='background:#f9f4ef;padding:24px;border-radius:0 0 10px 10px;'>
                        <p style='color:#555;font-size:15px;'>Hi {$b_row['user_name']},</p>
                        <p style='color:#555;font-size:15px;'>$intro_line</p>

                        <table style='width:100%;border-collapse:collapse;margin-top:16px;'>
                            <tr style='background:#fff;'>
                                <td style='padding:10px 14px;font-weight:bold;color:#4b2c2c;border-bottom:1px solid #edddd4;'>Booking ID</td>
                                <td style='padding:10px 14px;color:#555;border-bottom:1px solid #edddd4;'>#$bid</td>
                            </tr>
                            <tr style='background:#fff;'>
                                <td style='padding:10px 14px;font-weight:bold;color:#4b2c2c;border-bottom:1px solid #edddd4;'>Service</td>
                                <td style='padding:10px 14px;color:#555;border-bottom:1px solid #edddd4;'>{$b_row['service_name']}</td>
                            </tr>
                            <tr style='background:#fff;'>
                                <td style='padding:10px 14px;font-weight:bold;color:#4b2c2c;border-bottom:1px solid #edddd4;'>Booking Date</td>
                                <td style='padding:10px 14px;color:#555;border-bottom:1px solid #edddd4;'>{$b_row['booking_date']}</td>
                            </tr>
                            <tr style='background:#fff;'>
                                <td style='padding:10px 14px;font-weight:bold;color:#4b2c2c;'>Status</td>
                                <td style='padding:10px 14px;color:$color;font-weight:bold;'>$new_status</td>
                            </tr>
                        </table>

                        <p style='margin-top:20px;color:#aaa;font-size:12px;text-align:center;'>
                            Intra Decor Home — Professional Home Decor Services
                        </p>
                    </div>
                </div>
                ";

                sendEmail($b_row['user_email'], $subject, $body);
            }
        }
    }

    header("Location: mybookings.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Bookings</title>
<link rel="stylesheet" href="serviceprovider.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
.main-content { padding: 30px; }
h2 { color: #4b2c2c; margin-bottom: 24px; font-size: 22px; }

.booking-card {
    background: #fff;
    border-radius: 14px;
    padding: 20px 24px;
    margin-bottom: 16px;
    box-shadow: 0 3px 12px rgba(0,0,0,0.07);
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 16px;
    border-left: 5px solid #e0c9c9;
}
.booking-card.pending  { border-left-color: #f39c12; }
.booking-card.accepted { border-left-color: #2ecc71; }
.booking-card.rejected { border-left-color: #e74c3c; }

.booking-info h3 { color: #4b2c2c; font-size: 16px; margin: 0 0 10px; }

.info-list { list-style: none; padding: 0; margin: 0; }
.info-list li {
    font-size: 13px; color: #555;
    display: flex; align-items: center; gap: 8px;
    margin-bottom: 6px;
}
.info-list li i { color: #c17f4a; width: 14px; }

.status-badge {
    padding: 5px 14px; border-radius: 20px;
    font-size: 12px; font-weight: 700;
    display: inline-block; margin-bottom: 12px;
}
.badge-pending  { background: #fff3cd; color: #856404; }
.badge-accepted { background: #d4edda; color: #155724; }
.badge-rejected { background: #f8d7da; color: #721c24; }

.action-btns { display: flex; gap: 10px; flex-wrap: wrap; align-items: center; }

.btn-accept {
    background: #2ecc71; color: #fff;
    padding: 8px 20px; border-radius: 8px;
    text-decoration: none; font-size: 13px; font-weight: 600;
    transition: 0.2s;
}
.btn-accept:hover { background: #27ae60; }

.btn-reject {
    background: #e74c3c; color: #fff;
    padding: 8px 20px; border-radius: 8px;
    text-decoration: none; font-size: 13px; font-weight: 600;
    transition: 0.2s;
}
.btn-reject:hover { background: #c0392b; }

.btn-whatsapp {
    background: #25d366; color: #fff;
    padding: 8px 20px; border-radius: 8px;
    text-decoration: none; font-size: 13px; font-weight: 600;
    display: flex; align-items: center; gap: 6px;
    transition: 0.2s;
}
.btn-whatsapp:hover { background: #1da851; }

.no-bookings {
    text-align: center; padding: 60px 20px;
    color: #aaa;
}
.no-bookings i { font-size: 48px; display: block; margin-bottom: 14px; color: #ddd; }
</style>
</head>
<body>

<div class="sidebar">
    <h2><i class="fa-solid fa-user-gear"></i> Service Provider</h2>
    <ul>
        <li><a href="serviceprovider.php"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>
        <li><a href="addservice.php"><i class="fa-solid fa-plus"></i> Add Service</a></li>
        <li><a href="servicelist.php"><i class="fa-solid fa-list"></i> My Services</a></li>
        <li><a href="mybookings.php" class="active"><i class="fa-solid fa-calendar-check"></i> My Bookings</a></li>
        <li><a href="providerprofile.php"><i class="fa-solid fa-user"></i> Profile</a></li>
        <li><a href="../logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
    </ul>
</div>

<div class="main">
    <h2><i class="fa-solid fa-calendar-check"></i> My Bookings</h2>

    <?php
    $bookings = [];
    while($row = mysqli_fetch_assoc($result)){
        $bookings[] = $row;
    }
    ?>

    <?php if(count($bookings) > 0){ ?>

    <?php foreach($bookings as $b){
        $status_class = strtolower($b['status']);
        // WhatsApp number
        $wa = preg_replace('/[^0-9]/', '', $b['user_phone'] ?? '');
        if(substr($wa,0,1)=='0') $wa = '92'.substr($wa,1);
        $wa_msg = urlencode("Hi {$b['user_name']}! I am confirming your booking for {$b['service_name']} on {$b['booking_date']}.");
    ?>
    <div class="booking-card <?php echo $status_class; ?>">

        <div class="booking-info">
            <h3><i class="fa-solid fa-screwdriver-wrench"></i> <?php echo $b['service_name']; ?></h3>

            <span class="status-badge badge-<?php echo $status_class; ?>">
                <?php
                if($status_class == 'pending')  echo '⏳ Pending';
                if($status_class == 'accepted') echo '✅ Accepted';
                if($status_class == 'rejected') echo '❌ Rejected';
                ?>
            </span>

            <ul class="info-list">
                <li><i class="fa-solid fa-user"></i> <?php echo $b['user_name']; ?></li>
                <li><i class="fa-solid fa-envelope"></i> <?php echo $b['user_email']; ?></li>
                <li><i class="fa-solid fa-phone"></i> <?php echo $b['user_phone'] ?? 'Not provided'; ?></li>
                <li><i class="fa-solid fa-calendar"></i> <?php echo date('d M Y', strtotime($b['booking_date'])); ?></li>
                <li><i class="fa-solid fa-location-dot"></i> <?php echo $b['address']; ?></li>
                <li><i class="fa-solid fa-clock"></i> Booked on: <?php echo date('d M Y', strtotime($b['created_at'])); ?></li>
            </ul>
        </div>

        <div class="action-btns">
            <?php if($b['status'] == 'Pending'){ ?>
            <a href="mybookings.php?action=accept&id=<?php echo $b['booking_id']; ?>"
               onclick="return confirm('Accept this booking?')"
               class="btn-accept">
                <i class="fa-solid fa-check"></i> Accept
            </a>
            <a href="mybookings.php?action=reject&id=<?php echo $b['booking_id']; ?>"
               onclick="return confirm('Reject this booking?')"
               class="btn-reject">
                <i class="fa-solid fa-xmark"></i> Reject
            </a>
            <?php } ?>

            <?php if(!empty($wa)){ ?>
            <a href="https://wa.me/<?php echo $wa; ?>?text=<?php echo $wa_msg; ?>"
               target="_blank" class="btn-whatsapp">
                <i class="fa-brands fa-whatsapp"></i> WhatsApp
            </a>
            <?php } ?>
        </div>

    </div>
    <?php } ?>

    <?php } else { ?>
    <div class="no-bookings">
        <i class="fa-solid fa-calendar-xmark"></i>
        No bookings received yet.
    </div>
    <?php } ?>

</div>

</body>
</html>