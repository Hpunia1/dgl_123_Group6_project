<?php
// Database credentials
$host = "localhost";       // Server (default is localhost)
$username = "root";        // Default username
$password = "";            // Default password for XAMPP (leave blank)
$database = "Group6_project"; // Your database name

// Connect to the database
$conn = mysqli_connect($host, $username, $password, $database);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully!";
?>