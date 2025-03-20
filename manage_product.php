<?php
session_start();
require_once __DIR__ . '/../config/db.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

// Show success message if redirected from add_product.php
$success_message = "";
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']); // Clear the message
}

$result = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="manage-container">
    <h2>Manage Products</h2>

    <?php if (!empty($success_message)) echo "<p class='success-message'>$success_message</p>"; ?>

    <div class="action-buttons">
        <a href="add_product.php" class="button">➕ Add New Product</a>
    </div>

    <div class="table-container">
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
            <?php while ($product = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($product['id']) ?></td>
                <td><?= htmlspecialchars($product['name']) ?></td>
                <td><?= htmlspecialchars($product['description']) ?></td>
                <td>$<?= number_format($product['price'], 2) ?></td>
                <td><img src="../uploads/<?= htmlspecialchars($product['image']) ?>" alt="Product Image"></td>
                <td class="action-links">
                    <a href="edit_product.php?id=<?= $product['id'] ?>" class="edit">✏ Edit</a>
                    <a href="delete_product.php?id=<?= $product['id'] ?>" class="delete" onclick="return confirm('Are you sure?');">❌ Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <div class="action-buttons">
        <a href="dashboard.php" class="button back-button">⬅ Back to Dashboard</a>
    </div>
</div>

</body>
</html>
