<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "computer_store");

// Validate and fetch product
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid product ID.");
}
$id = (int)$_GET['id'];
$product = $conn->query("SELECT * FROM products WHERE id = $id")->fetch_assoc();
$categories = $conn->query("SELECT id, name FROM categories");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name        = $_POST['name'];
    $description = $_POST['description'];
    $price       = $_POST['price'];
    $category_id = $_POST['category_id'];
    $image_url   = $product['image_url'];

    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_name = basename($_FILES['image']['name']);
        $target = "../pics/" . $image_name;
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
        $image_url = $image_name;
    }

    $stmt = $conn->prepare("UPDATE products SET name=?, description=?, price=?, image_url=?, category_id=? WHERE id=?");
    $stmt->bind_param("ssdsii", $name, $description, $price, $image_url, $category_id, $id);
    $stmt->execute();
    header("Location: admin_dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Product</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f4f7fa;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 600px;
      margin: 60px auto;
      background: white;
      padding: 40px 30px;
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    h2 {
      text-align: center;
      color: #333;
      margin-bottom: 30px;
    }

    label {
      font-weight: bold;
      display: block;
      margin-top: 15px;
      margin-bottom: 5px;
      color: #555;
    }

    input[type="text"],
    input[type="number"],
    textarea,
    select {
      width: 100%;
      padding: 12px;
      border: 1.6px solid #ccc;
      border-radius: 6px;
      font-size: 1rem;
      box-sizing: border-box;
    }

    textarea {
      resize: vertical;
      min-height: 80px;
    }

    input[type="file"] {
      margin-top: 8px;
    }

    button {
      margin-top: 25px;
      width: 100%;
      padding: 14px;
      font-size: 1.1rem;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    button:hover {
      background-color: #0056b3;
    }

    .current-image {
      margin-top: 8px;
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .current-image img {
      max-width: 80px;
      border-radius: 4px;
    }

    small {
      color: #888;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>Edit Product</h2>

  <form method="POST" enctype="multipart/form-data">
    <label for="name">Product Name:</label>
    <input type="text" id="name" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>

    <label for="description">Description:</label>
    <textarea id="description" name="description" required><?= htmlspecialchars($product['description']) ?></textarea>

    <label for="price">Price ($):</label>
    <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" required>

    <label for="category_id">Category:</label>
    <select id="category_id" name="category_id" required>
      <option disabled>Choose...</option>
                    <option>Laptops</option>
                    <option>Desktops</option>
                    <option>Monitors</option>
                    <option>Keyboards</option>
                    <option>Mouse</option>
                    <option>Graphic Cards</option>

      <?php while ($cat = $categories->fetch_assoc()): ?>
        <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $product['category_id'] ? 'selected' : '' ?>>
          <?= htmlspecialchars($cat['name']) ?>
        </option>
      <?php endwhile; ?>
    </select>

    <label for="image">Change Image:</label>
    <input type="file" name="image" id="image" accept="image/*">
    <div class="current-image">
      <img src="../pics/<?= htmlspecialchars($product['image_url']) ?>" alt="Current Image">
      <small><?= htmlspecialchars($product['image_url']) ?></small>
    </div>

    <button type="submit">Update Product</button>
  </form>
</div>

</body>
</html>
