<?php
session_start();
include "../db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$userQuery  = "SELECT name,email FROM users WHERE id='$user_id'";
$userResult = mysqli_query($conn,$userQuery);
$userData   = mysqli_fetch_assoc($userResult);

$query      = "SELECT * FROM providerprofile WHERE provider_id='$user_id'";
$result     = mysqli_query($conn,$query);
$profileData= mysqli_fetch_assoc($result);

if(isset($_POST['save_profile'])){

    $phone           = $_POST['phone'];
    $call_number     = $_POST['call_number'];
    $whatsapp_number = $_POST['whatsapp_number'];
    $city            = $_POST['city'];

    $profile_image = isset($profileData['profile_image']) ? $profileData['profile_image'] : '';

    if(isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0){
        $img_name  = time().'_'.basename($_FILES['profile_image']['name']);
        $img_tmp   = $_FILES['profile_image']['tmp_name'];
        $img_dest  = "../uploads/".$img_name;
        if(move_uploaded_file($img_tmp, $img_dest)){
            $profile_image = $img_name;
        }
    }

    if($profileData){
        $update = "UPDATE providerprofile 
                   SET phone='$phone', call_number='$call_number', 
                       whatsapp_number='$whatsapp_number',
                       city='$city', profile_image='$profile_image'
                   WHERE provider_id='$user_id'";
        mysqli_query($conn,$update);
    } else {
        $insert = "INSERT INTO providerprofile 
                   (provider_id, name, email, phone, call_number, whatsapp_number, city, profile_image)
                   VALUES
                   ('$user_id','{$userData['name']}','{$userData['email']}',
                    '$phone','$call_number','$whatsapp_number','$city','$profile_image')";
        mysqli_query($conn,$insert);
    }

    header("Location: providerprofile.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Service Provider Profile</title>
<link rel="stylesheet" href="providerprofile.css?v=2">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
.profile-img-box {
    display: flex; align-items: center; gap: 20px;
    margin-bottom: 20px; padding: 16px;
    background: #f9f4f4; border-radius: 12px;
}
.profile-img-box img {
    width: 90px; height: 90px; border-radius: 50%;
    object-fit: cover; border: 3px solid #ffa502;
}
.profile-img-box .avatar-placeholder {
    width: 90px; height: 90px; border-radius: 50%;
    background: #4b2c2c; display: flex; align-items: center;
    justify-content: center; color: #fff; font-size: 32px;
    border: 3px solid #ffa502; flex-shrink: 0;
}
.upload-label {
    display: inline-flex; align-items: center; gap: 8px;
    background: #ffa502; color: #fff; padding: 8px 18px;
    border-radius: 8px; cursor: pointer; font-size: 13px;
    font-weight: 600; transition: 0.2s;
}
.upload-label:hover { background: #e69500; }
.field-note {
    font-size: 11px; color: #999; margin-top: 4px;
    display: block;
}
</style>
</head>

<body>

<div class="sidebar">
    <h2><i class="fa-solid fa-user-gear"></i> Service Provider</h2>
    <ul>
        <li><a href="serviceprovider.php"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>
        <li><a href="addservice.php"><i class="fa-solid fa-plus"></i> Add Service</a></li>
        <li><a href="servicelist.php"><i class="fa-solid fa-list"></i> My Services</a></li>
        <li><a href="mybookings.php"><i class="fa-solid fa-calendar-check"></i> My Bookings</a></li>
        <li><a href="providerprofile.php" class="active"><i class="fa-solid fa-user"></i> Profile</a></li>
        <li><a href="../logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
    </ul>
</div>

<div class="main-content">
<div class="container">

<form method="POST" enctype="multipart/form-data">

<h2>Service Provider Profile</h2>

<!-- Profile Image -->
<div class="profile-img-box">
    <?php if(!empty($profileData['profile_image'])){ ?>
    <img src="../uploads/<?php echo $profileData['profile_image']; ?>" alt="Profile">
    <?php } else { ?>
    <div class="avatar-placeholder">
        <i class="fa-solid fa-user"></i>
    </div>
    <?php } ?>
    <div>
        <label class="upload-label" for="profile_image">
            <i class="fa-solid fa-camera"></i> Upload Profile Photo
        </label>
        <input type="file" id="profile_image" name="profile_image"
               accept="image/*" style="display:none;"
               onchange="previewImg(this)">
        <p style="font-size:12px;color:#999;margin-top:6px;">JPG, PNG supported</p>
    </div>
</div>

<!-- Name -->
<div class="input-group">
    <i class="fa fa-user"></i>
    <input type="text" value="<?php echo $userData['name']; ?>" readonly>
</div>

<!-- Email -->
<div class="input-group">
    <i class="fa fa-envelope"></i>
    <input type="email" value="<?php echo $userData['email']; ?>" readonly>
</div>

<!-- Call Number -->
<div class="input-group">
    <i class="fa fa-phone"></i>
    <input type="tel" name="call_number"
           value="<?php echo isset($profileData['call_number']) ? $profileData['call_number'] : ''; ?>"
           placeholder="Call Number — 03XXXXXXXXX">
    <span class="field-note">📞 This number will be used on the "Call Now" button</span>
</div>

<!-- WhatsApp Number -->
<div class="input-group">
    <i class="fa-brands fa-whatsapp"></i>
    <input type="tel" name="whatsapp_number"
           value="<?php echo isset($profileData['whatsapp_number']) ? $profileData['whatsapp_number'] : ''; ?>"
           placeholder="WhatsApp Number — 03XXXXXXXXX">
    <span class="field-note">💬 This number will be used on the "WhatsApp" button</span>
</div>

<!-- Phone (existing) -->
<div class="input-group">
    <i class="fa fa-mobile"></i>
    <input type="tel" name="phone"
           value="<?php echo isset($profileData['phone']) ? $profileData['phone'] : ''; ?>"
           placeholder="General Phone — 03XXXXXXXXX">
</div>

<!-- City -->
<div class="input-group">
    <i class="fa fa-city"></i>
    <input type="text" name="city"
           value="<?php echo isset($profileData['city']) ? $profileData['city'] : ''; ?>"
           placeholder="Your city" required>
</div>

<button type="submit" name="save_profile">Save Profile</button>

</form>
</div>
</div>

<script>
function previewImg(input){
    if(input.files && input.files[0]){
        const reader = new FileReader();
        reader.onload = function(e){
            const box = document.querySelector('.profile-img-box');
            let img = box.querySelector('img');
            let placeholder = box.querySelector('.avatar-placeholder');
            if(placeholder) placeholder.remove();
            if(!img){
                img = document.createElement('img');
                img.style.cssText = 'width:90px;height:90px;border-radius:50%;object-fit:cover;border:3px solid #ffa502;';
                box.insertBefore(img, box.firstChild);
            }
            img.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

</body>
</html>