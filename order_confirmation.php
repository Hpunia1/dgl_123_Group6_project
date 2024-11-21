<?php
session_start();

$pageTitle = "Order Confirmation";
include 'includes/header.php';

$order_id = htmlspecialchars($_GET['order_id'] ?? '');

// Display confirmation
if ($order_id) {
    echo "<h1>Order Confirmed!</h1>";
    echo "<p>Thank you for your purchase. Your order ID is <strong>$order_id</strong>.</p>";
    echo "<p><a href='shopping.php'>Continue Shopping</a></p>";
} else {
    echo "<p>Invalid order ID.</p>";
}

include 'includes/footer.php';
?>