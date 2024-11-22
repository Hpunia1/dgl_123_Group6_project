<?php
include '../db.php';

// Fetch all customers
$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers</title>
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
            <a href="sales.php" class="nav-link px-3 py-2">Sales</a>
        </li>
        <li class="nav-item">
            <a href="customers.php" class="nav-link px-3 py-2">Customers</a>
        </li>
    </ul>
</nav>
        </aside>
    <div class="container py-4">
        <h1 class="h4 mb-4">Customers</h1>
         
        <div class="table-responsive bg-white shadow-sm rounded">
            <table class="table table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col">username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Registered On</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['username']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['created_at']) ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>