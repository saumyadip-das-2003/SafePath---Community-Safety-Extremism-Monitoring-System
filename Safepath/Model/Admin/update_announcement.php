<?php 
session_start();
include('../../Model/dbcon.php'); // Database connection

// Ensure the user is logged in and is an admin
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../View/login.php");
    exit();
}

// Handle search functionality
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Query to fetch announcement based on search (title)
$announcement = null;
$error_message = null;  // Declare error_message variable for no results
if ($search != '') {
    // Query to search for announcement by title
    $sql = "SELECT * FROM announcements WHERE title LIKE '%$search%'";
    $result = $conn->query($sql);
    
    // If the announcement is found, fetch the result
    if ($result->num_rows > 0) {
        $announcement = $result->fetch_assoc();
    } else {
        // If no result, display an error message
        $error_message = "No announcement found with the provided title.";
    }
}

// Handle form submission to update announcement data
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_announcement_id'])) {
    $id = $_POST['update_announcement_id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $status = $_POST['status'];

    // Update the announcement details (title, description, and status)
    $update_sql = "UPDATE announcements SET 
                        title = '$title',
                        description = '$description',
                        status = '$status'
                    WHERE id = $id";

    if ($conn->query($update_sql)) {
        $status_message = 'success';
    } else {
        $status_message = 'error';
    }
}
?>


