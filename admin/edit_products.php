<?php
include('../db.php');
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login.php");
    exit();
}

$id = $_GET['id'];
$sql = "SELECT * FROM products WHERE id = $id";
$result = mysqli_query($conn, $sql);
$product = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $discount = $_POST['discount'];

    $sql = "UPDATE products SET name = '$name', description = '$description', price = '$price', discount = '$discount' WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles.css">
    <title>Edit Product</title>
</head>
<body>
<header>
    <h1>Edit Product</h1>
    <a href="index.php">Back</a>
</header>
<div class="container">
    <form method="POST">
        <label for="name">Product Name:</label>
        <input type="text" name="name" id="name" value="<?= $product['name'] ?>" required>

        <label for="description">Description:</label>
        <textarea name="description" id="description" rows="5" required><?= $product['description'] ?></textarea>

        <label for="price">Product Price:</label>
        <input type="number" name="price" id="price" value="<?= $product['price'] ?>" required>

        <label for="discount">Discount (%):</label>
        <input type="number" name="discount" id="discount" value="<?= $product['discount'] ?>" required>

        <button type="submit">Update Product</button>
    </form>
</div>
</body>
</html>