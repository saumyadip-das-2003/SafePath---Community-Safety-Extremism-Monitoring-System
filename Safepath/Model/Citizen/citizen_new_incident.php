<?php
session_start();
include('dbcon.php');

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $user_id = $_SESSION['user']['id'];

    // Insert incident (without images first)
    $sql = "INSERT INTO incident (citizen_id, title, location, description) 
            VALUES ('$user_id', '$title', '$location', '$description')";

    if ($conn->query($sql)) {
        $incident_id = $conn->insert_id;

        // Handle multiple image uploads
        if (isset($_FILES['images']) && count($_FILES['images']['name']) > 0) {
            for ($i = 0; $i < count($_FILES['images']['name']); $i++) {
                if ($_FILES['images']['error'][$i] == 0) {

                    // Check image size (max 5MB)
                    if ($_FILES['images']['size'][$i] > 5 * 1024 * 1024) {
                        echo "<script>alert('One of the images is larger than 5MB and was skipped.');</script>";
                        continue;
                    }

                    // Read image content as binary
                    $imageData = file_get_contents($_FILES['images']['tmp_name'][$i]);

                    // Insert into incident_images table
                    $stmt = $conn->prepare("INSERT INTO incident_images (incident_id, image) VALUES (?, ?)");
                    $null = NULL;
                    $stmt->bind_param("ib", $incident_id, $null);
                    $stmt->send_long_data(1, $imageData);
                    $stmt->execute();
                }
            }
        }

        echo "<script>alert('Incident added successfully!'); window.location.href = 'citizen_dashboard.php';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}
?>