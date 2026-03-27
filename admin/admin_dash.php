<?php
// Step 2: Error reporting ON (temporary)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn = mysqli_connect("localhost", "root", "", "cartify");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

/* ---------- TOTAL PRODUCTS ---------- */
$productQuery = mysqli_query($conn, "SELECT COUNT(id) AS total_products FROM products");
$productData = mysqli_fetch_assoc($productQuery);
$totalProducts = $productData['total_products'] ?? 0;

/* ---------- TOTAL ORDERS ---------- */
$orderQuery = mysqli_query($conn, "SELECT COUNT(order_id) AS total_orders FROM orders");
$orderData = mysqli_fetch_assoc($orderQuery);
$totalOrders = $orderData['total_orders'] ?? 0;

/* * ---------- ACTIVE CUSTOMERS (CORRECTED) ---------- 
 * Counts distinct email addresses from the orders table structure confirmed from your image.
 */
$customerQuery = mysqli_query($conn, "SELECT COUNT(DISTINCT email) AS total_customers FROM orders");
$customerData = mysqli_fetch_assoc($customerQuery);
$totalCustomers = $customerData['total_customers'] ?? 0;

/* ---------- TOTAL REVENUE ---------- */
$revenueQuery = mysqli_query($conn, "SELECT IFNULL(SUM(total_amount),0) AS total_revenue FROM orders");
$revenueData = mysqli_fetch_assoc($revenueQuery);
$totalRevenue = $revenueData['total_revenue'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cartify - Admin Dashboard</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="admin_dash.css">
</head>
<body>

<nav class="navbar">
    <div class="nav-container">
        <div class="brand-section">
            <a class="nav-brand">
                <i class="fas fa-shopping-cart"></i>
                Cartify Admin
            </a>
        </div>

        <div class="admin-section">
            <div class="admin-info">
                <i class="fas fa-user-tie"></i>
                <span class="admin-greeting">Hello, Admin</span>
            </div>

            <div class="nav-links">
                <a href="../Home/main_page.php" class="nav-link logout">
                    <i class="fas fa-arrow-right-from-bracket"></i>
                    Logout
                </a>
            </div>
        </div>
    </div>
</nav>

<div class="main-container">

    <header class="dashboard-header">
        <h1>Cartify Dashboard</h1>
        <p class="dashboard-subtitle">Manage your online store efficiently</p>
    </header>

    <div class="dashboard-options">

        <a href="add_post.php" class="option-card create-post">
            <div class="option-icon"><i class="fas fa-plus-circle"></i></div>
            <h3 class="option-title">Create Product</h3>
            <p class="option-description">Add new products to your store</p>
            <span class="option-link">Add New →</span>
        </a>

        <a href="update_products.html" class="option-card update-post">
            <div class="option-icon"><i class="fas fa-edit"></i></div>
            <h3 class="option-title">Update Product</h3>
            <p class="option-description">Edit product details and pricing</p>
            <span class="option-link">Edit Items →</span>
        </a>

        <a href="view_products.php" class="option-card see-posts">
            <div class="option-icon"><i class="fas fa-boxes"></i></div>
            <h3 class="option-title">View Products</h3>
            <p class="option-description">See all products in your inventory</p>
            <span class="option-link">View All →</span>
        </a>

        <a href="delete_products.html" class="option-card delete-post">
            <div class="option-icon"><i class="fas fa-trash-alt"></i></div>
            <h3 class="option-title">Remove Product</h3>
            <p class="option-description">Delete products from your store</p>
            <span class="option-link">Manage →</span>
        </a>

    </div>

    <div class="dashboard-options secondary-options">
        <a href="view_orders.php" class="option-card manage-orders">
            <div class="option-icon"><i class="fas fa-clipboard-list"></i></div>
            <h3 class="option-title">Manage Orders</h3>
            <p class="option-description">View and process customer orders</p>
            <span class="option-link">View Orders →</span>
        </a>
    </div>

    <div class="stats-section">

        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-shopping-bag"></i></div>
            <h4>Total Products</h4>
            <p class="stat-number"><?php echo $totalProducts; ?></p>
        </div>

        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-clipboard-check"></i></div>
            <h4>Total Orders</h4>
            <p class="stat-number"><?php echo $totalOrders; ?></p>
        </div>

        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-users"></i></div>
            <h4>Active Customers</h4>
            <p class="stat-number"><?php echo $totalCustomers; ?></p>
        </div>

        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-dollar-sign"></i></div>
            <h4>Revenue</h4>
            <p class="stat-number">PKR <?php echo number_format($totalRevenue, 2); ?></p>
        </div>

    </div>

</div>

<footer class="footer">
    <p>Cartify E-commerce Admin Dashboard &copy; 2023</p>
</footer>

</body>
</html>