<?php include 'config.php'; ?>
<link rel="stylesheet" href="styles.css">

<h2>Order Management</h2>
<table border="1">
    <tr>
        <th>Order ID</th>
        <th>User ID</th>
        <th>Total Price</th>
        <th>Status</th>
    </tr>
    <?php
    $orders = $conn->query("SELECT * FROM orders");
    while ($row = $orders->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['user_id']}</td>
                <td>${$row['total_price']}</td>
                <td>{$row['status']}</td>
              </tr>";
    }
    ?>
</table>
