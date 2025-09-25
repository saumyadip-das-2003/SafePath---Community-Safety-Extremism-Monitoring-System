<?php
session_start();
include('dbcon.php'); // Database connection

// Ensure the user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: ../../View/login.php');
    exit();
}

// Get the logged-in user's ID
$user_id = $_SESSION['user']['id'];

// Handle the incident update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['incident_id'])) {
    $incident_id = intval($_POST['incident_id']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // Handle image upload
    if (isset($_FILES['incident_image']) && $_FILES['incident_image']['error'] == 0) {
        $image = $_FILES['incident_image']['tmp_name'];
        $imageContent = addslashes(file_get_contents($image));

        // Delete the previous image from the database
        $conn->query("DELETE FROM incident_images WHERE incident_id = $incident_id");

        // Insert the new image into the incident_images table
        $insertImageSql = "INSERT INTO incident_images (incident_id, image) VALUES ('$incident_id', '$imageContent')";
        $conn->query($insertImageSql);

        // Update the incident details without modifying the image column in the incident table
        $updateSql = "UPDATE incident SET title = '$title', location = '$location', description = '$description' WHERE id = $incident_id AND citizen_id = '$user_id'";
    } else {
        // If no image uploaded, update only the text fields
        $updateSql = "UPDATE incident SET title = '$title', location = '$location', description = '$description' WHERE id = $incident_id AND citizen_id = '$user_id'";
    }

    if ($conn->query($updateSql) === TRUE) {
        $status = 'success';
    } else {
        $status = 'error';
    }
}

// Handle the incident deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_incident_id'])) {
    $delete_incident_id = intval($_POST['delete_incident_id']);

    // Delete incident images first to avoid foreign key constraint issues
    $conn->query("DELETE FROM incident_images WHERE incident_id = $delete_incident_id");

    // Delete the incident from the database
    $deleteIncidentSql = "DELETE FROM incident WHERE id = $delete_incident_id AND citizen_id = '$user_id'";
    if ($conn->query($deleteIncidentSql) === TRUE) {
        $delete_status = 'success';
    } else {
        $delete_status = 'error';
    }
}

// Fetch the incidents uploaded by the user where review is NULL
$sql = "SELECT i.*, c.name AS citizen_name
        FROM incident i
        JOIN citizen c ON i.citizen_id = c.id
        WHERE i.citizen_id = '$user_id' AND i.review IS NULL"; // Ensure review is NULL

$incidents = $conn->query($sql);
?>


