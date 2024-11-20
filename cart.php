<?php
session_start();

$pageTitle = "Cart";
include 'includes/header.php';

// Retrieve the cart
$cart = $_SESSION['cart'] ?? [];

// Handle item removal
if (isset($_GET['remove_id'])) {
    $removeId = $_GET['remove_id'];
    if (isset($cart[$removeId])) {
        unset($cart[$removeId]); // Remove the item from the cart
        $_SESSION['cart'] = $cart; // Update the session
        header('Location: cart.php'); // Refresh to update the view
        exit();
    }
}

// Calculate the subtotal
$subtotal = 0;
foreach ($cart as $item) {
    $subtotal += $item['price'] * $item['quantity'];
}
?>
<main class="cart-container">
    <h1>Your Cart</h1>
    <p><a href="shopping.php">Continue Shopping</a></p>

    <?php if (!empty($cart)): ?>
        <?php foreach ($cart as $item): ?>
            <div class="cart-item">
                <img src="assets/images/<?php echo htmlspecialchars($item['image']); ?>" alt="Product Image">
                <div>
                    <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                    <p>Quantity: <?php echo htmlspecialchars($item['quantity']); ?></p>
                    <p>Price: $<?php echo number_format($item['price'], 2); ?></p>
                    <a href="cart.php?remove_id=<?php echo $item['id']; ?>">Remove</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Your cart is empty. <a href="shopping.php">Continue Shopping</a></p>
    <?php endif; ?>

    <div class="order-summary">
        <h2>Order Summary</h2>
        <p>Subtotal: $<?php echo number_format($subtotal, 2); ?></p>
        <p><a href="checkout.php">Proceed to Checkout</a></p>
    </div>
</main>
<?php include 'includes/footer.php'; ?>