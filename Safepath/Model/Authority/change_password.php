<?php
session_start();
include('dbcon.php');

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user']['id'];

$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

// Fetch current password hash
$sql = "SELECT password FROM citizen WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($hashedPassword);
$stmt->fetch();
$stmt->close();

// Verify current password
if (!password_verify($current_password, $hashedPassword)) {
    die("<script>alert('Current password is incorrect.'); window.history.back();</script>");
}

// Validate new password
if ($new_password !== $confirm_password) {
    die("<script>alert('New passwords do not match.'); window.history.back();</script>");
}

if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,20}$/", $new_password)) {
    die("<script>alert('Password must be 8-20 characters, include upper, lower, and digit.'); window.history.back();</script>");
}

// Update password
$new_hashed = password_hash($new_password, PASSWORD_DEFAULT);
$update = $conn->prepare("UPDATE citizen SET password=? WHERE id=?");
$update->bind_param("si", $new_hashed, $user_id);

if ($update->execute()) {
    echo "<script>alert('Password updated successfully!'); window.location.href='citizen_profile.php';</script>";
} else {
    echo "<script>alert('Error updating password.'); window.history.back();</script>";
}
?>
