<?php include('../../Model/theme.php'); ?>
<?php
include ('../../Model/Citizen/citizen_profile.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - SafePath</title>
    <link rel="stylesheet" href="../dashboard.css">
    <link rel="stylesheet" href="citizen_profile.css">
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
        <div class="container">
            <h2>Profile</h2>

            <!-- Profile Card -->
            <div class="profileCard">
                <div class="avatarCol">
                    <?php 
                    if ($user_data['profile_image']) { 
                        $imageData = base64_encode($user_data['profile_image']); 
                        echo '<img class="avatar" src="data:image/jpeg;base64,' . $imageData . '" alt="Profile Image">';
                    } else {
                        echo '<img class="avatar" src="default-profile.jpg" alt="Profile Image">';
                    }
                    ?>
                    <label class="uploadBtn">
                        Change photo
                        <input type="file" id="profile_image" name="profile_image" form="editForm" accept="image/*">
                    </label>
                    <img id="preview" class="avatarPreview" alt="Preview">
                </div>

                <div class="infoCol">
                    <div class="infoRow"><span>Name:</span> <?php echo $user_data['name']; ?></div>
                    <div class="infoRow"><span>Email:</span> <?php echo $user_data['email']; ?></div>
                    <div class="infoRow"><span>Mobile:</span> <?php echo $user_data['mobile']; ?></div>
                    <div class="infoRow"><span>Date of Birth:</span> <?php echo $user_data['dob']; ?></div>
                    <div class="infoRow"><span>NID:</span> <?php echo $user_data['nid']; ?></div>
                </div>
            </div>

            <!-- Edit Profile -->
            <div class="card">
                <h3>Edit Profile</h3>
                <form id="editForm" action="update_profile.php" method="POST" class="formGrid">
                    <div class="field full">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" value="<?php echo $user_data['name']; ?>" required>
                    </div>
                    <div class="field">
                        <label for="dob">Date of Birth</label>
                        <input type="date" id="dob" name="dob" value="<?php echo $user_data['dob']; ?>" required>
                    </div>
                    <div class="field">
                        <label for="mobile">Mobile (11 digits)</label>
                        <input type="text" id="mobile" name="mobile" value="<?php echo $user_data['mobile']; ?>" required>
                        <small class="hint">Exactly 11 digits</small>
                    </div>
                    <div class="field">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo $user_data['email']; ?>" readonly class="readonly-field">
                    </div>
                    <div class="field">
                        <label for="nid">NID (10 digits)</label>
                        <input type="text" id="nid" name="nid" value="<?php echo $user_data['nid']; ?>" readonly class="readonly-field">
                    </div>
                    <div class="field full">
                        <button type="submit" class="primary">Save Changes</button>
                    </div>
                </form>
            </div>

            <!-- Change Password -->
            <div class="card">
                <h3>Change Password</h3>
                <form id="passwordForm" action="change_password.php" method="POST" class="formGrid">
                    <div class="field full">
                        <label for="current_password">Current Password</label>
                        <input type="password" id="current_password" name="current_password" required>
                    </div>
                    <div class="field full">
                        <label for="new_password">New Password</label>
                        <input type="password" id="new_password" name="new_password" required>
                        <small class="hint">8–20 chars, at least 1 upper, 1 lower, 1 digit</small>
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
    </div>

    <footer>
        <p>&copy; 2025 SafePath. All Rights Reserved.</p>
    </footer>

    <script src="../../Controller/Citizen/citizen_profile.js"></script>
</body>
</html>