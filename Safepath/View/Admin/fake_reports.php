<?php include('../../Model/theme.php'); ?>
<?php include('../../Model/Admin/fake_reports.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Fake Citizens - SafePath</title>
    <link rel="stylesheet" href="../../View/dashboard.css"> <!-- Dashboard CSS -->
    <link rel="stylesheet" href="manage_citizen.css"> <!-- Manage Citizen CSS -->
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #2e7d32;
            color: white;
        }
        .btn {
            padding: 5px 10px;
            background-color: #2e7d32;
            color: white;
            border: none;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #1b5e20;
        }
        .status {
            font-weight: bold;
        }
        .blocked {
            color: red;
        }
        .active {
            color: green;
        }
    </style>
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
            <li><a href="manage_announcement.php">Manage Announcements</a></li>
            <li><a href="fake_reports.php" class="active">Fake Submit Management</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Content Section -->
    <div class="content">
        <h2>Manage Fake Citizens</h2>

        <!-- Search Form -->
        <form method="GET" action="fake_reports.php">
            <input type="text" name="search" placeholder="Search by email..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Search</button>
        </form>

        <!-- Fake Citizens Table -->
        <table>
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($citizens->num_rows > 0): ?>
                    <?php while ($citizen = $citizens->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($citizen['email']); ?></td>
                            <td class="status <?php echo $citizen['blocked'] ? 'blocked' : 'active'; ?>">
                                <?php echo $citizen['blocked'] ? 'Blocked' : 'Active'; ?>
                            </td>
                            <td>
                                <?php if (!$citizen['blocked']): ?>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="block_id" value="<?php echo $citizen['id']; ?>">
                                        <button type="submit" class="btn" onclick="return confirm('Are you sure you want to block this citizen?')">Block</button>
                                    </form>
                                <?php else: ?>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="unblock_id" value="<?php echo $citizen['id']; ?>">
                                        <button type="submit" class="btn" onclick="return confirm('Are you sure you want to unblock this citizen?')">Unblock</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No fake citizens found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

    </div>

    <footer>
        <p>&copy; 2025 SafePath. All Rights Reserved.</p>
    </footer>

</body>
</html>
