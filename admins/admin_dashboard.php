<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

include "../includes/header.php";
$conn = new mysqli("localhost", "root", "", "computer_store");
$products = $conn->query("SELECT * FROM products ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Dashboard</title>
  <style>
    body {
      background: #f4f7fa;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
    }

    .dashboard-content {
      max-width: 1200px;
      margin: 40px auto 40px;
      padding: 0 20px;
    }

    h2 {
      color: #333;
      font-size: 2rem;
      text-align: center;
      margin-bottom: 30px;
      font-weight: 700;
    }

    .actions-bar {
      display: flex;
      justify-content: center;
      gap: 15px;
      flex-wrap: wrap;
      margin-bottom: 30px;
    }

    .actions-bar a {
      text-decoration: none;
      padding: 12px 22px;
      border-radius: 8px;
      font-weight: 700;
      color: white;
      box-shadow: 0 3px 8px rgba(0,0,0,0.15);
      transition: background 0.3s ease, box-shadow 0.3s ease;
      user-select: none;
    }

    .btn-add {
      background: #28a745;
    }
    .btn-add:hover {
      background: #218838;
      box-shadow: 0 6px 14px rgba(33, 136, 56, 0.5);
    }

    .btn-orders {
      background: #17a2b8;
    }
    .btn-orders:hover {
      background: #117a8b;
      box-shadow: 0 6px 14px rgba(17, 122, 139, 0.5);
    }

    .btn-logout {
      background: #dc3545;
    }
    .btn-logout:hover {
      background: #c82333;
      box-shadow: 0 6px 14px rgba(200, 35, 51, 0.5);
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      border-radius: 12px;
      overflow: hidden;
    }

    thead {
      background: #007bff;
      color: white;
    }

    th, td {
      padding: 14px 18px;
      text-align: left;
      border-bottom: 1px solid #eaeaea;
    }

    tbody tr:hover {
      background: #f1f9ff;
    }

    .table-actions a {
      margin-right: 8px;
      padding: 7px 12px;
      border-radius: 6px;
      font-size: 0.9rem;
      text-decoration: none;
      color: white;
      user-select: none;
      box-shadow: 0 2px 6px rgba(0,0,0,0.2);
      transition: background 0.3s ease, box-shadow 0.3s ease;
    }

    .table-actions a.edit {
      background: #ffc107;
      color: #212529;
    }
    .table-actions a.edit:hover {
      background: #e0a800;
      box-shadow: 0 4px 10px rgba(224, 168, 0, 0.5);
    }

    .table-actions a.delete {
      background: #dc3545;
    }
    .table-actions a.delete:hover {
      background: #c82333;
      box-shadow: 0 4px 10px rgba(200, 35, 51, 0.5);
    }

    @media (max-width: 600px) {
      table, thead, tbody, th, td, tr {
        display: block;
      }
      tr {
        margin-bottom: 20px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        border-radius: 12px;
        padding: 15px;
        background: white;
      }
      th {
        display: none;
      }
      td {
        position: relative;
        padding-left: 50%;
        text-align: left;
        border-bottom: none;
        padding-top: 10px;
        padding-bottom: 10px;
      }
      td::before {
        position: absolute;
        top: 50%;
        left: 15px;
        transform: translateY(-50%);
        font-weight: 700;
        white-space: nowrap;
        content: attr(data-label);
        color: #444;
      }
      .table-actions a {
        margin-bottom: 5px;
        display: inline-block;
      }
    }
  </style>
</head>
<body>

<div class="dashboard-content">
  <h2>Welcome Admin - Manage Products</h2>

  <div class="actions-bar">
    <a href="add_product.php" class="btn-add">+ Add Product</a>
    <a href="view_orders.php" class="btn-orders">📦 View Orders</a>
    <a href="admin_logout.php" class="btn-logout">🚪 Logout</a>
  </div>

  <table>
    <thead>
      <tr>
        <th>ID</th><th>Name</th><th>Price</th><th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $products->fetch_assoc()): ?>
        <tr>
          <td data-label="ID"><?= $row['id'] ?></td>
          <td data-label="Name"><?= htmlspecialchars($row['name']) ?></td>
          <td data-label="Price">$<?= number_format($row['price'], 2) ?></td>
          <td class="table-actions" data-label="Actions">
            <a href="edit_product.php?id=<?= $row['id'] ?>" class="edit">Edit</a>
            <a href="delete_product.php?id=<?= $row['id'] ?>" class="delete" onclick="return confirm('Delete this product?')">Delete</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php include "../includes/footer.php"; ?>
</body>
</html>
