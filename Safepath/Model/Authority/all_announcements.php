<?php
session_start();
include('dbcon.php');

// Ensure the user is logged in and is an authority
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'authority') {
    header("Location: ../../View/login.php");
    exit();
}

// Handle update of announcement info or status
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['announcement_id'])) {
    $announcement_id = intval($_POST['announcement_id']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $status = $_POST['status'];

    $update_sql = "UPDATE announcements 
                   SET title = '$title', description = '$description', status = '$status' 
                   WHERE id = $announcement_id";

    if ($conn->query($update_sql) === TRUE) {
        $_SESSION['status_message'] = "Announcement updated successfully!";
    } else {
        $_SESSION['status_message'] = "Error updating announcement: " . $conn->error;
    }

    header("Location: all_announcements.php?filter=" . ($_GET['filter'] ?? 'all'));
    exit();
}

// Handle delete announcement
if (isset($_GET['delete_id'])) {
    $announcement_id = intval($_GET['delete_id']);
    $delete_sql = "DELETE FROM announcements WHERE id = $announcement_id";

    if ($conn->query($delete_sql) === TRUE) {
        $_SESSION['status_message'] = "Announcement deleted successfully!";
    } else {
        $_SESSION['status_message'] = "Error deleting announcement: " . $conn->error;
    }

    header("Location: ../../View/Authority/all_announcements.php?filter=" . ($_GET['filter'] ?? 'all'));
    exit();
}

// Handle filter
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

if ($filter === 'active') {
    $sql = "SELECT * FROM announcements WHERE status = 'active' ORDER BY created_at DESC";
} elseif ($filter === 'inactive') {
    $sql = "SELECT * FROM announcements WHERE status = 'inactive' ORDER BY created_at DESC";
} else {
    $sql = "SELECT * FROM announcements ORDER BY created_at DESC";
}

$result = $conn->query($sql);
?>

