<?php
include '../db.php';

// Handle Delete Request
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $sql = "DELETE FROM users WHERE id = $delete_id";
    if (mysqli_query($conn, $sql)) {
        header("Location: customers.php");
        exit();
    } else {
        die("Error deleting user: " . mysqli_error($conn));
    }
}

// Handle Edit/Save Request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $sql = "UPDATE users SET username = '$username', email = '$email' WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        header("Location: customers.php");
        exit();
    } else {
        die("Error updating user: " . mysqli_error($conn));
    }
}

// Fetch all customers
$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Customers</title>
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

        <!-- Main Content -->
        <div class="container py-4">
            <h1 class="h4 mb-4">Manage Customers</h1>

            <!-- Customers Table -->
            <div class="table-responsive bg-white shadow-sm rounded">
                <table class="table table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Username</th>
                            <th scope="col">Email</th>
                            <th scope="col">Registered On</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <form method="POST">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <td>
                                    <input type="text" name="username" value="<?= htmlspecialchars($row['username']) ?>" class="form-control">
                                </td>
                                <td>
                                    <input type="email" name="email" value="<?= htmlspecialchars($row['email']) ?>" class="form-control">
                                </td>
                                <td><?= htmlspecialchars($row['created_at']) ?></td>
                                <td>
                                    <button type="submit" class="btn btn-sm btn-success">Save</button>
                                    <a href="customers.php?delete_id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                                </td>
                            </form>
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