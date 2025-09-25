<?php
session_start();
include('../../Model/dbcon.php'); // Database connection

// Ensure the user is logged in and is an admin
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../View/Admin/manage_citizen.php");
    exit();
}

// Handle the search functionality
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Fetch citizens based on search
$sql = "SELECT * FROM citizen WHERE email LIKE '%$search%'"; // Search by email
$citizens = $conn->query($sql);

// Handle delete citizen action
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);
    $conn->query("DELETE FROM citizen WHERE id = $delete_id");
    header("Location: ../../View/Admin/manage_citizen.php"); // Refresh the page after deletion
    exit();
}

// Handle add new citizen
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['new_citizen'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $nid = mysqli_real_escape_string($conn, $_POST['nid']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password

    // Insert new citizen into the database
    $sql = "INSERT INTO citizen (name, dob, mobile, email, nid, password) VALUES ('$name', '$dob', '$mobile', '$email', '$nid', '$password')";
    $conn->query($sql);

    header("Location: ../../View/Admin/manage_citizen.php"); 
    exit();
}

?>


