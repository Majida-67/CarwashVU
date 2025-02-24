<?php
// Database credentials
$host = "localhost";  // Database server (typically localhost)
$username = "root";   // MySQL username (default for XAMPP is "root")
$password = "";       // MySQL password (default for XAMPP is blank)
$dbname = "carwash"; // Your database name

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // Error if connection fails
}
?>
