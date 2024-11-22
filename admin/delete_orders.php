<?php
include '../db.php'; // Include database connection

// Check if the 'id' parameter is present in the URL
if (isset($_GET['id'])) {
    $order_id = intval($_GET['id']); // Get the order ID and sanitize it
    
    // Delete the order from the database
    $sql = "DELETE FROM orders WHERE id = $order_id";
    
    if (mysqli_query($conn, $sql)) {
        // Redirect back to the order status page after successful deletion
        header("Location: orderstatus.php");
        exit();
    } else {
        // Display an error message if the deletion fails
        die("Error deleting order: " . mysqli_error($conn));
    }
} else {
    // Redirect back to the order status page if no 'id' parameter is provided
    header("Location: orderstatus.php");
    exit();
}
?>