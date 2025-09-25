
<?php include('../../Model/Admin/pdate_authority.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Authority - SafePath</title>
	<link rel="stylesheet" href="../../View/dashboard.css"> <!-- External Dashboard CSS -->
    <link rel="stylesheet" href="manage_citizen.css"> <!-- External CSS for Manage Authority -->
    <style>
        /* Styling for the search form */
.search-form {
    margin-bottom: 20px;
    display: flex;
    justify-content: left;
    margin-top: 20px; /* Adds some space above the search form */
}

/* Styling for the search input */
.search-form input {
    padding: 8px;
    width: 250px;
    border-radius: 4px;
    border: 1px solid #ddd;
    font-size: 16px;
    margin-right: 10px;
}

/* Styling for the search button */
.search-form button {
    padding: 8px 16px;
    background-color: #2e7d32;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

/* Hover effect for search button */
.search-form button:hover {
    background-color: #1b5e20;
}

/* Styling for the form container */
.update-authority-form {
    width: 500px;
    margin: 30px auto;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

/* Styling for the form input fields */
.update-authority-form label {
    font-weight: bold;
    margin-bottom: 5px;
    display: block;
    color: #333;
}

.update-authority-form input[type="email"],
.update-authority-form input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
}

/* Styling for the submit button */
.update-authority-form button {
    padding: 12px 25px;
    background-color: #2e7d32;
    color: white;
    border: none;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.update-authority-form button:hover {
    background-color: #1b5e20;
}

/* Styling for error and success messages */
.status-message {
    margin-bottom: 20px;
}

.status-message p {
    font-weight: bold;
}

.status-message p[style="color: green;"] {
    color: green;
}

.status-message p[style="color: red;"] {
    color: red;
}

    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h3>SafePath</h3>
        <ul>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="manage_citizen.php">Manage Citizen</a></li>
            <li><a href="update_citizen.php">Update Citizen</a></li>
            <li><a href="manage_authority.php">Manage Authority</a></li>
            <li><a href="pdate_authority.php">Update Authority</a></li>
            <li><a href="manage_admin.php">Manage Admin</a></li>
            <li><a href="manage_incidents.php">Manage Incidents</a></li>
            <li><a href="manage_announcement.php">Manage Announcements</a></li>
            <li><a href="fake_reports.php">Fake Submit Management</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Content Section -->
    <div class="content">
        <h2>Update Authority</h2>

        <!-- Status Message -->
        <?php if (isset($status)): ?>
            <div class="status-message">
                <?php if ($status == 'success'): ?>
                    <p style="color: green;">Authority updated successfully!</p>
                <?php elseif ($status == 'error'): ?>
                    <p style="color: red;">Error updating authority. Please try again.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Search Form -->
        <form method="GET" action="pdate_authority.php" class="search-form">
            <input type="text" name="search" placeholder="Search by email..." value="<?php echo htmlspecialchars($search); ?>" required>
            <button type="submit">Search</button>
        </form>

        <!-- Display error message if no authority is found -->
        <?php if (isset($error_message)): ?>
            <p style="color: red;"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <!-- Authority Update Form -->
        <?php if (isset($authority)): ?>
            <form method="POST" action="pdate_authority.php" class="update-authority-form">
                <input type="hidden" name="update_authority_id" value="<?php echo $authority['id']; ?>">

                <label for="email">Email:</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($authority['email']); ?>" required>

                <label for="password">Password:</label>
                <input type="password" name="password" placeholder="Enter new password (leave blank to keep existing)">

                <button type="submit">Update Authority</button>
            </form>
        <?php endif; ?>
    </div>

    <footer>
        <p>&copy; 2025 SafePath. All Rights Reserved.</p>
    </footer>

</body>
</html>