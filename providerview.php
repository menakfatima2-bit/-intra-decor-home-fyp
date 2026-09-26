<?php
session_start();
include "db.php";

$service_id = intval($_GET['id']);

// call_number + whatsapp_number bhi fetch karo
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

// WhatsApp number — whatsapp_number pehle, phir phone fallback
$wa_num   = !empty($data['whatsapp_number']) ? $data['whatsapp_number'] : ($data['phone'] ?? '');
$wa_phone = preg_replace('/[^0-9]/', '', $wa_num);
if(substr($wa_phone, 0, 1) == '0') $wa_phone = '92'.substr($wa_phone, 1);

// Call number — call_number pehle, phir phone fallback
$call_num = !empty($data['call_number']) ? $data['call_number'] : ($data['phone'] ?? '');
$phone    = $data['phone'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['serviceprovider_name']; ?> — Provider Profile</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --brown:#4b2c2c; --brown2:#7a4040; --gold:#c17f4a;
            --gold2:#e8a96a; --cream:#f9f4ef; --white:#ffffff;
            --text:#3a2a2a; --muted:#8a7070; --border:#edddd4;
            --shadow:0 8px 32px rgba(75,44,44,0.12);
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { background:var(--cream); font-family:'DM Sans',sans-serif; color:var(--text); }
        .page { min-height:100vh; }
        .content-wrap { max-width:960px; margin:0 auto; padding:32px 24px 80px; }

        .back-link {
            display:inline-flex; align-items:center; gap:8px;
            color:var(--brown); text-decoration:none; font-size:13px; font-weight:500;
            margin-bottom:28px; opacity:0.7; transition:0.2s;
        }
        .back-link:hover { opacity:1; color:var(--gold); }

        .hero {
            background:var(--brown); border-radius:24px; overflow:hidden;
            margin-bottom:20px; box-shadow:var(--shadow); position:relative;
        }
        .hero::before {
            content:''; position:absolute; width:320px; height:320px;
            background:radial-gradient(circle,rgba(193,127,74,0.15) 0%,transparent 70%);
            top:-80px; right:-80px; border-radius:50%;
        }
        .hero-inner {
            display:flex; gap:32px; padding:36px 36px 32px;
            align-items:center; position:relative; z-index:1; flex-wrap:wrap;
        }

        .avatar-wrap { position:relative; flex-shrink:0; }
        .avatar {
            width:108px; height:108px; border-radius:50%;
            border:3px solid rgba(255,255,255,0.2); overflow:hidden;
            background:var(--brown2); display:flex; align-items:center; justify-content:center;
            box-shadow:0 8px 24px rgba(0,0,0,0.3);
        }
        .avatar img { width:100%; height:100%; object-fit:cover; }
        .avatar i { color:rgba(255,255,255,0.5); font-size:44px; }
        .verified-ring {
            position:absolute; bottom:4px; right:4px; background:#2ecc71;
            width:24px; height:24px; border-radius:50%; border:2px solid var(--brown);
            display:flex; align-items:center; justify-content:center;
        }
        .verified-ring i { color:#fff; font-size:11px; }

        .hero-info { flex:1; min-width:200px; }
        .provider-name { font-family:'Playfair Display',serif; font-size:28px; color:#fff; margin-bottom:4px; }
        .service-pill {
            display:inline-flex; align-items:center; gap:6px;
            background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.15);
            color:var(--gold2); padding:5px 14px; border-radius:20px;
            font-size:12px; font-weight:600; margin-bottom:16px;
            text-transform:uppercase; letter-spacing:0.8px;
        }
        .hero-stats { display:flex; gap:20px; flex-wrap:wrap; margin-bottom:18px; }
        .stat-item { display:flex; align-items:center; gap:7px; color:rgba(255,255,255,0.75); font-size:13px; }
        .stat-item i { color:var(--gold2); font-size:12px; }

        /* Contact Buttons */
        .contact-btns { display:flex; gap:10px; flex-wrap:wrap; }

        .visible-number {
            margin-top: 10px;
            color: rgba(255,255,255,0.85);
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .visible-number i { color: var(--gold2); margin-right: 6px; }

        .btn-call {
            display:inline-flex; align-items:center; gap:8px;
            background:#fff; color:var(--brown);
            padding:10px 20px; border-radius:25px;
            text-decoration:none; font-size:13px; font-weight:700;
            transition:0.2s; box-shadow:0 3px 12px rgba(0,0,0,0.2);
        }
        .btn-call:hover { background:#f0e8e8; transform:translateY(-2px); }
        .btn-call i { color:var(--brown); }

        .btn-whatsapp {
            display:inline-flex; align-items:center; gap:8px;
            background:#25d366; color:#fff;
            padding:10px 20px; border-radius:25px;
            text-decoration:none; font-size:13px; font-weight:600;
            transition:0.2s; box-shadow:0 3px 12px rgba(37,211,102,0.4);
        }
        .btn-whatsapp:hover { background:#1da851; transform:translateY(-2px); }

        .charge-box {
            background:rgba(0,0,0,0.2); border:1px solid rgba(255,255,255,0.1);
            border-radius:18px; padding:24px 28px; text-align:center;
            min-width:150px; flex-shrink:0; backdrop-filter:blur(10px);
        }
        .charge-label { font-size:10px; color:rgba(255,255,255,0.4); text-transform:uppercase; letter-spacing:1.5px; margin-bottom:8px; }
        .charge-amount { font-family:'Playfair Display',serif; font-size:34px; font-weight:700; color:#fff; line-height:1; }
        .charge-unit { font-size:11px; color:var(--gold2); margin-top:6px; }

        .card {
            background:var(--white); border-radius:20px; padding:28px 30px;
            margin-bottom:20px; box-shadow:0 2px 16px rgba(75,44,44,0.07);
            border:1px solid rgba(193,127,74,0.08);
        }
        .card-title {
            font-family:'Playfair Display',serif; font-size:17px; color:var(--brown);
            margin-bottom:16px; padding-bottom:12px; border-bottom:1px solid var(--border);
            display:flex; align-items:center; gap:10px;
        }
        .card-title i { color:var(--gold); font-size:15px; }
        .card-title .count {
            margin-left:auto; font-family:'DM Sans',sans-serif; font-size:12px;
            color:var(--muted); font-weight:400; background:var(--cream);
            padding:3px 10px; border-radius:12px;
        }
        .about-text { color:#5a4a4a; font-size:14px; line-height:1.9; font-weight:300; }

        .main-img-wrap {
            width:100%; height:420px; border-radius:14px; overflow:hidden;
            margin-bottom:14px; cursor:zoom-in; background:var(--cream); position:relative;
        }
        .main-img-wrap img { width:100%; height:100%; object-fit:cover; transition:transform 0.5s; }
        .main-img-wrap:hover img { transform:scale(1.04); }
        .zoom-hint {
            position:absolute; bottom:14px; right:14px; background:rgba(0,0,0,0.5);
            color:#fff; font-size:11px; padding:5px 12px; border-radius:20px;
            display:flex; align-items:center; gap:5px; backdrop-filter:blur(6px);
        }
        .thumb-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(85px,1fr)); gap:10px; }
        .thumb-item {
            position:relative; cursor:pointer; border-radius:10px; overflow:hidden;
            border:2.5px solid transparent; transition:0.2s; aspect-ratio:1;
        }
        .thumb-item img { width:100%; height:100%; object-fit:cover; transition:transform 0.3s; }
        .thumb-item:hover { border-color:var(--gold2); }
        .thumb-item:hover img { transform:scale(1.08); }
        .thumb-item.active { border-color:var(--gold); box-shadow:0 0 0 3px rgba(193,127,74,0.25); }
        .thumb-num { position:absolute; bottom:4px; right:6px; font-size:10px; font-weight:600; color:#fff; text-shadow:0 1px 4px rgba(0,0,0,0.6); }

        .no-gallery { text-align:center; padding:50px 20px; color:var(--muted); }
        .no-gallery i { font-size:40px; display:block; margin-bottom:12px; color:var(--border); }

        .book-btn {
            display:flex; align-items:center; justify-content:center; gap:12px;
            background:linear-gradient(135deg,var(--gold) 0%,#a85e30 100%);
            color:#fff; padding:20px; border-radius:16px; text-decoration:none;
            font-size:17px; font-weight:600; transition:0.3s;
            box-shadow:0 8px 24px rgba(193,127,74,0.4);
        }
        .book-btn:hover {
            background:linear-gradient(135deg,var(--brown) 0%,var(--brown2) 100%);
            transform:translateY(-3px);
        }
        .book-btn i { font-size:20px; }

        .unavailable-box {
            text-align:center; padding:20px; background:#fdecea;
            border-radius:16px; color:#c0392b; font-size:15px; border:1px solid #f5c6cb;
        }

        .lightbox {
            display:none; position:fixed; inset:0; background:rgba(0,0,0,0.92);
            z-index:9999; align-items:center; justify-content:center; cursor:zoom-out;
        }
        .lightbox.show { display:flex; }
        .lightbox-img { max-width:92vw; max-height:90vh; border-radius:12px; object-fit:contain; }
        .lb-close { position:absolute; top:20px; right:24px; color:rgba(255,255,255,0.7); font-size:28px; cursor:pointer; }
        .lb-close:hover { color:#fff; }
        .lb-nav {
            position:absolute; top:50%; transform:translateY(-50%);
            background:rgba(255,255,255,0.12); color:#fff; border:none; border-radius:50%;
            width:48px; height:48px; font-size:18px; cursor:pointer;
            display:flex; align-items:center; justify-content:center;
        }
        .lb-prev { left:20px; } .lb-next { right:20px; }

        @media(max-width:640px){
            .hero-inner { flex-direction:column; text-align:center; padding:28px 20px; }
            .hero-stats { justify-content:center; }
            .contact-btns { justify-content:center; }
            .charge-box { width:100%; }
            .main-img-wrap { height:240px; }
            .content-wrap { padding:20px 16px 60px; }
        }
    </style>
</head>
<body>
<div class="page">
<div class="content-wrap">

    <a href="services.php" class="back-link">
        <i class="fa-solid fa-arrow-left"></i> Back to Services
    </a>

    <!-- Hero -->
    <div class="hero">
        <div class="hero-inner">

            <div class="avatar-wrap">
                <div class="avatar">
                    <?php if(!empty($data['profile_image'])){ 
                        $pic = $data['profile_image'];
                        $src = (str_starts_with($pic, 'http')) ? $pic : 'uploads/' . $pic;
                    ?>
                    <img src="<?php echo $src; ?>" alt="Profile">
                    <?php } else { ?>
                    <div class="avatar-initials" style="width:100%;height:100%;border-radius:50%;background:#ffa502;display:flex;align-items:center;justify-content:center;font-size:36px;font-weight:700;color:#fff;">
                        <?php echo strtoupper(substr($data['serviceprovider_name'],0,1)); ?>
                    </div>
                    <?php } ?>
                </div>
                <?php if($data['is_approved'] == 1){ ?>
                <div class="verified-ring" title="Verified Provider">
                    <i class="fa-solid fa-check"></i>
                </div>
                <?php } ?>
            </div>

            <div class="hero-info">
                <h1 class="provider-name"><?php echo $data['serviceprovider_name']; ?></h1>
                <div class="service-pill">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                    <?php echo $data['service_name']; ?>
                </div>

                <div class="hero-stats">
                    <span class="stat-item"><i class="fa-solid fa-location-dot"></i> <?php echo $data['city']; ?></span>
                    <span class="stat-item"><i class="fa-solid fa-star"></i> <?php echo $data['experience']; ?> yrs exp</span>
                    <span class="stat-item">
                        <i class="fa-solid fa-circle" style="color:<?php echo $data['status']=='Active'?'#2ecc71':'#e74c3c';?>;font-size:8px;"></i>
                        <?php echo $data['status']; ?>
                    </span>
                </div>

                <!-- Call + WhatsApp Buttons -->
                <div class="contact-btns">
                    <?php if(!empty($call_num)){ ?>
                    <a href="tel:<?php echo $call_num; ?>" class="btn-call">
                        <i class="fa-solid fa-phone"></i> Call Now
                    </a>
                    <?php } ?>

                    <?php if(!empty($wa_phone)){ ?>
                    <a href="https://wa.me/<?php echo $wa_phone; ?>?text=Hi! I saw your <?php echo urlencode($data['service_name']); ?> service on Intra Decor Home. Can we discuss?"
                       target="_blank" class="btn-whatsapp">
                        <i class="fa-brands fa-whatsapp"></i> WhatsApp
                    </a>
                    <?php } ?>
                </div>

                <?php if(!empty($call_num) || !empty($wa_num)){ ?>
                <p class="visible-number">
                    <?php if(!empty($call_num)){ ?>
                        <i class="fa-solid fa-phone"></i> Call: <?php echo htmlspecialchars($call_num); ?>
                    <?php } ?>
                    <?php if(!empty($wa_num) && $wa_num !== $call_num){ ?>
                        &nbsp;&nbsp;|&nbsp;&nbsp;<i class="fa-brands fa-whatsapp"></i> WhatsApp: <?php echo htmlspecialchars($wa_num); ?>
                    <?php } ?>
                </p>
                <?php } ?>
            </div>

            <div class="charge-box">
                <div class="charge-label">Work Charges</div>
                <div class="charge-amount">Rs <?php echo number_format($data['started_at'],0); ?></div>
                <div class="charge-unit">per square foot</div>
            </div>

        </div>
    </div>

    <!-- About -->
    <div class="card">
        <div class="card-title"><i class="fa-solid fa-align-left"></i> About This Service</div>
        <p class="about-text"><?php echo nl2br($data['service_description']); ?></p>
    </div>

    <!-- Gallery -->
    <div class="card">
        <div class="card-title">
            <i class="fa-solid fa-images"></i> Previous Work Gallery
            <span class="count"><?php echo count($images); ?> photos</span>
        </div>

        <?php if(count($images) > 0){ ?>
        <div class="main-img-wrap" onclick="openLb(0)">
            <img id="mainImg" src="uploads/<?php echo $images[0]; ?>" alt="Work">
            <div class="zoom-hint"><i class="fa-solid fa-magnifying-glass-plus"></i> Click to enlarge</div>
        </div>
        <div class="thumb-grid">
            <?php foreach($images as $i => $img){ ?>
            <div class="thumb-item <?php echo $i==0?'active':''; ?>"
                 onclick="changeImg(this,'<?php echo $img; ?>',<?php echo $i; ?>)">
                <img src="uploads/<?php echo $img; ?>" alt="Photo <?php echo $i+1; ?>">
                <span class="thumb-num"><?php echo $i+1; ?></span>
            </div>
            <?php } ?>
        </div>
        <?php } else { ?>
        <div class="no-gallery">
            <i class="fa-solid fa-image"></i>
            No work images uploaded yet.
        </div>
        <?php } ?>
    </div>

    <!-- Book -->
    <?php if($data['status'] == 'Active'){ ?>
    <a href="serviceproviderdashboard/bookservice.php?id=<?php echo $service_id; ?>" class="book-btn">
        <i class="fa-solid fa-calendar-check"></i> Book This Service
    </a>
    <?php } else { ?>
    <div class="unavailable-box">
        <i class="fa-solid fa-circle-xmark"></i> This service is currently unavailable.
    </div>
    <?php } ?>

</div>
</div>

<!-- Lightbox -->
<div class="lightbox" id="lb" onclick="closeLb(event)">
    <span class="lb-close" onclick="closeLb()">&times;</span>
    <button class="lb-nav lb-prev" onclick="lbNav(-1,event)"><i class="fa-solid fa-chevron-left"></i></button>
    <img class="lightbox-img" id="lbImg" src="" alt="">
    <button class="lb-nav lb-next" onclick="lbNav(1,event)"><i class="fa-solid fa-chevron-right"></i></button>
</div>

<script>
const imgs = <?php echo json_encode($images); ?>;
let current = 0;

function changeImg(el, img, idx){
    document.getElementById('mainImg').src = 'uploads/' + img;
    document.querySelectorAll('.thumb-item').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
    current = idx;
}

function openLb(idx){
    current = idx;
    document.getElementById('lbImg').src = 'uploads/' + imgs[current];
    document.getElementById('lb').classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeLb(e){
    if(!e || e.target === document.getElementById('lb') || e.target.classList.contains('lb-close')){
        document.getElementById('lb').classList.remove('show');
        document.body.style.overflow = '';
    }
}

function lbNav(dir, e){
    e.stopPropagation();
    current = (current + dir + imgs.length) % imgs.length;
    document.getElementById('lbImg').src = 'uploads/' + imgs[current];
}

document.addEventListener('keydown', function(e){
    if(document.getElementById('lb').classList.contains('show')){
        if(e.key==='ArrowRight') lbNav(1,{stopPropagation:()=>{}});
        if(e.key==='ArrowLeft')  lbNav(-1,{stopPropagation:()=>{}});
        if(e.key==='Escape') closeLb();
    }
});
</script>

</body>
</html>