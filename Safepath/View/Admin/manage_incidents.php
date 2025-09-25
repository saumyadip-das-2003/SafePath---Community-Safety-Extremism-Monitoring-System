<?php include('../../Model/theme.php'); ?>
<?php include('../../Model/Admin/manage_incidents.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citizen Home - SafePath</title>
    <link rel="stylesheet" href="../dashboard.css">
    <link rel="stylesheet" href="manage_incidents.css">
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
			<li><a href="update_incident.php">Update Incidents</a></li>
            <li><a href="manage_announcement.php">Manage Announcements</a></li>
            <li><a href="fake_reports.php">Fake Submit Management</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Content Section -->
    <div class="content">
        <div class="top-bar">
            <form method="GET" action="manage_incidents.php" class="search-form">
                <input type="text" name="search" placeholder="Search by location..." value="<?php echo htmlspecialchars($search); ?>">
                <select name="filter">
                    <option value="latest" <?php if($filter=='latest') echo 'selected'; ?>>Latest</option>
                    <option value="upvotes" <?php if($filter=='upvotes') echo 'selected'; ?>>Most Upvoted</option>
                    <option value="downvotes" <?php if($filter=='downvotes') echo 'selected'; ?>>Most Downvoted</option>
                </select>
                <button type="submit">Apply</button>
            </form>
        </div>

        <h2>Incidents Feed</h2>

        <?php while ($incident = $incidents->fetch_assoc()): ?>
            <div class="incident-card" id="incident_<?php echo $incident['id']; ?>">
                <h3><?php echo $incident['title']; ?></h3>
                <p><strong>Posted by:</strong> <?php echo $incident['citizen_name']; ?></p> <!-- Citizen name -->
                <p><strong>Location:</strong> <?php echo $incident['location']; ?></p>
                <p><?php echo nl2br($incident['description']); ?></p>

                <!-- Display Review Status -->
                <p><strong>Review:</strong> 
                    <?php 
                    if ($incident['review']) {
                        echo htmlspecialchars($incident['review']); 
                    } else {
                        echo "No review yet";
                    }
                    ?>
                </p>

                <!-- Display Images -->
                <?php 
                $images_res = $conn->query("SELECT image FROM incident_images WHERE incident_id = ".$incident['id']);
                if ($images_res && $images_res->num_rows > 0): ?>
                    <div class="incident-images">
                        <?php while ($img = $images_res->fetch_assoc()): ?>
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($img['image']); ?>" class="incident-image" />
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>

                <!-- Delete Incident Form -->
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="delete_incident_id" value="<?php echo $incident['id']; ?>">
                    <button type="submit" class="btn-delete" onclick="return confirm('Are you sure you want to delete this incident?')">Delete Incident</button>
                </form>
            </div>
        <?php endwhile; ?>
    </div>

    <footer>
        <p>&copy; 2025 SafePath. All Rights Reserved.</p>
    </footer>
</body>
</html>
