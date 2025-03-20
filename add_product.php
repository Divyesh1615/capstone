<?php
session_start();
require_once __DIR__ . '/../config/db.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

$error_message = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST['name']) ? trim(htmlspecialchars($_POST['name'])) : '';
    $description = isset($_POST['description']) ? trim(htmlspecialchars($_POST['description'])) : '';
    $price = isset($_POST['price']) ? (float) $_POST['price'] : 0.0;

    // Ensure the uploads directory exists
    $target_dir = __DIR__ . "/../uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageFileType = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        
        // Validate file upload
        if ($_FILES['image']['size'] > 5000000) {
            $error_message = "File size too large. Maximum 5MB allowed.";
        } elseif (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
            $error_message = "Invalid file type. Only JPG, JPEG, PNG, and GIF allowed.";
        } else {
            // Store a unique filename
            $image = time() . "_" . basename($_FILES['image']['name']);
            $target_file = $target_dir . $image;

            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $stmt = $conn->prepare("INSERT INTO products (name, description, price, image) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssds", $name, $description, $price, $image);

                if ($stmt->execute()) {
                    $_SESSION['success_message'] = "Product added successfully!";
                    header("Location: manage_product.php");
                    exit();
                } else {
                    $error_message = "Error adding product.";
                }
                $stmt->close();
            } else {
                $error_message = "Failed to upload image.";
            }
        }
    } else {
        $error_message = "Please upload an image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="product-container">
    <h2>Add Product</h2>

    <?php 
    if (!empty($error_message)) {
        echo "<p class='error-message'>$error_message</p>"; 
    } elseif (isset($_SESSION['success_message'])) {
        echo "<p class='success-message'>" . $_SESSION['success_message'] . "</p>";
        unset($_SESSION['success_message']); // Clear success message after displaying
    }
    ?>

    <form method="POST" action="add_product.php" enctype="multipart/form-data">
        <label>Product Name:</label>
        <input type="text" name="name" placeholder="Enter Product Name" required value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">

        <label>Description:</label>
        <textarea name="description" placeholder="Enter Product Description" required><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>

        <label>Price:</label>
        <input type="number" name="price" step="0.01" placeholder="Enter Price" required value="<?php echo isset($_POST['price']) ? htmlspecialchars($_POST['price']) : ''; ?>">

        <label>Upload Image:</label>
        <input type="file" name="image" required>

        <button type="submit" class="button">Add Product</button>
    </form>

    <a href="dashboard.php" class="back-button">⬅ Back to Dashboard</a>
</div>

</body>
</html>
