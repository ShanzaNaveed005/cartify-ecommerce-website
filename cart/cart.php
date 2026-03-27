<?php
session_start();
include __DIR__ . '/../config/db.php';
if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
$cart = $_SESSION['cart'];

// ------------------- Filter deleted products -------------------
foreach ($cart as $id => $item) {
    $id = (int)$id;
    $res = mysqli_query($conn, "SELECT id FROM products WHERE id=$id AND status='active'");
    if (mysqli_num_rows($res) == 0) {
        // Product deleted or inactive, remove from session
        unset($_SESSION['cart'][$id]);
        unset($cart[$id]);
    }
}
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$cart = $_SESSION['cart'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cartify | Cart</title>
    <link rel="stylesheet" href="cart.css">
</head>
<body>

<h2 class="cart-title">🛒 Your Cart</h2>

<?php if (empty($cart)) { ?>
    <p class="empty-cart">Your cart is empty.</p>
<?php } else { ?>

<table class="cart-table">
<tr>
    <th>Product</th>
    <th>Price</th>
    <th>Qty</th>
    <th>Total</th>
    <th></th>
</tr>

<?php $grand = 0; ?>
<?php foreach ($cart as $item): ?>
<?php $total = (float)$item['price'] * (int)$item['qty']; ?>
<?php $grand += $total; ?>

<tr>
    <td class="product-cell">
        <img src="../admin/uploads/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
        <?= htmlspecialchars($item['name']) ?>
    </td>
    <td>$<?= number_format($item['price'], 2) ?></td>
    <td>
        <form action="update_cart.php" method="post">
            <input type="hidden" name="id" value="<?= $item['id'] ?>">
            <input type="number" name="qty" value="<?= $item['qty'] ?>" min="1">
            <button>Update</button>
        </form>
    </td>
    <td>$<?= number_format($total, 2) ?></td>
    <td>
        <a class="remove-btn" href="remove_from_cart.php?id=<?= $item['id'] ?>">✖</a>
    </td>
</tr>

<?php endforeach; ?>

<tr class="grand-row">
    <td colspan="3">Grand Total</td>
    <td colspan="2">$<?= number_format($grand, 2) ?></td>
</tr>
</table>

<a href="../Home/main_page.php" class="continue-btn">Continue Shopping</a>

<?php } ?>

</body>
</html>
