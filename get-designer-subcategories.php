<?php
header('Content-Type: application/json');
include 'db.php';

if (!isset($_GET['category']) || empty(trim($_GET['category']))) {
    echo json_encode(["success" => false, "error" => "Category parameter is required"]);
    exit;
}

$category = trim($_GET['category']);

$query = "SELECT DISTINCT product_type FROM productadd WHERE category=? AND status='approved'";
$stmt = mysqli_prepare($conn, $query);

if (!$stmt) {
    echo json_encode(["success" => false, "error" => mysqli_error($conn)]);
    exit;
}

mysqli_stmt_bind_param($stmt, "s", $category);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$subcategories = [];
while ($row = mysqli_fetch_assoc($result)) {
    $subcategories[] = $row['product_type'];
}

mysqli_stmt_close($stmt);

echo json_encode(["success" => true, "subcategories" => $subcategories]);
?>
