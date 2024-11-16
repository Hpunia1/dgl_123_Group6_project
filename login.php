<?php
// Start session
session_start();

// Initialize error variable
$error = '';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database credentials
    $host = 'localhost';
    $db = 'login_system';
    $user = 'root';
    $pass = '';

    // Connect to database
    $conn = new mysqli($host, $user, $pass, $db);

    if ($conn->connect_error) {
        die('Database connection failed: ' . $conn->connect_error);
    }

    // Get input values
    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];

    // Query database for user
    $stmt = $conn->prepare('SELECT password_hash FROM users WHERE username = ?');
    $stmt->bind_param('s', $inputUsername);
    $stmt->execute();
    $stmt->bind_result($passwordHash);
    $stmt->fetch();

    // Verify password
    if ($passwordHash && password_verify($inputPassword, $passwordHash)) {
        // Set session variables
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $inputUsername;

        // Redirect to dashboard
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Invalid username or password';
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="login-container">
        <h2>Login to Your Account</h2>
        <?php if (!empty($error)) echo "<p class='error'>" . htmlspecialchars($error) . "</p>"; ?>
        <form action="login.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="#">Sign Up</a></p>
    </div>
</body>
</html>