<?php
session_start();

$pageTitle = "Product Details";
include 'includes/header.php';

// Include the products data
include 'scripts/data.php';

// Get product details by ID
$productId = $_GET['id'] ?? null;
$product = $products[$productId] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $cart = $_SESSION['cart'] ?? [];
    $selectedSize = $_POST['size'] ?? 'Default';
    $selectedColor = $_POST['color'] ?? 'Default';

    // Generate a unique key for size and color combinations
    $uniqueKey = $productId . '_' . $selectedSize . '_' . $selectedColor;

    // Check if the item with the selected size and color already exists in the cart
    if (isset($cart[$uniqueKey])) {
        $cart[$uniqueKey]['quantity'] += 1; // Increment quantity if already in the cart
    } else {
        // Add a new item with selected size and color to the cart
        $cart[$uniqueKey] = [
            'id' => $productId,
            'name' => $product['name'],
            'price' => $product['price'],
            'image' => $product['image'],
            'quantity' => 1,
            'size' => $selectedSize,
            'color' => $selectedColor,
        ];
    }

    $_SESSION['cart'] = $cart; // Update session
    header('Location: cart.php'); // Redirect to cart page
    exit();
}

if (!$product) {
    echo "<h1>Product not found</h1>";
} else {
?>
    <div class="product-container">
        <div class="product-image">
            <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
        </div>
        <div class="product-details">
            <h1><?php echo htmlspecialchars($product['name']); ?></h1>
            <p class="price">$<?php echo number_format($product['price'], 2); ?></p>
            <form method="post">
                <label for="size">Select Size:</label>
                <select name="size" id="size" required>
                    <option value="S">Small</option>
                    <option value="M">Medium</option>
                    <option value="L">Large</option>
                    <option value="XL">Extra Large</option>
                </select>

                <label for="color">Select Color:</label>
                <select name="color" id="color" required>
                    <option value="Red">Red</option>
                    <option value="Blue">Blue</option>
                    <option value="Green">Green</option>
                    <option value="Black">Black</option>
                </select>

                <button type="submit" name="add_to_cart">Add to Cart</button>
            </form>
        </div>
    </div>
<?php
}
include 'includes/footer.php';
?>