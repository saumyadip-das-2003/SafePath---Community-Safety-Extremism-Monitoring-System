<?php
session_start();
include('dbcon.php');

// Ensure the user is logged in and is an authority
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'authority') {
    header("Location: ../../View/login.php");
    exit();
}

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['title'], $_POST['description'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // Insert the new announcement into the database
    $sql = "INSERT INTO announcements (title, description) VALUES ('$title', '$description')";
    
    if ($conn->query($sql) === TRUE) {
        $status_message = "Announcement created successfully!";
    } else {
        $status_message = "Error creating announcement: " . $conn->error;
    }
}
?>

