<?php include('../../Model/theme.php'); ?>
<?php include('../../Model/Admin/admin_dashboard.php'); ?>



 




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - SafePath</title>
    <link rel="stylesheet" href="admin_dashboard.css"> <!-- External CSS for Admin Dashboard -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>

<!-- Logout Button on Top Right Corner -->
    <div class="logout-btn-container">
        <a href="logout.php" class="logout-btn">
            <i class="fa fa-sign-out-alt"></i> Logout
        </a>
    </div>

    <div class="content">
        <h2>Welcome, Admin!</h2>

        <!-- System Analytics -->
        <div class="dashboard-analytics">
            <div class="analytics-box">
                <h4>Total Users</h4>
                <p><?php echo $total_users; ?></p>
            </div>
            <div class="analytics-box">
                <h4>Total Incidents</h4>
                <p><?php echo $total_incidents; ?></p>
            </div>
            <div class="analytics-box">
                <h4>Resolved Incidents</h4>
                <p><?php echo $resolved_incidents; ?></p>
            </div>
            <div class="analytics-box">
                <h4>Fake Incidents</h4>
                <p><?php echo $fake_incidents; ?></p>
            </div>
            <div class="analytics-box">
                <h4>Active Announcements</h4>
                <p><?php echo $active_announcements; ?></p>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <h3>Quick Actions</h3>
            <a href="manage_citizen.php" class="btn-action">Manage Citizen</a>
            <a href="manage_authority.php" class="btn-action">Manage Authority</a>
            <a href="manage_admin.php" class="btn-action">Manage Admin</a>
            <a href="manage_incidents.php" class="btn-action">Manage Incidents</a>
            <a href="manage_announcement.php" class="btn-action">Manage Announcements</a>
            <a href="fake_reports.php" class="btn-action">Fake Incident Management</a>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 SafePath. All Rights Reserved.</p>
    </footer>

</body>
</html>
