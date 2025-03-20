<?php
session_start();
include '../config/db.php';
include '../includes/navbar.php';

// Check if the cart is empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<p class='error-message'>Your cart is empty. Please add items before checkout.</p>";
    include '../includes/footer.php';
    exit;
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<p class='error-message'>Please <a href='../login.php'>log in</a> to proceed to checkout.</p>";
    include '../includes/footer.php';
    exit;
}

$user_id = $_SESSION['user_id'];
$total_price = 0;
$order_items = [];

// Prepare order details
foreach ($_SESSION['cart'] as $item) {
    $total_price += $item['price'] * $item['quantity'];
    $order_items[] = [
        'product_id' => $item['id'],
        'quantity' => $item['quantity'],
        'price' => $item['price']
    ];
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['payment_method'])) {
    $payment_method = $_POST['payment_method'];
    $card_number = $_POST['card_number'] ?? null;
    $card_expiry = $_POST['card_expiry'] ?? null;
    $card_cvv = $_POST['card_cvv'] ?? null;

    // Restrict Cash on Delivery for orders under $150
    if ($payment_method == "COD" && $total_price < 150) {
        echo "<p class='error-message'>Cash on Delivery is only available for orders above $150.</p>";
        include '../includes/footer.php';
        exit;
    }

    // Validate card expiry date if payment method is Credit Card
    if ($payment_method == "Credit Card") {
        $currentMonth = date('m');
        $currentYear = date('y');

        list($expMonth, $expYear) = explode("/", $card_expiry);
        $expMonth = intval($expMonth);
        $expYear = intval($expYear);

        if ($expYear < $currentYear || ($expYear == $currentYear && $expMonth < $currentMonth)) {
            echo "<p class='error-message'>Your card has expired. Please use a valid card.</p>";
            include '../includes/footer.php';
            exit;
        }
    }

    // Insert order into database
    $order_query = "INSERT INTO orders (user_id, total_price, payment_method, status, created_at) VALUES (?, ?, ?, 'pending', NOW())";
    $order_stmt = $conn->prepare($order_query);
    if (!$order_stmt) {
        die("Database error: " . $conn->error);
    }
    $order_stmt->bind_param("ids", $user_id, $total_price, $payment_method);
    $order_stmt->execute();
    $order_id = $order_stmt->insert_id;

    // Insert each item into `order_items` table
    foreach ($order_items as $item) {
        $item_query = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
        $item_stmt = $conn->prepare($item_query);
        if (!$item_stmt) {
            die("Database error: " . $conn->error);
        }
        $item_stmt->bind_param("iiid", $order_id, $item['product_id'], $item['quantity'], $item['price']);
        $item_stmt->execute();
    }

    // Clear cart after successful checkout
    unset($_SESSION['cart']);

    // Redirect to confirmation page
    header("Location: confirmation.php?order_id=" . $order_id);
    exit;
}
?>

<link rel="stylesheet" href="checkout.css">

<div class="checkout-container">
    <h2>Secure Checkout</h2>
    <p>Total Amount: <strong>$<?php echo number_format($total_price, 2); ?></strong></p>

    <form method="POST" action="" onsubmit="return validatePayment()">
        <h3>Select Payment Method</h3>

        <label>
            <input type="radio" name="payment_method" value="COD" required onclick="togglePaymentFields()"> 
            Cash on Delivery (Available for orders above $150)
        </label><br>

        <label>
            <input type="radio" name="payment_method" value="Credit Card" required onclick="togglePaymentFields()"> 
            Credit/Debit Card
        </label><br>

        <div id="card-details" style="display: none;">
            <h3>Enter Card Details</h3>
            <label>Card Number:</label>
            <input type="text" name="card_number" id="card_number" placeholder="1234 5678 9101 1121" maxlength="16">

            <label>Expiry Date:</label>
            <input type="text" name="card_expiry" id="card_expiry" placeholder="MM/YY" maxlength="5">

            <label>CVV:</label>
            <input type="text" name="card_cvv" id="card_cvv" placeholder="123" maxlength="3">
        </div>

        <button type="submit" class="btn">Confirm Order</button>
    </form>
</div>

<script>
    function togglePaymentFields() {
        let selectedMethod = document.querySelector('input[name="payment_method"]:checked').value;
        let cardDetails = document.getElementById("card-details");

        if (selectedMethod === "Credit Card") {
            cardDetails.style.display = "block";
        } else {
            cardDetails.style.display = "none";
        }
    }

    function validatePayment() {
        let selectedMethod = document.querySelector('input[name="payment_method"]:checked').value;

        if (selectedMethod === "Credit Card") {
            let cardNumber = document.getElementById("card_number").value;
            let cardExpiry = document.getElementById("card_expiry").value;
            let cardCvv = document.getElementById("card_cvv").value;

            let cardNumberPattern = /^[0-9]{16}$/;
            let cardExpiryPattern = /^(0[1-9]|1[0-2])\/\d{2}$/;
            let cardCvvPattern = /^[0-9]{3}$/;

            if (!cardNumberPattern.test(cardNumber)) {
                alert("Please enter a valid 16-digit card number.");
                return false;
            }

            if (!cardExpiryPattern.test(cardExpiry)) {
                alert("Please enter a valid expiry date (MM/YY).");
                return false;
            }

            let currentMonth = new Date().getMonth() + 1; // JS months are 0-indexed
            let currentYear = new Date().getFullYear() % 100; // Get last 2 digits of year

            let expMonth = parseInt(cardExpiry.split("/")[0], 10);
            let expYear = parseInt(cardExpiry.split("/")[1], 10);

            if (expYear < currentYear || (expYear === currentYear && expMonth < currentMonth)) {
                alert("Your card has expired. Please use a valid card.");
                return false;
            }

            if (!cardCvvPattern.test(cardCvv)) {
                alert("Please enter a valid 3-digit CVV.");
                return false;
            }
        }

        return true;
    }
</script>

<?php include '../includes/footer.php'; ?>
