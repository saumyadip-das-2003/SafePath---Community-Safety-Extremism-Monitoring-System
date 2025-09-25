<?php
session_start();
include('dbcon.php');

if (!isset($_SESSION['user'])) {
    header("Location: ../../View/login.php");
    exit();
}

$user_id = $_SESSION['user']['id'];

$name = mysqli_real_escape_string($conn, $_POST['name']);
$dob = mysqli_real_escape_string($conn, $_POST['dob']);
$mobile = mysqli_real_escape_string($conn, $_POST['mobile']);

// 🔹 Age Validation
$birthDate = new DateTime($dob);
$today = new DateTime();
$age = $today->diff($birthDate)->y;

if ($age < 18) {
    die("<script>alert('You must be at least 18 years old.'); window.history.back();</script>");
}

// Validate Name
if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
    die("<script>alert('Invalid name. Only letters and spaces allowed.'); window.history.back();</script>");
}

// Validate Mobile (11 digits)
if (!preg_match("/^\d{11}$/", $mobile)) {
    die("<script>alert('Mobile number must be exactly 11 digits.'); window.history.back();</script>");
}

// Handle Profile Image (optional)
if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
    $profileImage = file_get_contents($_FILES['profile_image']['tmp_name']);

    $stmt = $conn->prepare("UPDATE citizen SET name=?, dob=?, mobile=?, profile_image=? WHERE id=?");
    $null = NULL; // placeholder
    $stmt->bind_param("sssbi", $name, $dob, $mobile, $null, $user_id);
    $stmt->send_long_data(3, $profileImage);
} else {
    $stmt = $conn->prepare("UPDATE citizen SET name=?, dob=?, mobile=? WHERE id=?");
    $stmt->bind_param("sssi", $name, $dob, $mobile, $user_id);
}


if ($stmt->execute()) {
    echo "<script>alert('Profile updated successfully!'); window.location.href='../../View/Citizen/citizen_profile.php';</script>";
} else {
    echo "<script>alert('Error updating profile: " . $stmt->error . "'); window.history.back();</script>";
}
?>
