<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "computer_store");

$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = $_POST['name'];
    $description = $_POST['description'];
    $price       = $_POST['price'];
    $category_id = (int)$_POST['category_id'];

    // Handle image upload
    $image_url = "";
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_name = basename($_FILES['image']['name']);
        $target_dir = "../pics/";
        $target_file = $target_dir . $image_name;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_url = $image_name;
        } else {
            $message = "❌ Failed to upload image.";
        }
    }

    if (!$message) {
        $stmt = $conn->prepare("INSERT INTO products (name, description, price, image_url, category_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdsi", $name, $description, $price, $image_url, $category_id);
        
        if ($stmt->execute()) {
            $message = "✅ Product added successfully!";
        } else {
            $message = "❌ Error: " . $stmt->error;
        }
        $stmt->close();
    }
}

$categories = $conn->query("SELECT id, name FROM categories");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Add Product - Admin</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f5f7fa;
      margin: 0;
      padding: 0;
    }

    .main-wrapper {
      display: flex;
      justify-content: center;
      align-items: flex-start;
      min-height: 85vh;
      padding-top: 50px;
    }

    .container {
      background: white;
      padding: 30px 40px;
      border-radius: 12px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.15);
      width: 420px;
    }

    h2 {
      text-align: center;
      color: #333;
      margin-bottom: 25px;
    }

    form label {
      display: block;
      font-weight: 600;
      margin-top: 15px;
      margin-bottom: 6px;
      color: #555;
    }

    input[type="text"],
    input[type="number"],
    select,
    textarea,
    input[type="file"] {
      width: 100%;
      padding: 10px 12px;
      border-radius: 6px;
      border: 1.8px solid #ccc;
      font-size: 1rem;
      transition: border-color 0.3s ease;
      resize: vertical;
    }

    input[type="text"]:focus,
    input[type="number"]:focus,
    select:focus,
    textarea:focus,
    input[type="file"]:focus {
      border-color: #4a90e2;
      outline: none;
    }

    textarea {
      min-height: 70px;
    }

    button {
      margin-top: 5px;
      width: 100%;
      padding: 14px;
      background: #4a90e2;
      border: none;
      border-radius: 8px;
      color: white;
      font-size: 1.15rem;
      font-weight: 700;
      cursor: pointer;
      box-shadow: 0 8px 15px rgba(74, 144, 226, 0.4);
      transition: background-color 0.3s ease;
    }

    button:hover {
      background: #357ABD;
    }

    p.message {
      text-align: center;
      font-size: 1rem;
      padding: 10px;
      border-radius: 6px;
      margin-bottom: 20px;
    }

    p.message.success {
      background: #d4edda;
      color: #155724;
    }

    p.message.error {
      background: #f8d7da;
      color: #721c24;
    }
  </style>
</head>
<body>

<!-- Include the top navigation bar here -->
<?php include "../includes/header.php"; ?>

<!-- Wrap form content only inside flex container -->
<div class="main-wrapper">
  <div class="container">
    <h2>Add New Product</h2>

    <?php if ($message): ?>
      <p class="message <?= strpos($message, '✅') === 0 ? 'success' : 'error' ?>"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" novalidate>
      <label for="name">Product Name:</label>
      <input id="name" name="name" type="text" required />

      <label for="description">Description:</label>
      <textarea id="description" name="description" required></textarea>

      <label for="price">Price ($):</label>
      <input id="price" name="price" type="number" step="0.01" min="0" required />

      <label for="category_id">Category:</label>
      <select id="category_id" name="category_id" required>
        <option disabled selected>Choose...</option>
                    <option>Laptops</option>
                    <option>Desktops</option>
                    <option>Monitors</option>
                    <option>Keyboards</option>
                    <option>Mouse</option>
                    <option>Graphic Cards</option>
        <?php while ($cat = $categories->fetch_assoc()): ?>
          <option value="<?= (int)$cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
        <?php endwhile; ?>
      </select>

      <label for="image">Upload Image:</label>
      <input id="image" name="image" type="file" accept="image/*" required />

      <button type="submit">Add Product</button>
    </form>
  </div>
</div>

<?php include "../includes/footer.php"; ?>
</body>
</html>
