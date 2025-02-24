<?php
// Database configuration
define('DB_SERVER', 'localhost'); // Database server (usually 'localhost')
define('DB_USERNAME', 'root');    // Your database username
define('DB_PASSWORD', '');        // Your database password (leave empty if none)
define('DB_DATABASE', 'booking_system'); // Your database name

// Create the database connection
try {
    // Create a PDO instance
    $conn = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_DATABASE, DB_USERNAME, DB_PASSWORD);
    
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Set the character encoding to UTF-8 to avoid any character set issues
    $conn->exec("SET NAMES 'utf8'");

    // Uncomment the following line for debugging purposes (to check if the connection was successful)
    // echo "Connected successfully"; // Optional, can be removed in production
} catch(PDOException $e) {
    // Error handling
    die("Connection failed: " . $e->getMessage());
}
return $conn;
?>
