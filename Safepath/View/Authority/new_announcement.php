<?php include('../../Model/theme.php'); ?>
<?php
include ('../../Model/Authority/new_announcement.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Announcement - SafePath</title>
    <link rel="stylesheet" href="../dashboard.css"> <!-- External CSS -->
    <link rel="stylesheet" href="authority_New_Announcement.css"> <!-- External CSS for the form -->
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h3>SafePath</h3>
        <ul>
            <li><a href="authority_dashboard.php">All Incidents</a></li>
            <li><a href="reviewed_incidents.php">Reviewed Incidents</a></li>
            <li><a href="new_announcement.php" class="active">New Announcement</a></li>
            <li><a href="all_announcements.php">All Announcements</a></li>
            <li><a href="authority_profile.php">Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Content Section -->
    <div class="content">
        <h3>Create a New Announcement</h3>

        <!-- Status Message -->
        <?php if (isset($status_message)): ?>
            <div class="status-message">
                <?php echo $status_message; ?>
            </div>
        <?php endif; ?>

        <!-- Announcement Form -->
        <form action="new_announcement.php" method="POST" class="announcement-form">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="5" required></textarea>
            </div>

            <button type="submit" class="btn-submit">Create Announcement</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2025 SafePath. All Rights Reserved.</p>
    </footer>

</body>
</html>
