<?php
session_start();
include 'db.php';

// Check if user is logged in
if (!isset($_SESSION['email']) || !isset($_SESSION['name'])) {
    echo "<script>alert('Session expired! Please login again.'); window.location.href='login.php';</script>";
    exit();
}

// User details from session
$user_id = $_SESSION['user_id']; 
$customer_name = $_SESSION['name'];  // ✅ Fix: Session se `name` fetch karein
$customer_email = $_SESSION['email'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $phone = $_POST['phone'];
    $service = $_POST['service'];
    $service_date = $_POST['date'];
    $service_time = $_POST['time'];
    $status = 'Pending';

    // Insert booking into database
    $query = "INSERT INTO customer_bookings (user_id, name, user_email, phone, service, service_date, service_time, status) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("isssssss", $user_id, $customer_name, $customer_email, $phone, $service, $service_date, $service_time, $status);

    if ($stmt->execute()) {
        echo "<script>alert('Booking Created Successfully!');</script>";
        echo "<script>window.location.href='booking_history.php';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #010c3e;
        }

        input,
        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #010c3e;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Create a Booking</h2>
        <form method="POST">
            <label for="name">Full Name:</label>
            <input type="text" name="name" id="name"> <!-- ✅ Auto-filled Name -->

            <label for="phone">Phone:</label>
            <input type="text" name="phone" id="phone" required>

            <label for="service">Select Service:</label>
            <select name="service" id="service" required>
                <option value="Car Wash">Car Wash</option>
                <option value="Oil Change">Oil Change</option>
                <option value="Interior Cleaning">Interior Cleaning</option>
            </select>

            <label for="date">Select Date:</label>
            <input type="date" name="date" id="date" required>

            <label for="time">Select Time:</label>
            <input type="time" name="time" id="time" required>

            <button type="submit">Submit Booking</button>
        </form>
    </div>
</body>

</html>