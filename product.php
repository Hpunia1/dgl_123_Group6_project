<?php
session_start();
$pageTitle = "Product Details";
include 'includes/header.php';

// Include the database connection
include 'db.php';

// Get product details by ID
$productId = isset($_GET['id']) ? (int)$_GET['id'] : null;

if (!$productId) {
    echo "<h1>Product not found</h1>";
    include 'includes/footer.php';
    exit();
}

// Fetch the product from the database, including discount
$query = "
    SELECT p.id, p.name, p.description, p.price, p.image, p.category, 
           IFNULL(s.discount, 0) AS discount
    FROM products p
    LEFT JOIN sales s ON p.id = s.product_id
    WHERE p.id = $productId";
$result = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    echo "<h1>Product not found</h1>";
    include 'includes/footer.php';
    exit();
}

// Calculate the discounted price
$product['final_price'] = $product['price'] - ($product['price'] * ($product['discount'] / 100));

// Handle Add to Cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $cart = $_SESSION['cart'] ?? [];
    $selectedSize = $_POST['size'] ?? 'Default';
    $quantity = (int)$_POST['quantity'];

    // Generate a unique key for size combinations
    $uniqueKey = $productId . '_' . $selectedSize;

    if (isset($cart[$uniqueKey])) {
        $cart[$uniqueKey]['quantity'] += $quantity;
    } else {
        $cart[$uniqueKey] = [
            'id' => $product['id'],
            'name' => $product['name'],
            'price' => $product['final_price'],
            'image' => $product['image'],
            'quantity' => $quantity,
            'size' => $selectedSize,
        ];
    }

    $_SESSION['cart'] = $cart;
    header('Location: cart.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['name']); ?> - Product Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .product-container {
            margin-top: 50px;
        }
        .product-image img {
            width: 100%;
            max-height: 500px;
            object-fit: cover;
        }
        .discount-label {
            background-color: #f00;
            color: #fff;
            padding: 2px 8px;
            font-size: 12px;
            font-weight: bold;
            border-radius: 4px;
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>
</head>
<body>
<div class="container product-container">
    <div class="row">
        <!-- Product Image -->
        <div class="col-md-6 position-relative">
            <?php if ($product['discount'] > 0): ?>
                <div class="discount-label"><?= $product['discount']; ?>% OFF</div>
            <?php endif; ?>
            <img src="<?= htmlspecialchars($product['image']); ?>" class="img-fluid rounded" alt="<?= htmlspecialchars($product['name']); ?>">
        </div>
        <!-- Product Details -->
        <div class="col-md-6">
            <h1><?= htmlspecialchars($product['name']); ?></h1>
            <p class="text-muted">
                <?php if ($product['discount'] > 0): ?>
                    <span class="text-decoration-line-through">$<?= number_format($product['price'], 2); ?></span>
                <?php endif; ?>
                <span class="fw-bold">$<?= number_format($product['final_price'], 2); ?></span>
            </p>
            <p><?= htmlspecialchars($product['description']); ?></p>
            <p>Category: <strong><?= htmlspecialchars($product['category']); ?></strong></p>
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
                <button type="submit" name="add_to_cart" class="btn btn-success">Add to Cart</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
<?php include 'includes/footer.php'; ?>