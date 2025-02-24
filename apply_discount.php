<?php
include 'db.php'; // Include database connection
session_start();

// Get user ID from session
if (!isset($_SESSION['user_id'])) {
    die("User not logged in");
}
$user_id = $_SESSION['user_id'];

// Fetch previous bookings count
$count_query = "SELECT COUNT(*) AS total_bookings FROM customer_bookings WHERE user_id = ?";
$stmt = $conn->prepare($count_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$count_result = $stmt->get_result();
$count_row = $count_result->fetch_assoc();
$total_bookings = $count_row['total_bookings'];

// Apply discount based on number of bookings
$discount = 0;
if ($total_bookings == 1) {
    $discount = 5; // 5% discount for first booking
} elseif ($total_bookings == 2) {
    $discount = 10; // 10% discount for second booking
}

// Update the latest booking with the applied discount
$update_query = "UPDATE customer_bookings SET discount = ? WHERE user_id = ? ORDER BY id DESC LIMIT 1";
$stmt = $conn->prepare($update_query);
$stmt->bind_param("ii", $discount, $user_id);
$stmt->execute();

// Redirect back to booking history or confirmation page
echo "<script>alert('Discount Applied: {$discount}%'); window.location.href='booking_history.php';</script>";
?>
