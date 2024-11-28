<?php
include '../db.php';
session_start();

// Redirect to login if admin is not logged in.
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login.php");
    exit();
}

// Handle Apply/Save Discount
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['discounts'] as $sale_id => $data) {
        $product_id = intval($data['product_id']);
        $discount = floatval($data['discount']);
        
        if ($sale_id === 'new') {
            $sql = "INSERT INTO sales (product_id, discount) VALUES ('$product_id', '$discount')";
        } else {
            $sql = "UPDATE sales SET product_id = '$product_id', discount = '$discount' WHERE id = $sale_id";
        }

        if (!mysqli_query($conn, $sql)) {
            echo "Error saving sale: " . mysqli_error($conn);
        }
    }

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
        echo "Error deleting sale: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Management</title>
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
    <div class="container-fluid p-4">
        <h1 class="text-center">Manage Sales</h1>
        <form method="POST" class="mt-4">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product ID</th>
                        <th>Discount</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = mysqli_query($conn, "SELECT * FROM sales");
                    while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td>
                                <input type="number" name="discounts[<?= $row['id'] ?>][product_id]" value="<?= $row['product_id'] ?>" class="form-control">
                            </td>
                            <td>
                                <input type="number" name="discounts[<?= $row['id'] ?>][discount]" value="<?= $row['discount'] ?>" class="form-control" step="0.01">
                            </td>
                            <td>
                                <a href="sales.php?delete_id=<?= $row['id'] ?>" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    <tr>
                        <td>New</td>
                        <td>
                            <input type="number" name="discounts[new][product_id]" class="form-control">
                        </td>
                        <td>
                            <input type="number" name="discounts[new][discount]" class="form-control" step="0.01">
                        </td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>
<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>