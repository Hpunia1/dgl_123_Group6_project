<?php
// Include data.php to fetch products
$result = include '../scripts/data.php';

// Check if the query succeeded
if (!$result) {
    die("Failed to fetch products from the database.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Products</title>
    <!-- Bootstrap CSS -->
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
                        <a href="../admin/index.php" class="nav-link px-3 py-2">Dashboard</a>
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

        <!-- Main Content -->
        <main class="flex-fill">
            <!-- Header -->
            <header class="bg-white shadow-sm p-3">
                <h1 class="h4 mb-0">Products List</h1>
            </header>

            <div class="container py-4">
                <!-- Products Table -->
                <div class="table-responsive bg-white shadow-sm rounded">
                    <table class="table table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Product Name</th>
                                <th scope="col">Category</th>
                                <th scope="col">Price</th>
                                <th scope="col">Stock</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td class="d-flex align-items-center">
                                    <img src="<?= htmlspecialchars($row['image']) ?>" alt="Product Image" class="rounded-circle me-3" width="40" height="40">
                                    <?= htmlspecialchars($row['name']) ?>
                                </td>
                                <td><?= htmlspecialchars($row['category']) ?></td>
                                <td>$<?= number_format($row['price'], 2) ?></td>
                                <td><?= htmlspecialchars($row['stock']) ?></td>
                                <td>
                                    <?php if ($row['status'] == 'Scheduled'): ?>
                                        <span class="badge bg-primary">Scheduled</span>
                                    <?php elseif ($row['status'] == 'Active'): ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Draft</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="edit_product.php?id=<?= $row['id'] ?>" class="text-decoration-none text-primary me-2">Edit</a>
                                    <a href="delete_product.php?id=<?= $row['id'] ?>" class="text-decoration-none text-danger" onclick="return confirm('Are you sure?')">Delete</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>