<?php
// Include the database connection
include '../db.php';
include '../scripts/data.php';

// Fetch all products from the database
$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);

// Return the result
return $result;
?>