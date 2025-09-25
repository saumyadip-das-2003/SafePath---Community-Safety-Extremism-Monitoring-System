<?php
session_start();
include('dbcon.php');

// Ensure the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

// Handle search and filter
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'latest';

// Base query for incidents with dynamic upvotes and downvotes count, defaulting to 0 if no votes
$sql = "SELECT i.*, c.name AS citizen_name,
            COALESCE((SELECT COUNT(*) FROM votes v WHERE v.incident_id = i.id AND v.vote_type = 'upvote'), 0) AS upvotes,
            COALESCE((SELECT COUNT(*) FROM votes v WHERE v.incident_id = i.id AND v.vote_type = 'downvote'), 0) AS downvotes
        FROM incident i
        JOIN citizen c ON i.citizen_id = c.id
        WHERE i.review IS NULL";

// Apply search filter
if ($search != '') {
    $sql .= " AND i.location LIKE '%$search%'";
}

// Apply sorting filter
if ($filter == "upvotes") {
    $sql .= " ORDER BY upvotes DESC";
} elseif ($filter == "downvotes") {
    $sql .= " ORDER BY downvotes DESC";
} else {
    $sql .= " ORDER BY i.created_at DESC";
}

$incidents = $conn->query($sql);

// Handle voting via AJAX
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ajax']) && $_POST['ajax'] == 'vote') {

    $incident_id = intval($_POST['incident_id']);
    $vote_type = $_POST['vote_type'];
    $user_id = $_SESSION['user']['id'];

    // Check if the user has already voted on this incident
    $voteCheck = $conn->query("SELECT * FROM votes WHERE user_id = '$user_id' AND incident_id = '$incident_id'");

    if ($voteCheck->num_rows > 0) {
        // If the user has already voted, we remove their old vote from the votes table
        $existingVote = $voteCheck->fetch_assoc();
        $existingVoteType = $existingVote['vote_type'];

        // Remove old vote record from the votes table
        $conn->query("DELETE FROM votes WHERE user_id = '$user_id' AND incident_id = '$incident_id'");

        // Log the existing vote for debugging
        error_log("Existing Vote - Vote Type: $existingVoteType");

        // Adjust vote counts in the `votes` table accordingly (handled dynamically)
    }

    // Insert the new vote into the votes table
    $conn->query("INSERT INTO votes (user_id, incident_id, vote_type) VALUES ('$user_id', '$incident_id', '$vote_type')");

    // Get updated vote counts from the votes table dynamically
    $upvoteQuery = $conn->query("SELECT COUNT(*) AS upvotes FROM votes WHERE incident_id = $incident_id AND vote_type = 'upvote'");
    $downvoteQuery = $conn->query("SELECT COUNT(*) AS downvotes FROM votes WHERE incident_id = $incident_id AND vote_type = 'downvote'");

    $upvoteRow = $upvoteQuery->fetch_assoc();
    $downvoteRow = $downvoteQuery->fetch_assoc();

    // Return updated vote counts as JSON response
    echo json_encode(["success" => true, "upvotes" => $upvoteRow['upvotes'], "downvotes" => $downvoteRow['downvotes']]);
    exit();
}
