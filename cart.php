<?php
session_start();
include './includes/conn.php';
include './includes/header.php';

$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) {
    echo "<div class='container'><div class='alert alert-info mt-5 text-center'><h4>Your cart is empty.</h4></div></div>";
    include './includes/footer.php';
    exit;
}

// Get product details
$ids = implode(',', array_keys($cart));
$stmt = $pdo->query("SELECT * FROM products WHERE id IN ($ids)");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Determine correct Continue Shopping link
$continueUrl = isset($_SESSION['user_name']) ? 'user_dashboard.php' : 'index.php';
$continueText = isset($_SESSION['user_name']) ? '← Continue Shopping' : '← Continue Shopping';
?>

<div class="container mt-4">
    <h2 class="mb-4">🛒 Your Shopping Cart</h2>

    <table class="table table-striped table-hover border">
        <thead class="table-dark">
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th width="100">Quantity</th>
                <th>Subtotal</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php $total = 0; foreach ($products as $product): 
            $qty = $cart[$product['id']];
            $subtotal = $product['price'] * $qty;
            $total += $subtotal;
        ?>
            <tr>
                <td><?= htmlspecialchars($product['name']) ?></td>
                <td>$<?= number_format($product['price'], 2) ?></td>
                <td><?= $qty ?></td>
                <td>$<?= number_format($subtotal, 2) ?></td>
                <td>
                    <a href="remove_from_cart.php?id=<?= $product['id'] ?>" class="btn btn-sm btn-danger">Remove</a>
                </td>
            </tr>
        <?php endforeach; ?>
            <tr class="table-secondary">
                <td colspan="3" class="text-end fw-bold">Total</td>
                <td class="fw-bold">$<?= number_format($total, 2) ?></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <div class="d-flex justify-content-between mt-4">
        <a href="<?= $continueUrl ?>" class="btn btn-outline-secondary"><?= $continueText ?></a>
        <a href="checkout.php" class="btn btn-primary">Proceed to Checkout →</a>
    </div>
</div>

<?php include './includes/footer.php'; ?>
