<?php
include('../db.php');
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login.php");
    exit();
}

$id = $_GET['id'];
$sql = "DELETE FROM products WHERE id = $id";
if (mysqli_query($conn, $sql)) {
    header("Location: index.php");
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}
?>