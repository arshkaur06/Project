<?php
$conn = new mysqli("localhost", "root", "", "computer_store");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get product ID from URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid product ID.");
}

$product_id = (int)$_GET['id'];

$stmt = $conn->prepare("SELECT p.name, p.description, p.price, p.image_url, c.name AS category_name
                        FROM products p
                        JOIN categories c ON p.category_id = c.id
                        WHERE p.id = ?");
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
        <div class="product-category"><strong>Category:</strong> <?= htmlspecialchars($product['category_name']) ?></div>
        <div class="product-price">$<?= number_format($product['price'], 2) ?></div>
        <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
    </div>
</div>

<a href="index.php" class="back-link">&larr; Back to products</a>

</body>
</html>
