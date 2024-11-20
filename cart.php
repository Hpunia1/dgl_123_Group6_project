<?php
$pageTitle = "Cart";
include 'includes/header.php';

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Initialize subtotal
$subtotal = 0;

// Calculate totals if cart is not empty
if (!empty($cart)) {
    foreach ($cart as $item) {
        $subtotal += $item['price'] * $item['quantity'];
    }
}
?><main class="cart-container">
<section class="cart-items">
    <h1>Your Cart</h1>
    <p>Not ready to checkout? <a href="shopping.php">Continue Shopping</a></p>
    
    <?php if (!empty($cart)): ?>
        <?php foreach ($cart as $item): ?>
            <div class="cart-item">
                <img src="assets/images/<?php echo htmlspecialchars($item['image']); ?>" alt="Product Image" class="cart-item-image">
                <div class="cart-item-details">
                    <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                    <p>Size: <?php echo htmlspecialchars($item['size']); ?></p>
                    <p>Quantity: <?php echo htmlspecialchars($item['quantity']); ?></p>
                    <p class="price">$<?php echo number_format($item['price'], 2); ?></p>
                    <a href="remove_item.php?id=<?php echo $item['id']; ?>" class="remove-item">Remove</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Your cart is empty. <a href="shopping.php">Continue Shopping</a></p>
    <?php endif; ?>
</section>

<aside class="order-summary">
    <h2>Order Summary</h2>
    <div class="coupon">
        <input type="text" placeholder="Enter coupon code here">
    </div>
    <div class="summary-details">
        <p>Subtotal: <span>$<?php echo number_format($subtotal, 2); ?></span></p>
        <p>Shipping: <span>Calculated at the next step</span></p>
        <p>Total: <span>$<?php echo number_format($subtotal, 2); ?></span></p>
    </div>
    <button class="checkout-btn">Continue to Checkout</button>
</aside>
</main>

<section class="order-info">
<h2>Order Information</h2>
<details>
    <summary>Return Policy</summary>
    <p>This is our example return policy which is everything you need to know about our returns.</p>
</details>
<details>
    <summary>Shipping Options</summary>
    <p>Information about shipping options will go here.</p>
</details>
</section>

<?php include 'includes/footer.php'; ?>
