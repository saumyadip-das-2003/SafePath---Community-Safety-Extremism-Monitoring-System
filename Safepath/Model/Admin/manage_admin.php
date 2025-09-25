<?php
session_start();
include('../../Model/dbcon.php'); // Database connection

// Ensure the user is logged in and is an admin
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../View/Admin/manage_admin.php");
    exit();
}

// Handle the search functionality
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Fetch admins based on search
$sql = "SELECT * FROM admin WHERE email LIKE '%$search%'"; // Search by email
$admins = $conn->query($sql);

// Fetch the first admin (super admin)
$first_admin_sql = "SELECT * FROM admin ORDER BY id ASC LIMIT 1"; // Fetch the first row (super admin)
$first_admin_result = $conn->query($first_admin_sql);
$first_admin = $first_admin_result->fetch_assoc();
$first_admin_id = $first_admin['id']; // Store the ID of the first admin

// Handle delete admin action
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);

    // Prevent deleting the first admin (super admin)
    if ($delete_id == $first_admin_id) {
        echo "<script>alert('You cannot delete the super admin.');</script>";
    } else {
        $conn->query("DELETE FROM admin WHERE id = $delete_id");
        header("Location: ../../View/Admin/manage_admin.php"); // Refresh the page after deletion
        exit();
    }
}

// Handle add new admin
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['new_admin'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    // Check if the email already exists
    $check_email = "SELECT * FROM admin WHERE email = '$email'";
    $result = $conn->query($check_email);
    
    if ($result->num_rows > 0) {
        // Email already exists
        echo "<script>alert('Email is already registered. Please choose a different email.');</script>";
    } else {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password

        // Insert new admin into the database
        $sql = "INSERT INTO admin (email, password) VALUES ('$email', '$password')";
        $conn->query($sql);

        header("Location: ../../View/Admin/manage_admin.php"); 
        exit();
    }
}
?>
