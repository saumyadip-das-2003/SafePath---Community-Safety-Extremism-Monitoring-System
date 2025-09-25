<?php
session_start();
include('dbcon.php');

// Ensure the user is logged in and is an authority
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'authority') {
    header("Location: ../../View/login.php");
    exit();
}

// Fetch logged-in authority data
$user_id = $_SESSION['user']['id'];
$sql = "SELECT * FROM authority WHERE id = $user_id";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}

$user_data = $result->fetch_assoc();
$status_message = "";

// Handle password change
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['current_password'], $_POST['new_password'], $_POST['confirm_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Verify current password
    if (!password_verify($current_password, $user_data['password'])) {
        $status_message = "<p class='error'>Current password is incorrect.</p>";
    } elseif ($new_password !== $confirm_password) {
        $status_message = "<p class='error'>New password and confirmation do not match.</p>";
    } elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,20}$/", $new_password)) {
        $status_message = "<p class='error'>Password must be 8–20 characters, include upper, lower, and a digit.</p>";
    } else {
        // Hash and update password
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
        $update_sql = "UPDATE authority SET password = '$hashed_password' WHERE id = $user_id";

        if ($conn->query($update_sql) === TRUE) {
            $status_message = "<p class='success'>Password updated successfully!</p>";
        } else {
            $status_message = "<p class='error'>Error updating password: " . $conn->error . "</p>";
        }
    }
}
?>
