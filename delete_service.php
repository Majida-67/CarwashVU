<?php
// Include the database connection
include('db_connection.php');

// Get the service ID from the URL
$service_id = isset($_GET['id']) ? $_GET['id'] : 0;

// Fetch the service details from the database
$query = "SELECT * FROM admin_services WHERE id = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $service_id, PDO::PARAM_INT);
$stmt->execute();
$service = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if service exists
if (!$service) {
    die("Service not found!");
}

// If a service is found, delete it from the database
$query = "DELETE FROM admin_services WHERE id = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $service_id, PDO::PARAM_INT);

if ($stmt->execute()) {
    // If the service had an image, delete it from the 'uploads' folder
    if ($service['image_url'] && file_exists($service['image_url'])) {
        unlink($service['image_url']);
    }

    echo "Service deleted successfully!";
    // Redirect to the admin services page after deletion
    // header("Location: admin_services.php");
    header("Location: admin_services_list.php");

    exit;
} else {
    echo "Failed to delete service.";
}
?>
