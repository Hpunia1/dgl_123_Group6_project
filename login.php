<?php

require 'db.php'; // Include database connection
session_start();

// Display success message if the user is redirected after registration
$message = "";
if (isset($_GET['message']) && $_GET['message'] == 'success') {
    $message = "Registration successful! Please log in.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]); // trim(string,charlist)
    $password = trim($_POST["password"]);

    // Check if username exists in the database
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Password is correct, start a session
            $_SESSION["loggedin"] = true;
            $_SESSION["username"] = $username;
            // Redirect to homepage
            header("Location: index.php");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "Invalid username.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>

    <!-- Show registration success message if available -->
    <?php if (!empty($message)) { echo "<p style='color: green;'>$message</p>"; } ?>

    <form action="login.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br>
       
        <label for="password">Password:</label>
        <input type="password" name="password" required><br>
       
        <button type="submit">Login</button>
    </form>

    <!-- Register button for new users -->
    <p>Don't have an account? <a href="register.php">Register</a></p>
</body>
</html>