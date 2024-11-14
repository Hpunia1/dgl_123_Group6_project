<?php
// Start a session to handle login status
session_start();

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Replace these with your actual login credentials
    $username = 'admin';
    $password = 'password123';

    // Get input values
    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];

    // Verify credentials
    if ($inputUsername === $username && $inputPassword === $password) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        // Redirect to homepage or dashboard
        header('Location: index.html');
        exit;
    } else {
        $error = 'Invalid username or password';
    }
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
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
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