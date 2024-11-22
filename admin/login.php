<?php
session_start();

// Hardcoded credentials
$hardcoded_username = "admin";
$hardcoded_password = "password";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if ($username === $hardcoded_username && $password === $hardcoded_password) {
        // Set session variables
        $_SESSION["admin_logged_in"] = true;
        $_SESSION["admin_username"] = $username;

        // Redirect to admin panel
        header("Location: index.php");
        exit();
    } else {
        $message = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles.css">
    <title>Admin Login</title>
</head>
<body>
    <h2>Admin Login</h2>
    <?php if (!empty($message)) : ?>
        <p style="color: red;"><?php echo $message; ?></p>
    <?php endif; ?>

    <form action="login.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <button type="submit">Login</button>
    </form>

    <p><a href="../index.php">Back to Home</a></p>
</body>
</html>