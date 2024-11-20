<?php
$pageTitle = "Product Details";
include 'includes/header.php';

// Include the products data
include 'scripts/data.php';

// Get product details by ID
$productId = $_GET['id'] ?? null;
$product = $products[$productId] ?? null;

if (!$product) {
    echo "<h1>Product not found</h1>";
} else {
?>
    <div class="product-container">
        <div class="product-image">
            <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
        </div>
        <div class="product-details">
            <h1><?php echo $product['name']; ?></h1>
            <p class="price">$<?php echo $product['price']; ?></p>
            <button class="add-to-cart">Add to Cart</button>
        </div>
    </div>
<?php
}
include 'includes/footer.php';
?>
