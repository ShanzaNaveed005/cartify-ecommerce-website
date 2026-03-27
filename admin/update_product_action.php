<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request method");
}

// Check required fields
$required = ['id', 'product_name', 'product_price'];
foreach ($required as $field) {
    if (empty($_POST[$field])) {
        die("Required field missing: $field");
    }
}

$conn = mysqli_connect("localhost", "root", "", "cartify");
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Get and sanitize data
$id = intval($_POST['id']);
$product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
$sku = mysqli_real_escape_string($conn, $_POST['sku'] ?? '');
$brand = mysqli_real_escape_string($conn, $_POST['brand'] ?? '');
$category = mysqli_real_escape_string($conn, $_POST['category'] ?? '');
$product_price = floatval($_POST['product_price']);
$discount_price = !empty($_POST['discount_price']) ? floatval($_POST['discount_price']) : NULL;
$stock = intval($_POST['stock'] ?? 0);
$sold_count = intval($_POST['sold_count'] ?? 0);
$status = mysqli_real_escape_string($conn, $_POST['status'] ?? 'active');
$short_description = mysqli_real_escape_string($conn, $_POST['short_description'] ?? '');
$description = mysqli_real_escape_string($conn, $_POST['description'] ?? '');

// Handle image upload if provided
$image_update = "";
if (!empty($_FILES['product_image']['name'])) {
    $target_dir = "uploads/";
    $image_name = time() . "_" . basename($_FILES["product_image"]["name"]);
    $target_file = $target_dir . $image_name;
    
    if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
        $image_update = ", image = '$image_name'";
    }
}

// Prepare and execute UPDATE query
$query = "UPDATE products SET 
          product_name = ?,
          sku = ?,
          brand = ?,
          category = ?,
          product_price = ?,
          discount_price = ?,
          stock = ?,
          sold_count = ?,
          status = ?,
          short_description = ?,
          description = ?
          $image_update
          WHERE id = ?";

$stmt = mysqli_prepare($conn, $query);
if (!$stmt) {
    die("Prepare failed: " . mysqli_error($conn));
}

// Bind parameters
if ($image_update) {
    // With image
mysqli_stmt_bind_param($stmt, "ssssddiisssi",

        $product_name,
        $sku,
        $brand,
        $category,
        $product_price,
        $discount_price,
        $stock,
        $sold_count,
        $status,
        $short_description,
        $description,
        $id
    );
} else {
    // Without image
 mysqli_stmt_bind_param($stmt, "ssssddiisssi",

        $product_name,
        $sku,
        $brand,
        $category,
        $product_price,
        $discount_price,
        $stock,
        $sold_count,
        $status,
        $short_description,
        $description,
        $id
    );
}

if (mysqli_stmt_execute($stmt)) {
    // Success - redirect back to update products page
    header("Location: update_products.html");
    exit();
} else {
    // Error
    die("Update failed: " . mysqli_error($conn));
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>