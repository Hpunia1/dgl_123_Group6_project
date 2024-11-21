<?php
session_start();

$pageTitle = "Checkout";
include 'includes/header.php';

// Retrieve the cart
$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) {
    echo "<p>Your cart is empty. <a href='shopping.php'>Continue Shopping</a></p>";
    include 'includes/footer.php';
    exit();
}

// Calculate the subtotal
$subtotal = 0;
foreach ($cart as $item) {
    $subtotal += $item['price'] * $item['quantity'];
}

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $billing_name = htmlspecialchars($_POST['billing_name']);
    $billing_address = htmlspecialchars($_POST['billing_address']);
    $billing_city = htmlspecialchars($_POST['billing_city']);
    $billing_state = htmlspecialchars($_POST['billing_state']);
    $billing_zip = htmlspecialchars($_POST['billing_zip']);
    $payment_method = htmlspecialchars($_POST['payment_method']);
    $credit_card_number = htmlspecialchars($_POST['credit_card_number'] ?? '');
    $credit_card_expiry = htmlspecialchars($_POST['credit_card_expiry'] ?? '');
    $credit_card_cvc = htmlspecialchars($_POST['credit_card_cvc'] ?? '');
    $paypal_account_id = htmlspecialchars($_POST['paypal_account_id'] ?? '');

    // You can process payment here (e.g., using a payment gateway API like Stripe/PayPal)
    $order_id = uniqid('order_');

    // Save the order to the database (example, replace with actual DB operations)
    require 'db.php';

    $stmt = $conn->prepare("INSERT INTO orders (order_id, customer_name, address, city, state, zip, payment_method, total_amount, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("sssssssd", $order_id, $billing_name, $billing_address, $billing_city, $billing_state, $billing_zip, $payment_method, $subtotal);
    $stmt->execute();

    foreach ($cart as $item) {
        $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("siid", $order_id, $item['id'], $item['quantity'], $item['price']);
        $stmt->execute();
    }

    $stmt->close();
    $conn->close();

    // Clear the cart
    unset($_SESSION['cart']);

    // Redirect to a confirmation page
    header("Location: order_confirmation.php?order_id=$order_id");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Checkout</title>
    </head>
<body>
<div class="container">
    <h1>Checkout</h1>
    <form action="checkout.php" method="POST">
        <h2>Billing Address</h2>
        <label for="billing_name">Name:</label>
        <input type="text" id="billing_name" name="billing_name" required>

        <label for="billing_address">Address:</label>
        <input type="text" id="billing_address" name="billing_address" required>

        <label for="billing_city">City:</label>
        <input type="text" id="billing_city" name="billing_city" required>

        <label for="billing_state">State:</label>
        <input type="text" id="billing_state" name="billing_state" required>

        <label for="billing_zip">ZIP Code:</label>
        <input type="text" id="billing_zip" name="billing_zip" required>

        <h2>Payment Method</h2>
        <div class="payment-method">
            <input type="radio" id="credit_card" name="payment_method" value="Credit Card" onclick="showPaymentDetails('credit_card_form')" required>
            <img src="https://img.icons8.com/color/48/000000/visa.png" alt="Credit Card">
            <label for="credit_card">Credit Card</label>
        </div>
        <div id="credit_card_form" class="payment-details">
            <label for="credit_card_number">Card Number:</label>
            <input type="text" id="credit_card_number" name="credit_card_number">

            <label for="credit_card_expiry">Expiry Date:</label>
            <input type="text" id="credit_card_expiry" name="credit_card_expiry" placeholder="MM/YY">

            <label for="credit_card_cvc">CVC:</label>
            <input type="text" id="credit_card_cvc" name="credit_card_cvc">
        </div>

        <div class="payment-method">
            <input type="radio" id="paypal" name="payment_method" value="PayPal" onclick="showPaymentDetails('paypal_form')" required>
            <img src="https://img.icons8.com/color/48/000000/paypal.png" alt="PayPal">
            <label for="paypal">PayPal</label>
        </div>
        <div id="paypal_form" class="payment-details">
            <label for="paypal_account_id">PayPal Account ID:</label>
            <input type="text" id="paypal_account_id" name="paypal_account_id">
        </div>

        <div class="payment-method">
            <input type="radio" id="cod" name="payment_method" value="Cash on Delivery" onclick="showPaymentDetails('')" required>
            <img src="https://img.icons8.com/color/48/000000/cash-in-hand.png" alt="Cash on Delivery">
            <label for="cod">Cash on Delivery</label>
        </div>

        <h2>Order Summary</h2>
        <p class="subtotal">Subtotal: $<?= number_format($subtotal, 2); ?></p>

        <button type="submit">Place Order</button>
    </form>
</div>

<script>
    function showPaymentDetails(formId) {
        // Hide all payment detail forms
        document.querySelectorAll('.payment-details').forEach(function (form) {
            form.style.display = 'none';
        });

        // Show the selected payment detail form
        if (formId) {
            document.getElementById(formId).style.display = 'block';
        }
    }
</script>
</body>
</html>