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
<div class="container mt-5">
    <h1 class="text-center">Your Cart</h1>
    <p class="text-center"><a href="shopping.php">Continue Shopping</a></p>

    <?php if (!empty($cart)): ?>
        <div class="row">
            <?php foreach ($cart as $key => $item): ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="<?= htmlspecialchars($item['image']); ?>" class="card-img-top" alt="Product Image">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($item['name']); ?></h5>
                            <p>Quantity: <?= htmlspecialchars($item['quantity']); ?></p>
                            <p>Price: $<?= number_format($item['price'], 2); ?></p>
                            <a href="cart.php?remove_id=<?= htmlspecialchars($key); ?>" class="btn btn-danger btn-sm">Remove</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center">
            <h2>Subtotal: $<?= number_format($subtotal, 2); ?></h2>
            <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
        </div>
    <?php else: ?>
        <p class="text-center">Your cart is empty. <a href="shopping.php">Continue Shopping</a></p>
    <?php endif; ?>
</div>
<?php include 'includes/footer.php'; ?>