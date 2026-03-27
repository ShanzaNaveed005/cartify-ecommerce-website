<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "cartify");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Get form data
$product_name     = $_POST['product_name'];
$sku              = $_POST['sku'];
$brand            = $_POST['brand'];
$category          = $_POST['category'];
$product_price    = $_POST['product_price'];
$discount_price   = $_POST['discount_price'];
$stock             = $_POST['stock'];
$sold_count        = $_POST['sold_count'];
$status            = $_POST['status'];
$short_description = $_POST['short_description'];
$description       = $_POST['description'];

// Image upload
$image_name = $_FILES['product_image']['name'];
$image_tmp  = $_FILES['product_image']['tmp_name'];

$upload_folder = "uploads/";
$image_path = $upload_folder . basename($image_name);

// Create uploads folder if not exists
if (!is_dir($upload_folder)) {
    mkdir($upload_folder, 0777, true);
}

// Move uploaded image
if (!move_uploaded_file($image_tmp, $image_path)) {
    die("Image upload failed");
}

// Insert query
$sql = "INSERT INTO products 
(product_name, sku, brand, category, product_price, discount_price, stock, sold_count, status, image, short_description, description)
VALUES
('$product_name', '$sku', '$brand', '$category', '$product_price', '$discount_price', '$stock', '$sold_count', '$status', '$image_name', '$short_description', '$description')";

// Execute query
if (mysqli_query($conn, $sql)) {
    echo "<script>
        alert('Product added successfully!');
        window.location.href = 'admin_dash.php';
    </script>";
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
