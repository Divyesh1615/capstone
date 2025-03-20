<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: /Capstones/admin/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">

    
</head>
<body>

<div class="dashboard-container">
    <h2>Welcome, <?php echo $_SESSION['admin_name']; ?>!</h2>
    <p>You are logged in as an admin.</p>

    <div class="button-container">
        <a href="add_product.php" class="button">➕ Add Product</a>
        <a href="manage_products.php" class="button">🛍️ Manage Products</a>
        <a href="logout.php" class="button logout">🚪 Logout</a>
    </div>
</div>

</body>
</html>
