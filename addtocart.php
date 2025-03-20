<?php
session_start();
include 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    echo "<p class='error-message'>Please log in to add items to the cart.</p>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);

    // Check if the product exists
    $query = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if (!$product) {
        echo "<p class='error-message'>Product not found.</p>";
        exit;
    }

    // Check if the item is already in the cart
    $check_cart = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
    $check_cart->bind_param("ii", $user_id, $product_id);
    $check_cart->execute();
    $cart_result = $check_cart->get_result();

    if ($cart_result->num_rows > 0) {
        // If the item is already in the cart, update the quantity
        $update_cart = $conn->prepare("UPDATE cart SET quantity = quantity + ? WHERE user_id = ? AND product_id = ?");
        $update_cart->bind_param("iii", $quantity, $user_id, $product_id);
        $update_cart->execute();
    } else {
        // If not, insert a new item into the cart
        $insert_cart = $conn->prepare("INSERT INTO cart (user_id, product_id, product_name, price, quantity) VALUES (?, ?, ?, ?, ?)");
        $insert_cart->bind_param("iisdi", $user_id, $product_id, $product['name'], $product['price'], $quantity);
        $insert_cart->execute();
    }
}

header("Location: cart.php");
exit();
