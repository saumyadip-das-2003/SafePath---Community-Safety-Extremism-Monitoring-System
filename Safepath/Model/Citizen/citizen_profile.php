<?php
session_start();
include('dbcon.php');

// Ensure the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: ../../View/login.php");
    exit();
}

// Get the logged-in user's ID
$user_id = $_SESSION['user']['id'];

// Fetch user data
$sql = "SELECT * FROM citizen WHERE id = $user_id";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$user_data = $result->fetch_assoc();

// Handle profile image upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
    $image = $_FILES['profile_image']['tmp_name'];
    $imageContent = addslashes(file_get_contents($image));

    // Update the profile image in the database
    $updateImageSql = "UPDATE citizen SET profile_image = '$imageContent' WHERE id = '$user_id'";
    if ($conn->query($updateImageSql) === TRUE) {
        // Fetch the updated profile image after insertion
        $getImageSql = "SELECT profile_image FROM citizen WHERE id = '$user_id'";
        $imageResult = $conn->query($getImageSql);
        $imageData = $imageResult->fetch_assoc();
        
        // Return the base64-encoded image
        echo json_encode(['success' => true, 'image' => base64_encode($imageData['profile_image'])]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating profile image.']);
    }
    exit();  // Stop the script after the response
}

?>