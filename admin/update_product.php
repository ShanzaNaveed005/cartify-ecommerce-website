<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if ID is provided and valid
if (!isset($_GET['id']) || !is_numeric($_GET['id']) || $_GET['id'] <= 0) {
    die("Invalid product ID");
}

$conn = mysqli_connect("localhost", "root", "", "cartify");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Sanitize ID
$id = intval($_GET['id']);

// Prepare query to prevent SQL injection
$stmt = mysqli_prepare($conn, "SELECT * FROM products WHERE id = ?");
if (!$stmt) {
    die("Prepare failed: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Check if product exists
if (mysqli_num_rows($result) == 0) {
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    die("Product not found");
}

$product = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);
mysqli_close($conn);

// Helper function for safe output
function safe_output($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="update_products_style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-light">
<div class="container mt-4">
    <h3>Update Product</h3>
    
   <form action="update_product_action.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= safe_output($product['id']) ?>">
        
        <div class="mb-3">
            <label class="form-label">Product Name *</label>
            <input type="text" name="product_name" class="form-control"
                   value="<?= safe_output($product['product_name']) ?>" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">SKU</label>
            <input type="text" name="sku" class="form-control"
                   value="<?= safe_output($product['sku']) ?>">
        </div>
        
        <div class="mb-3">
            <label class="form-label">Brand</label>
            <input type="text" name="brand" class="form-control"
                   value="<?= safe_output($product['brand']) ?>">
        </div>
        
        <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="category" class="form-select">
                <option value="">Select Category</option>
                <option value="fashion" <?= ($product['category'] ?? '') == 'fashion' ? 'selected' : '' ?>>Fashion</option>
                <option value="electronics" <?= ($product['category'] ?? '') == 'electronics' ? 'selected' : '' ?>>Electronics</option>
                <option value="beauty" <?= ($product['category'] ?? '') == 'beauty' ? 'selected' : '' ?>>Beauty</option>
                <option value="home" <?= ($product['category'] ?? '') == 'home' ? 'selected' : '' ?>>Home</option>
                <option value="sports" <?= ($product['category'] ?? '') == 'sports' ? 'selected' : '' ?>>Sports</option>
                <option value="mobile" <?= ($product['category'] ?? '') == 'mobile' ? 'selected' : '' ?>>Mobile Phones</option>
                <option value="laptops" <?= ($product['category'] ?? '') == 'laptops' ? 'selected' : '' ?>>Laptops</option>
            </select>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Price *</label>
            <input type="number" step="0.01" min="0" name="product_price" class="form-control"
                   value="<?= safe_output($product['product_price']) ?>" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Discount Price</label>
            <input type="number" step="0.01" min="0" name="discount_price" class="form-control"
                   value="<?= safe_output($product['discount_price']) ?>">
        </div>
        
        <div class="mb-3">
            <label class="form-label">Stock</label>
            <input type="number" min="0" name="stock" class="form-control"
                   value="<?= safe_output($product['stock']) ?>">
        </div>
        
        <div class="mb-3">
            <label class="form-label">Sold Count</label>
            <input type="number" min="0" name="sold_count" class="form-control"
                   value="<?= safe_output($product['sold_count']) ?>">
        </div>
        
        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="active" <?= ($product['status'] ?? '') == 'active' ? 'selected' : '' ?>>Active</option>
                <option value="inactive" <?= ($product['status'] ?? '') == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                <option value="draft" <?= ($product['status'] ?? '') == 'draft' ? 'selected' : '' ?>>Draft</option>
            </select>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Short Description</label>
            <textarea name="short_description" class="form-control" rows="2"><?= safe_output($product['short_description']) ?></textarea>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4"><?= safe_output($product['description']) ?></textarea>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Product Image (Current: <?= safe_output($product['image'] ?? 'No image') ?>)</label>
            <input type="file" name="product_image" class="form-control" accept="image/*">
            <small class="text-muted">Leave empty to keep current image</small>
        </div>
        
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="update_products.html" class="btn btn-secondary">Cancel</a>
            <button type="button" class="btn btn-danger" onclick="if(confirm('Delete this product?')) window.location='delete_product.php?id=<?= $id ?>'">Delete</button>
        </div>
    </form>
</div>

<script>
// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const price = parseFloat(document.querySelector('input[name="product_price"]').value);
    const discount = document.querySelector('input[name="discount_price"]').value;
    
    if (price <= 0) {
        e.preventDefault();
        alert('Price must be greater than 0');
        return false;
    }
    
    if (discount && parseFloat(discount) >= price) {
        e.preventDefault();
        alert('Discount price must be less than regular price');
        return false;
    }
    
    return true;
});
</script>
</body>
</html>