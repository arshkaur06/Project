<?php
session_start();
include './includes/conn.php'; // $pdo connection

// Check user login
if (!isset($_SESSION['user_email'])) {
    header('Location: login.php');
    exit;
}

// Get order ID from URL
$orderId = $_GET['orderId'] ?? null;
if (!$orderId || !is_numeric($orderId)) {
    die("Invalid order ID.");
}

// Fetch order info (make sure the order belongs to this user)
$stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ? AND user_email = ?");
$stmt->execute([$orderId, $_SESSION['user_email']]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    die("Order not found or you don't have permission to view it.");
}

// Fetch order items with product details
$stmt = $pdo->prepare("
    SELECT oi.quantity, oi.unit_price, p.name 
    FROM order_items oi
    JOIN products p ON oi.product_id = p.id
    WHERE oi.order_id = ?
");
$stmt->execute([$orderId]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Order Confirmation - #<?= htmlspecialchars($orderId) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
      body {
        background-color: #f8f9fa;
      }
      .order-header {
        background: linear-gradient(90deg, #4e54c8, #8f94fb);
        color: white;
        padding: 2rem;
        border-radius: 0.5rem;
        box-shadow: 0 4px 10px rgb(0 0 0 / 0.1);
        margin-bottom: 2rem;
      }
      .table thead {
        background-color: #343a40;
        color: white;
      }
      .btn-primary {
        background-color: #4e54c8;
        border-color: #4e54c8;
      }
      .btn-primary:hover {
        background-color: #3a3f91;
        border-color: #3a3f91;
      }
    </style>
</head>
<body>
<div class="container my-5">

  <div class="order-header text-center">
    <h1 class="display-5 fw-bold">🎉 Thank You for Your Order!</h1>
    <p class="lead mb-0">Your order <strong>#<?= htmlspecialchars($orderId) ?></strong> was placed successfully on <strong><?= htmlspecialchars(date('F j, Y, g:i A', strtotime($order['created_at']))) ?></strong>.</p>
  </div>

  <div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
      <h4 class="mb-0">Order Summary</h4>
    </div>
    <div class="card-body p-0">
      <table class="table table-striped mb-0">
        <thead>
          <tr>
            <th scope="col">Product</th>
            <th scope="col" class="text-center">Quantity</th>
            <th scope="col" class="text-end">Unit Price</th>
            <th scope="col" class="text-end">Subtotal</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($items as $item): ?>
            <tr>
              <td><?= htmlspecialchars($item['name']) ?></td>
              <td class="text-center"><?= (int)$item['quantity'] ?></td>
              <td class="text-end">$<?= number_format($item['unit_price'], 2) ?></td>
              <td class="text-end">$<?= number_format($item['unit_price'] * $item['quantity'], 2) ?></td>
            </tr>
          <?php endforeach; ?>
          <tr class="table-active fw-bold">
            <td colspan="3" class="text-end">Total</td>
            <td class="text-end">$<?= number_format($order['total_price'], 2) ?></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <div class="d-flex justify-content-center gap-3 mt-4">
    <a href="index.php" class="btn btn-primary btn-lg px-4">Continue Shopping</a>
    <a href="view_my_orders.php" class="btn btn-outline-secondary btn-lg px-4">View My Orders</a>
  </div>
  
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
