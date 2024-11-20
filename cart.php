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
        unset($cart[$removeId]);
        $_SESSION['cart'] = $cart;
        header('Location: cart.php');
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
        <?php foreach ($cart as $key => $item): ?>
            
            <div class="cart-item">
                <img src="<?= htmlspecialchars($item['image']); ?>" alt="Product Image">
                <div>
                    <h3><?= htmlspecialchars($item['name']); ?></h3>
                    <p>Quantity: <?= htmlspecialchars($item['quantity']); ?></p>
                    <p>Price: $<?= number_format($item['price'], 2); ?></p>
                    <a href="cart.php?remove_id=<?= htmlspecialchars($key); ?>">Remove</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Your cart is empty. <a href="shopping.php">Continue Shopping</a></p>
    <?php endif; ?>

    <div class="order-summary">
        <h2>Order Summary</h2>
        <p>Subtotal: $<?= number_format($subtotal, 2); ?></p>
        <p><a href="checkout.php">Proceed to Checkout</a></p>
    </div>
</main>
<?php include 'includes/footer.php'; ?>
