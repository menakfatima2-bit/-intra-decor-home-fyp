<?php
session_start();
include "db.php";

$categories = ['Paint','Tiles','Wallpaper','Wall Panelling'];

$city_areas = [
    'Lahore'      => ['DHA','Gulberg','Johar Town','Bahria Town'],
    'Karachi'     => ['DHA Karachi','Clifton','Gulshan-e-Iqbal','Saddar'],
    'Islamabad'   => ['F-7','F-10','Bahria Town','DHA Islamabad'],
    'Rawalpindi'  => ['Bahria Town','Saddar','Westridge','Satellite Town'],
    'Faisalabad'  => ['Gulberg','Madina Town','Canal Road','Susan Road'],
    'Multan'      => ['Cantt','Gulgasht','Shah Rukn-e-Alam','New Multan'],
    'Gujranwala'  => ['GT Road','Satellite Town','Model Town','Peoples Colony'],
    'Sialkot'     => ['Cantt','Allama Iqbal Road','Hajipura','Paris Road'],
    'Peshawar'    => ['Hayatabad','University Road','Cantt','Saddar'],
    'Quetta'      => ['Cantt','Satellite Town','Jinnah Road','Sariab Road'],
    'Sheikhupura' => ['Sheikhupura City','Housing Colony','Ghang Road','Bhikhi Road'],
    'Farooqabad'  => ['Farooqabad City','GT Road','Railway Road','New Town'],
];

$selected_city     = isset($_GET['city'])     ? $_GET['city']     : '';
$selected_area     = isset($_GET['area'])     ? $_GET['area']     : '';
$selected_category = isset($_GET['category']) ? $_GET['category'] : '';

$providers = [];

// Always fetch providers
$where = "u.is_approved=1 AND a.status='Active'";

if($selected_city != ''){
    if($selected_area != ''){
        $where .= " AND (a.city='$selected_city - $selected_area' OR a.city='$selected_area')";
    } else {
        $where .= " AND (a.city='$selected_city' OR a.city LIKE '$selected_city - %')";
    }
}

if($selected_category != ''){
    $where .= " AND (a.category='$selected_category' OR a.service_name LIKE '%$selected_category%')";
}

$query = "SELECT a.*, p.phone, p.profile_image
          FROM addservice a
          LEFT JOIN providerprofile p ON a.serviceprovider_id = p.provider_id
          LEFT JOIN users u ON a.serviceprovider_id = u.id
          WHERE $where
          ORDER BY a.service_id DESC";
$result = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result)){
    $providers[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services — Intra Decor Home</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { background: #f5f0f0; }
        .page-wrapper { max-width: 1200px; margin: 0 auto; padding: 30px 20px 60px; }
        .page-title { color: #4b2c2c; font-size: 26px; margin-bottom: 24px; font-weight: 700; }
        .filter-bar {
            background: #fff; border-radius: 16px; padding: 18px 24px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08); display: flex;
            align-items: center; gap: 16px; flex-wrap: wrap; margin-bottom: 30px;
        }
        .filter-group { display: flex; align-items: center; gap: 10px; }
        .filter-group label {
            font-weight: 600; color: #4b2c2c; font-size: 13px;
            white-space: nowrap; display: flex; align-items: center; gap: 6px;
        }
        .filter-bar select {
            padding: 10px 16px; border-radius: 10px; border: 2px solid #e0c9c9;
            font-size: 14px; color: #4b2c2c; cursor: pointer; outline: none;
            min-width: 170px; background: #fff; font-family: inherit;
        }
        .filter-bar select:focus { border-color: #c17f4a; }
        .divider { width: 1px; height: 36px; background: #e8d8d8; }
        .result-info {
            color: #666; font-size: 14px; margin-bottom: 20px;
            display: flex; align-items: center; gap: 8px;
        }
        .result-badge {
            background: #4b2c2c; color: #fff;
            padding: 3px 10px; border-radius: 20px; font-size: 12px; font-weight: 600;
        }
        .providers-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 24px;
        }
        .provider-card {
            background: #fff; border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.07); overflow: hidden;
            transition: transform 0.25s, box-shadow 0.25s;
        }
        .provider-card:hover { transform: translateY(-6px); box-shadow: 0 12px 30px rgba(0,0,0,0.13); }
        .card-top {
            background: linear-gradient(135deg, #4b2c2c 0%, #7a4040 100%);
            padding: 28px 20px 20px;
            display: flex; flex-direction: column; align-items: center;
            position: relative;
        }
        .profile-circle {
            width: 90px; height: 90px; border-radius: 50%;
            border: 4px solid rgba(255,255,255,0.3); overflow: hidden;
            background: #6b3d3d; display: flex; align-items: center; justify-content: center;
            margin-bottom: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }
        .profile-circle img { width: 100%; height: 100%; object-fit: cover; }
        .profile-circle i { color: #fff; font-size: 38px; }
        .card-top h3 { color: #fff; font-size: 17px; font-weight: 700; margin: 0 0 4px; text-align: center; }
        .card-service-tag {
            background: rgba(255,255,255,0.15); color: #ffd9a0;
            padding: 4px 14px; border-radius: 20px; font-size: 12px; font-weight: 600;
        }
        .verified-tag {
            position: absolute; top: 12px; right: 12px;
            background: #2ecc71; color: #fff;
            font-size: 11px; font-weight: 600;
            padding: 3px 10px; border-radius: 20px;
            display: flex; align-items: center; gap: 4px;
        }
        .card-body { padding: 18px; }
        .card-meta { list-style: none; padding: 0; margin: 0 0 14px; }
        .card-meta li {
            font-size: 13px; color: #555; display: flex; align-items: center; gap: 10px;
            padding: 6px 0; border-bottom: 1px solid #f5f0f0;
        }
        .card-meta li:last-child { border-bottom: none; }
        .card-meta li i { color: #c17f4a; width: 14px; text-align: center; font-size: 13px; }
        .charge-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; }
        .charge-badge {
            background: #4b2c2c; color: #fff;
            padding: 6px 16px; border-radius: 20px; font-size: 13px; font-weight: 700;
        }
        .whatsapp-mini {
            display: inline-flex; align-items: center; gap: 6px;
            background: #25d366; color: #fff; padding: 6px 14px; border-radius: 20px;
            font-size: 12px; font-weight: 600; text-decoration: none; transition: 0.2s;
        }
        .whatsapp-mini:hover { background: #1da851; }
        .view-btn {
            display: block; text-align: center; background: #c17f4a; color: #fff;
            padding: 12px; border-radius: 10px; text-decoration: none;
            font-size: 14px; font-weight: 600; transition: 0.2s;
        }
        .view-btn:hover { background: #4b2c2c; }
        .no-result { text-align: center; padding: 60px 20px; color: #aaa; font-size: 15px; }
        .no-result i { font-size: 44px; display: block; margin-bottom: 12px; color: #ddd; }
        @media(max-width:600px){
            .filter-bar { flex-direction: column; align-items: flex-start; }
            .filter-bar select { width: 100%; }
            .divider { display: none; }
        }
    </style>
</head>
<body>

<div class="container">
<div class="topheader">
    <div class="headerleftside">
        <div class="logo-box"><img src="assets/images/logo.png" alt="Logo"/></div>
        <div class="search-box">
            <form action="search.php" method="GET" style="display:contents;">
                <input type="text" name="q" placeholder="Search products & services..." value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>" autocomplete="off">
                <i class="fa-solid fa-magnifying-glass" style="cursor:pointer;" onclick="this.closest('form').submit()"></i>
            </form>
        </div>
    </div>
    <div class="headerrightside">
        <div class="user-menu">
            <?php if (isset($_SESSION['user_id'])) { ?>
                <a class="login" href="logout.php">Logout</a>
            <?php } else { ?>
                <a class="login" href="signup.php">Login/Signup</a>
            <?php } ?>
            <a class="my-account" href="userdashboard/userdashboard.php"><i class="fa-solid fa-user"></i> My Account</a>
        </div>
        <div class="cart-box">
            <a href="cart.php">
                <i class="fa-solid fa-cart-shopping"></i>
                <span class="cart-text">Cart</span>
            </a>
        </div>
    </div>
    <div class="hamburger"><i class="fa-solid fa-bars"></i></div>
</div>
<div class="bottomheader">
    <a href="index.php" class="nav-btn">Home</a>
    <a href="paint.php" class="nav-btn">Paint Visualizer</a>
    <a href="Tiles.php" class="nav-btn">Tiles</a>
    <a href="wallpaper.php" class="nav-btn">Wallpaper</a>
    <a href="wallpenals.php" class="nav-btn">Wall Panelling</a>
    <a href="services.php" class="nav-btn active">Services</a>
    <a href="room-preview.php" class="nav-btn">AI Room Designer</a>
</div>
</div>

<div class="page-wrapper">

    <h2 class="page-title">
        <i class="fa-solid fa-screwdriver-wrench"></i> Find Service Providers
    </h2>

    <form method="GET" action="services.php" id="filterForm">
        <div class="filter-bar">
            <div class="filter-group">
                <label><i class="fa-solid fa-city"></i> City:</label>
                <select name="city" id="city-select">
                    <option value="">-- All Cities --</option>
                    <?php foreach(array_keys($city_areas) as $city){ ?>
                    <option value="<?php echo $city; ?>"
                        <?php if($selected_city == $city) echo 'selected'; ?>>
                        <?php echo $city; ?>
                    </option>
                    <?php } ?>
                </select>
            </div>

            <div class="divider" id="area-divider" style="<?php echo $selected_city ? '' : 'display:none'; ?>"></div>

            <div class="filter-group" id="area-group" style="<?php echo $selected_city ? '' : 'display:none'; ?>">
                <label><i class="fa-solid fa-location-dot"></i> Area:</label>
                <select name="area" id="area-select">
                    <option value="">-- All Areas --</option>
                    <?php
                    if($selected_city && isset($city_areas[$selected_city])){
                        foreach($city_areas[$selected_city] as $area){
                            $sel = ($selected_area == $area) ? 'selected' : '';
                            echo "<option value='$area' $sel>$area</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="divider"></div>

            <div class="filter-group">
                <label><i class="fa-solid fa-layer-group"></i> Service:</label>
                <select name="category" id="cat-select">
                    <option value="">-- All Services --</option>
                    <?php foreach($categories as $cat){ ?>
                    <option value="<?php echo $cat; ?>"
                        <?php if($selected_category == $cat) echo 'selected'; ?>>
                        <?php echo $cat; ?>
                    </option>
                    <?php } ?>
                </select>
            </div>

            <button type="submit" style="display:none;">Search</button>
        </div>
    </form>

    <!-- Result Info -->
    <p class="result-info">
        <span class="result-badge"><?php echo count($providers); ?></span>
        provider(s) found
        <?php if($selected_city){ echo " in <b>".($selected_area ?: $selected_city)."</b>"; } ?>
        <?php if($selected_category){ echo " for <b>$selected_category</b>"; } ?>
    </p>

    <!-- Providers Grid -->
    <?php if(count($providers) > 0){ ?>
    <div class="providers-grid">
        <?php foreach($providers as $p){
            $phone = $p['phone'] ?? '';
            $wa = preg_replace('/[^0-9]/', '', $phone);
            if(substr($wa,0,1)=='0') $wa = '92'.substr($wa,1);
        ?>
        <div class="provider-card">
            <div class="card-top">
                <div class="verified-tag"><i class="fa-solid fa-circle-check"></i> Verified</div>
                <div class="profile-circle">
                    <?php if(!empty($p['profile_image'])){
                        $pic = $p['profile_image'];
                        $src = (str_starts_with($pic, 'http')) ? $pic : 'uploads/' . $pic;
                    ?>
                    <img src="<?php echo $src; ?>" alt="Profile" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
                    <?php } else { ?>
                    <div style="width:100%;height:100%;border-radius:50%;background:#ffa502;display:flex;align-items:center;justify-content:center;font-size:28px;font-weight:700;color:#fff;">
                        <?php echo strtoupper(substr($p['serviceprovider_name'],0,1)); ?>
                    </div>
                    <?php } ?>
                </div>
                <h3><?php echo $p['serviceprovider_name']; ?></h3>
                <span class="card-service-tag">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                    <?php echo $p['service_name']; ?>
                </span>
            </div>
            <div class="card-body">
                <ul class="card-meta">
                    <li><i class="fa-solid fa-location-dot"></i> <?php echo $p['city']; ?></li>
                    <li><i class="fa-solid fa-phone"></i> <?php echo $phone ?: 'Not provided'; ?></li>
                    <li><i class="fa-solid fa-star"></i> <?php echo $p['experience']; ?> years experience</li>
                    <li><i class="fa-solid fa-align-left"></i> <?php echo substr($p['service_description'],0,60); ?>...</li>
                </ul>
                <div class="charge-row">
                    <span class="charge-badge">
                        <i class="fa-solid fa-tag"></i>
                        Rs <?php echo number_format($p['started_at'],0); ?> / sq.ft
                    </span>
                    <?php if(!empty($wa)){ ?>
                    <a href="https://wa.me/<?php echo $wa; ?>?text=Hi! I found your service on Intra Decor Home."
                       target="_blank" class="whatsapp-mini">
                        <i class="fa-brands fa-whatsapp"></i> Chat
                    </a>
                    <?php } ?>
                </div>
                <a href="providerview.php?id=<?php echo $p['service_id']; ?>" class="view-btn">
                    <i class="fa-solid fa-eye"></i> View Full Profile & Gallery
                </a>
            </div>
        </div>
        <?php } ?>
    </div>

    <?php } else { ?>
    <div class="no-result">
        <i class="fa-solid fa-circle-xmark"></i>
        No providers found
        <?php if($selected_city){ echo " in <b>".($selected_area ?: $selected_city)."</b>"; } ?>
    </div>
    <?php } ?>

</div>

<script>
const cityAreas = <?php echo json_encode($city_areas); ?>;
const citySelect  = document.getElementById('city-select');
const areaGroup   = document.getElementById('area-group');
const areaDivider = document.getElementById('area-divider');
const areaSelect  = document.getElementById('area-select');
const catSelect   = document.getElementById('cat-select');
const form        = document.getElementById('filterForm');

citySelect.addEventListener('change', function(){
    const city = this.value;
    if(city && cityAreas[city]){
        areaSelect.innerHTML = '<option value="">-- All Areas --</option>';
        cityAreas[city].forEach(area => {
            areaSelect.innerHTML += `<option value="${area}">${area}</option>`;
        });
        areaGroup.style.display   = 'flex';
        areaDivider.style.display = 'block';
    } else {
        areaGroup.style.display   = 'none';
        areaDivider.style.display = 'none';
    }
    form.submit();
});

areaSelect.addEventListener('change', function(){ form.submit(); });
catSelect.addEventListener('change', function(){ form.submit(); });

const hamburger = document.querySelector('.hamburger');
const nav = document.querySelector('.bottomheader');
if(hamburger) hamburger.addEventListener('click', ()=>{ nav.classList.toggle('active'); });
</script>

</body>
</html>