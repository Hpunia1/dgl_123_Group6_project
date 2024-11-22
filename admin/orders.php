<?php
session_start();
require '../db.php';

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: ../login.php');
    exit;
}

// Fetch all orders
$orders = $conn->query("SELECT o.id, u.username, p.name AS product_name, o.quantity, o.status 
                        FROM orders o
                        JOIN users u ON o.user_id = u.id
                        JOIN products p ON o.product_id = p.id")->fetch_all(MYSQLI_ASSOC);

// Update order status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $orderId = intval($_POST['order_id']);
    $status = $_POST['status'];
    $conn->query("UPDATE orders SET status = '$status' WHERE id = $orderId");
    header('Location: orders.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Orders</title>
</head>
<body>
<div class="container mt-5">
    <h1>Manage Orders</h1>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($orders as $order): ?>
            <tr>
                <td><?= $order['id']; ?></td>
                <td><?= htmlspecialchars($order['username']); ?></td>
                <td><?= htmlspecialchars($order['product_name']); ?></td>
                <td><?= $order['quantity']; ?></td>
                <td><?= $order['status']; ?></td>
                <td>
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="order_id" value="<?= $order['id']; ?>">
                        <select name="status" class="form-control" required>
                            <option value="Pending" <?= $order['status'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="Shipped" <?= $order['status'] === 'Shipped' ? 'selected' : ''; ?>>Shipped</option>
                            <option value="Completed" <?= $order['status'] === 'Completed' ? 'selected' : ''; ?>>Completed</option>
                            <option value="Cancelled" <?= $order['status'] === 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                        </select>
                        <button name="update_status" class="btn btn-success btn-sm mt-1">Update</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <a href="index.php" class="btn btn-primary">Back to Dashboard</a>
</div>
</body>
</html>