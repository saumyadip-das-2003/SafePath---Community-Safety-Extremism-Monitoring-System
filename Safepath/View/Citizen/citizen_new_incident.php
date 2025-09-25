<?php include('../../Model/theme.php'); ?>
<?php include ('../../Model/Citizen/citizen_new_incident.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Incident - SafePath</title>
    <link rel="stylesheet" href="../dashboard.css">
    <link rel="stylesheet" href="citizen_new_incident.css">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h3>SafePath</h3>
        <ul>
            <li><a href="citizen_dashboard.php">Home</a></li>
            <li><a href="citizen_new_incident.php" class="active">New Incident</a></li>
            <li><a href="citizen_my_uploads.php">My Uploads</a></li>
			<li><a href="citizen_view_announcement.php">Announcement</a></li>
            <li><a href="citizen_profile.php">Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Content -->
    <div class="content">
        <div class="form-card">
            <h2>📌 Report a New Incident</h2>
            <p class="subtitle">Fill in the details below to report an incident.</p>

            <form action="citizen_new_incident.php" method="POST" enctype="multipart/form-data" class="incident-form">
                <div class="form-group">
                    <label for="title">Incident Title</label>
                    <input type="text" id="title" name="title" placeholder="Enter a short title" required>
                </div>

                <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" id="location" name="location" placeholder="Enter incident location" required>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="5" placeholder="Describe what happened..." required></textarea>
                </div>

                <div class="form-group">
                    <label for="images">Upload Photos</label>
                    <input type="file" id="images" name="images[]" accept="image/*" multiple onchange="previewImages(event)">
                    <div id="previewArea"></div>
                </div>

                <button type="submit" class="btn-submit">Submit Incident</button>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 SafePath. All Rights Reserved.</p>
    </footer>

    <script>
        // Show image previews before uploading
        function previewImages(event) {
            let previewArea = document.getElementById('previewArea');
            previewArea.innerHTML = "";
            let files = event.target.files;

            for (let i = 0; i < files.length; i++) {
                let img = document.createElement("img");
                img.src = URL.createObjectURL(files[i]);
                img.classList.add("preview-img");
                previewArea.appendChild(img);
            }
        }
    </script>
</body>
</html>
