<?php
session_start();

// Admin authentication check
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

// DB connection - replace with your actual connection if different
$conn = new mysqli("localhost", "root", "", "computer_store");
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Query to get orders with product details
$sql = "
    SELECT
        o.id AS order_id,
        o.user_email,
        o.total_price,
        o.created_at,
        p.name AS product_name,
        oi.quantity
    FROM orders o
    JOIN order_items oi ON o.id = oi.order_id
    JOIN products p ON oi.product_id = p.id
    ORDER BY o.created_at DESC, o.id DESC
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>View Orders - Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <style>
        body {
          font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
          background: #f4f6f9;
          margin: 0;
          padding: 30px;
        }
        .container {
          max-width: 1000px;
          margin: auto;
          background: white;
          padding: 30px;
          border-radius: 10px;
          box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
        h2 {
          text-align: center;
          margin-bottom: 30px;
          color: #333;
        }
        table {
          width: 100%;
          border-collapse: collapse;
          margin-top: 10px;
        }
        th, td {
          padding: 12px 16px;
          text-align: center;
          border-bottom: 1px solid #ddd;
        }
        th {
          background-color: #007BFF;
          color: white;
        }
        tr:hover {
          background-color: #f1f1f1;
        }
        .back-link {
          display: inline-block;
          margin-bottom: 20px;
          text-decoration: none;
          color: #007BFF;
          font-weight: bold;
        }
        .back-link:hover {
          text-decoration: underline;
        }
        .no-orders {
          text-align: center;
          color: #666;
          font-size: 18px;
          margin-top: 40px;
        }
    </style>
</head>
<body>

<div class="container">
    <a href="admin_dashboard.php" class="back-link">&larr; Back to Dashboard</a>
    <h2>User Orders</h2>

    <?php if ($result && $result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User Email</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Total ($)</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $currentOrderId = 0;
                while ($row = $result->fetch_assoc()):
                    // Optional: highlight or group rows by order ID if you want.
                ?>
                <tr>
                    <td><?= htmlspecialchars($row['order_id']) ?></td>
                    <td><?= htmlspecialchars($row['user_email']) ?></td>
                    <td><?= htmlspecialchars($row['product_name']) ?></td>
                    <td><?= (int)$row['quantity'] ?></td>
                    <td><?= number_format($row['total_price'], 2) ?></td>
                    <td><?= date("Y-m-d H:i", strtotime($row['created_at'])) ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="no-orders">No orders have been placed yet.</div>
    <?php endif; ?>
</div>

</body>
</html>

<?php
$conn->close();
?>
