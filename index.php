<?php
include './includes/header.php';
include './includes/conn.php';  // PDO $pdo connection

$search = isset($_GET['search']) ? trim($_GET['search']) : '';

if (!empty($search)) {
    $stmt = $pdo->prepare("
        SELECT p.*
        FROM products p
        JOIN categories c ON p.category_id = c.id
        WHERE c.name LIKE ?
    ");
    $stmt->execute(["%$search%"]);
} else {
    $stmt = $pdo->query("SELECT * FROM products");
}

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>



<h1>Available Products</h1>

<?php if ($products): ?>
  <div class="products-grid">
    <?php foreach ($products as $product): ?>
      <div class="product-card">
        <img src="pics/<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" />
        <h3><?= htmlspecialchars($product['name']) ?></h3>
        <p>Price: $<?= number_format($product['price'], 2) ?></p>
        <a href="view_product_details.php?id=<?= (int)$product['id'] ?>" class="details-btn">View Details</a>
        <a href="add_to_cart.php?id=<?= $product['id'] ?>&quantity=1" class="btn btn-success mt-2">Add to Cart</a>

      </div>
    <?php endforeach; ?>
  </div>
<?php else: ?>
  <p>No products found.</p>
<?php endif; ?>

<style>
.products-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 20px;
  margin-top: 20px;
  padding: 0;
}
.product-card {
  border: 1px solid #ddd;
  border-radius: 8px;
  padding: 15px;
  text-align: center;
  background: #fff;
  box-shadow: 0 2px 5px rgba(0,0,0,0.1);
  transition: transform 0.2s ease;
}
.product-card:hover {
  transform: scale(1.05);
  box-shadow: 0 6px 15px rgba(0,0,0,0.2);
}
.product-card img {
  max-width: 100%;
  height: 150px;
  object-fit: contain;
  margin-bottom: 10px;
}
.product-card h3 {
  font-size: 1.2rem;
  margin: 10px 0 5px;
  color: #333;
}
.product-card p {
  font-size: 1rem;
  color: #666;
  margin-bottom: 15px;
}
.details-btn {
  text-decoration: none;
  color: white;
  background-color: #007bff;
  padding: 8px 12px;
  border-radius: 4px;
  font-weight: 600;
  display: inline-block;
}
.details-btn:hover {
  background-color: #0056b3;
}
</style>

<?php include './includes/footer.php'; ?>
