<?php
include '../db.php';

// Handle form submission for adding/updating sales
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $product_id = $_POST['product_id'];
    $discount = $_POST['discount'];

    if ($id) {
        // Update existing sale
        $sql = "UPDATE sales SET product_id = '$product_id', discount = '$discount' WHERE id = '$id'";
    } else {
        // Add new sale
        $sql = "INSERT INTO sales (product_id, discount) VALUES ('$product_id', '$discount')";
    }
    mysqli_query($conn, $sql);
}

// Fetch sales
$sales = mysqli_query($conn, "SELECT s.id, p.name AS product, s.discount 
                              FROM sales s 
                              JOIN products p ON s.product_id = p.id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-4">
        <h1 class="h4 mb-4">Manage Sales</h1>

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
<main>
        <!-- Add/Edit Sale Form -->
        <form method="POST" class="mb-4">
            <input type="hidden" name="id" id="sale-id">
            <div class="mb-3">
                <label for="product_id" class="form-label">Product</label>
                <select name="product_id" id="product_id" class="form-select" required>
                    <?php
                    $products = mysqli_query($conn, "SELECT id, name FROM products");
                    while ($product = mysqli_fetch_assoc($products)): ?>
                        <option value="<?= $product['id'] ?>"><?= htmlspecialchars($product['name']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="discount" class="form-label">Discount (%)</label>
                <input type="number" name="discount" id="discount" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>

        <!-- Sales Table -->
        <div class="table-responsive bg-white shadow-sm rounded">
            <table class="table table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Product</th>
                        <th scope="col">Discount (%)</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($sale = mysqli_fetch_assoc($sales)): ?>
                    <tr>
                        <td><?= htmlspecialchars($sale['product']) ?></td>
                        <td><?= htmlspecialchars($sale['discount']) ?>%</td>
                        <td>
                            <button class="btn btn-sm btn-primary" onclick="editSale(<?= $sale['id'] ?>, <?= $sale['product_id'] ?>, <?= $sale['discount'] ?>)">Edit</button>
                            <a href="delete_sale.php?id=<?= $sale['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
                    </main>
    <script>
        function editSale(id, productId, discount) {
            document.getElementById('sale-id').value = id;
            document.getElementById('product_id').value = productId;
            document.getElementById('discount').value = discount;
        }
    </script>
</body>
</html>