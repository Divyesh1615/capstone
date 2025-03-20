<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>


<?php
$base_url = "http://localhost/Capstones"; // Adjust if necessary
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Automation</title>
    <link rel="stylesheet" href="<?php echo $base_url; ?>/styles.css">
</head>
<body>

<header class="top-bar">
    <div class="contact-info">
        <span>📞 (225) 555-0118</span>
        <span>✉️ info@homeautomation.ca</span>
    </div>
    <div class="follow-us">
        <p>Follow Us and get a chance to win 80% off</p>
    </div>
    <div class="social-icons">
    <a href="#"><i class="fa-brands fa-facebook"></i></a>
        <a href="#"><i class="fa-brands fa-instagram"></i></a>
        <a href="#"><i class="fa-brands fa-twitter"></i></a>
    </div>
</header>



