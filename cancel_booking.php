<?php
include('db_connection3.php');

// Cancel booking
$id = $_GET['id'];
$query = "UPDATE bookings SET status = 'Cancelled' WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->execute([$id]);

header("Location: viewbookinghistory.php");
exit;
?>
