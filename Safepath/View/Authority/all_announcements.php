<?php include('../../Model/theme.php'); ?>
<?php
include ('../../Model/Authority/all_announcements.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Announcements - SafePath</title>
	<link rel="stylesheet" href="authoroty_All_Announcement.css"> <!-- Announcement Cards CSS -->
    <link rel="stylesheet" href="../dashboard.css"> <!-- Sidebar/Layout CSS -->
    
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h3>SafePath</h3>
        <ul>
            <li><a href="authority_dashboard.php">All Incidents</a></li>
            <li><a href="reviewed_incidents.php">Reviewed Incidents</a></li>
            <li><a href="new_announcement.php">New Announcement</a></li>
            <li><a href="all_announcements.php" class="active">All Announcements</a></li>
            <li><a href="authority_profile.php">Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Content Section -->
    <div class="content">
        <h3>All Announcements</h3>

        <!-- Status Message -->
        <?php if (isset($_SESSION['status_message'])): ?>
            <div class="status-message">
                <?php 
                echo $_SESSION['status_message']; 
                unset($_SESSION['status_message']); 
                ?>
            </div>
        <?php endif; ?>

        <!-- Filter Form -->
        <form action="all_announcements.php" method="GET" class="filter-form">
            <label for="filter">Filter by Status:</label>
            <select name="filter" id="filter" onchange="this.form.submit()">
                <option value="all" <?php if ($filter == 'all') echo 'selected'; ?>>All</option>
                <option value="active" <?php if ($filter == 'active') echo 'selected'; ?>>Active</option>
                <option value="inactive" <?php if ($filter == 'inactive') echo 'selected'; ?>>Inactive</option>
            </select>
        </form>

        <!-- Display all announcements -->
        <div class="announcement-list">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($announcement = $result->fetch_assoc()): ?>
                    <div class="announcement-card">
                        <!-- Editable Form -->
                        <form action="all_announcements.php?filter=<?php echo $filter; ?>" method="POST">
                            <input type="hidden" name="announcement_id" value="<?php echo $announcement['id']; ?>">

                            <label for="title-<?php echo $announcement['id']; ?>">Title:</label>
                            <input type="text" id="title-<?php echo $announcement['id']; ?>" name="title" value="<?php echo htmlspecialchars($announcement['title']); ?>" required>

                            <label for="description-<?php echo $announcement['id']; ?>">Description:</label>
                            <textarea id="description-<?php echo $announcement['id']; ?>" name="description" rows="3" required><?php echo htmlspecialchars($announcement['description']); ?></textarea>

                            <label for="status-<?php echo $announcement['id']; ?>">Status:</label>
                            <select name="status" id="status-<?php echo $announcement['id']; ?>">
                                <option value="active" <?php if ($announcement['status'] == 'active') echo 'selected'; ?>>Active</option>
                                <option value="inactive" <?php if ($announcement['status'] == 'inactive') echo 'selected'; ?>>Inactive</option>
                            </select>

                            <!-- Buttons Side by Side -->
                            <div class="button-group">
                                <button type="submit" class="btn">Save Changes</button>
                                <a href="all_announcements.php?delete_id=<?php echo $announcement['id']; ?>&filter=<?php echo $filter; ?>" 
                                   class="btn-delete" 
                                   onclick="return confirm('Are you sure you want to delete this announcement?');">
                                   Delete
                                </a>
                            </div>
                        </form>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No announcements found.</p>
            <?php endif; ?>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 SafePath. All Rights Reserved.</p>
    </footer>

</body>
</html>
