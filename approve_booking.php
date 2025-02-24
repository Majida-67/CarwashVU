<?php
include 'db.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    mysqli_query($conn, "UPDATE customer_bookings SET status='Approved' WHERE id='$id'");
    header("Location: view_booking.php");
}
?>
