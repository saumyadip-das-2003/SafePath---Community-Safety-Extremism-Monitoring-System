<?php include('../Model/theme.php'); ?>

<?php include ('../Model/login.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SafePath</title>
    <link rel="stylesheet" href="login.css">
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

    <!-- Login Section -->
    <section id="login">
            <h2>Login</h2>
            <form action="login.php" method="POST" class="login-form">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required placeholder="Enter your email">

                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="Enter your password">

                <label for="role">Role</label>
                <select name="role" id="role" required>
                    <option value="citizen">Citizen</option>
                    <option value="authority">Authority</option>
                    <option value="admin">Admin</option>
                </select>

                <button type="submit">Login</button>

                <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
            </form>
    </section>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2025 SafePath. All Rights Reserved.</p>
    </footer>
</body>
</html>
