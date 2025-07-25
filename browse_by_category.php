<?php
include './includes/header.php';
include './includes/conn.php'; // Assumes $pdo is defined

// Fixed list of 6 categories
$categories = ['Laptops', 'Desktops', 'Monitors', 'Keyboards', 'Mouse', 'Graphic Cards'];

// Get selected category from dropdown
$selectedCategory = $_GET['category'] ?? '';

// Validate selection
$filterCategory = in_array($selectedCategory, $categories) ? $selectedCategory : '';

// SQL query
$sql = "SELECT p.*, c.name AS category_name 
        FROM products p 
        JOIN categories c ON p.category_id = c.id";
$params = [];

if ($filterCategory) {
    $sql .= " WHERE c.name = ?";
    $params[] = $filterCategory;
}

$sql .= " ORDER BY p.name";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container my-5">
  <h2 class="text-center mb-4">🛒 Browse Products</h2>

  <!-- Dropdown Category Filter -->
  <form method="GET" class="row justify-content-center mb-4">
    <div class="col-md-6">
      <select name="category" class="form-select" onchange="this.form.submit()">
        <option value="">All Categories</option>
        <?php foreach ($categories as $cat): ?>
          <option value="<?= htmlspecialchars($cat) ?>" <?= $cat === $selectedCategory ? 'selected' : '' ?>>
            <?= htmlspecialchars($cat) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
  </form>

  <!-- Product Grid -->
  <?php if ($products): ?>
    <div class="products-grid">
      <?php foreach ($products as $p): ?>
        <div class="product-card">
          <img src="pics/<?= htmlspecialchars($p['image_url']) ?>" alt="<?= htmlspecialchars($p['name']) ?>">
          <h5 class="mt-2"><?= htmlspecialchars($p['name']) ?></h5>
          <p class="text-muted">$<?= number_format($p['price'], 2) ?></p>
          <span class="badge bg-secondary"><?= htmlspecialchars($p['category_name']) ?></span><br>
          <a href="view_product_details.php?id=<?= $p['id'] ?>" class="details-btn">View Details</a>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <p class="text-center">No products found in this category.</p>
  <?php endif; ?>
</div>

<!-- Styles -->
<style>
.products-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
  gap: 20px;
}
.product-card {
  background: #fff;
  padding: 15px;
  text-align: center;
  border: 1px solid #ddd;
  border-radius: 8px;
  transition: transform .2s;
}
.product-card:hover {
  transform: scale(1.03);
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
.product-card img {
  max-width: 100%;
  height: 160px;
  object-fit: contain;
}
.details-btn {
  display: inline-block;
  margin-top: 10px;
  padding: 6px 12px;
  background: #007bff;
  color: #fff;
  border-radius: 4px;
  text-decoration: none;
  font-weight: 600;
}
.details-btn:hover {
  background: #0056b3;
}
</style>

<?php include './includes/footer.php'; ?>
