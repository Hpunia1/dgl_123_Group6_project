<?php
include '../db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "DELETE FROM orders WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        header("Location: orderstatus.php");
        exit();
    } else {
        die("Error deleting order: " . mysqli_error($conn));
    }
}
?>