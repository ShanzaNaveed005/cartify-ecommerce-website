<?php
session_start();
unset($_SESSION['cart']); // remove all items
header("Location: ../home/cart.php");
exit;
