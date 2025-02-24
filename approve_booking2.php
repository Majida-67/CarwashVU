<?php
include 'db.php';
$id = $_GET['id'];
$query = "UPDATE customer_bookings SET status='Confirmed' WHERE id=$id";
mysqli_query($conn, $query);
header("Location: employee_bookings.php");
?>
