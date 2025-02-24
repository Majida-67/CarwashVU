<?php
// Database connection
include('db_connection3.php');

// Check if 'id' is passed as a GET parameter
if (isset($_GET['id'])) {
    $booking_id = $_GET['id'];

    // Delete the booking from the database
    $stmt = $conn->prepare("DELETE FROM bookings WHERE id = ?");
    $stmt->execute([$booking_id]);

    // Redirect to the admin dashboard after successful deletion
    header("Location: viewbookinghistory.php");
    exit;
} else {
    echo "No booking ID provided!";
    exit;
}
?>
