<?php
include '../db.php'; // Ensure the database connection file is included

// Generate a hashed password
$password = password_hash('admin_password', PASSWORD_BCRYPT);

// Update the admin password in the database
$sql = "UPDATE admins SET password='$password' WHERE username='admin'";

if (mysqli_query($conn, $sql)) {
    echo "Password updated.";
} else {
    echo "Error: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>