<?php
// Define base URL dynamically
$base_url = "http://localhost/Capstones"; // Update this if necessary
?>
<footer class="footer">
    <div class="footer-top">
        <div class="logo">Home Automation</div>
        <div class="social-icons">
        <a href="#"><i class="fa-brands fa-facebook"></i></a>
        <a href="#"><i class="fa-brands fa-instagram"></i></a>
        <a href="#"><i class="fa-brands fa-twitter"></i></a>
    </div>
    </div>

    <div class="footer-middle">
        <div class="footer-column">
            <h4>Company Info</h4>
            <ul>
                <li><a href="<?php echo $base_url; ?>/about.php">About Us</a></li>
                <li><a href="#">Careers</a></li>
                <li><a href="#">We are hiring</a></li>
                <li><a href="#">Blog</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h4>Legal</h4>
            <ul>
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Terms & Conditions</a></li>
                <li><a href="#">Refund Policy</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h4>Resources</h4>
            <ul>
                <li><a href="#">iOS & Android</a></li>
                <li><a href="#">Watch a Demo</a></li>
                <li><a href="#">Customers</a></li>
                <li><a href="#">API Integration</a></li>
            </ul>
        </div>
    </div>

    <div class="footer-bottom">
        <p>Made With Love By Waterloo - All Rights Reserved</p>
    </div>
</footer>

<!-- Include JavaScript -->
<script src="<?php echo $base_url; ?>/script.js"></script>
</body>
</html>
