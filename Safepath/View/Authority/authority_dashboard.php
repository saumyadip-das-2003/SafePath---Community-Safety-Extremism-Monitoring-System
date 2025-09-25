<?php include('../../Model/theme.php'); ?>
<?php 
include ('../../Model/Authority/authority_dashboard.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authority Dashboard - SafePath</title>
    <link rel="stylesheet" href="../dashboard.css"> <!-- External CSS -->
    <link rel="stylesheet" href="authority_dashboard.css"> <!-- External CSS for Incident Cards -->
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h3>SafePath</h3>
        <ul>
            <li><a href="authority_dashboard.php" class="active">All Incidents</a></li>
            <li><a href="reviewed_incidents.php">Reviewed Incidents</a></li>
            <li><a href="new_announcement.php">New Announcement</a></li>
            <li><a href="all_announcements.php">All Announcements</a></li>
            <li><a href="authority_profile.php">Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Content Section -->
    <div class="content">
        <h3>All Incidents</h3>
        <!-- Filter -->
        <form action="authority_dashboard.php" method="GET">
            Filter: <select name="filter" onchange="this.form.submit()">
                <option value="latest" <?php if ($filter == 'latest') echo 'selected'; ?>>Latest</option>
                <option value="upvotes" <?php if ($filter == 'upvotes') echo 'selected'; ?>>Most Upvoted</option>
                <option value="downvotes" <?php if ($filter == 'downvotes') echo 'selected'; ?>>Most Downvoted</option>
            </select>
        </form>

        <!-- Display All Incidents -->
        <div class="incident-list">

            <?php while ($incident = $incidents->fetch_assoc()): ?>
                <div class="incident-card">
                    <h4><?php echo $incident['title']; ?></h4>
                    <p><strong>Location:</strong> <?php echo $incident['location']; ?></p>
                    <p><strong>Description:</strong> <?php echo nl2br($incident['description']); ?></p>
                    <p><strong>Upvotes:</strong> <?php echo $incident['upvotes']; ?> | <strong>Downvotes:</strong> <?php echo $incident['downvotes']; ?></p>

                    <!-- Display all images for this incident -->
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

                    <!-- Resource Selection -->
                    <form action="authority_dashboard.php" method="POST">
                        <input type="hidden" name="incident_id" value="<?php echo $incident['id']; ?>">
                        
                        <label>Select Resource:</label><br>
                        <input type="checkbox" name="resource[]" value="Fire Service"> Fire Service
                        <input type="checkbox" name="resource[]" value="Ambulance"> Ambulance
                        <input type="checkbox" name="resource[]" value="Police"> Police
                        <input type="checkbox" name="resource[]" value="Army"> Army

                        <button type="submit" class="btn">Add Resource</button>
                    </form>
                </div>
            <?php endwhile; ?>
        </div>

        <?php if (isset($error_message)): ?>
            <p style="color: red;"><?php echo $error_message; ?></p>
        <?php endif; ?>

    </div>

    <footer>
        <p>&copy; 2025 SafePath. All Rights Reserved.</p>
    </footer>

</body>
</html>
