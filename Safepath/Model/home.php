<?php
// Include database connection
include('dbcon.php');

// Query to fetch unresolved incident where 'review' is NULL
$query = "SELECT * FROM incident WHERE review IS NULL ORDER BY created_at DESC LIMIT 5";
$result = mysqli_query($conn, $query);

// Check if there are any unresolved incidents
$incidents = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Fetch incident images
        $incident_images = [];
        $incident_id = $row['id'];
        $image_query = "SELECT * FROM incident_images WHERE incident_id = '$incident_id'";
        $image_result = mysqli_query($conn, $image_query);

        while ($image_row = mysqli_fetch_assoc($image_result)) {
            $incident_images[] = base64_encode($image_row['image']); // Encoding images to base64 for display
        }

        $row['images'] = $incident_images;
        $incidents[] = $row;
    }
} else {
    $incidents = [];
}
?>
