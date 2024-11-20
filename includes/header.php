<?php
session_start();
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
            <a href="login.php" class="login-link">Login</a>
        </div>
    </section>
</header>
