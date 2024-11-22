<?php
// Include database connection
include '../db.php';

// Start the session
session_start();

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ../admin/login.php"); // Redirect to login page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
                        <a href="index.php" class="nav-link px-3 py-2 active">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="products.php" class="nav-link px-3 py-2">Products</a>
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
            <header class="bg-white shadow-sm p-3 d-flex justify-content-between align-items-center">
                <h1 class="h4 mb-0">Dashboard</h1>
                <!-- Logout Button -->
                <a href="index.php?logout=true" class="btn btn-danger btn-sm">Logout</a>
            </header>

            <div class="container py-4">
                <!-- Cards in Grid Layout -->
                <div class="row g-4">
                    <!-- Add Product Card -->
                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <h5 class="card-title">Add Product</h5>
                                <p class="card-text">Easily add new products to your inventory.</p>
                                <a href="add_products.php" class="btn btn-primary">Add Product</a>
                            </div>
                        </div>
                    </div>

                    <!-- Update/Delete Users Card -->
                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <h5 class="card-title">Update/Delete Users</h5>
                                <p class="card-text">Manage registered users in the system.</p>
                                <a href="customers.php" class="btn btn-warning">Manage Users</a>
                            </div>
                        </div>
                    </div>

                    <!-- Order Status Card -->
                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <h5 class="card-title">Order Status</h5>
                                <p class="card-text">Track the status of orders placed by customers.</p>
                                <a href="orderstatus.php" class="btn btn-success">View Orders</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>