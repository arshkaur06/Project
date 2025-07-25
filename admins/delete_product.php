<?php
session_start();

// Ensure only admin can access
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "computer_store");

// Check if ID is valid
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid product ID.");
}

$product_id = (int)$_GET['id'];

// Optional: Delete image file from /pics/ if you want
// $product = $conn->query("SELECT image_url FROM products WHERE id = $product_id")->fetch_assoc();
// if ($product && file_exists("../pics/" . $product['image_url'])) {
//     unlink("../pics/" . $product['image_url']); // deletes image file
// }

// Delete product
$stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();

// Redirect back to dashboard
header("Location: admin_dashboard.php");
exit;
?>
