<?php
// Start the session to store user data
session_start();

// Including the database connection
include('dbcon.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = $_POST['role'];  // Get the selected role

    // Prepare a SQL query based on the role selected
    if ($role == "citizen") {
        // Query to check if email exists for citizen role
        $sql = "SELECT * FROM citizen WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Check if citizen is blocked
            if ($user['blocked']) {
                echo "<script>alert('Your account is blocked. Please contact the admin.');</script>";
            } 
            else if (password_verify($password, $user['password'])) {
                // Store user data in session and redirect to the citizen dashboard
                $_SESSION['user'] = $user;  // Storing user data
                $_SESSION['role'] = 'citizen';  // Storing the role
                header("Location: ../View/Citizen/citizen_dashboard.php"); // Redirect to citizen dashboard
                exit();
            } else {
                echo "<script>alert('Invalid password.');</script>";
            }
        } else {
            echo "<script>alert('No account found with this email.');</script>";
        }
    }

    // The authority and admin parts remain unchanged
    elseif ($role == "authority") {
        $sql = "SELECT * FROM authority WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user;
                $_SESSION['role'] = 'authority';
                header("Location: ../View/Authority/authority_dashboard.php");
                exit();
            } else {
                echo "<script>alert('Invalid password.');</script>";
            }
        } else {
            echo "<script>alert('No account found with this email.');</script>";
        }
    }
    elseif ($role == "admin") {
        $sql = "SELECT * FROM admin WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user;
                $_SESSION['role'] = 'admin';
                header("Location: ../View/Admin/admin_dashboard.php");
                exit();
            } else {
                echo "<script>alert('Invalid password.');</script>";
            }
        } else {
            echo "<script>alert('No account found with this email.');</script>";
        }
    }
}
?>
