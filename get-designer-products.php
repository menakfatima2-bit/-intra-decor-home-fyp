<?php
header('Content-Type: application/json');
include 'db.php';

if (!isset($_GET['subcategory']) || empty(trim($_GET['subcategory']))) {
    echo json_encode(["success" => false, "error" => "Subcategory parameter is required"]);
    exit;
}

$subcategory = trim($_GET['subcategory']);
$category = isset($_GET['category']) ? trim($_GET['category']) : '';

if (!empty($category)) {
    $query = "SELECT id, name, price, product_image FROM productadd WHERE category=? AND product_type=? AND status='approved'";
    $stmt = mysqli_prepare($conn, $query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ss", $category, $subcategory);
    }
} else {
    $query = "SELECT id, name, price, product_image FROM productadd WHERE product_type=? AND status='approved'";
    $stmt = mysqli_prepare($conn, $query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $subcategory);
    }
}

if (!$stmt) {
    echo json_encode(["success" => false, "error" => mysqli_error($conn)]);
    exit;
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$products = [];
while ($row = mysqli_fetch_assoc($result)) {
    $products[] = [
        "id" => $row['id'],
        "name" => $row['name'],
        "price" => $row['price'],
        "product_image" => "uploads/" . $row['product_image']
    ];
}

mysqli_stmt_close($stmt);

echo json_encode(["success" => true, "products" => $products]);
?>
