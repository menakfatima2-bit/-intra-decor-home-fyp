<?php
session_start();
include "../db.php";

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'service_provider'){
    header("Location: ../login.php");
    exit();
}

if(isset($_POST['add_service'])){

    $provider_id   = $_SESSION['user_id'];
    $provider_name = $_SESSION['user_name'];
    $service_name  = $_POST['service_name'];
    $description   = $_POST['description'];
    $price_start   = $_POST['price_start'];
    $status        = $_POST['status'];
    $city          = $_POST['city'];
    $area          = $_POST['area'];
    $experience    = $_POST['experience'];
    $phone         = $_POST['phone'];

    $full_location = $city;
    if(!empty($area)){
        $full_location = $city . ' - ' . $area;
    }

    $query = "INSERT INTO addservice 
              (serviceprovider_id, serviceprovider_name, service_name,
               service_description, started_at, experience, city, status)
              VALUES
              ('$provider_id','$provider_name','$service_name',
               '$description','$price_start','$experience','$full_location','$status')";

    if(mysqli_query($conn, $query)){
        $service_id = mysqli_insert_id($conn);

        $check = mysqli_query($conn, "SELECT * FROM providerprofile WHERE provider_id='$provider_id'");
        if(mysqli_num_rows($check) > 0){
            mysqli_query($conn, "UPDATE providerprofile SET phone='$phone', city='$full_location' WHERE provider_id='$provider_id'");
        } else {
            $userQ = mysqli_query($conn, "SELECT name, email FROM users WHERE id='$provider_id'");
            $uData = mysqli_fetch_assoc($userQ);
            mysqli_query($conn, "INSERT INTO providerprofile (provider_id, name, email, phone, city) 
                                 VALUES ('$provider_id','{$uData['name']}','{$uData['email']}','$phone','$full_location')");
        }

        if(!empty($_FILES['images']['name'][0])){
            $total = count($_FILES['images']['name']);
            for($i = 0; $i < $total; $i++){
                if($_FILES['images']['error'][$i] == 0){
                    $img_name = time().'_'.$i.'_'.basename($_FILES['images']['name'][$i]);
                    $img_tmp  = $_FILES['images']['tmp_name'][$i];
                    $img_dest = "../uploads/".$img_name;
                    if(move_uploaded_file($img_tmp, $img_dest)){
                        mysqli_query($conn, "INSERT INTO service_gallery (service_id, image_path) VALUES ('$service_id', '$img_name')");
                    }
                }
            }
        }

        echo "<script>alert('Service Added Successfully!'); window.location='servicelist.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error: ".mysqli_error($conn)."');</script>";
    }
}

$existingProfile = mysqli_fetch_assoc(mysqli_query($conn, "SELECT phone FROM providerprofile WHERE provider_id='{$_SESSION['user_id']}'"));
$existing_phone = $existingProfile['phone'] ?? '';

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
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="addservice.css?v=10">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<title>Add Service</title>
<style>
.upload-box {
    border: 2px dashed #ffa502; padding: 30px 20px; text-align: center;
    border-radius: 10px; background: #fff8ef; cursor: pointer;
    width: 100%; box-sizing: border-box; transition: 0.2s;
}
.upload-box:hover { background: #fff2e0; border-color: #e69500; }
.upload-box .upload-icon { font-size: 36px; color: #ffa502; margin-bottom: 10px; }
.upload-box p { margin: 0 0 4px; font-weight: 600; color: #333; font-size: 15px; }
.upload-box span { color: #777; font-size: 13px; }
.upload-count {
    margin-top: 10px; background: #ffa502; color: #fff;
    padding: 4px 14px; border-radius: 20px; font-size: 13px; font-weight: 600; display: none;
}
.gallery-preview { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 14px; }
.preview-box { position: relative; width: 120px; height: 120px; }
.preview-box img { width: 120px; height: 120px; object-fit: cover; border-radius: 10px; border: 2px solid #ffa502; }
.remove-btn {
    position: absolute; top: -8px; right: -8px; background: #ff4757; color: #fff;
    font-size: 11px; width: 22px; height: 22px; border-radius: 50%;
    cursor: pointer; display: flex; align-items: center; justify-content: center; font-weight: bold;
}
.remove-btn:hover { background: #c0392b; }
#area-row { display: none; }
</style>
</head>
<body>

<div class="container">

<div class="sidebar">
    <h2><i class="fa-solid fa-user-gear"></i> Service Provider</h2>
    <ul>
        <li><a href="serviceprovider.php"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>
        <li><a href="addservice.php" class="active"><i class="fa-solid fa-plus"></i> Add Service</a></li>
        <li><a href="servicelist.php"><i class="fa-solid fa-list"></i> My Services</a></li>
        <li><a href="mybookings.php"><i class="fa-solid fa-calendar-check"></i> My Bookings</a></li>
        <li><a href="providerprofile.php"><i class="fa-solid fa-user"></i> Profile</a></li>
        <li><a href="../logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
    </ul>
</div>

<h2>Add New Service</h2>

<form action="addservice.php" method="POST" enctype="multipart/form-data">

    <label>Service Name</label>
    <input type="text" name="service_name" placeholder="Enter service name" required>

    <label>Description</label>
    <textarea name="description" placeholder="Describe your service..." required></textarea>

    <label>Price (per sq.ft)</label>
    <input type="number" name="price_start" placeholder="Rs per sq.ft" required>

    <label>Status</label>
    <select name="status" required>
        <option value="Active">Active</option>
        <option value="Inactive">Inactive</option>
    </select>

    <label>Experience</label>
    <input type="text" name="experience" placeholder="Years of experience" required>

    <label>City</label>
    <select name="city" id="city-select" required>
        <option value="" disabled selected>Select City</option>
        <?php foreach(array_keys($city_areas) as $city){ ?>
        <option value="<?php echo $city; ?>"><?php echo $city; ?></option>
        <?php } ?>
    </select>

    <div id="area-row">
        <label>Area <small style="color:#999;font-weight:400;">(Optional)</small></label>
        <select name="area" id="area-select">
            <option value="">-- Select Area --</option>
        </select>
    </div>

    <label>WhatsApp / Phone Number</label>
    <input type="tel" name="phone"
           placeholder="03XXXXXXXXX"
           value="<?php echo $existing_phone; ?>"
           required>

    <label>Work Gallery<br><small style="color:#999;font-weight:400;">(Max 5 images)</small></label>

    <div>
        <div class="upload-box" onclick="document.getElementById('images').click();">
            <div class="upload-icon"><i class="fa-solid fa-images"></i></div>
            <p>Click to Upload Work Images</p>
            <span>JPG, PNG supported &nbsp;|&nbsp; Max 5 images</span>
            <span class="upload-count" id="uploadCount"></span>
        </div>
        <input type="file" id="images" name="images[]" multiple accept="image/*" style="display:none;">
        <div class="gallery-preview" id="preview"></div>
    </div>

    <button type="submit" name="add_service">
        <i class="fa-solid fa-plus"></i> Add Service
    </button>

</form>
</div>

<script>
const cityAreas = <?php echo json_encode($city_areas); ?>;

document.getElementById('city-select').addEventListener('change', function(){
    const city = this.value;
    const areaRow    = document.getElementById('area-row');
    const areaSelect = document.getElementById('area-select');
    if(city && cityAreas[city]){
        areaSelect.innerHTML = '<option value="">-- Select Area --</option>';
        cityAreas[city].forEach(area => {
            areaSelect.innerHTML += `<option value="${area}">${area}</option>`;
        });
        areaRow.style.display = 'block';
    } else {
        areaRow.style.display = 'none';
    }
});

const imageInput  = document.getElementById('images');
const preview     = document.getElementById('preview');
const uploadCount = document.getElementById('uploadCount');

imageInput.addEventListener('change', function(){
    preview.innerHTML = '';
    let files = Array.from(this.files).slice(0, 5);
    uploadCount.style.display = files.length > 0 ? 'inline-block' : 'none';
    uploadCount.textContent = files.length + ' image(s) selected';
    files.forEach(file => {
        const reader = new FileReader();
        reader.onload = function(e){
            const box = document.createElement('div');
            box.classList.add('preview-box');
            const img = document.createElement('img');
            img.src = e.target.result;
            box.appendChild(img);
            preview.appendChild(box);
        };
        reader.readAsDataURL(file);
    });
});
</script>

</body>
</html>