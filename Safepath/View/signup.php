<?php include('../Model/theme.php'); ?>

<?php include ('../Model/signup.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignUp - SafePath</title>
    <link rel="stylesheet" href="signup.css">
    <script src="../Controller/signup.js"></script>
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="logo">
            <h1>SafePath</h1>
        </div>
        <nav>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="signup.php">SignUp</a></li>
                <li><a href="home.php#contact">Contact</a></li>
            </ul>
        </nav>
    </header>

    <!-- SignUp Section -->
    <section id="signup">
        <div class="container">
            <h2>Sign Up</h2>

            <!-- Display error message if any -->
            <?php
            if (isset($_SESSION['error_message'])) {
                echo "<script>alert('" . $_SESSION['error_message'] . "');</script>";
                unset($_SESSION['error_message']);
            }
            ?>

            <form action="signup.php" method="POST" enctype="multipart/form-data" class="signup-form">
                <label for="name">Full Name</label>
                <input onkeyup="validateName()" type="text" id="name" name="name" value="<?php echo isset($_SESSION['name']) ? $_SESSION['name'] : ''; ?>" required placeholder="Enter your full name">
                <span id="nameMessage"></span>

                <label for="dob">Date of Birth</label>
                <input onkeyup="validateAge()" type="date" id="dob" name="dob" value="<?php echo isset($_SESSION['dob']) ? $_SESSION['dob'] : ''; ?>" required>
                <span id="dobMessage"></span>

                <label for="mobile">Mobile Number</label>
                <input onkeyup="validateMobile()" type="number" id="mobile" name="mobile" value="<?php echo isset($_SESSION['mobile']) ? $_SESSION['mobile'] : ''; ?>" required placeholder="Enter your 11-digit mobile number" maxlength="11">
                <span id="mobileMessage"></span>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>" required placeholder="Enter your email">
                

                <label for="nid">NID</label>
                <input onkeyup="validateNid()" type="number" id="nid" name="nid" value="<?php echo isset($_SESSION['nid']) ? $_SESSION['nid'] : ''; ?>" required placeholder="Enter your 10-digit NID" maxlength="10">
                <span id="nidMessage"></span>

                <label for="password">Password</label>
                <input onkeyup="validatePassword()" type="password" id="password" name="password" value="<?php echo isset($_SESSION['password']) ? $_SESSION['password'] : ''; ?>" required placeholder="Enter your password" onkeyup="validatePassword()">
                <span id="passwordMessage"></span>

                <label for="profile_image">Profile Image</label>
                <input type="file" id="profile_image" name="profile_image" accept="image/*">

                <button type="submit">SignUp</button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 SafePath. All Rights Reserved.</p>
    </footer>
</body>
</html>
