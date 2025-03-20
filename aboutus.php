<?php include '../config/db.php'; ?>
<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>
<link rel="stylesheet" href="about.css">

<!-- About Section -->
<section class="about-container">
    <div class="about-content">
        <h4>ABOUT COMPANY</h4>
        <h1>ABOUT US</h1>
        <p>We know how large objects will act, but things on a small scale</p>
        <button class="btn-quote">Get Quote Now</button>
    </div>

    <div class="about-image">
        <img src="../Image/technology 1.png" alt="About Us">
    </div>
</section>

<section class="info-section">
    <div class="info-container">
        <div class="info-left">
            <p class="small-text">Problems trying</p>
            <h3 class="info-heading">
                Met minim Mollie non desert Alamo est <br>
                sit cliquey dolor do met sent.
            </h3>
        </div>
        <div class="info-right">
            <p class="info-description">
                Problems trying to resolve the conflict between the two major realms of Classical physics: Newtonian mechanics
            </p>
        </div>
    </div>
</section>

<section class="stats-section">
    <div class="stat">
        <h2>15K</h2>
        <p>Happy Customers</p>
    </div>
    <div class="stat">
        <h2>150K</h2>
        <p>Monthly Visitors</p>
    </div>
    <div class="stat">
        <h2>15</h2>
        <p>Countries Worldwide</p>
    </div>
    <div class="stat">
        <h2>100+</h2>
        <p>Top Partners</p>
    </div>
</section>

<section class="video-section">
    <div class="video-container">
        <img src="../Image/unsplash_T_Qe4QlMIvQ123.png" alt="Video Thumbnail" class="video-thumbnail">
        <div class="play-button">
            <img src="../Image/button-primary-color.png" alt="Play Button">
        </div>
    </div>
</section>

<section class="team-section">
    <div class="team-header">
        <h2>Meet Our Team</h2>
        <p>Problems trying to resolve the conflict between <br> the two major realms of Classical physics: Newtonian mechanics</p>
    </div>

    <div class="team-container">
        <?php
        $team_members = $conn->query("SELECT * FROM team");
        while ($member = $team_members->fetch_assoc()) {
            echo '<div class="team-member">
                    <img src="uploads/'.$member['image'].'" alt="'.$member['name'].'">
                    <h3>'.$member['name'].'</h3>
                    <p>'.$member['profession'].'</p>
                    <div class="social-icons">
                        <a href="'.$member['facebook'].'"><i class="fa-brands fa-facebook"></i></a>
                        <a href="'.$member['instagram'].'"><i class="fa-brands fa-instagram"></i></a>
                        <a href="'.$member['twitter'].'"><i class="fa-brands fa-twitter"></i></a>
                    </div>
                </div>';
        }
        ?>
    </div>
</section>

<section class="clients-section">
    <div class="clients-header">
        <h2>Big Companies Are Here</h2>
        <p>Problems trying to resolve the conflict between <br> the two major realms of Classical physics: Newtonian mechanics</p>
    </div>

    <div class="clients-logos">
        <img src="../Image/fa-brands-1.png" alt="Hooli">
        <img src="../Image/fa-brands-2.png" alt="Lyft">
        <img src="../Image/fa-brands-4.png" alt="Leaf">
        <img src="../Image/fa-brands-5.png" alt="Stripe">
        <img src="../Image/fa-brands-6.png" alt="AWS">
    </div>
</section>

<section class="work-with-us">
    <div class="work-content">
        <p class="work-title">WORK WITH US</p>
        <h2>Now Let's grow Yours</h2>
        <p class="work-description">
            The gradual accumulation of information about atomic and small-scale behavior during the first quarter of the 20th
        </p>
        <button class="work-button">Click Here</button>
    </div>
    <div class="work-image">
        <img src="../Image/desktop-testimonial.png" alt="Work With Us">
    </div>
</section>

<?php include '../includes/footer.php'; ?>
