<?php
session_start();

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];

    if (isset($_SESSION['cart'][$id])) {
        if ($_SESSION['cart'][$id] > 1) {
            $_SESSION['cart'][$id]--; // Decrease quantity by 1
        } else {
            unset($_SESSION['cart'][$id]); // Remove if only 1 left
        }
    }
}

header("Location: /Project/cart.php");
exit;
