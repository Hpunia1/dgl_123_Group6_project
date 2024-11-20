<?php
session_start();

$pageTitle = "Product Details";
include 'includes/header.php';

// Include the products data
include 'scripts/data.php';

// Get product details by ID
$productId = isset($_GET['id']) ? (int)$_GET['id'] : null;

// Validate if the product exists in the array
$product = null;
foreach ($products as $item) {
    if ($item['id'] === $productId) {
        $product = $item;
        break;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $cart = $_SESSION['cart'] ?? [];
    $selectedSize = $_POST['size'] ?? 'Default';
    $selectedColor = $_POST['color'] ?? 'Default';

    // Generate a unique key for size and color combinations
    $uniqueKey = $productId . '_' . $selectedSize . '_' . $selectedColor;

    if (isset($cart[$uniqueKey])) {
        $cart[$uniqueKey]['quantity'] += 1;
    } else {
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

    $_SESSION['cart'] = $cart;
    header('Location: cart.php');
    exit();
}

if (!$product) {
    echo "<h1>Product not found</h1>";
} else {
?>
    <div class="product-container">
        <div class="product-image">
            <img src="<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['name']); ?>">
        </div>
        <div class="product-details">
            <h1><?= htmlspecialchars($product['name']); ?></h1>
            <p class="price">$<?= number_format($product['price'], 2); ?></p>
            <form method="post">
                <input type="hidden" name="product_id" value="<?= htmlspecialchars($productId); ?>">
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
