<?php
include '../db.php';

function fetchProducts($conn) {
    $sql = "SELECT id, name, price, image, category FROM products ORDER BY id ASC";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        throw new Exception("Query failed: " . mysqli_error($conn));
    }

    $products = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }

    return $products;
}

// Example usage:
// Uncomment the following to test
// try {
//     $products = fetchProducts($conn);
//     print_r($products);
// } catch (Exception $e) {
//     echo $e->getMessage();
// }
?>
