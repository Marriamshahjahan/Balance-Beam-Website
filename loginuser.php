<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'login');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=? AND password=?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Username and password are correct, redirect to profile page
        $_SESSION['username'] = $username;
        header("Location: profile_$username.html");
        exit();
    } else {
        // Incorrect username or password
        echo "Incorrect username or password";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
