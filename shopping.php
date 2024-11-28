<?php
session_start();
include 'db.php'; // Include database connection
include 'includes/header.php';

// Fetch products from the database along with discounts
$products = [];
try {
    $query = "
        SELECT p.id, p.name, p.price, p.image, p.category, 
               IFNULL(s.discount, 0) AS discount
        FROM products p
        LEFT JOIN sales s ON p.id = s.product_id";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        throw new Exception("Error fetching products: " . mysqli_error($conn));
    }

    while ($row = mysqli_fetch_assoc($result)) {
        // Calculate final price with discount
        $row['final_price'] = $row['price'] - ($row['price'] * ($row['discount'] / 100));
        $products[] = $row;
    }
} catch (Exception $e) {
    echo "<p>Error fetching products: " . $e->getMessage() . "</p>";
}

// Handle Add to Cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $cart = $_SESSION['cart'] ?? [];
    $productId = $_POST['product_id'];

    // Find the product details
    foreach ($products as $product) {
        if ($product['id'] == $productId) {
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] += 1;
            } else {
                $cart[$productId] = [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'price' => $product['final_price'],
                    'image' => $product['image'],
                    'quantity' => 1,
                ];
            }
            break;
        }
    }

    $_SESSION['cart'] = $cart;
    header('Location: shopping.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .content {
            display: flex;
            gap: 20px;
        }
        .filters {
            width: 250px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
        }
        .products {
            flex-grow: 1;
        }
        .card {
            position: relative;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        .card img {
            height: 200px;
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
<body class="bg-light">
<section class="hero-shoping">
    <div class="hero-p">
        <h1>Shop Men's</h1>
        <p>
            Revamp your style with the latest designer trends in <br>men's clothing or
            achieve a perfectly curated wardrobe.
        </p>
    </div>
</section>

<div class="container mt-5">
    <div class="content">
        <!-- Filters Sidebar -->
        <aside class="filters">
            <h3>Filters</h3>
            <form method="POST">
                <div>
                    <h4>Categories</h4>
                    <ul>
                        <li>
                            <label>
                                <input type="checkbox" name="categories[]" value="Jackets" 
                                    <?= in_array('Jackets', $_POST['categories'] ?? []) ? 'checked' : ''; ?> />
                                Jackets
                            </label>
                        </li>
                        <li>
                            <label>
                                <input type="checkbox" name="categories[]" value="Sweatshirts & Hoodies" 
                                    <?= in_array('Sweatshirts & Hoodies', $_POST['categories'] ?? []) ? 'checked' : ''; ?> />
                                Sweatshirts & Hoodies
                            </label>
                        </li>
                        <li>
                            <label>
                                <input type="checkbox" name="categories[]" value="Shoes" 
                                    <?= in_array('Shoes', $_POST['categories'] ?? []) ? 'checked' : ''; ?> />
                                Shoes
                            </label>
                        </li>
                    </ul>
                </div>
                <button type="submit" class="btn btn-primary btn-sm">Apply Filters</button>
            </form>
            <div class="flt mt-2">
                <a href="shopping.php" class="btn btn-link btn-sm">Clear filters</a>
            </div>
        </aside>

        <!-- Products Section -->
        <div class="products">
            <h1 class="text-center mb-4">Products</h1>
            <div class="row">
                <?php foreach ($products as $product): ?>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <?php if ($product['discount'] > 0): ?>
                                <span class="discount-label"><?= $product['discount']; ?>% OFF</span>
                            <?php endif; ?>
                            <!-- Clickable Product Image -->
                            <a href="product.php?id=<?= $product['id']; ?>">
                                <img src="<?= htmlspecialchars($product['image']); ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']); ?>">
                            </a>
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($product['name']); ?></h5>
                                <p>
                                    <?php if ($product['discount'] > 0): ?>
                                        <span class="text-muted text-decoration-line-through">$<?= number_format($product['price'], 2); ?></span>
                                    <?php endif; ?>
                                    <span class="fw-bold">$<?= number_format($product['final_price'], 2); ?></span>
                                </p>
                                <!-- Add to Cart Form -->
                                <form method="POST">
                                    <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                                    <button type="submit" name="add_to_cart" class="btn btn-primary btn-sm">Add to Cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>