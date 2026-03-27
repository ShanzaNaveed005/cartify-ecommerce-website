<?php
header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = mysqli_connect("localhost", "root", "", "cartify");

if (!$conn) {
    echo json_encode(["error" => "Database connection failed: " . mysqli_connect_error()]);
    exit;
}

// Get category parameter safely
$category = isset($_GET['category']) ? trim($_GET['category']) : "";
$category = mysqli_real_escape_string($conn, $category);

// Base query
$query = "SELECT id, product_name, sku, brand, product_price, stock, 
                 status, sold_count, category, short_description, 
                 description, image, created_at 
          FROM products 
          WHERE 1=1";

// Add category filter if specified
if ($category != "") {
    $query .= " AND category = '$category'";
}

$query .= " ORDER BY id DESC";
$result = mysqli_query($conn, $query);

if (!$result) {
    echo json_encode(["error" => "Query failed: " . mysqli_error($conn)]);
    exit;
}

$products = [];
while ($row = mysqli_fetch_assoc($result)) {
    // Ensure image has default if empty
    if (empty($row['image'])) {
        $row['image'] = 'default.jpg';
    }
    $products[] = $row;
}

mysqli_close($conn);
echo json_encode($products);
?>