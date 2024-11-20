<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Ecommerce Shop'; ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
    <section class="navbar">
        <div class="logo">
            <a href="index.php"><img src="images/logo.svg" alt="MAR logo" class="logo"></a>
        </div>
        <nav>
            <ul>
                <li><a href="shopping.php">Shop</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Stories</a></li>
                <li><a href="#">Search</a></li>
            </ul>
        </nav>
        <div class="login-cart">
            <a href="cart.php" class="cart-link">🛒</a>
            <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
                <span>Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</span>
                <a href="logout.php" class="logout-link">Logout</a>
            <?php else: ?>
                <a href="login.php" class="login-link">Login</a>
                <a href="register.php" class="register-link">Register</a>
            <?php endif; ?>
        </div>
    </section>
</header>