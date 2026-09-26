<?php
header('Content-Type: application/json');
include 'db.php';

$query = "SELECT DISTINCT category FROM productadd WHERE status='approved'";
$result = mysqli_query($conn, $query);

if (!$result) {
    echo json_encode(["success" => false, "error" => mysqli_error($conn)]);
    exit;
}

$categories = [];
while ($row = mysqli_fetch_assoc($result)) {
    // Standardize naming or return raw
    $categories[] = $row['category'];
}

echo json_encode(["success" => true, "categories" => $categories]);
?>
