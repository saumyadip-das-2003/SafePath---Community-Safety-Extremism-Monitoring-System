<?php include('../../Model/theme.php'); ?>

<?php include('../../Model/Admin/manage_authority.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Authority - SafePath</title>
    <link rel="stylesheet" href="../../View/dashboard.css"> <!-- External Dashboard CSS -->
    <link rel="stylesheet" href="manage_citizen.css"> <!-- External CSS for Manage Authority -->
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h3>SafePath</h3>
        <ul>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="manage_citizen.php">Manage Citizen</a></li>
            <li><a href="manage_authority.php">Manage Authority</a></li>
            <li><a href="pdate_authority.php">Update Authority</a></li>
            <li><a href="manage_admin.php">Manage Admin</a></li>
            <li><a href="manage_incidents.php">Manage Incidents</a></li>
            <li><a href="manage_announcement.php">Manage Announcements</a></li>
            <li><a href="fake_reports.php">Fake Submit Management</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Content Section -->
    <div class="content">
        <h2>Manage Authorities</h2>

        <!-- Search Form -->
        <form method="GET" action="manage_authority.php">
            <input type="text" name="search" placeholder="Search by email..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Search</button>
        </form>

        <!-- Add New Authority Button -->
        <button class="btn" id="add-authority-btn" onclick="toggleAddAuthorityForm()">Add New Authority</button>

        <!-- Add Authority Form (Hidden by default) -->
        <div id="add-authority-form" class="form-container" style="display:none;">
            <h3>Add Authority</h3>
            <form method="POST" action="manage_authority.php">
                <input type="hidden" name="new_authority" value="1">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <button type="submit">Save Authority</button>
            </form>
        </div>

        <!-- Authorities Table -->
        <table>
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($authority = $authorities->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($authority['email']); ?></td>
                        <td>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="delete_id" value="<?php echo $authority['id']; ?>">
                                <button type="submit" class="btn" onclick="return confirm('Are you sure you want to delete this authority?')">Delete</button>
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

    <script>
        // JavaScript function to toggle the add authority form
        function toggleAddAuthorityForm() {
            const form = document.getElementById('add-authority-form');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }
    </script>

</body>
</html>
