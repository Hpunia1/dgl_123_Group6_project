<?php
include '../db.php';
include '../scripts/data.php';
session_start();

// Redirect to login if admin is not logged in.
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login.php");
    exit();
}

// Fetch products with their discounts
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
    echo "<p>" . $e->getMessage() . "</p>";
    include '../scripts/databackup.php'; // Fallback to hardcoded data
    $products = $products ?? []; // Use fallback data if available
}

// Handle delete product
if (isset($_GET['delete'])) {
    $productId = $_GET['delete'];
    $deleteQuery = "DELETE FROM products WHERE id = $productId";
    if (mysqli_query($conn, $deleteQuery)) {
        header("Location: products.php");
        exit();
    } else {
        echo "<p>Error deleting product: " . mysqli_error($conn) . "</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
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
        .price-original {
            text-decoration: line-through;
            color: #999;
            font-size: 14px;
        }
        .price-discount {
            color: #000;
            font-size: 16px;
            font-weight: bold;
        }
        .card {
            position: relative;
        }
    </style>
</head>
<body class="bg-light">
<div class="d-flex">
    <!-- Sidebar -->
    <aside class="bg-white shadow-sm" style="width: 250px; height: 100vh;">
        <div class="p-3 text-center fw-bold border-bottom">Admin Panel</div>
        <nav class="mt-3">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="index.php" class="nav-link px-3 py-2">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a href="products.php" class="nav-link px-3 py-2 active">Products</a>
                </li>
                <li class="nav-item">
                    <a href="categories.php" class="nav-link px-3 py-2">Categories</a>
                </li>
                <li class="nav-item">
                    <a href="sales.php" class="nav-link px-3 py-2">Sales</a>
                </li>
                <li class="nav-item">
                    <a href="customers.php" class="nav-link px-3 py-2">Customers</a>
                </li>
            </ul>
        </nav>
    </aside>
    <div class="container-fluid p-4">
        <h1 class="text-center">Product List</h1>
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <!-- Discount Label -->
                        <?php if ($product['discount'] > 0): ?>
                            <div class="discount-label"><?= $product['discount']; ?>% OFF</div>
                        <?php endif; ?>
                        
                        <img src="<?= htmlspecialchars($product['image']); ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($product['name']); ?></h5>
                            <p class="card-text">
                                <!-- Original Price -->
                                <?php if ($product['discount'] > 0): ?>
                                    <span class="price-original">$<?= number_format($product['price'], 2); ?></span>
                                <?php endif; ?>
                                <!-- Discounted Price -->
                                <span class="price-discount">$<?= number_format($product['final_price'], 2); ?></span>
                            </p>
                            <p class="card-text">Category: <?= htmlspecialchars($product['category']); ?></p>
                            <!-- Action Buttons -->
                            <div class="d-flex justify-content-between mt-3">
                                <!-- Delete Button -->
                                <a href="?delete=<?= $product['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                                <!-- Discount Button -->
                                <a href="sales.php?product_id=<?= $product['id']; ?>" class="btn btn-primary btn-sm">Add Discount</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>