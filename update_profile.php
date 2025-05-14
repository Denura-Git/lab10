<?php
session_start();  // Start session

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');  // Redirect to login if not logged in
    exit();
}

// Get the logged-in user's username from the session
$username = $_SESSION['username'];

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_email = $_POST['email'];

    // Create a database connection
    $conn = new mysqli('localhost', 'lab10', '', 'user'); // Update with your DB credentials

    // Check the connection to the database
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update the user's email in the database using prepared statements
    $sql = "UPDATE user SET email=? WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $new_email, $username);  // Bind new email and username as parameters
    if ($stmt->execute()) {
        header('Location: profile.php');  // Redirect to profile after successful update
        exit();
    } else {
        echo "Error updating email: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
