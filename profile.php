<?php
session_start(); // Start a session to access the logged-in user's data

// Check if the user is logged in by verifying the session variable
if (!isset($_SESSION['username'])) {
    // If the session does not exist, redirect to the login page
    header('Location: login.php');
    exit();
}

// Get the logged-in user's username from the session
$username = $_SESSION['username'];

// Connect to the database (change database credentials as needed)
$conn = new mysqli('localhost', 'root', '', 'user'); // Update your DB credentials

// Check the connection to the database
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the user data from the database based on the username stored in the session
$sql = "SELECT * FROM user WHERE username='$username'";
$result = $conn->query($sql);

// Check if the user exists in the database
if ($result->num_rows > 0) {
    // Fetch the user's data
    $user = $result->fetch_assoc();
} else {
    echo "User not found!";
    exit();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
</head>
<body>
    <h1>Welcome, <?php echo $user['username']; ?>!</h1>
    <p>Email: <?php echo $user['email']; ?></p>

    <!-- Link to edit profile -->
    <a href="profile.php?edit=true">Edit Profile</a>
</body>
</html>
