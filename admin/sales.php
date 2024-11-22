<?php
include '../db.php';

// Handle Apply/Save Discount
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['discounts'] as $sale_id => $data) {
        $product_id = intval($data['product_id']);
        $discount = floatval($data['discount']);
        
        if ($sale_id === 'new') {
            // Insert new discount
            $sql = "INSERT INTO sales (product_id, discount) VALUES ('$product_id', '$discount')";
        } else {
            // Update existing discount
            $sql = "UPDATE sales SET product_id = '$product_id', discount = '$discount' WHERE id = $sale_id";
        }
        mysqli_query($conn, $sql);
    }

    // Redirect to refresh page
    header("Location: sales.php");
    exit();
}

// Handle Delete Discount
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $sql = "DELETE FROM sales WHERE id = $delete_id";
    if (mysqli_query($conn, $sql)) {
        header("Location: sales.php");
        exit();
    } else {
        die("Error deleting sale: " . mysqli_error($conn));
    }
}

// Fetch all sales
$sales = mysqli_query($conn, "SELECT s.id, p.id AS product_id, p.name AS product, s.discount 
                              FROM sales s 
                              JOIN products p ON s.product_id = p.id");
$products = mysqli_query($conn, "SELECT id, name FROM products");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Sales</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
                        <a href="products.php" class="nav-link px-3 py-2">Products</a>
                    </li>
                    <li class="nav-item">
                        <a href="categories.php" class="nav-link px-3 py-2">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a href="sales.php" class="nav-link px-3 py-2 active">Sales</a>
                    </li>
                    <li class="nav-item">
                        <a href="customers.php" class="nav-link px-3 py-2">Customers</a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="container py-4">
            <h1 class="h4 mb-4">Manage Discounts</h1>

            <!-- Sales Form -->
            <form method="POST">
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
                            <!-- Existing Discounts -->
                            <?php while ($sale = mysqli_fetch_assoc($sales)): ?>
                            <tr>
                                <td>
                                    <select name="discounts[<?= $sale['id'] ?>][product_id]" class="form-control">
                                        <?php
                                        mysqli_data_seek($products, 0); // Reset product pointer
                                        while ($product = mysqli_fetch_assoc($products)): ?>
                                            <option value="<?= $product['id'] ?>" <?= $sale['product_id'] == $product['id'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($product['name']) ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="discounts[<?= $sale['id'] ?>][discount]" value="<?= htmlspecialchars($sale['discount']) ?>" class="form-control">
                                </td>
                                <td>
                                    <a href="sales.php?delete_id=<?= $sale['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this discount?')">Remove</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>

                            <!-- New Discount Row -->
                            <tr>
                                <td>
                                    <select name="discounts[new][product_id]" class="form-control">
                                        <option value="" disabled selected>Select Product</option>
                                        <?php
                                        mysqli_data_seek($products, 0); // Reset product pointer
                                        while ($product = mysqli_fetch_assoc($products)): ?>
                                            <option value="<?= $product['id'] ?>"><?= htmlspecialchars($product['name']) ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="discounts[new][discount]" placeholder="Enter Discount" class="form-control">
                                </td>
                                <td>
                                    <span class="text-muted">New Discount</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Save Button -->
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>