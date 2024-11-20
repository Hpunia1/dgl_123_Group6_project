<header>
    <section class="navbar">
        <div class="logo">
            <a href="index.php">
                <img src="assets/images/logo.svg" alt="MAR logo" class="logo" />
            </a>
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
            <a href="cart.php" class="cart-link"> 🛒 </a>
            <a href="login.php" class="login-link">Login</a>
        </div>
    </section>
</header>
<?php
    $servername = "localhost";
    $username = "root";  // Replace with your DB username
    $password = "";  // Replace with your DB password
    $dbname = "demophp"; // your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>
