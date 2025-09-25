<?php
session_start();
include('dbcon.php'); // Database connection

// Ensure the user is logged in and is an admin or citizen
if (!isset($_SESSION['user'])) {
    header("Location: ../../View/Admin/manage_announcement.php");
    exit();
}

// Handle search functionality for announcements
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Query to fetch all active and inactive announcements based on the search filter
$sql = "SELECT * FROM announcements WHERE title LIKE '%$search%' OR description LIKE '%$search%' ORDER BY created_at DESC";

$announcements = $conn->query($sql);
?>


