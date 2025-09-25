<?php
// Start the session to retain form data and error messages
session_start();

// Including the database connection
include('dbcon.php');

// Initialize error message
$error_message = "";

// Collect form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Store the form data in the session
    $_SESSION['name'] = $_POST['name'];
    $_SESSION['dob'] = $_POST['dob'];
    $_SESSION['mobile'] = $_POST['mobile'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['nid'] = $_POST['nid'];

    // Collect data and perform validation
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $nid = mysqli_real_escape_string($conn, $_POST['nid']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Handle profile image upload
    $profileImage = NULL;
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        $profileImage = file_get_contents($_FILES['profile_image']['tmp_name']);
    }

    // Validate Name (Only alphabetical and spaces allowed)
    if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
        $_SESSION['error_message'] = "Invalid name. Name should only contain letters and spaces.";
        header('Location: signup.php');
        exit();
    }

    // Validate Mobile (Exactly 11 digits)
    if (!preg_match("/^\d{11}$/", $mobile)) {
        $_SESSION['error_message'] = "Invalid mobile number. It must be exactly 11 digits.";
        header('Location: signup.php');
        exit();
    }

    // Validate NID (Exactly 10 digits)
    if (!preg_match("/^\d{10}$/", $nid)) {
        $_SESSION['error_message'] = "Invalid NID. It must be exactly 10 digits.";
        header('Location: signup.php');
        exit();
    }

    // Validate Age (18 years or older)
    $birthDate = new DateTime($dob);
    $today = new DateTime();
    $age = $today->diff($birthDate)->y;

    if ($age < 18) {
        $_SESSION['error_message'] = "You must be at least 18 years old to register.";
        header('Location: signup.php');
        exit();
    }

    // Validate Password (should be strong)
    $regexStrongPassword = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,20}$/"; // At least 1 lowercase, 1 uppercase, 1 digit
    if (!preg_match($regexStrongPassword, $password)) {
        $_SESSION['error_message'] = "Invalid password. Password must be between 8-20 characters and contain at least one uppercase letter, one lowercase letter, and one digit.";
        header('Location: signup.php');
        exit();
    }

    // Check if Email or NID already exists in the database
    $sql = "SELECT * FROM citizen WHERE email = '$email' OR nid = '$nid'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['error_message'] = "Email or NID already registered.";
        header('Location: signup.php');
        exit();
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert data into the database
    $sql = "INSERT INTO citizen (name, dob, mobile, email, nid, password, profile_image) 
            VALUES ('$name', '$dob', '$mobile', '$email', '$nid', '$hashedPassword', ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $profileImage);

    if ($stmt->execute()) {
        // Redirect to login page after successful registration
        unset($_SESSION['name']); // Clear session data after successful registration
        unset($_SESSION['dob']);
        unset($_SESSION['mobile']);
        unset($_SESSION['email']);
        unset($_SESSION['nid']);
        
        echo "<script>
                alert('Registration successful!');
                
                    window.location.href = '../View/login.php';
             
              </script>";
    } 
	else 
	{
        $_SESSION['error_message'] = "Error: " . $stmt->error;
        header('Location: signup.php');
        exit();
    }

    // Close the connection
    $conn->close();
}
?>