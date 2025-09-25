<?php include('../../Model/theme.php'); ?>
<?php include('../../Model/Admin/update_citizen.php'); ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Citizen - SafePath</title>
    <link rel="stylesheet" href="../dashboard.css">
    <link rel="stylesheet" href="manage_citizen.css">
    <link rel="stylesheet" href="update_citizen.css"> <!-- External CSS -->
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
            <li><a href="manage_announcement.php">Manage Announcements</a></li>
            <li><a href="fake_reports.php">Fake Submit Management</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Content Section -->
    <div class="content">
        <h2>Update Citizen</h2>

        <!-- Status Message -->
        <?php if (isset($status)): ?>
            <div class="status-message">
                <?php if ($status == 'success'): ?>
                    <p style="color: green;">Citizen updated successfully!</p>
                <?php elseif ($status == 'error'): ?>
                    <p style="color: red;">Error updating citizen. Please try again.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Search Form -->
        <form method="GET" action="update_citizen.php" class="search-form">
            <input type="text" name="search" placeholder="Search by email..." value="<?php echo htmlspecialchars($search); ?>" required>
            <button type="submit">Search</button>
        </form>

        <!-- Display error message if no citizen is found -->
        <?php if (isset($error_message)): ?>
            <p style="color: red;"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <!-- Citizen Update Form -->
        <?php if (isset($citizen)): ?>
            <form method="POST" action="update_citizen.php" enctype="multipart/form-data" class="update-citizen-form">
                <input type="hidden" name="update_citizen_id" value="<?php echo $citizen['id']; ?>">

                <label for="name">Name:</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($citizen['name']); ?>" required>

                <label for="dob">Date of Birth:</label>
                <input type="date" name="dob" value="<?php echo htmlspecialchars($citizen['dob']); ?>" required>

                <label for="mobile">Mobile:</label>
                <input type="text" name="mobile" value="<?php echo htmlspecialchars($citizen['mobile']); ?>" required>

                <label for="email">Email:</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($citizen['email']); ?>" required>

                <label for="nid">NID:</label>
                <input type="text" name="nid" value="<?php echo htmlspecialchars($citizen['nid']); ?>" required>

                <!-- Profile Image Display (If available in the database) -->
                <?php if ($citizen['profile_image']): ?>
                    <div class="profile-image-container">
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($citizen['profile_image']); ?>" alt="Profile Image">
                    </div>
                <?php endif; ?>

                <label for="profile_image">Profile Image:</label>
                <input type="file" name="profile_image" accept="image/*">

                <button type="submit">Update Citizen</button>
            </form>
        <?php endif; ?>
    </div>

    <footer>
        <p>&copy; 2025 SafePath. All Rights Reserved.</p>
    </footer>

</body>
</html>
