<?php
include '../db.php';

// Handle Update Order Status Request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate input data
    if (!isset($_POST['id'], $_POST['status'])) {
        die("Invalid request: Missing required parameters.");
    }

    $id = intval($_POST['id']); // Ensure ID is an integer
    $status = mysqli_real_escape_string($conn, $_POST['status']); // Sanitize the status input

    // Ensure status is one of the allowed values
    $allowedStatuses = ['Pending', 'Shipped', 'Delivered', 'Cancelled'];
    if (!in_array($status, $allowedStatuses)) {
        die("Invalid status value.");
    }

    // Update the order status in the database
    $sql = "UPDATE orders SET status = '$status' WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        // Redirect back to the same page to prevent resubmission
        header("Location: orderstatus.php");
        exit();
    } else {
        // Display the error if the query fails
        die("Error updating order: " . mysqli_error($conn));
    }
}

// Fetch all orders
$sql = "SELECT * FROM orders ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error fetching orders: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Status</title>
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
                    <li class="nav-item">
                        <a href="orderstatus.php" class="nav-link px-3 py-2 active">Order Status</a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="container py-4">
            <h1 class="h4 mb-4">Order Status</h1>

            <div class="table-responsive bg-white shadow-sm rounded">
                <table class="table table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Order ID</th>
                            <th scope="col">Customer Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Products</th>
                            <th scope="col">Total Price</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id']); ?></td>
                            <td><?= htmlspecialchars($row['customer_name']); ?></td>
                            <td><?= htmlspecialchars($row['customer_email']); ?></td>
                            <td><?= htmlspecialchars($row['product_details']); ?></td>
                            <td>$<?= number_format($row['total_amount'], 2); ?></td>
                            <td>
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']); ?>">
                                    <select name="status" class="form-select form-select-sm w-auto d-inline">
                                        <option value="Pending" <?= $row['status'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                        <option value="Shipped" <?= $row['status'] === 'Shipped' ? 'selected' : ''; ?>>Shipped</option>
                                        <option value="Delivered" <?= $row['status'] === 'Delivered' ? 'selected' : ''; ?>>Delivered</option>
                                        <option value="Cancelled" <?= $row['status'] === 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-success">Update</button>
                                </form>
                            </td>
                            <td>
                                <a href="delete_order.php?id=<?= htmlspecialchars($row['id']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this order?')">Delete</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>