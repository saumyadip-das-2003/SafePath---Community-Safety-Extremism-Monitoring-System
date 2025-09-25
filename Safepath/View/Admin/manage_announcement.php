<?php include('../../Model/theme.php'); ?>
<?php include('../../Model/Admin/manage_announcement.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements - SafePath</title>
    <link rel="stylesheet" href="../dashboard.css">
    <link rel="stylesheet" href="manage_announcement.css">
    <link rel="stylesheet" href="manage_citizen.css">
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h3>SafePath</h3>
        <ul>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="manage_citizen.php">Manage Citizen</a></li>
            <li><a href="manage_authority.php">Manage Authority</a></li>
            <li><a href="manage_admin.php">Manage Admin</a></li>
            <li><a href="manage_incidents.php">Manage Incidents</a></li>
            <li><a href="manage_announcement.php">Manage Announcements</a></li>
            <li><a href="update_announcement.php">Update Announcements</a></li>
            <li><a href="fake_reports.php">Fake Submit Management</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Content Section -->
    <div class="content">
        <div class="top-bar">
            <form method="GET" action="manage_announcement.php" class="search-form">
                <input type="text" name="search" placeholder="Search by title or description..." value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit">Search</button>
            </form>
        </div>

        <h2>Announcements</h2>

        <?php while ($announcement = $announcements->fetch_assoc()): ?>
            <div class="announcement-card" id="announcement_<?php echo $announcement['id']; ?>">
                <h3><?php echo htmlspecialchars($announcement['title']); ?></h3>
                <p><strong>Status:</strong> <?php echo htmlspecialchars($announcement['status']); ?></p> <!-- Display Status -->
                <p><strong>Created at:</strong> <?php echo htmlspecialchars($announcement['created_at']); ?></p>
                <p><?php echo nl2br(htmlspecialchars($announcement['description'])); ?></p>
            </div>
        <?php endwhile; ?>
    </div>

    <footer>
        <p>&copy; 2025 SafePath. All Rights Reserved.</p>
    </footer>
</body>
</html>