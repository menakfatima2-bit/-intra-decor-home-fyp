<?php
session_start();
header('Content-Type: application/json');
include 'db.php';

// Cleanup old previews (older than 30 mins) to save disk space
$preview_dir = 'uploads/designer_previews/';
if (is_dir($preview_dir)) {
    foreach (glob($preview_dir . 'preview_*.jpg') as $file) {
        if (filemtime($file) < time() - 1800) {
            @unlink($file);
        }
    }
}

$wall_texture = isset($_GET['wall_texture']) ? trim($_GET['wall_texture']) : '';
$floor_texture = isset($_GET['floor_texture']) ? trim($_GET['floor_texture']) : '';

$wall_product_id = isset($_GET['wall_product_id']) ? intval($_GET['wall_product_id']) : 0;
$floor_product_id = isset($_GET['floor_product_id']) ? intval($_GET['floor_product_id']) : 0;
$wall_price = isset($_GET['wall_price']) ? floatval($_GET['wall_price']) : 0;
$floor_price = isset($_GET['floor_price']) ? floatval($_GET['floor_price']) : 0;

if (empty($wall_texture) && empty($floor_texture)) {
    $product_image = isset($_GET['product_image']) ? trim($_GET['product_image']) : '';
    $category = isset($_GET['category']) ? trim($_GET['category']) : '';
    if (!empty($product_image)) {
        if (strtolower($category) === 'tiles') {
            $floor_texture = $product_image;
        } else {
            $wall_texture = $product_image;
        }
    }
}

if (empty($wall_texture) && empty($floor_texture)) {
    echo json_encode(["success" => false, "error" => "Either wall_texture or floor_texture is required"]);
    exit;
}

$base_dir = __DIR__;

$allowed_rooms = [
    'default'     => 'assets/images/room.jpeg',
    'bedroom'     => 'assets/images/rooms/bedroom.jpg',
    'livingroom'  => 'assets/images/rooms/livingroom.jpg',
    'kitchen'     => 'assets/images/rooms/kitchen.jpg',
    'washroom'    => 'assets/images/rooms/washroom.jpg',
];

$room_key = isset($_GET['room']) ? trim($_GET['room']) : 'default';
if (!array_key_exists($room_key, $allowed_rooms)) {
    $room_key = 'default';
}

$room_relative = $allowed_rooms[$room_key];
$room_path = $base_dir . '/' . $room_relative;

if (!file_exists($room_path)) {
    $room_key = 'default';
    $room_relative = $allowed_rooms['default'];
    $room_path = $base_dir . '/' . $room_relative;
}

if (!file_exists($room_path)) {
    $room_relative = 'room.png';
    $room_path = $base_dir . '/room.png';
}

if (!file_exists($room_path)) {
    echo json_encode(["success" => false, "error" => "Sample room image not found on the server"]);
    exit;
}

function resolve_texture($base_dir, $image_path) {
    if (empty($image_path)) return '';
    $path = $base_dir . '/' . $image_path;
    if (!file_exists($path)) {
        if (strpos($image_path, 'uploads/') === 0) {
            $path = $base_dir . '/' . $image_path;
        } else {
            $path = $base_dir . '/uploads/' . $image_path;
        }
    }
    return file_exists($path) ? $path : '';
}

$wall_abs = resolve_texture($base_dir, $wall_texture);
$floor_abs = resolve_texture($base_dir, $floor_texture);

if (!empty($wall_texture) && empty($wall_abs)) {
    echo json_encode(["success" => false, "error" => "Wall texture image not found: " . $wall_texture]);
    exit;
}
if (!empty($floor_texture) && empty($floor_abs)) {
    echo json_encode(["success" => false, "error" => "Floor texture image not found: " . $floor_texture]);
    exit;
}

$output_filename = 'preview_' . uniqid() . '.jpg';
$output_relative = 'uploads/designer_previews/' . $output_filename;
$output_path = $base_dir . '/' . $output_relative;

if (!is_dir($preview_dir)) {
    mkdir($preview_dir, 0777, true);
}

// ---------------------------------------------------------------------
// CHANGED: instead of shell_exec() on a local Python install, we now
// call the Room Designer API hosted on Render.
// Set this to your actual deployed Render URL (no trailing slash).
// ---------------------------------------------------------------------
$api_url = 'https://menakfatima.pythonanywhere.com/process';

$post_fields = [
    'room' => new CURLFile($room_path)
];
if (!empty($wall_abs)) {
    $post_fields['wall_texture'] = new CURLFile($wall_abs);
}
if (!empty($floor_abs)) {
    $post_fields['floor_texture'] = new CURLFile($floor_abs);
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $api_url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 90); // Render free tier can be slow to "wake up"
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: multipart/form-data']);

$result = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curl_error = curl_error($ch);
curl_close($ch);

if ($result === false) {
    echo json_encode(["success" => false, "error" => "Failed to reach design API: " . $curl_error]);
    exit;
}

if ($http_code !== 200) {
    // API returned an error (JSON body with "error" field)
    $err_json = json_decode($result, true);
    $err_msg = $err_json['error'] ?? ('API returned HTTP ' . $http_code);
    echo json_encode(["success" => false, "error" => $err_msg]);
    exit;
}

// Success: $result is raw JPEG bytes — save it locally
if (file_put_contents($output_path, $result) === false) {
    echo json_encode(["success" => false, "error" => "Failed to save result image"]);
    exit;
}

$response = [
    "success" => true,
    "result_path" => $output_relative,
    "room_path" => $room_relative,
    "mode" => "remote_api"
];

$_SESSION['last_design'] = [
    'room_key'          => $room_key,
    'room_path'         => $room_relative,
    'wall_texture'      => $wall_texture,
    'floor_texture'     => $floor_texture,
    'wall_product_id'   => $wall_product_id,
    'floor_product_id'  => $floor_product_id,
    'wall_price'        => $wall_price,
    'floor_price'       => $floor_price,
    'result_path'       => $output_relative,
];

echo json_encode($response);
?>
