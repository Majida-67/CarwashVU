
<?php
// booking_success.php
session_start();
if (!isset($_SESSION['booking'])) {
    header("Location: create_booking.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Booking Successful</title>
</head>
<body>
    <h2>Booking Confirmed!</h2>
    <p>Your appointment on <?php echo $_SESSION['booking']['date']; ?> at <?php echo $_SESSION['booking']['time']; ?> for <?php echo $_SESSION['booking']['service']; ?> is confirmed.</p>
    <a href="create_booking.php">Book Another</a>
</body>
</html>
<?php session_destroy(); ?>
