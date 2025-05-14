<?php
session_start();  // Start a session to track login state

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the submitted username and password
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Create a database connection
    $conn = new mysqli('localhost', 'root', '', 'user'); // Update with your DB credentials
    
    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to select the user record with matching username and password
    $sql = "SELECT * FROM user WHERE username='$username' AND password='$password'";
    
    // Execute the query
    $result = $conn->query($sql);
    
    // Check if the user was found in the database
    if ($result->num_rows > 0) {
        // Start a session and store the username for use on other pages
        $_SESSION['username'] = $username;
        
        // Redirect the user to the profile page
        header('Location: profile.php');
        exit();
    } else {
        // If the credentials don't match, display an error message
        echo "Invalid username or password!";
    }

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="POST" action="login.php">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br><br>
        
        <input type="submit" value="Login">
    </form>
</body>
</html>
