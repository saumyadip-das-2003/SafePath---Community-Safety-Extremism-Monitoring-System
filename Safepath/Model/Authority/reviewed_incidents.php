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

$authority_data = $result->fetch_assoc();

// Fetch all incidents where review is 'under action'
$incident_sql = "
SELECT i.*, 
       c.id AS citizen_id,
       c.name AS citizen_name,
       COALESCE((SELECT COUNT(*) FROM votes v WHERE v.incident_id = i.id AND v.vote_type = 'upvote' AND v.user_id = i.citizen_id),0) AS upvotes,
       COALESCE((SELECT COUNT(*) FROM votes v WHERE v.incident_id = i.id AND v.vote_type = 'downvote' AND v.user_id = i.citizen_id),0) AS downvotes
FROM incident i
JOIN citizen c ON i.citizen_id = c.id
WHERE i.review = 'under action'
ORDER BY i.created_at DESC
";

$incidents = $conn->query($incident_sql);

// Handle marking incident as resolved or fake
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['incident_id'])) {
    $incident_id = intval($_POST['incident_id']);
    $action = $_POST['action'];  // 'resolved' or 'fake'

    // First, fetch the citizen_id for this incident
    $citizen_res = $conn->query("SELECT citizen_id FROM incident WHERE id = $incident_id");
    $citizen_row = $citizen_res->fetch_assoc();
    $citizen_id = $citizen_row['citizen_id'];

    // Update the review status based on the action
    if ($action == 'resolved') {
        $update_sql = "UPDATE incident SET review = 'resolved' WHERE id = $incident_id";
        $conn->query($update_sql);
    } elseif ($action == 'fake') {
        $update_sql = "UPDATE incident SET review = 'fake' WHERE id = $incident_id";
        $conn->query($update_sql);

        // Insert into the fake table using the citizen's user_id
        $insert_fake_sql = "INSERT INTO fake (user_id, incident_id) VALUES ('$citizen_id', '$incident_id')";
        $conn->query($insert_fake_sql);
    }

    // Redirect to refresh the page
    header("Location: ../../View/Authority/reviewed_incidents.php");
    exit();
}
?>
