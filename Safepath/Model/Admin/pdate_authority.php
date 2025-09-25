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

// Query to fetch authority based on search (email)
$authority = null;
$error_message = null;  // Declare error_message variable for no results
if ($search != '') {
    // Query to search for authority by email
    $sql = "SELECT * FROM authority WHERE email LIKE '%$search%'";
    $result = $conn->query($sql);
    
    // If the authority is found, fetch the result
    if ($result->num_rows > 0) {
        $authority = $result->fetch_assoc();
    } else {
        // If no result, display an error message
        $error_message = "No authority found with the provided email.";
    }
}

// Handle form submission to update authority data
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_authority_id'])) {
    $id = $_POST['update_authority_id'];
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // If password is not empty, hash it before updating
    if (!empty($password)) {
        $password = password_hash($password, PASSWORD_DEFAULT);
    } else {
        // If no password change, retain the current password
        $password = $authority['password'];
    }

    // Update the authority details (email and password)
    $update_sql = "UPDATE authority SET 
                    email = '$email',
                    password = '$password'
                    WHERE id = $id";

    if ($conn->query($update_sql)) {
        $status = 'success';
    } else {
        $status = 'error';
    }
}
?>


