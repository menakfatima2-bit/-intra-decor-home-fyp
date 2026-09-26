<?php
session_start();
include "db.php";

$service_id = intval($_GET['id']);

// Service + provider info fetch — call_number + whatsapp_number bhi
$query = "SELECT a.*, p.phone, p.call_number, p.whatsapp_number, p.profile_image, u.is_approved
          FROM addservice a
          LEFT JOIN providerprofile p ON a.serviceprovider_id = p.provider_id
          LEFT JOIN users u ON a.serviceprovider_id = u.id
          WHERE a.service_id = '$service_id'";
$result = mysqli_query($conn, $query);
$data   = mysqli_fetch_assoc($result);

if(!$data){
    echo "<p style='text-align:center;margin-top:50px;'>Service not found.</p>";
    exit();
}

$gallery_q = mysqli_query($conn, "SELECT * FROM service_gallery WHERE service_id='$service_id'");
$images = [];
while($img = mysqli_fetch_assoc($gallery_q)){
    $images[] = $img['image_path'];
}

// WhatsApp number format
$wa_num = $data['whatsapp_number'] ?? $data['phone'] ?? '';
$wa = preg_replace('/[^0-9]/', '', $wa_num);
if(substr($wa,0,1)=='0') $wa = '92'.substr($wa,1);

// Call number
$call_num = $data['call_number'] ?? $data['phone'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['serviceprovider_name']; ?> — Provider Profile</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { background: #f5f0f0; }
        .profile-wrapper { max-width: 1000px; margin: 30px auto; padding: 0 20px 60px; }

        .back-link {
            display: inline-flex; align-items: center; gap: 8px;
            color: #4b2c2c; text-decoration: none; font-size: 14px;
            margin-bottom: 20px; font-weight: 600; transition: 0.2s;
        }
        .back-link:hover { color: #c17f4a; }

        /* Provider Info Card */
        .provider-info-card {
            background: #fff; border-radius: 16px; padding: 28px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            display: flex; gap: 24px; align-items: flex-start;
            margin-bottom: 28px; flex-wrap: wrap;
        }

        .provider-avatar {
            width: 90px; height: 90px; border-radius: 50%;
            overflow: hidden; background: #4b2c2c;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 36px; flex-shrink: 0;
            border: 3px solid #c17f4a;
        }
        .provider-avatar img { width: 100%; height: 100%; object-fit: cover; }

        .provider-details { flex: 1; min-width: 220px; }
        .name-row { display: flex; align-items: center; gap: 10px; margin-bottom: 6px; flex-wrap: wrap; }
        .name-row h2 { color: #4b2c2c; font-size: 22px; margin: 0; }

        .verified-badge {
            background: #e8f5e9; color: #2e7d32;
            font-size: 12px; font-weight: 600; padding: 4px 10px;
            border-radius: 20px; display: inline-flex; align-items: center; gap: 4px;
        }

        .service-title { color: #c17f4a; font-size: 14px; font-weight: 600; margin-bottom: 14px; }

        .meta-list { list-style: none; padding: 0; margin: 0 0 16px; }
        .meta-list li {
            display: flex; align-items: center; gap: 10px;
            font-size: 14px; color: #555; margin-bottom: 8px;
        }
        .meta-list li i { color: #c17f4a; width: 16px; text-align: center; }

        /* Contact Buttons */
        .contact-btns { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 4px; }

        .btn-call {
            display: inline-flex; align-items: center; gap: 8px;
            background: #4b2c2c; color: #fff;
            padding: 10px 20px; border-radius: 25px;
            text-decoration: none; font-size: 14px; font-weight: 600;
            transition: 0.2s; box-shadow: 0 3px 10px rgba(75,44,44,0.3);
        }
        .btn-call:hover { background: #6b3d3d; transform: translateY(-2px); }

        .btn-whatsapp {
            display: inline-flex; align-items: center; gap: 8px;
            background: #25d366; color: #fff;
            padding: 10px 20px; border-radius: 25px;
            text-decoration: none; font-size: 14px; font-weight: 600;
            transition: 0.2s; box-shadow: 0 3px 10px rgba(37,211,102,0.35);
        }
        .btn-whatsapp:hover { background: #1da851; transform: translateY(-2px); }

        /* Charge Box */
        .charge-box {
            background: #4b2c2c; color: #fff;
            border-radius: 12px; padding: 18px 24px;
            text-align: center; min-width: 150px; flex-shrink: 0;
        }
        .charge-box .label { font-size: 12px; color: #c0a0a0; margin-bottom: 6px; }
        .charge-box .amount { font-size: 28px; font-weight: 700; }
        .charge-box .per { font-size: 12px; color: #c17f4a; margin-top: 4px; }

        /* Description */
        .desc-card {
            background: #fff; border-radius: 16px; padding: 24px 28px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08); margin-bottom: 28px;
        }
        .desc-card h3 {
            color: #4b2c2c; font-size: 16px; margin: 0 0 12px;
            border-bottom: 2px solid #f0e0e0; padding-bottom: 8px;
        }
        .desc-card p { color: #555; font-size: 14px; line-height: 1.8; margin: 0; }

        /* Gallery */
        .gallery-card {
            background: #fff; border-radius: 16px; padding: 24px 28px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08); margin-bottom: 28px;
        }
        .gallery-card h3 {
            color: #4b2c2c; font-size: 16px; margin: 0 0 18px;
            border-bottom: 2px solid #f0e0e0; padding-bottom: 8px;
            display: flex; align-items: center; gap: 8px;
        }
        .gallery-card h3 .count {
            margin-left: auto; font-size: 12px; color: #aaa;
            font-weight: 400; background: #f5f0f0;
            padding: 3px 10px; border-radius: 12px;
        }

        .main-img-box {
            width: 100%; height: 380px; border-radius: 12px;
            overflow: hidden; margin-bottom: 12px; background: #f0e8e8;
            cursor: zoom-in; position: relative;
        }
        .main-img-box img { width: 100%; height: 100%; object-fit: cover; transition: 0.3s; }
        .main-img-box:hover img { transform: scale(1.03); }

        .thumb-row { display: flex; gap: 10px; flex-wrap: wrap; }
        .thumb-row img {
            width: 80px; height: 70px; object-fit: cover; border-radius: 8px;
            cursor: pointer; border: 3px solid transparent; transition: 0.2s;
        }
        .thumb-row img:hover,
        .thumb-row img.active { border-color: #c17f4a; transform: scale(1.05); }

        .no-gallery { text-align: center; padding: 40px; color: #aaa; font-size: 14px; }
        .no-gallery i { font-size: 36px; display: block; margin-bottom: 10px; }

        /* Action Buttons Row */
        .action-row { display: flex; gap: 12px; flex-wrap: wrap; }

        .book-btn {
            flex: 1;
            display: block; text-align: center;
            background: #c17f4a; color: #fff;
            padding: 16px; border-radius: 12px;
            font-size: 16px; font-weight: 600;
            text-decoration: none; transition: 0.2s;
            box-shadow: 0 4px 15px rgba(193,127,74,0.4);
        }
        .book-btn:hover { background: #4b2c2c; }
        .book-btn i { margin-right: 8px; }

        @media(max-width: 600px){
            .provider-info-card { flex-direction: column; }
            .charge-box { width: 100%; }
            .main-img-box { height: 220px; }
            .action-row { flex-direction: column; }
        }
    </style>
</head>
<body>

<div class="profile-wrapper">

    <a href="services.php" class="back-link">
        <i class="fa-solid fa-arrow-left"></i> Back to Services
    </a>

    <!-- Provider Info -->
    <div class="provider-info-card">

        <!-- Avatar -->
        <div class="provider-avatar">
            <?php if(!empty($data['profile_image'])){ ?>
            <img src="uploads/<?php echo $data['profile_image']; ?>" alt="Profile">
            <?php } else { ?>
            <i class="fa-solid fa-user-gear"></i>
            <?php } ?>
        </div>

        <div class="provider-details">

            <div class="name-row">
                <h2><?php echo $data['serviceprovider_name']; ?></h2>
                <?php if(!empty($data['is_approved']) && $data['is_approved'] == 1){ ?>
                <span class="verified-badge">
                    <i class="fa-solid fa-circle-check"></i> Verified
                </span>
                <?php } ?>
            </div>

            <div class="service-title">
                <i class="fa-solid fa-screwdriver-wrench"></i>
                <?php echo $data['service_name']; ?>
            </div>

            <ul class="meta-list">
                <li><i class="fa-solid fa-location-dot"></i> <?php echo $data['city']; ?></li>
                <li><i class="fa-solid fa-star"></i> <?php echo $data['experience']; ?> years experience</li>
                <li>
                    <i class="fa-solid fa-circle" style="color:<?php echo $data['status']=='Active'?'#2ecc71':'#e74c3c';?>;font-size:10px;"></i>
                    <?php echo $data['status']; ?>
                </li>
            </ul>

            <!-- Contact Buttons -->
            <div class="contact-btns">
                <?php if(!empty($call_num)){ ?>
                <a href="tel:<?php echo $call_num; ?>" class="btn-call">
                    <i class="fa-solid fa-phone"></i> Call Now
                </a>
                <?php } ?>

                <?php if(!empty($wa)){ ?>
                <a href="https://wa.me/<?php echo $wa; ?>?text=Hi! I found your <?php echo urlencode($data['service_name']); ?> service on Intra Decor Home."
                   target="_blank" class="btn-whatsapp">
                    <i class="fa-brands fa-whatsapp"></i> WhatsApp
                </a>
                <?php } ?>
            </div>

            <?php if(!empty($call_num) || !empty($wa_num)){ ?>
            <p style="margin-top:10px; color:rgba(255,255,255,0.85); font-size:14px; font-weight:600; letter-spacing:0.5px;">
                <?php if(!empty($call_num)){ ?>
                    <i class="fa-solid fa-phone" style="margin-right:6px;"></i> Call: <?php echo htmlspecialchars($call_num); ?>
                <?php } ?>
                <?php if(!empty($wa_num) && $wa_num !== $call_num){ ?>
                    &nbsp;&nbsp;|&nbsp;&nbsp;<i class="fa-brands fa-whatsapp" style="margin-right:6px;"></i> WhatsApp: <?php echo htmlspecialchars($wa_num); ?>
                <?php } ?>
            </p>
            <?php } ?>

        </div>

        <!-- Charges -->
        <div class="charge-box">
            <div class="label">Work Charges</div>
            <div class="amount">Rs <?php echo number_format($data['started_at'], 0); ?></div>
            <div class="per">per square foot</div>
        </div>

    </div>

    <!-- Description -->
    <div class="desc-card">
        <h3><i class="fa-solid fa-align-left"></i> About This Service</h3>
        <p><?php echo nl2br($data['service_description']); ?></p>
    </div>

    <!-- Work Gallery -->
    <div class="gallery-card">
        <h3>
            <i class="fa-solid fa-images"></i> Previous Work Gallery
            <span class="count"><?php echo count($images); ?> photos</span>
        </h3>

        <?php if(count($images) > 0){ ?>
        <div class="main-img-box" onclick="openLb(0)">
            <img id="mainImg" src="uploads/<?php echo $images[0]; ?>" alt="Work Image">
        </div>
        <div class="thumb-row">
            <?php foreach($images as $i => $img){ ?>
            <img src="uploads/<?php echo $img; ?>"
                 onclick="changeImg(this,<?php echo $i; ?>)"
                 class="<?php echo $i==0?'active':''; ?>"
                 alt="Gallery <?php echo $i+1; ?>">
            <?php } ?>
        </div>
        <?php } else { ?>
        <div class="no-gallery">
            <i class="fa-solid fa-image"></i>
            No work images uploaded yet.
        </div>
        <?php } ?>
    </div>

    <!-- Action Buttons -->
    <?php if($data['status'] == 'Active'){ ?>
    <div class="action-row">
        <a href="serviceproviderdashboard/bookservice.php?id=<?php echo $service_id; ?>" class="book-btn">
            <i class="fa-solid fa-calendar-check"></i> Book This Service
        </a>
    </div>
    <?php } else { ?>
    <div style="text-align:center;padding:16px;background:#fdecea;border-radius:12px;color:#e74c3c;font-size:14px;">
        <i class="fa-solid fa-circle-xmark"></i> This service is currently unavailable.
    </div>
    <?php } ?>

</div>

<!-- Lightbox -->
<div id="lb" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.9);z-index:9999;align-items:center;justify-content:center;" onclick="closeLb()">
    <span style="position:absolute;top:20px;right:28px;color:#fff;font-size:30px;cursor:pointer;">&times;</span>
    <img id="lbImg" src="" style="max-width:92vw;max-height:90vh;border-radius:10px;object-fit:contain;">
</div>

<script>
const imgs = <?php echo json_encode($images); ?>;
let current = 0;

function changeImg(el, idx){
    document.getElementById('mainImg').src = el.src;
    document.querySelectorAll('.thumb-row img').forEach(i => i.classList.remove('active'));
    el.classList.add('active');
    current = idx;
}

function openLb(idx){
    current = idx;
    document.getElementById('lbImg').src = 'uploads/' + imgs[current];
    const lb = document.getElementById('lb');
    lb.style.display = 'flex';
}

function closeLb(){
    document.getElementById('lb').style.display = 'none';
}
</script>

</body>
</html>