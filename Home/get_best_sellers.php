<?php
$conn = mysqli_connect("localhost","root","","cartify");

$q = "SELECT product_name, product_price, image 
      FROM products 
      ORDER BY sold_count DESC 
      LIMIT 4";

$r = mysqli_query($conn,$q);
$data = [];

while($row = mysqli_fetch_assoc($r)){
    $data[] = $row;
}

echo json_encode($data);
