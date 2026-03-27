<?php
session_start();
include "../db.php";

if (!isset($_GET['id'])) {
    echo json_encode(["status" => "error"]);
    exit;
}

$id = (int)$_GET['id'];


$q = "SELECT id, product_name, product_price, discount_price, image, stock 
      FROM products 
      WHERE id = $id AND status = 'active'";
$res = mysqli_query($conn, $q);

if (mysqli_num_rows($res) == 0) {
    echo json_encode(["status" => "not_found"]);
    exit;
}

$p = mysqli_fetch_assoc($res);


$price = (isset($p['discount_price']) && $p['discount_price'] > 0) 
         ? floatval($p['discount_price']) 
         : floatval($p['product_price']);


if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}


if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id]['qty']++;
} else {
    $_SESSION['cart'][$id] = [
        "id" => $id,
        "name" => $p['product_name'],
        "price" => $price,
        "qty" => 1,
        "image" => $p['image'] ?? ''
    ];
}

echo json_encode([
    "status" => "success",
    "count" => count($_SESSION['cart'])
]);
