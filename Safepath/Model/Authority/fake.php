<?php
session_start();
include('dbcon.php');

// Ensure the user is logged in and is an authority
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'authority') {
    header("Location: ../../View/login.php");
    exit();
}

// Fetch the logged-in authority's data
$authority_id = $_SESSION['user']['id'];
$sql = "SELECT * FROM authority WHERE id = $authority_id";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$user_data = $result->fetch_assoc();

// Fetch all incidents where review is 'fake'
// Use citizen_id from incident table (not authority_id)
$incident_sql = "
SELECT i.*, 
       c.id AS citizen_id, 
       c.name AS citizen_name,
       COALESCE((SELECT COUNT(*) FROM votes v WHERE v.incident_id = i.id AND v.vote_type = 'upvote' AND v.user_id = i.citizen_id),0) AS upvotes,
       COALESCE((SELECT COUNT(*) FROM votes v WHERE v.incident_id = i.id AND v.vote_type = 'downvote' AND v.user_id = i.citizen_id),0) AS downvotes
FROM incident i
JOIN citizen c ON i.citizen_id = c.id
WHERE i.review = 'fake'
ORDER BY i.created_at DESC
";

$incidents = $conn->query($incident_sql);

if (!$incidents) {
    die("Incident query failed: " . mysqli_error($conn));
}
?>
