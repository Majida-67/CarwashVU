<?php
$servername = "localhost"; // Usually 'localhost'
$username = "root"; // Your database username
$password = ""; // Your database password (empty for XAMPP)
$database = "carwash_user_management"; // Change this to your actual DB name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
