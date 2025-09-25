<?php include('../../Model/theme.php'); ?>
<?php include ('../../Model/Citizen/citizen_view_announcement.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Announcements - SafePath</title>
    <link rel="stylesheet" href="../dashboard.css"> <!-- External dashboard CSS -->
    <link rel="stylesheet" href="citizen_view_announcement.css"> <!-- External CSS for Announcement Card -->
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h3>SafePath</h3>
        <ul>
            <li><a href="citizen_dashboard.php">Home</a></li>
            <li><a href="citizen_new_incident.php">New Incident</a></li>
            <li><a href="citizen_my_uploads.php">My Uploads</a></li>
            <li><a href="citizen_view_announcement.php">Announcement</a></li>
            <li><a href="citizen_profile.php">Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
			
        </ul>
    </div>

    <!-- Content Section -->
    <div class="content">
        <h2>Active Announcements</h2>

        <!-- Display active announcements -->
        <?php if ($announcements->num_rows > 0): ?>
            <?php while ($announcement = $announcements->fetch_assoc()): ?>
                <div class="announcement-card">
                    <h3><?php echo $announcement['title']; ?></h3>
                    <p><strong>Description:</strong> <?php echo nl2br($announcement['description']); ?></p>
                    <p><strong>Created At:</strong> <?php echo $announcement['created_at']; ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No active announcements found.</p>
        <?php endif; ?>
    </div>

    <footer>
        <p>&copy; 2025 SafePath. All Rights Reserved.</p>
    </footer>

</body>
</html>
