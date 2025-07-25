<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "computer_store");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$products = $conn->query("SELECT id, name, price, image_url FROM products");
?>

<?php include "./includes/header.php"; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?>!</h2>
        <form method="POST" action="user_logout.php">
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
    </div>

    <h4 class="mb-3">Available Products</h4>

    <div class="row">
        <?php while ($row = $products->fetch_assoc()): ?>
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <img src="pics/<?= htmlspecialchars($row['image_url']) ?>" class="card-img-top" alt="<?= htmlspecialchars($row['name']) ?>" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($row['name']) ?></h5>
                        <p class="card-text">$<?= number_format($row['price'], 2) ?></p>
                        <a href="/Project/view_product_details.php?id=<?= $row['id'] ?>" class="btn btn-md btn-outline-primary";>View Details</a>
                        
                        <a href="/Project/add_to_cart.php?id=<?= (int)$row['id'] ?>" class="btn btn-success mt-1">Add to Cart</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include "./includes/footer.php"; ?>
