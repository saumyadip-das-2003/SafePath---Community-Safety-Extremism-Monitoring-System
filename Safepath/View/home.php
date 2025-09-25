<?php include('../Model/theme.php'); ?>

<?php include('../Model/home.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>SafePath - Home</title>
    <link rel="stylesheet" href="home.css">
</head>

<body>
    <header>
        <div class="logo">
            <h1>SafePath</h1>
        </div>
        <nav>
            <ul>
                <li><a href="#about">About SafePath</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="signup.php">SignUp</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>
    </header>

    <section id="hero">
        <div class="hero-content">
            <h2>Welcome to SafePath</h2>
            <p>Your safety, our priority. Report incidents and stay informed.</p>
        </div>
    </section>

    <!-- Unresolved Incidents Section -->
    <section id="incidents">
        <div class="container">
            <div class="incident-slider" id="incident-slider">
                <?php if (!empty($incidents)) : ?>
                    <?php foreach ($incidents as $index => $incident) : ?>
                        <div class="incident-card">
                            <h4>Title:</h4>
                            <p><?php echo htmlspecialchars($incident['title']); ?></p>

                            <h4>Location:</h4>
                            <p><?php echo htmlspecialchars($incident['location']); ?></p>

                            <h4>Description:</h4>
                            <p><?php echo htmlspecialchars($incident['description']); ?></p>

                            <div class="incident-info">
                                <?php if (!empty($incident['images'])) : ?>
                                    <img src="data:image/jpeg;base64,<?php echo $incident['images'][0]; ?>" alt="Incident Image">
                                <?php else: ?>
                                    <p>No image available.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p>No unresolved incidents found.</p>
                <?php endif; ?>
            </div>
            <!-- Arrows for Sliding -->
            <span class="side-arrow left-arrow" onclick="moveSlide(-1)">&#10094;</span>
            <span class="side-arrow right-arrow" onclick="moveSlide(1)">&#10095;</span>
        </div>
    </section>

    <section id="about">
        <div class="container">
            <h2>About SafePath</h2>
            <p>SafePath is a platform designed to allow citizens to report incidents and for authorities to review and respond to them. Our goal is to create a safer environment by fostering communication between the public and the government.</p>
        </div>
    </section>

    <section id="contact">
        <div class="container">
            <h2>Contact Us</h2>
            <p>For any inquiries, please reach out to us at: <a href="mailto:info@safepath.com">info@safepath.com</a></p>
        </div>
    </section>

    <footer>
        <p>&copy; 2025 SafePath. All Rights Reserved.</p>
    </footer>

    <script src="../Controller/home.js"> </script>
</body>

</html>