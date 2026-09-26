<?php
/**
 * ============================================================
 *  IntraDecor Home — Fix Provider Avatars (Real Images)
 *  Run: http://localhost:8080/fyp-home/fix_avatars.php
 *  Delete after running!
 * ============================================================
 */

$host = "YOUR_DB_HOST";
$user = "if0_42479335";
$pass = "YOUR_DB_PASSWORD";
$db   = "if0_42479335_intradecorhome";

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) die("DB connection failed: " . mysqli_connect_error());

// 15 real provider images in uploads folder
$images = [];
for ($i = 1; $i <= 15; $i++) {
    $images[] = "provider{$i}.png";
}

// Get all dummy providers (intradecor.com email)
$result = mysqli_query($conn, "SELECT provider_id, name FROM providerprofile WHERE provider_id IN (SELECT id FROM users WHERE role='service_provider' AND email LIKE '%@intradecor.com')");

$updated = 0;
$log = [];
$img_counter = 0;

while ($row = mysqli_fetch_assoc($result)) {
    $id       = $row['provider_id'];
    $img_name = $images[$img_counter % count($images)]; // rotate through 15 images

    $update = "UPDATE providerprofile SET profile_image='".mysqli_real_escape_string($conn, $img_name)."' WHERE provider_id='$id'";

    if (mysqli_query($conn, $update)) {
        $updated++;
        $log[] = "✅ " . $row['name'] . " → " . $img_name;
    } else {
        $log[] = "❌ Error: " . $row['name'] . " — " . mysqli_error($conn);
    }

    $img_counter++;
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Avatar Fix — IntraDecor</title>
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: Arial, sans-serif; background: #f0f0f0; padding: 40px 20px; }
.wrap { max-width: 800px; margin: auto; }
.box { background: #fff; border-radius: 10px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin-bottom: 20px; }
h2 { color: #2e7d32; margin-bottom: 16px; }
.stat { background: #8B2500; color: #fff; padding: 16px 28px; border-radius: 10px; font-size: 26px; font-weight: 700; display: inline-block; margin-bottom: 16px; }
.stat span { display: block; font-size: 13px; font-weight: 400; margin-top: 4px; }
pre { background: #1a1a1a; color: #d4d4d4; padding: 16px; border-radius: 8px; font-size: 12px; max-height: 400px; overflow-y: auto; line-height: 1.8; }
.warn { background: #fff3e0; border-left: 4px solid #ffa502; padding: 14px 18px; border-radius: 6px; font-size: 14px; margin-top: 16px; }
</style>
</head>
<body>
<div class="wrap">
    <div class="box">
        <h2>✅ Provider Images Updated!</h2>
        <div class="stat"><?= $updated ?><span>Providers Updated</span></div>
        <div class="warn">
            ⚠️ <strong>Delete this file after running!</strong> Remove <code>fyp-home/fix_avatars.php</code>
        </div>
    </div>
    <div class="box">
        <h3 style="margin-bottom:12px;">Log:</h3>
        <pre><?= implode("\n", $log) ?></pre>
    </div>
</div>
</body>
</html>