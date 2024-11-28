<?php
session_start();
$pageTitle = "Product Details";
include 'includes/header.php';

// Include the database connection
include 'db.php';

// Get product details by ID
$productId = isset($_GET['id']) ? (int)$_GET['id'] : null;

// Fetch the product from the database
$query = "SELECT * FROM products WHERE id = $productId";
$result = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $cart = $_SESSION['cart'] ?? [];
    $productId = $_POST['product_id'];
    $selectedSize = $_POST['size'] ?? 'Default';
    $quantity = (int)$_POST['quantity'];

    // Generate a unique key for size combinations
    $uniqueKey = $productId . '_' . $selectedSize;

    if (isset($cart[$uniqueKey])) {
        $cart[$uniqueKey]['quantity'] += $quantity;
    } else {
        $cart[$uniqueKey] = [
            'id' => $productId,
            'name' => $product['name'],
            'price' => $product['price'],
            'image' => $product['image'],
            'quantity' => $quantity,
            'size' => $selectedSize,
        ];
    }

    $_SESSION['cart'] = $cart;
    header('Location: cart.php');
    exit();
}

if (!$product) {
    echo "<h1>Product not found</h1>";
} else {
?>
<div class="container mt-5">
    <div class="row">
        <!-- Product Image -->
        <div class="col-md-6">
            <img src="<?= htmlspecialchars($product['image']); ?>" class="img-fluid rounded" alt="<?= htmlspecialchars($product['name']); ?>">
        </div>
        <!-- Product Details -->
        <div class="col-md-6">
            <h1><?= htmlspecialchars($product['name']); ?></h1>
            <p class="text-muted">$<?= number_format($product['price'], 2); ?></p>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse auctor, sapien non laoreet volutpat, risus nisi scelerisque odio, eget vehicula libero nunc sit amet massa.</p>
            <form method="POST" class="mt-4">
                <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']); ?>">

                <!-- Size Dropdown -->
                <div class="mb-3">
                    <label for="size" class="form-label">Select Size:</label>
                    <select name="size" id="size" class="form-select" required>
                        <option value="S">Small</option>
                        <option value="M">Medium</option>
                        <option value="L">Large</option>
                        <option value="XL">Extra Large</option>
                    </select>
                </div>

                <!-- Quantity Selector -->
                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity:</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1" required>
                </div>

                <!-- Add to Cart Button -->
                <button type="submit" name="add_to_cart" class="btn btn-primary">Add to Cart</button>
            </form>
        </div>
    </div>
</div>
<?php
}
include 'includes/footer.php';
?>