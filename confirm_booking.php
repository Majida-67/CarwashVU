<?php
include('db_connection3.php');

// Confirm booking
$id = $_GET['id'];
$query = "UPDATE bookings SET status = 'Confirmed' WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->execute([$id]);

header("Location: viewbookinghistory.php");
exit;
?>
