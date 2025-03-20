<?php include 'config.php'; ?>
<?php
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$result = $conn->query("SELECT * FROM products");
?>
<link rel="stylesheet" href="styles.css">

<h2>Product Management</h2>
<a href="add_product.php">Add New Product</a>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Price</th>
        <th>Image</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td>$<?php echo $row['price']; ?></td>
            <td><img src="../uploads/<?php echo $row['image']; ?>" width="50"></td>
            <td>
                <a href="edit_product.php?id=<?php echo $row['id']; ?>">Edit</a>
                <a href="delete_product.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Delete this product?');">Delete</a>
            </td>
        </tr>
    <?php } ?>
</table>
