<?php include('../../Model/theme.php'); ?>
<?php
include ('../../Model/Authority/authority_profile.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authority Profile - SafePath</title>
    <link rel="stylesheet" href="../dashboard.css">
    <link rel="stylesheet" href="authority_profile.css">
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h3>SafePath</h3>
        <ul>
            <li><a href="authority_dashboard.php">All Incidents</a></li>
            <li><a href="reviewed_incidents.php">Reviewed Incidents</a></li>
            <li><a href="new_announcement.php">New Announcement</a></li>
            <li><a href="all_announcements.php">All Announcements</a></li>
            <li><a href="authority_profile.php" class="active">Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Content -->
    <div class="content">
        <h2>Authority Profile</h2>

        <!-- Status Message -->
        <?php if ($status_message): ?>
            <div class="status-message"><?php echo $status_message; ?></div>
        <?php endif; ?>

        <!-- Profile Info -->
        <div class="profile-card">
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user_data['email']); ?></p>
        </div>

        <!-- Change Password -->
        <div class="card">
            <h3>Change Password</h3>
            <form action="authority_profile.php" method="POST" class="formGrid">
                <div class="field full">
                    <label for="current_password">Current Password</label>
                    <input type="password" id="current_password" name="current_password" required>
                </div>
                <div class="field full">
                    <label for="new_password">New Password</label>
                    <input type="password" id="new_password" name="new_password" required>
                    <small class="hint">8–20 chars, at least 1 uppercase, 1 lowercase, and 1 digit.</small>
                </div>
                <div class="field full">
                    <label for="confirm_password">Confirm New Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                <div class="field full">
                    <button type="submit" class="primary">Change Password</button>
                </div>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 SafePath. All Rights Reserved.</p>
    </footer>
</body>
</html>
