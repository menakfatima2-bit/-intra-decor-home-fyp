<?php
session_start();
include "../db.php";

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'user'){
    header("Location: ../login.php");
    exit();
}

$booking_id = intval($_GET['id']);

$query = "SELECT b.*, a.serviceprovider_name, a.city, a.started_at
          FROM booking b
          JOIN addservice a ON b.service_id = a.service_id
          WHERE b.booking_id='$booking_id' AND b.user_id='{$_SESSION['user_id']}'";
$result = mysqli_query($conn, $query);
$booking = mysqli_fetch_assoc($result);

if(!$booking){
    header("Location: ../services.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmed!</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #f5f0f0; font-family: Arial, sans-serif; }

        .wrapper {
            max-width: 540px;
            margin: 60px auto;
            padding: 0 20px;
            text-align: center;
        }

        /* Success Icon */
        .success-icon {
            width: 80px; height: 80px;
            background: #2ecc71;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 20px;
            font-size: 36px; color: #fff;
            box-shadow: 0 6px 20px rgba(46,204,113,0.4);
        }

        h2 { color: #4b2c2c; font-size: 22px; margin-bottom: 8px; }
        .subtitle { color: #888; font-size: 14px; margin-bottom: 28px; }

        /* Booking Details Card */
        .details-card {
            background: #fff;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            margin-bottom: 24px;
            text-align: left;
        }
        .details-card h3 {
            color: #4b2c2c; font-size: 15px;
            margin-bottom: 16px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0e0e0;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 9px 0;
            border-bottom: 1px solid #f5f0f0;
            font-size: 14px;
        }
        .detail-row:last-child { border-bottom: none; }
        .detail-row .dlabel { color: #888; display: flex; align-items: center; gap: 8px; }
        .detail-row .dlabel i { color: #c17f4a; width: 14px; }
        .detail-row .dvalue { color: #4b2c2c; font-weight: 600; text-align: right; max-width: 60%; }

        /* Status Badge */
        .status-badge {
            background: #fff3cd;
            color: #856404;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        /* Booking ID */
        .booking-id {
            background: #f0e8e8;
            color: #4b2c2c;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 700;
        }

        /* Buttons */
        .btn-row { display: flex; gap: 12px; flex-wrap: wrap; }
        .btn-primary {
            flex: 1;
            padding: 13px;
            background: #4b2c2c;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            text-align: center;
            transition: 0.2s;
        }
        .btn-primary:hover { background: #c17f4a; }
        .btn-outline {
            flex: 1;
            padding: 13px;
            background: #fff;
            color: #4b2c2c;
            border: 2px solid #4b2c2c;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            text-align: center;
            transition: 0.2s;
        }
        .btn-outline:hover { background: #f0e8e8; }
    </style>
</head>
<body>

<div class="wrapper">

    <!-- Success Icon -->
    <div class="success-icon">
        <i class="fa-solid fa-check"></i>
    </div>

    <h2>Booking Confirmed!</h2>
    <p class="subtitle">Your booking has been placed successfully. The provider will contact you soon.</p>

    <!-- Booking Details -->
    <div class="details-card">
        <h3><i class="fa-solid fa-receipt"></i> Booking Details</h3>

        <div class="detail-row">
            <span class="dlabel"><i class="fa-solid fa-hashtag"></i> Booking ID</span>
            <span class="dvalue">
                <span class="booking-id">#<?php echo $booking['booking_id']; ?></span>
            </span>
        </div>

        <div class="detail-row">
            <span class="dlabel"><i class="fa-solid fa-screwdriver-wrench"></i> Service</span>
            <span class="dvalue"><?php echo $booking['service_name']; ?></span>
        </div>

        <div class="detail-row">
            <span class="dlabel"><i class="fa-solid fa-user-gear"></i> Provider</span>
            <span class="dvalue"><?php echo $booking['serviceprovider_name']; ?></span>
        </div>

        <div class="detail-row">
            <span class="dlabel"><i class="fa-solid fa-location-dot"></i> City</span>
            <span class="dvalue"><?php echo $booking['city']; ?></span>
        </div>

        <div class="detail-row">
            <span class="dlabel"><i class="fa-solid fa-calendar"></i> Booking Date</span>
            <span class="dvalue"><?php echo date('d M Y', strtotime($booking['booking_date'])); ?></span>
        </div>

        <div class="detail-row">
            <span class="dlabel"><i class="fa-solid fa-house"></i> Address</span>
            <span class="dvalue"><?php echo $booking['address']; ?></span>
        </div>

        <div class="detail-row">
            <span class="dlabel"><i class="fa-solid fa-tag"></i> Charges</span>
            <span class="dvalue">Rs <?php echo number_format($booking['started_at'], 0); ?> / sq.ft</span>
        </div>

        <div class="detail-row">
            <span class="dlabel"><i class="fa-solid fa-circle-info"></i> Status</span>
            <span class="dvalue">
                <span class="status-badge">⏳ <?php echo $booking['status']; ?></span>
            </span>
        </div>

    </div>

    <!-- Buttons -->
    <div class="btn-row">
        <a href="../services.php" class="btn-outline">
            <i class="fa-solid fa-arrow-left"></i> Back to Services
        </a>
        <a href="../index.php" class="btn-primary">
            <i class="fa-solid fa-house"></i> Go to Home
        </a>
    </div>

</div>

</body>
</html>