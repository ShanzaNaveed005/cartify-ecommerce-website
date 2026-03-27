<?php
$conn = mysqli_connect("localhost", "root", "", "cartify");

if (!$conn) {
    die("Database connection failed");
}

$q = "SELECT * FROM orders ORDER BY created_at DESC";
$res = mysqli_query($conn, $q);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Orders - Cartify Admin</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body{
            font-family: Arial, sans-serif;
            background:#f4f6f8;
            margin:0;
            padding:20px;
        }

        h1{
            margin-bottom:20px;
        }

        /* Back Button */
        .back-btn{
            display:inline-block;
            margin-bottom:15px;
            text-decoration:none;
            background:#3e7c4f;
            color:#fff;
            padding:8px 14px;
            border-radius:5px;
        }

        .back-btn:hover{
            background:#2e5b36;
        }

        /* Table */
        table{
            width:100%;
            border-collapse:collapse;
            background:#fff;
        }

        th, td{
            padding:10px;
            border:1px solid #ddd;
            text-align:left;
            font-size:14px;
        }

        /* ✅ GREEN HEADER */
        .orders-table thead tr{
            background-color:#3e7c4f;
        }

        .orders-table thead th{
            color:#ffffff;
            font-weight:600;
        }

        tr:nth-child(even){
            background:#f9f9f9;
        }
    </style>
</head>
<body>

<a href="admin_dash.php" class="back-btn">
    ← Back to Dashboard
</a>

<h1>All Orders</h1>

<table class="orders-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>City</th>
            <th>Country</th>
            <th>Order No</th>
            <th>Total</th>
            <th>Date</th>
        </tr>
    </thead>

    <tbody>
    <?php if(mysqli_num_rows($res) > 0): ?>
        <?php $i=1; while($row = mysqli_fetch_assoc($res)): ?>
        <tr>
            <td><?= $i++ ?></td>
            <td><?= $row['first_name']." ".$row['last_name'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['phone'] ?></td>
            <td><?= $row['address'] ?></td>
            <td><?= $row['city'] ?></td>
            <td><?= $row['country'] ?></td>
            <td><?= $row['order_number'] ?></td>
            <td>Rs <?= $row['total_amount'] ?></td>
            <td><?= $row['created_at'] ?></td>
        </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="10" style="text-align:center;">No orders found</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

</body>
</html>
