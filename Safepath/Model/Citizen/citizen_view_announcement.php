<?php
// Start session and include database connection
session_start();
include('dbcon.php');

// Ensure the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: ../../View/login.php");
    exit();
}

// Fetch all active announcements from the database
$sql = "SELECT * FROM announcements WHERE status = 'active' ORDER BY created_at DESC";
$announcements = $conn->query($sql);
?>

