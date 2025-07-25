<?php
session_start();



if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid product ID.");
}

$product_id = (int)$_GET['id'];
$quantity = isset($_GET['quantity']) ? (int)$_GET['quantity'] : 1;

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// If product is already in cart, increase quantity
if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id] += $quantity;
} else {
    $_SESSION['cart'][$product_id] = $quantity;
}

// Redirect to cart or back to product list
header("Location: cart.php");
exit;
