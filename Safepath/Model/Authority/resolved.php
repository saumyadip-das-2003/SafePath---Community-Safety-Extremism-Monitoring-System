<?php
session_start();
include('dbcon.php');

// Ensure the user is logged in and is an authority
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'authority') {
    header("Location: ../../View/login.php");
    exit();
}

// Fetch the logged-in user's data
$user_id = $_SESSION['user']['id'];
$sql = "SELECT * FROM authority WHERE id = $user_id";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$user_data = $result->fetch_assoc();

// Fetch all incidents where review is 'resolved'
$incident_sql = "SELECT i.*, 
                        (SELECT COUNT(*) FROM votes v WHERE v.incident_id = i.id AND v.vote_type = 'upvote') AS upvotes,
                        (SELECT COUNT(*) FROM votes v WHERE v.incident_id = i.id AND v.vote_type = 'downvote') AS downvotes,
                        c.name AS citizen_name
                  FROM incident i
                  JOIN citizen c ON i.citizen_id = c.id
                  WHERE i.review = 'resolved'";  // Only fetch incidents with 'resolved' review status

$incidents = $conn->query($incident_sql);

?>

