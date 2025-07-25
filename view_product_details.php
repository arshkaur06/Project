<?php
$conn = new mysqli("localhost", "root", "", "computer_store");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if id is set and is a number
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid product ID.");
}

$product_id = (int)$_GET['id'];

// Simple query without category join
$stmt = $conn->prepare("SELECT name, description, price, image_url FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Product not found.");
}

$product = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>
<?php
session_start();
$backUrl = isset($_SESSION['user_name']) ? 'user_dashboard.php' : 'index.php';
$backText = $backUrl === 'user_dashboard.php' ? '← Back to Dashboard' : '← Back to products';
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($product['name']) ?> - Details</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .product-container {
            display: flex;
            gap: 30px;
        }
        .product-image img {
            max-width: 400px;
            height: auto;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        .product-info {
            max-width: 600px;
        }
        .product-info h1 {
            margin-top: 0;
        }
        .product-price {
            color: green;
            font-size: 1.5em;
            margin: 15px 0;
        }
        .back-link {
            margin-top: 30px;
            display: inline-block;
            text-decoration: none;
            color: #555;
            border: 1px solid #555;
            padding: 8px 12px;
            border-radius: 5px;
        }
        .back-link:hover {
            background-color: #555;
            color: white;
        }
    </style>
</head>
<body>

<div class="product-container">
    <div class="product-image">
        <img src="pics/<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
    </div>
    <div class="product-info">
        <h1><?= htmlspecialchars($product['name']) ?></h1>
        <div class="product-price">$<?= number_format($product['price'], 2) ?></div>
        <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
    </div>
</div>

<!-- Old static link -->
<!-- <a href="index.php" class="back-link">← Back to products</a> -->

<!-- New dynamic link -->
<a href="<?= $backUrl ?>" class="back-link"><?= $backText ?></a>


</body>
</html>
