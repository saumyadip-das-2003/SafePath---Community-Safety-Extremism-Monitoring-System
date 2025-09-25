<?php include('../../Model/theme.php'); ?>
<?php include ('../../Model/Citizen/citizen_my_uploads.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Uploads - SafePath</title>
    <link rel="stylesheet" href="../dashboard.css">
    <link rel="stylesheet" href="citizen_my_uploads.css">
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
            <li><a href="citizen_profile.php" class="active">Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Content Section -->
    <div class="content">
        <h2>My Uploads</h2>

        <!-- Display status message -->
        <?php if (isset($status)): ?>
            <div class="status-message">
                <?php if ($status == 'success'): ?>
                    <p style="color: green;">Incident updated successfully!</p>
                <?php elseif ($status == 'error'): ?>
                    <p style="color: red;">Error updating incident. Please try again.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Display delete status message -->
        <?php if (isset($delete_status)): ?>
            <div class="status-message">
                <?php if ($delete_status == 'success'): ?>
                    <p style="color: green;">Incident deleted successfully!</p>
                <?php elseif ($delete_status == 'error'): ?>
                    <p style="color: red;">Error deleting incident. Please try again.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Display incidents -->
        <?php while ($incident = $incidents->fetch_assoc()): ?>
            <div class="incident-card" id="incident_<?php echo $incident['id']; ?>">
                <h3>Edit Incident</h3>
                <form action="citizen_my_uploads.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="incident_id" value="<?php echo $incident['id']; ?>">

                    <label for="title-<?php echo $incident['id']; ?>">Title:</label>
                    <input type="text" id="title-<?php echo $incident['id']; ?>" name="title" value="<?php echo $incident['title']; ?>" required>

                    <label for="location-<?php echo $incident['id']; ?>">Location:</label>
                    <input type="text" id="location-<?php echo $incident['id']; ?>" name="location" value="<?php echo $incident['location']; ?>" required>

                    <label for="description-<?php echo $incident['id']; ?>">Description:</label>
                    <textarea id="description-<?php echo $incident['id']; ?>" name="description" rows="4" required><?php echo $incident['description']; ?></textarea>

                    <!-- Display all current images for this incident -->
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

                    <!-- Option to upload a new image -->
                    <label for="incident_image-<?php echo $incident['id']; ?>">Change Image:</label>
                    <input type="file" name="incident_image" id="incident_image-<?php echo $incident['id']; ?>" accept="image/*">

                    <button type="submit" class="btn-submit">Save Changes</button>
                </form>

                <!-- Delete Incident Button -->
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