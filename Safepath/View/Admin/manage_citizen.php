<?php include('../../Model/theme.php'); ?>
<?php include('../../Model/Admin/manage_citizen.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Citizen - SafePath</title>
    <link rel="stylesheet" href="../../View/dashboard.css"> <!-- External Dashboard CSS -->
    <link rel="stylesheet" href="manage_citizen.css"> <!-- External CSS for Manage Citizen -->
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
        <h2>Manage Citizens</h2>

        <!-- Search Form -->
        <form method="GET" action="manage_citizen.php">
            <input type="text" name="search" placeholder="Search by email..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Search</button>
        </form>

        <!-- Add New Citizen Button -->
        <button class="btn" id="add-citizen-btn" onclick="toggleAddCitizenForm()">Add New Citizen</button>

        <!-- Add Citizen Form (Hidden by default) -->
        <div id="add-citizen-form" class="form-container" style="display:none;">
            <h3>Add Citizen</h3>
            <form method="POST" action="manage_citizen.php">
                <input type="hidden" name="new_citizen" value="1">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" required>

                <label for="mobile">Mobile:</label>
                <input type="text" id="mobile" name="mobile" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="nid">NID:</label>
                <input type="text" id="nid" name="nid" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <button type="submit">Save Citizen</button>
            </form>
        </div>

        <!-- Citizens Table -->
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Date of Birth</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>NID</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($citizen = $citizens->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $citizen['name']; ?></td>
                        <td><?php echo $citizen['dob']; ?></td>
                        <td><?php echo $citizen['mobile']; ?></td>
                        <td><?php echo $citizen['email']; ?></td>
                        <td><?php echo $citizen['nid']; ?></td>
                        <td>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="delete_id" value="<?php echo $citizen['id']; ?>">
                                <button type="submit" class="btn" onclick="return confirm('Are you sure you want to delete this citizen?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

    </div>

    <footer>
        <p>&copy; 2025 SafePath. All Rights Reserved.</p>
    </footer>

    

    <script src="../../Controller/Admin/manage_citizen.js">
        
    </script>
</body>
</html>