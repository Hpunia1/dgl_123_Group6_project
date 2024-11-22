<?php
include('../db.php');
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $discount = $_POST['discount'];

    // Handle file upload
    $image = $_FILES['image']['name'];
    $target = "../uploads/" . basename($image);
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $sql = "INSERT INTO products (name, description, price, discount, image) 
                VALUES ('$name', '$description', '$price', '$discount', '$image')";
        if (mysqli_query($conn, $sql)) {
            header("Location: index.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Error uploading image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles.css">
    <title>Add Product</title>
</head>
<body>
<header>
    <h1>Add Product</h1>
    <a href="index.php">Back</a>
</header>
<div class="container">
    <form method="POST" enctype="multipart/form-data">
        <label for="name">Product Name:</label>
        <input type="text" name="name" id="name" required>

        <label for="description">Description:</label>
        <textarea name="description" id="description" rows="5" required></textarea>

        <label for="price">Product Price:</label>
        <input type="number" name="price" id="price" required>

        <label for="discount">Discount (%):</label>
        <input type="number" name="discount" id="discount" required>

        <label for="image">Product Image:</label>
        <input type="file" name="image" id="image" accept="image/*" required>

        <button type="submit">Add Product</button>
    </form>
</div>
</body>
</html><?php
include('../db.php');
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $discount = $_POST['discount'];

    // Handle file upload
    $image = $_FILES['image']['name'];
    $target = "../uploads/" . basename($image);
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $sql = "INSERT INTO products (name, description, price, discount, image) 
                VALUES ('$name', '$description', '$price', '$discount', '$image')";
        if (mysqli_query($conn, $sql)) {
            header("Location: index.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Error uploading image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles.css">
    <title>Add Product</title>
</head>
<body>
<header>
    <h1>Add Product</h1>
    <a href="index.php">Back</a>
</header>
<div class="container">
    <form method="POST" enctype="multipart/form-data">
        <label for="name">Product Name:</label>
        <input type="text" name="name" id="name" required>

        <label for="description">Description:</label>
        <textarea name="description" id="description" rows="5" required></textarea>

        <label for="price">Product Price:</label>
        <input type="number" name="price" id="price" required>

        <label for="discount">Discount (%):</label>
        <input type="number" name="discount" id="discount" required>

        <label for="image">Product Image:</label>
        <input type="file" name="image" id="image" accept="image/*" required>

        <button type="submit">Add Product</button>
    </form>
</div>
</body>
</html>