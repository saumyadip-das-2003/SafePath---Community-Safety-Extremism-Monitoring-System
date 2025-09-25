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

// Set the filter to default as 'latest'
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'latest';

// Fetch incidents based on the selected filter
$incident_sql = "SELECT i.*, 
                        (SELECT COUNT(*) FROM votes v WHERE v.incident_id = i.id AND v.vote_type = 'upvote') AS upvotes,
                        (SELECT COUNT(*) FROM votes v WHERE v.incident_id = i.id AND v.vote_type = 'downvote') AS downvotes,
                        c.name AS citizen_name
                  FROM incident i
                  JOIN citizen c ON i.citizen_id = c.id
                  WHERE i.review IS NULL
                  ORDER BY 
                      CASE 
                          WHEN '$filter' = 'latest' THEN i.created_at
                          WHEN '$filter' = 'upvotes' THEN (SELECT COUNT(*) FROM votes v WHERE v.incident_id = i.id AND v.vote_type = 'upvote')
                          WHEN '$filter' = 'downvotes' THEN (SELECT COUNT(*) FROM votes v WHERE v.incident_id = i.id AND v.vote_type = 'downvote')
                      END DESC";

$incidents = $conn->query($incident_sql);

// Handle adding resource to an incident
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['incident_id'])) {
    $incident_id = intval($_POST['incident_id']);
    
    // Check if any resource is selected
    if (isset($_POST['resource']) && is_array($_POST['resource'])) {
        $selected_resources = $_POST['resource'];  // Get the selected resources as an array
        
        // Update the incident's review status to 'under action'
        $update_sql = "UPDATE incident SET review = 'under action' WHERE id = $incident_id";
        $conn->query($update_sql);

        // Insert each selected resource into the resource_given table
        foreach ($selected_resources as $resource) {
            $insert_resource_sql = "INSERT INTO resource_given (incident_id, resource) VALUES ('$incident_id', '$resource')";
            $conn->query($insert_resource_sql);
        }

        // Redirect to refresh the page
        header("Location: ../../View/Authority/authority_dashboard.php");
        exit();
    } else {
        $error_message = "Please select at least one resource.";
    }
}
?>
