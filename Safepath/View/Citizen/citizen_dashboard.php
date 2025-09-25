
<?php
include('../../Model/Citizen/citizen_dashboard.php');
?>
<?php include('../../Model/theme.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citizen Dashboard - SafePath</title>
    <link rel="stylesheet" href="../dashboard.css">
    <link rel="stylesheet" href="citizen_dashboard.css">
    <script src="../../Controller/Citizen/citizen_dashboard.js"></script>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h3>SafePath</h3>
        <ul>
            <li><a href="citizen_dashboard.php" class="active">Home</a></li>
            <li><a href="citizen_new_incident.php">New Incident</a></li>
            <li><a href="citizen_my_uploads.php">My Uploads</a></li>
			<li><a href="citizen_view_announcement.php">Announcement</a></li>
            <li><a href="citizen_profile.php">Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Content Section -->
    <div class="content">
        <div class="top-bar">
            <form method="GET" action="citizen_dashboard.php" class="search-form">
                <input type="text" name="search" placeholder="Search by location..." value="<?php echo htmlspecialchars($search); ?>">
                <select name="filter">
                    <option value="latest" >Latest</option>
                    <option value="upvotes">Most Upvoted</option>
                    <option value="downvotes" >Most Downvoted</option>
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
            
                <div class="incident-actions">
                    <!-- Voting Section -->
                    <button onclick="voteIncident(<?php echo $incident['id']; ?>, 'upvote')" class="btn upvote">
                        👍 Upvote (<span id="upvotes-<?php echo $incident['id']; ?>"><?php echo $incident['upvotes']; ?></span>)
                    </button>
                    <button onclick="voteIncident(<?php echo $incident['id']; ?>, 'downvote')" class="btn downvote">
                        👎 Downvote (<span id="downvotes-<?php echo $incident['id']; ?>"><?php echo $incident['downvotes']; ?></span>)
                    </button>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
	
	

    <footer>
        <p>&copy; 2025 SafePath. All Rights Reserved.</p>
    </footer>
</body>
</html>


