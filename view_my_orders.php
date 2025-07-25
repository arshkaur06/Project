<?php
session_start();
include './includes/conn.php'; // $pdo connection

// Check if user is logged in
if (!isset($_SESSION['user_email'])) {
    header('Location: login.php');
    exit;
}

// Fetch all orders for this user, newest first
$stmt = $pdo->prepare("SELECT id, total_price, created_at FROM orders WHERE user_email = ? ORDER BY created_at DESC");
$stmt->execute([$_SESSION['user_email']]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>My Orders</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #f8f9fa;
    }
    .orders-header {
      margin: 2rem 0;
      text-align: center;
    }
    .table thead {
      background-color: #343a40;
      color: white;
    }
    .btn-view {
      background-color: #4e54c8;
      border-color: #4e54c8;
      color: white;
    }
    .btn-view:hover {
      background-color: #3a3f91;
      border-color: #3a3f91;
      color: white;
    }
  </style>
</head>
<body>
<div class="container">

  <h1 class="orders-header">🛒 My Orders</h1>

  <?php if (empty($orders)): ?>
    <div class="alert alert-info text-center">
      You have no orders yet. <a href="index.php" class="alert-link">Start shopping now!</a>
    </div>
  <?php else: ?>
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>Order ID</th>
          <th>Date</th>
          <th>Total Price</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($orders as $order): ?>
          <tr>
            <td>#<?= htmlspecialchars($order['id']) ?></td>
            <td><?= htmlspecialchars(date('F j, Y, g:i A', strtotime($order['created_at']))) ?></td>
            <td>$<?= number_format($order['total_price'], 2) ?></td>
            <td>
              <a href="order_success.php?orderId=<?= urlencode($order['id']) ?>" class="btn btn-view btn-sm">View Details</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>

  <div class="text-center my-4">
    <a href="index.php" class="btn btn-primary btn-lg">Continue Shopping</a>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
