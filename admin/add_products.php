<?php
include('../db.php');
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login.php");
    exit();
}

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get form data
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $discount = $_POST['discount'];
        $category = $_POST['category']; // Capture selected category

        // Handle file upload
        $image = $_FILES['image']['name'];
        $target_directory = "../uploads/"; // Path to the uploads folder
        $target_file = $target_directory . basename($image);
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $file_extension = pathinfo($image, PATHINFO_EXTENSION);

        // Check upload directory
        if (!is_dir($target_directory)) {
            throw new Exception("Uploads directory does not exist.");
        }
        if (!is_writable($target_directory)) {
            throw new Exception("Uploads directory is not writable.");
        }

        // Validate file upload
        if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("File upload error code: " . $_FILES['image']['error']);
        }
        if (!in_array(strtolower($file_extension), $allowed_extensions)) {
            throw new Exception("Invalid file type. Allowed: JPG, JPEG, PNG, GIF.");
        }
        if ($_FILES['image']['size'] > 5 * 1024 * 1024) { // 5 MB limit
            throw new Exception("File size exceeds the 5 MB limit.");
        }

        // Attempt to move uploaded file
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            throw new Exception("Failed to move uploaded file. Check directory permissions.");
        }

        // Save relative path to database
        $image_path = "/dgl_123_Group6_project/uploads/" . basename($image);

        // Insert product into database with category and image path
        $sql = "INSERT INTO products (name, description, price, discount, category, image) 
                VALUES ('$name', '$description', '$price', '$discount', '$category', '$image_path')";
        if (!mysqli_query($conn, $sql)) {
            throw new Exception("Database error: " . mysqli_error($conn));
        }

        // Success - Redirect to index
        header("Location: index.php");
        exit();
    }
} catch (Exception $e) {
    // Catch any exception and display an error message
    http_response_code(500); // Send a 500 Internal Server Error response code
    echo "<p><strong>Error:</strong> " . $e->getMessage() . "</p>";

    // Log the error for debugging
    error_log("Error in Add Product: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
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
    <div class="container-fluid p-4">
        <h1 class="text-center">Add New Product</h1>
        <form method="POST" enctype="multipart/form-data" class="mt-4">
            <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" name="price" class="form-control" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="discount" class="form-label">Discount</label>
                <input type="number" name="discount" class="form-control" step="0.01">
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select name="category" class="form-select" required>
                    <option value="">Select a category</option>
                    <option value="Jackets">Jackets</option>
                    <option value="Fleece">Fleece</option>
                    <option value="Sweatshirts & Hoodies">Sweatshirts & Hoodies</option>
                    <option value="Sweaters">Sweaters</option>
                    <option value="Shirts">Shirts</option>
                    <option value="T-shirts">T-shirts</option>
                    <option value="Pants & Jeans">Pants & Jeans</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" name="image" class="form-control" required>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Add Product</button>
            </div>
        </form>
    </div>
</div>
<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>