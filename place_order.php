<?php
session_start();
require_once './includes/conn.php'; // assumes $pdo is a valid PDO connection

// ✅ 1. Check if user is logged in
if (!isset($_SESSION['user_email'])) {
    header('Location: login.php');
    exit;
}

// ✅ 2. Check if cart exists and has items
$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) {
    header('Location: cart.php?msg=empty');
    exit;
}

try {
    // ✅ 3. Fetch product prices in one query
    $productIds = array_keys($cart);
    $placeholders = implode(',', array_fill(0, count($productIds), '?'));

    $stmt = $pdo->prepare("SELECT id, price FROM products WHERE id IN ($placeholders)");
    $stmt->execute($productIds);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($products) !== count($productIds)) {
        throw new Exception("Some products in your cart no longer exist.");
    }

    // ✅ 4. Calculate total
    $total = 0;
    $priceMap = [];
    foreach ($products as $product) {
        $pid = $product['id'];
        $price = $product['price'];
        $qty = $cart[$pid];
        $priceMap[$pid] = $price;
        $total += $price * $qty;
    }

    // ✅ 5. Start transaction
    $pdo->beginTransaction();

    // ✅ 6. Insert order
    $stmt = $pdo->prepare("INSERT INTO orders (user_email, total_price, created_at) VALUES (?, ?, NOW())");
    $stmt->execute([$_SESSION['user_email'], $total]);
    $orderId = $pdo->lastInsertId();

    // ✅ 7. Insert order items (optional)
    $stmtItem = $pdo->prepare("
        INSERT INTO order_items (order_id, product_id, quantity, unit_price)
        VALUES (?, ?, ?, ?)
    ");
    foreach ($cart as $pid => $qty) {
        $stmtItem->execute([$orderId, $pid, $qty, $priceMap[$pid]]);
    }

    // ✅ 8. Commit & clear cart
    $pdo->commit();
    unset($_SESSION['cart']);

    // ✅ 9. Redirect to success page
    header("Location: order_success.php?orderId=$orderId");
    exit;

} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    die("Order failed: " . htmlspecialchars($e->getMessage()));
}
