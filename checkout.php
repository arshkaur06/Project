<?php
session_start();
include './includes/conn.php';
include './includes/header.php';

$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) {
  echo "<div class='alert alert-info mt-5'>Your cart is empty.</div>";
  include './includes/footer.php';
  exit;
}

// Fetch cart products
$ids = implode(',', array_keys($cart));
$stmt = $pdo->query("SELECT * FROM products WHERE id IN ($ids)");
$products = $stmt->fetchAll();

// Calculate total
$total = 0;
foreach ($products as $product) {
  $qty = $cart[$product['id']];
  $total += $product['price'] * $qty;
}
?>

<div class="container mt-4">
  <h2>Checkout Summary</h2>
  <table class="table">
    <tr><th>Product</th><th>Qty</th><th>Subtotal</th></tr>
    <?php foreach($products as $p): ?>
      <tr>
        <td><?= htmlspecialchars($p['name']) ?></td>
        <td><?= $cart[$p['id']] ?></td>
        <td>$<?= number_format($p['price'] * $cart[$p['id']], 2) ?></td>
      </tr>
    <?php endforeach; ?>
    <tr><th colspan="2">Total</th><th>$<?= number_format($total, 2) ?></th></tr>
  </table>

  <form method="POST" action="place_order.php">
    <button type="submit" class="btn btn-success">Place Order</button>
    <?php $backUrl = isset($_SESSION['user_name']) ? 'user_dashboard.php' : 'index.php'; ?>
    <a href="<?= $backUrl ?>" class="btn btn-secondary">← Continue Shopping</a>
  </form>
</div>

<?php include './includes/footer.php'; ?>
