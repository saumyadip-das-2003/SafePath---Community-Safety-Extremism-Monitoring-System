<?php
session_start();
include('../../Model/dbcon.php'); // Database connection

// Ensure the user is logged in and is an admin
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../View/Admin/fake_reports.php");
    exit();
}

// Handle search functionality
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// SQL query: fetch citizens appearing 3+ times in fake table
$sql = "SELECT citizen.email, citizen.id, IFNULL(citizen.blocked, 0) AS blocked, COUNT(fake.id) AS fake_count
        FROM citizen
        JOIN fake ON citizen.id = fake.user_id";

if (!empty($search)) {
    $sql .= " WHERE citizen.email LIKE '%$search%'";
}

$sql .= " GROUP BY citizen.id
          HAVING COUNT(fake.id) >= 3
          ORDER BY fake_count DESC";

$citizens = $conn->query($sql);

// Handle block action
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['block_id'])) {
    $block_id = intval($_POST['block_id']);
    $conn->query("UPDATE citizen SET blocked = TRUE WHERE id = $block_id");
    header("Location: ../../View/Admin/fake_reports.php");
    exit();
}

// Handle unblock action
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['unblock_id'])) {
    $unblock_id = intval($_POST['unblock_id']);
    $conn->query("UPDATE citizen SET blocked = FALSE WHERE id = $unblock_id");
    header("Location: ../../View/Admin/fake_reports.php");
    exit();
}
?>
