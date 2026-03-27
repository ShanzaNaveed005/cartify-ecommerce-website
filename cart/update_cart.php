<?php
session_start();
if(isset($_POST['id'], $_POST['qty'])){
    $id = $_POST['id'];
    $qty = (int)$_POST['qty'];

    if(isset($_SESSION['cart'][$id])){
        if($qty <= 0){
            unset($_SESSION['cart'][$id]);
        } else {
            $_SESSION['cart'][$id]['qty'] = $qty;
        }
    }
}
header("Location: cart.php");
exit;
