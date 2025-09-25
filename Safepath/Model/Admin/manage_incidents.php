<?php
session_start();
include('dbcon.php'); // Database connection

// Ensure the user is logged in and is an admin
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Handle search and filter
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'latest';

// Base query for all incidents with dynamic upvotes and downvotes count, defaulting to 0 if no votes
$sql = "SELECT i.*, c.name AS citizen_name,
            COALESCE((SELECT COUNT(*) FROM votes v WHERE v.incident_id = i.id AND v.vote_type = 'upvote'), 0) AS upvotes,
            COALESCE((SELECT COUNT(*) FROM votes v WHERE v.incident_id = i.id AND v.vote_type = 'downvote'), 0) AS downvotes
        FROM incident i
        JOIN citizen c ON i.citizen_id = c.id";

// Apply search filter (if any)
if ($search != '') {
    $sql .= " AND i.location LIKE '%$search%'"; // Search incidents by location
}

// Apply sorting filter
if ($filter == "upvotes") {
    $sql .= " ORDER BY upvotes DESC";
} elseif ($filter == "downvotes") {
    $sql .= " ORDER BY downvotes DESC";
} else {
    $sql .= " ORDER BY i.created_at DESC"; // Default sort by latest
}

$incidents = $conn->query($sql);

// Handle incident deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_incident_id'])) {
    $incident_id = intval($_POST['delete_incident_id']);

    // First, delete associated images from the incident_images table
    $delete_images_sql = "DELETE FROM incident_images WHERE incident_id = $incident_id";
    $conn->query($delete_images_sql);

    // Then, delete the incident from the incident table
    $delete_incident_sql = "DELETE FROM incident WHERE id = $incident_id";
    $conn->query($delete_incident_sql);
	
	// Also, delete the incident from the fake table if it exists
    $delete_fake_sql = "DELETE FROM fake WHERE incident_id = $incident_id";
    $conn->query($delete_fake_sql);

    // Redirect to refresh the page after deletion
    header("Location: manage_incidents.php");
    exit();
}
?>

