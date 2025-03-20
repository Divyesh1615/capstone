<?php
session_start();
require_once __DIR__ . '/../config/db.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

// Validate product ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: manage_products.php");
    exit();
}

$product_id = (int) $_GET['id'];

// Fetch product image
$stmt = $conn->prepare("SELECT image FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$stmt->bind_result($image);
$stmt->fetch();
$stmt->close();

// Delete product from database
$stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);

if ($stmt->execute()) {
    // Delete product image file if exists
    $image_path = __DIR__ . "/../uploads/" . $image;
    if (file_exists($image_path)) {
        unlink($image_path);
    }

    $_SESSION['success_message'] = "Product deleted successfully!";
} else {
    $_SESSION['success_message'] = "Error deleting product.";
}

$stmt->close();
$conn->close();

header("Location: manage_products.php");
exit();
?>
