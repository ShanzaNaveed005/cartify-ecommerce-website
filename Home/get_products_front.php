<?php
$conn = mysqli_connect("localhost", "root", "", "cartify");

$category = $_GET['category'] ?? '';
$search   = $_GET['search'] ?? '';

if($category != '') {
    $stmt = mysqli_prepare($conn, "SELECT * FROM products WHERE category=? AND status='active'");
    mysqli_stmt_bind_param($stmt, "s", $category);
} elseif($search != '') {
    $searchTerm = "%$search%";
    $stmt = mysqli_prepare($conn, "SELECT * FROM products WHERE product_name LIKE ? AND status='active'");
    mysqli_stmt_bind_param($stmt, "s", $searchTerm);
} else {
    $stmt = mysqli_prepare($conn, "SELECT * FROM products WHERE status='active' ORDER BY RAND() LIMIT 12");
}

mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);

$data = [];
while($row = mysqli_fetch_assoc($res)){
    $data[] = $row;
}

echo json_encode($data);
