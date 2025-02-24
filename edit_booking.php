<?php
// Database connection
include('db_connection3.php');

// Check if 'id' is passed as a GET parameter
if (isset($_GET['id'])) {
    $booking_id = $_GET['id'];

    // Fetch the booking details from the database
    $stmt = $conn->prepare("SELECT * FROM bookings WHERE id = ?");
    $stmt->execute([$booking_id]);
    $booking = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$booking) {
        echo "Booking not found!";
        exit;
    }
}

// Check if the form is submitted to update the booking
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $service = $_POST['service'];
    $service_date = $_POST['service_date'];
    $service_time = $_POST['service_time'];
    $status = $_POST['status'];

    // Update the booking in the database
    $stmt = $conn->prepare("UPDATE bookings SET name = ?, email = ?, phone = ?, service = ?, service_date = ?, service_time = ?, status = ? WHERE id = ?");
    $stmt->execute([$name, $email, $phone, $service, $service_date, $service_time, $status, $booking_id]);

    // Redirect to the admin dashboard after successful update
    header("Location: admin_dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Booking</title>
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f9f9f9;
        color: #333;
        margin: 0;
        padding: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }

    h2 {
        text-align: center;
        color: #00023c;
        margin-bottom: 20px;
    }

    form {
        background-color: #fff;
        padding: 20px 30px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 500px;
    }

    label {
        display: block;
        font-size: 14px;
        font-weight: bold;
        margin-bottom: 8px;
        color: #00023c;
    }

    input[type="text"],
    input[type="email"],
    input[type="date"],
    input[type="time"],
    select {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid  #00023c;
        border-radius: 4px;
        font-size: 14px;
    }

    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="date"]:focus,
    input[type="time"]:focus,
    select:focus {
        border-color: rgb(62, 152, 255);
        outline: none;
        box-shadow: 0 0 5px rgba(133, 133, 134, 0.5);
    }

    input[type="submit"] {
        background-color: #00023c;
        color: white;
        border: none;
        padding: 12px 20px;
        font-size: 16px;
        border-radius: 4px;
        cursor: pointer;
        width: 100%;
        transition: background-color 0.3s;
    }

    input[type="submit"]:hover {
        background-color:rgb(62, 152, 255);
    }

    @media (max-width: 768px) {
        form {
            padding: 15px 20px;
        }

        input[type="submit"] {
            font-size: 14px;
            padding: 10px 16px;
        }
    }
</style>

<body>
    
    <form method="POST" action="edit_booking.php?id=<?= $booking['id'] ?>">
    <h2>Edit Booking</h2>
        <label>Name:</label><br>
        <input type="text" name="name" value="<?= htmlspecialchars($booking['name']) ?>" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" value="<?= htmlspecialchars($booking['email']) ?>" required><br><br>

        <label>Phone:</label><br>
        <input type="text" name="phone" value="<?= htmlspecialchars($booking['phone']) ?>" required><br><br>

        <label>Service:</label><br>
        <input type="text" name="service" value="<?= htmlspecialchars($booking['service']) ?>" required><br><br>

        <label>Service Date:</label><br>
        <input type="date" name="service_date" value="<?= htmlspecialchars($booking['service_date']) ?>" required><br><br>

        <label>Service Time:</label><br>
        <input type="time" name="service_time" value="<?= htmlspecialchars($booking['service_time']) ?>" required><br><br>

        <label>Status:</label><br>
        <select name="status">
            <option value="pending" <?= $booking['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
            <option value="confirmed" <?= $booking['status'] == 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
            <option value="cancelled" <?= $booking['status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
        </select><br><br>

        <input type="submit" value="Update Booking">
    </form>
</body>

</html>