<?php
$conn = mysqli_connect("localhost", "root", "", "cartify");
if (!$conn) {
    echo json_encode([]);
    exit;
}

$query = "SELECT DISTINCT category FROM products WHERE status='active'";
$result = mysqli_query($conn, $query);

$categories = [];
while ($row = mysqli_fetch_assoc($result)) {
    $categories[] = $row['category'];
}

echo json_encode($categories);
