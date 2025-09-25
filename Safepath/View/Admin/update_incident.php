<?php include('../../Model/theme.php'); ?>
<?php include('../../Model/Admin/update_incident.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Incident - SafePath</title>
	<link rel="stylesheet" href="../dashboard.css">
    <link rel="stylesheet" href="manage_incidents.css">
    <link rel="stylesheet" href="manage_citizen.css">
    <style>
        /* Styling for the search form */
.search-form {
    margin-bottom: 20px;
    display: flex;
    justify-content: left;
    margin-top: 20px; /* Adds space above the search form */
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

/* Status messages */
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
            <li><a href="manage_admin.php">Manage Admin</a></li>
            <li><a href="manage_incidents.php">Manage Incidents</a></li>
            <li><a href="update_incident.php">Update Incidents</a></li>
            <li><a href="manage_announcement.php">Manage Announcements</a></li>
            <li><a href="fake_reports.php">Fake Submit Management</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Content Section -->
    <div class="content">
        <h2>Update Incident</h2>

        <!-- Status Message -->
        <?php if (isset($status_message)): ?>
            <div class="status-message">
                <?php if ($status_message == 'success'): ?>
                    <p style="color: green;">Incident updated successfully!</p>
                <?php elseif ($status_message == 'error'): ?>
                    <p style="color: red;">Error updating incident. Please try again.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Search Form -->
        <form method="GET" action="update_incident.php" class="search-form">
            <input type="text" name="search" placeholder="Search by title..." value="<?php echo htmlspecialchars($search); ?>" required>
            <button type="submit">Search</button>
        </form>

        <!-- Display error message if no incident is found -->
        <?php if (isset($error_message)): ?>
            <p style="color: red;"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <!-- Incident Update Form -->
        <?php if (isset($incident)): ?>
            <form method="POST" action="update_incident.php" class="update-incident-form" enctype="multipart/form-data">
                <input type="hidden" name="update_incident_id" value="<?php echo $incident['id']; ?>">

                <label for="title">Title:</label>
                <input type="text" name="title" value="<?php echo htmlspecialchars($incident['title']); ?>" required>

                <label for="location">Location:</label>
                <input type="text" name="location" value="<?php echo htmlspecialchars($incident['location']); ?>" required>

                <label for="description">Description:</label>
                <textarea name="description" rows="4" required><?php echo htmlspecialchars($incident['description']); ?></textarea>

                <label for="incident_image">Change Image:</label>
                <input type="file" name="incident_image" accept="image/*">

                <!-- Display current images -->
                <label>Current Images:</label>
                <div class="incident-images">
                    <?php 
                    $imageSql = "SELECT image FROM incident_images WHERE incident_id = ".$incident['id'];
                    $imageRes = $conn->query($imageSql);
                    if ($imageRes && $imageRes->num_rows > 0):
                        while ($imageData = $imageRes->fetch_assoc()):
                            $base64Image = base64_encode($imageData['image']);
                    ?>
                        <img src="data:image/jpeg;base64,<?php echo $base64Image; ?>" class="incident-image" />
                    <?php endwhile; endif; ?>
                </div>

                <button type="submit">Update Incident</button>
            </form>
        <?php endif; ?>
    </div>

    <footer>
        <p>&copy; 2025 SafePath. All Rights Reserved.</p>
    </footer>

</body>
</html>
