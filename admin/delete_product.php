<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode(["success" => false, "message" => "Product ID is required"]);
    exit;
}

$conn = mysqli_connect("localhost", "root", "", "cartify");

if (!$conn) {
    echo json_encode(["success" => false, "message" => "Database connection failed"]);
    exit;
}

// Sanitize and validate ID
$id = intval($_GET['id']);

// First, check if product exists
$checkQuery = "SELECT id, product_name, image FROM products WHERE id = $id";
$checkResult = mysqli_query($conn, $checkQuery);

if (!$checkResult || mysqli_num_rows($checkResult) == 0) {
    echo json_encode(["success" => false, "message" => "Product not found"]);
    exit;
}

$product = mysqli_fetch_assoc($checkResult);

// Delete the product
$deleteQuery = "DELETE FROM products WHERE id = $id";
$deleteResult = mysqli_query($conn, $deleteQuery);

if ($deleteResult) {
    // Optional: Delete the image file from uploads folder
    $imagePath = "uploads/" . $product['image'];
    if (file_exists($imagePath) && $product['image'] != 'default.jpg') {
        unlink($imagePath);
    }
    
    echo json_encode([
        "success" => true, 
        "message" => "Product '{$product['product_name']}' deleted successfully"
    ]);
} else {
    echo json_encode([
        "success" => false, 
        "message" => "Failed to delete product: " . mysqli_error($conn)
    ]);
}

mysqli_close($conn);
?>