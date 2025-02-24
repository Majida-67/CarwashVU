<?php
include 'db.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Check if the booking exists
    $checkQuery = "SELECT * FROM customer_bookings WHERE id = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Delete booking
        $deleteQuery = "DELETE FROM customer_bookings WHERE id = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "success";  // JavaScript AJAX success response
        } else {
            echo "error";  // JavaScript will show 'Failed to delete booking.'
        }
    } else {
        echo "not found";  // Booking not found case
    }

    $stmt->close();
} else {
    echo "invalid";  // Invalid ID or request
}

$conn->close();
?>
