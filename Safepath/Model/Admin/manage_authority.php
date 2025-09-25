<?php
session_start();
include('../../Model/dbcon.php'); // Database connection

// Ensure the user is logged in and is an admin
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../View/Admin/manage_authority.php");
    exit();
}

// Handle the search functionality
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Fetch authorities based on search
$sql = "SELECT * FROM authority WHERE email LIKE '%$search%'"; // Search by email
$authorities = $conn->query($sql);

// Handle delete authority action
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);
    $conn->query("DELETE FROM authority WHERE id = $delete_id");
    header("Location: ../../View/Admin/manage_authority.php"); // Refresh the page after deletion
    exit();
}

// Handle add new authority
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['new_authority'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    // Check if the email already exists
    $check_email = "SELECT * FROM authority WHERE email = '$email'";
    $result = $conn->query($check_email);
    
    if ($result->num_rows > 0) {
        // Email already exists
        echo "<script>alert('Email is already registered. Please choose a different email.');</script>";
    } else {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password

        // Insert new authority into the database
        $sql = "INSERT INTO authority (email, password) VALUES ('$email', '$password')";
        $conn->query($sql);

        header("Location: ../../View/Admin/manage_authority.php"); 
        exit();
    }
}
?>
