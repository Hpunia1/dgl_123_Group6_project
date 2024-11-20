<?php
session_start();

$pageTitle = "Product Details";
include 'includes/header.php';

// Include the products data
include 'scripts/data.php';

// Get product details by ID
$productId = isset($_GET['id']) ? (int)$_GET['id'] : null;

// Find the product by its ID
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
    // Define custom descriptions for specific categories
    $categoryDescriptions = [
        "Jackets" => "Stay stylish and warm with our Classic Comfort Jacket. Designed with premium materials, this jacket features a sleek silhouette, durable stitching, and a cozy inner lining. Perfect for layering during chilly days or adding a polished touch to your outfit, it’s a versatile must-have for any wardrobe. Available in a range of colors and sizes to suit your style.",
        "Shoes" => "Elevate your look with our stylish and comfortable fashion shoes. Designed for versatility, they pair effortlessly with casual or formal outfits, making them a perfect choice for any occasion. Crafted with high-quality materials for durability and all-day comfort, these shoes are a must-have for every wardrobe.",
    ];

    // Get the description for the product's category, if available
    $productDescription = $categoryDescriptions[$product['category']] ?? "No additional description is available for this product.";
?>
    <div class="product-container">
        <div class="product-image">
            <img src="<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['name']); ?>">
        </div>
        <div class="product-details">
            <h1><?= htmlspecialchars($product['name']); ?></h1>
            <p class="price">$<?= number_format($product['price'], 2); ?></p>
            <p class="description"><?= htmlspecialchars($productDescription); ?></p>
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
