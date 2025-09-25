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

// Query to fetch incident based on search (title)
$incident = null;
$error_message = null;  // Declare error_message variable for no results
if ($search != '') {
    // Query to search for incident by title
    $sql = "SELECT * FROM incident WHERE title LIKE '%$search%'";
    $result = $conn->query($sql);
    
    // If the incident is found, fetch the result
    if ($result->num_rows > 0) {
        $incident = $result->fetch_assoc();
    } else {
        // If no result, display an error message
        $error_message = "No incident found with the provided title.";
    }
}

// Handle form submission to update incident data
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_incident_id'])) {
    $id = $_POST['update_incident_id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // Update the incident details (title, location, description)
    $update_sql = "UPDATE incident SET 
                        title = '$title',
                        location = '$location',
                        description = '$description'
                    WHERE id = $id";

    if ($conn->query($update_sql)) {
        // Handle image upload if a new image is provided
        if (isset($_FILES['incident_image']) && $_FILES['incident_image']['error'] == 0) {
            $image = $_FILES['incident_image']['tmp_name'];
            $imageContent = addslashes(file_get_contents($image));

            // Delete previous images for the incident
            $conn->query("DELETE FROM incident_images WHERE incident_id = $id");

            // Insert the new image into the incident_images table
            $insertImageSql = "INSERT INTO incident_images (incident_id, image) VALUES ('$id', '$imageContent')";
            $conn->query($insertImageSql);
        }

        $status_message = 'success';
    } else {
        $status_message = 'error';
    }
}
?>