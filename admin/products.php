<?php
include '../scripts/data.php';
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login.php");
    exit();
}

$products = fetchProducts();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <style>
        body {
            display: flex;
        }
        aside {
            width: 250px;
            height: 100vh;
        }
        .content {
            flex: 1;
            margin-left: 250px;
        }
    </style> -->
</head>
<body class="bg-light">
    <!-- Sidebar -->
    <aside class="bg-white shadow-sm position-fixed">
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

    <!-- Main Content -->
    <div class="content container py-4">
        <h1 class="h4 mb-4">Products</h1>
        <div class="table-responsive bg-white shadow-sm rounded">
            <table class="table table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Image</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Price</th>
                        <th scope="col">Discount</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($products)): ?>
                    <tr>
                        <td>
                            <img src="../uploads/<?= htmlspecialchars($row['image']) ?>" alt="Product Image" class="img-thumbnail" style="width: 50px; height: 50px;">
                        </td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['description']) ?></td>
                        <td>$<?= number_format($row['price'], 2) ?></td>
                        <td><?= $row['discount'] ?>%</td>
                        <td>
                            <a href="edit_product.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                            <a href="delete_product.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>