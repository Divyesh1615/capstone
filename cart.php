<?php
session_start();
include '../config/db.php';
include '../includes/navbar.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'], $_POST['quantity'])) {
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);

    // Fetch product details from database
    $query = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Check if product is already in cart
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$product_id] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $quantity,
                'image' => $product['image']
            ];
        }
    }
}

// Display cart items
?>

<link rel="stylesheet" href="cart.css">

<div class="cart-container">
    <h2>Shopping Cart</h2>

    <?php if (!empty($_SESSION['cart'])): ?>
        <table class="cart-table">
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Action</th>
            </tr>

            <?php
            $total_price = 0;
            foreach ($_SESSION['cart'] as $item):
                $item_total = $item['price'] * $item['quantity'];
                $total_price += $item_total;
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td>$<?php echo number_format($item['price'], 2); ?></td>
                    <td><?php echo intval($item['quantity']); ?></td>
                    <td>$<?php echo number_format($item_total, 2); ?></td>
                    <td>
                        <a href="removefromcart.php?id=<?php echo $item['id']; ?>" class="remove-btn">❌ Remove</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <div class="cart-summary">
            <h3>Total: $<?php echo number_format($total_price, 2); ?></h3>
            <a href="checkout.php" class="btn">Proceed to Checkout</a>
        </div>

    <?php else: ?>
        <p class="empty-cart">Your cart is empty.</p>
    <?php endif; ?>

</div>

<?php include '../includes/footer.php'; ?>
