<!--  -->
<nav class="main-nav">
    <a href="index.php" class="logo">
    <img src="../Image/logp.jpg" alt="AutoNest Logo">

    AutoNest
    </a>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="shop.php">Shop</a></li>
        <li><a href="aboutus.php">About Us</a></li>
        <li><a href="contact.php">Contact</a></li>
    </ul>
    <div class="auth-icons">
        <?php if (isset($_SESSION['user_id'])) { ?>
            <a href="logout.php" class="login">Logout</a>
        <?php } else { ?>
            <a href="login.php" class="login">Login / Register</a>
        <?php } ?>
        <a href="cart.php" class="cart-link">🛒 <span class="cart-count">1</span></a>
    </div>
</nav>
