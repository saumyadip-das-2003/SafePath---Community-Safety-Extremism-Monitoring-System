<?php include('../../Model/theme.php'); ?>
<?php include('../../Model/Admin/manage_admin.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Admin - SafePath</title>
    <link rel="stylesheet" href="../../View/dashboard.css"> <!-- External Dashboard CSS -->
    <link rel="stylesheet" href="manage_citizen.css"> <!-- External CSS for Manage Admin -->
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
			<li><a href="update_admin.php">Update Admin</a></li>
            <li><a href="manage_incidents.php">Manage Incidents</a></li>
            <li><a href="manage_announcement.php">Manage Announcements</a></li>
            <li><a href="fake_reports.php">Fake Submit Management</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Content Section -->
    <div class="content">
        <h2>Manage Admins</h2>

        <!-- Search Form -->
        <form method="GET" action="manage_admin.php">
            <input type="text" name="search" placeholder="Search by email..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Search</button>
        </form>

        <!-- Add New Admin Button -->
        <button class="btn" id="add-admin-btn" onclick="toggleAddAdminForm()">Add New Admin</button>

        <!-- Add Admin Form (Hidden by default) -->
        <div id="add-admin-form" class="form-container" style="display:none;">
            <h3>Add Admin</h3>
            <form method="POST" action="manage_admin.php">
                <input type="hidden" name="new_admin" value="1">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <button type="submit">Save Admin</button>
            </form>
        </div>

        <!-- Admins Table -->
        <table>
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($admin = $admins->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($admin['email']); ?></td>
                        <td>
                            <?php if ($admin['id'] == $first_admin_id): ?>
                                <span>Cannot delete</span> <!-- Prevent deletion of the first admin -->
                            <?php else: ?>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="delete_id" value="<?php echo $admin['id']; ?>">
                                    <button type="submit" class="btn" onclick="return confirm('Are you sure you want to delete this admin?')">Delete</button>
                                </form>
                            <?php endif; ?>
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
        // JavaScript function to toggle the add admin form
        function toggleAddAdminForm() {
            const form = document.getElementById('add-admin-form');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }
    </script>

</body>
</html>
