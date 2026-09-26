<?php
session_start();
include "../db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT b.*, a.serviceprovider_name, a.service_name as svc_name,
                 p.phone as provider_phone
          FROM booking b
          LEFT JOIN addservice a ON b.service_id = a.service_id
          LEFT JOIN providerprofile p ON b.provider_id = p.provider_id
          WHERE b.user_id='$user_id'
          ORDER BY b.booking_id DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>
    <link rel="stylesheet" href="userdashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
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

        .booking-info h3 {
            color: #4b2c2c; font-size: 16px; margin: 0 0 10px;
        }
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

        .btn-whatsapp {
            background: #25d366; color: #fff;
            padding: 8px 18px; border-radius: 8px;
            text-decoration: none; font-size: 13px; font-weight: 600;
            display: inline-flex; align-items: center; gap: 6px;
            transition: 0.2s;
        }
        .btn-whatsapp:hover { background: #1da851; }

        .no-bookings {
            text-align: center; padding: 60px 20px; color: #aaa;
        }
        .no-bookings i { font-size: 48px; display: block; margin-bottom: 14px; color: #ddd; }

        h2 { color: #4b2c2c; margin-bottom: 24px; }
    </style>
</head>
<body>

<?php include "notifications_bell.php"; ?>
<div class="dashboard-wrapper">

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Intra Decor</h2>
        <a href="userdashboard.php"><i class="fa fa-home"></i> Dashboard</a>
        <a href="../cart.php"><i class="fa fa-cart-shopping"></i> My Cart</a>
        <a href="favorites.php"><i class="fa fa-heart"></i> Favorites</a>
        <a href="myorders.php"><i class="fa fa-box"></i> My Orders</a>
        <a href="MybookingUser.php" class="active"><i class="fa fa-calendar-check"></i> My Bookings</a>
        <a href="userprofile.php"><i class="fa fa-user"></i> Profile</a>
        <a href="../logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="main-content">
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
            $wa = preg_replace('/[^0-9]/', '', $b['provider_phone'] ?? '');
            if(substr($wa,0,1)=='0') $wa = '92'.substr($wa,1);
            $wa_msg = urlencode("Hi! I want to follow up on my booking for {$b['service_name']} on {$b['booking_date']}.");
        ?>
        <div class="booking-card <?php echo $status_class; ?>">

            <div class="booking-info">
                <h3><i class="fa-solid fa-screwdriver-wrench"></i>
                    <?php echo $b['svc_name'] ?? $b['service_name']; ?>
                </h3>

                <span class="status-badge badge-<?php echo $status_class; ?>">
                    <?php
                    if($status_class == 'pending')  echo '⏳ Pending';
                    if($status_class == 'accepted') echo '✅ Accepted';
                    if($status_class == 'rejected') echo '❌ Rejected';
                    ?>
                </span>

                <ul class="info-list">
                    <li><i class="fa-solid fa-user-gear"></i>
                        Provider: <?php echo $b['serviceprovider_name'] ?? 'N/A'; ?>
                    </li>
                    <li><i class="fa-solid fa-calendar"></i>
                        Date: <?php echo date('d M Y', strtotime($b['booking_date'])); ?>
                    </li>
                    <li><i class="fa-solid fa-location-dot"></i>
                        Address: <?php echo $b['address']; ?>
                    </li>
                    <li><i class="fa-solid fa-clock"></i>
                        Booked on: <?php echo date('d M Y', strtotime($b['created_at'])); ?>
                    </li>
                </ul>
            </div>

            <?php if(!empty($wa)){ ?>
            <a href="https://wa.me/<?php echo $wa; ?>?text=<?php echo $wa_msg; ?>"
               target="_blank" class="btn-whatsapp">
                <i class="fa-brands fa-whatsapp"></i> Contact Provider
            </a>
            <?php } ?>

        </div>
        <?php } ?>

        <?php } else { ?>
        <div class="no-bookings">
            <i class="fa-solid fa-calendar-xmark"></i>
            <p>No bookings yet.</p>
            <a href="../services.php" style="color:#c17f4a;font-weight:600;">
                Find Service Providers →
            </a>
        </div>
        <?php } ?>

    </div>
</div>
</body>
</html>