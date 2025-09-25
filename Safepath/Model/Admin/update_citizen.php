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

// Query to fetch citizens based on search
$citizen = null;
$error_message = null;  // Declare error_message variable for no results
if ($search != '') {
    // Query to search for citizens by email
    $sql = "SELECT * FROM citizen WHERE email LIKE '%$search%'";
    $result = $conn->query($sql);
    
    // If the citizen is found, fetch the result
    if ($result->num_rows > 0) {
        $citizen = $result->fetch_assoc();
    } else {
        // If no result, display an error message
        $error_message = "No citizen found with the provided email.";
    }
}

// Handle form submission to update citizen data
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_citizen_id'])) {
    $id = $_POST['update_citizen_id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $nid = mysqli_real_escape_string($conn, $_POST['nid']);
    
    // Handle profile image upload
    $profile_image = null;
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        $profile_image = addslashes(file_get_contents($_FILES['profile_image']['tmp_name']));
    }

    // Update the citizen details
    $update_sql = "UPDATE citizen SET 
                    name = '$name',
                    dob = '$dob',
                    mobile = '$mobile',
                    email = '$email',
                    nid = '$nid'";

    if ($profile_image) {
        $update_sql .= ", profile_image = '$profile_image'";
    }

    $update_sql .= " WHERE id = $id";

    if ($conn->query($update_sql)) {
        $status = 'success';
    } else {
        $status = 'error';
    }
}
?>

