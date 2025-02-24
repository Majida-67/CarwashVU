
// include 'db.php';
// $id = $_GET['id'];
// $query = "DELETE FROM customer_bookings WHERE id=$id";
// mysqli_query($conn, $query);
// header("Location: view_booking.php");


<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Booking ko delete nahi karna, sirf status 'Deleted' karna hai
    $query = "UPDATE customer_bookings SET status='Deleted' WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: view_booking.php?message=Booking deleted successfully");
    } else {
        header("Location: view_booking.php?message=Error deleting booking");
    }
    exit();
}
?>

