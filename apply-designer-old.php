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

// Optional: which product IDs are active (used only to remember the last combo in session for Add-to-Cart)
$wall_product_id = isset($_GET['wall_product_id']) ? intval($_GET['wall_product_id']) : 0;
$floor_product_id = isset($_GET['floor_product_id']) ? intval($_GET['floor_product_id']) : 0;
$wall_price = isset($_GET['wall_price']) ? floatval($_GET['wall_price']) : 0;
$floor_price = isset($_GET['floor_price']) ? floatval($_GET['floor_price']) : 0;

// Backwards compatibility: fallback to single parameter logic
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

// Room selection (supports multiple base room photos)
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

// Helper to resolve texture paths
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

// Generate unique output filename
$output_filename = 'preview_' . uniqid() . '.jpg';
$output_relative = 'uploads/designer_previews/' . $output_filename;
$output_path = $base_dir . '/' . $output_relative;

if (!is_dir($preview_dir)) {
    mkdir($preview_dir, 0777, true);
}

$python_path = 'C:\\Users\\Lenvovo\\AppData\\Local\\Programs\\Python\\Python312\\python.exe';
$script_path = $base_dir . '\\ai_room_designer.py';

$output = '';
$cmd = '';

if (!empty($wall_abs) && !empty($floor_abs)) {
    // Both wall and floor textures selected -> Sequential execution
    $temp_filename = 'temp_preview_' . uniqid() . '.jpg';
    $temp_path = $base_dir . '/uploads/designer_previews/' . $temp_filename;

    $cmd1 = sprintf(
        '"%s" "%s" --room "%s" --texture "%s" --output "%s" --target "wall" 2>&1',
        $python_path,
        $script_path,
        $room_path,
        $wall_abs,
        $temp_path
    );
    $output1 = shell_exec($cmd1);
    file_put_contents($base_dir . '/designer_cmd.log', "TIMESTAMP: " . date('Y-m-d H:i:s') . "\nCOMMAND 1 (Wall): " . $cmd1 . "\nOUTPUT: " . $output1 . "\n-------------------\n\n", FILE_APPEND);

    if (empty($output1) || strpos($output1, '"success": true') === false) {
        @unlink($temp_path);
        echo json_encode(["success" => false, "error" => "Failed to apply wall texture. " . $output1]);
        exit;
    }

    $cmd2 = sprintf(
        '"%s" "%s" --room "%s" --texture "%s" --output "%s" --target "floor" 2>&1',
        $python_path,
        $script_path,
        $temp_path,
        $floor_abs,
        $output_path
    );
    $output2 = shell_exec($cmd2);
    file_put_contents($base_dir . '/designer_cmd.log', "TIMESTAMP: " . date('Y-m-d H:i:s') . "\nCOMMAND 2 (Floor): " . $cmd2 . "\nOUTPUT: " . $output2 . "\n-------------------\n\n", FILE_APPEND);

    @unlink($temp_path);

    $output = $output2;
    $cmd = $cmd2;
} else {
    $input_path = $room_path;
    $texture_to_apply = !empty($wall_abs) ? $wall_abs : $floor_abs;
    $target_area = !empty($wall_abs) ? 'wall' : 'floor';

    $cmd = sprintf(
        '"%s" "%s" --room "%s" --texture "%s" --output "%s" --target "%s" 2>&1',
        $python_path,
        $script_path,
        $input_path,
        $texture_to_apply,
        $output_path,
        $target_area
    );
    $output = shell_exec($cmd);
    file_put_contents($base_dir . '/designer_cmd.log', "TIMESTAMP: " . date('Y-m-d H:i:s') . "\nCOMMAND (Single): " . $cmd . "\nOUTPUT: " . $output . "\n-------------------\n\n", FILE_APPEND);
}

if (empty($output)) {
    echo json_encode(["success" => false, "error" => "Failed to run Python designer script."]);
    exit;
}

$response = null;
$json_start = strpos($output, '{');
$json_end = strrpos($output, '}');

if ($json_start !== false && $json_end !== false) {
    $json_str = substr($output, $json_start, $json_end - $json_start + 1);
    $response = json_decode($json_str, true);
}

if ($response === null) {
    echo json_encode([
        "success" => false,
        "error" => "Python script error or syntax error",
        "raw_output" => $output
    ]);
    exit;
}

if ($response["success"]) {
    $response["result_path"] = $output_relative;
    $response["room_path"] = $room_relative;

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
}

echo json_encode($response);
?>