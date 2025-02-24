
<?php
// Increase memory limit at the top of the file
ini_set('memory_limit', '1024M');  // Set to 1GB or higher if needed

// Define database name
define('DB_DATABASE', 'booking_system');

// Your database connection code here
$servername = "localhost";
$username = "root";
$password = "";

try {
    // Use the defined constant DB_DATABASE for the database name
    $conn = new PDO("mysql:host=$servername;dbname=" . DB_DATABASE, $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully"; 
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
