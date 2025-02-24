<?php
include('db_connection.php'); // Connect to the database

// Fetch service details from URL
$service_name = isset($_GET['service_name']) ? urldecode($_GET['service_name']) : '';
$price = isset($_GET['price']) ? $_GET['price'] : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_name = $_POST['customer_name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $service_name = $_POST['service_name'];
    $price = $_POST['price'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    // Insert into the bookings table
    $query = "INSERT INTO customer_bookings (customer_name, email, contact, service_name, price, date, time, status) 
              VALUES (?, ?, ?, ?, ?, ?, ?, 'Pending')";
    $stmt = $conn->prepare($query);
    $stmt->execute([$customer_name, $email, $contact, $service_name, $price, $date, $time]);

    echo "<script>alert('Booking Successful!'); window.location.href='booking_history.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Service</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            width: 90%;
            max-width: 600px;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        h2 {
            color: #010c3e;
        }

        .form-group {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .form-group label {
            flex: 1;
            font-weight: bold;
            text-align: left;
            padding-right: 10px;
            color: #333;
        }

        .form-group input, .form-group select {
            flex: 2;
            padding: 8px;
            border: 1px solid #87d3d7;
            border-radius: 5px;
            width: 100%;
        }

        .btn {
            background: #010c3e;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .btn:hover {
            background: darkgreen;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Book a Service</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="service_name">Service Name:</label>
                <input type="text" id="service_name" name="service_name" value="<?= htmlspecialchars($service_name) ?>" readonly>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="text" id="price" name="price" value="<?= htmlspecialchars($price) ?>" readonly>
            </div>
            <div class="form-group">
                <label for="name">Your Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="contact">Contact No:</label>
                <input type="text" id="contact" name="contact" required>
            </div>
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required>
            </div>
            <div class="form-group">
                <label for="time">Time:</label>
                <input type="time" id="time" name="time" required>
            </div>
            <button type="submit" class="btn">Confirm Booking</button>
        </form>
    </div>
</body>
</html>
