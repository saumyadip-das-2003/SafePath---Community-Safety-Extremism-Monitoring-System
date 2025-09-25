<?php 
session_start();
include('dbcon.php');

// Ensure the user is logged in and is an admin
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch analytics data
$total_users_query = "SELECT COUNT(*) AS total_users FROM citizen";
$total_incidents_query = "SELECT COUNT(*) AS total_incidents FROM incident";
$resolved_incidents_query = "SELECT COUNT(*) AS resolved_incidents FROM incident WHERE review = 'resolved'";
$fake_incidents_query = "SELECT COUNT(*) AS fake_incidents FROM fake";
$active_announcements_query = "SELECT COUNT(*) AS active_announcements FROM announcements WHERE status = 'active'";

$total_users = $conn->query($total_users_query)->fetch_assoc()['total_users'];
$total_incidents = $conn->query($total_incidents_query)->fetch_assoc()['total_incidents'];
$resolved_incidents = $conn->query($resolved_incidents_query)->fetch_assoc()['resolved_incidents'];
$fake_incidents = $conn->query($fake_incidents_query)->fetch_assoc()['fake_incidents'];
$active_announcements = $conn->query($active_announcements_query)->fetch_assoc()['active_announcements'];
?>
