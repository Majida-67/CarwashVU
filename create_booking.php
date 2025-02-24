<?php
session_start();
include 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$service_name = isset($_GET['service_name']) ? $_GET['service_name'] : '';
$original_price = isset($_GET['price']) ? $_GET['price'] : 0;
$discount = isset($_GET['discount']) ? $_GET['discount'] : 0;

// Calculate final price after discount
$discounted_price = $original_price - ($original_price * $discount / 100);

// Fetch user details from add_users table
$query = "SELECT name, email, contact_details FROM add_users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_result = $stmt->get_result();
$user = $user_result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $service_name = $_POST['service_name'];
    $service_date = $_POST['service_date'];
    $service_time = $_POST['service_time'];
    $total_price = $_POST['total_price'];
    $discount = $_POST['discount'];
    $status = "Pending"; // Default status

    // Insert booking into customer_bookings table
    $query = "INSERT INTO customer_bookings (user_id, name, user_email, phone, service, service_date, service_time, status, total_price, discount) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("issssssdds", $user_id, $user['name'], $user['email'], $user['contact_details'], $service_name, $service_date, $service_time, $status, $total_price, $discount);

    if ($stmt->execute()) {
        header("Location: booking_history.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Service</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 500px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #010c3e;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .submit-btn {
            margin-top: 15px;
            padding: 10px;
            width: 100%;
            background: #010c3e;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .submit-btn:hover {
            background: #0240a8;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Book Your Service</h2>
        <form action="" method="post">
            <label for="name">Your Name:</label>
            <input type="text" name="name" id="name" value="<?= htmlspecialchars($user['name']) ?>" readonly>

            <label for="email">Your Email:</label>
            <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']) ?>" readonly>

            <label for="phone">Phone Number:</label>
            <input type="text" name="phone" id="phone" value="<?= htmlspecialchars($user['contact_details']) ?>" readonly>

            <label for="service_name">Service Name:</label>
            <input type="text" name="service_name" id="service_name" value="<?= htmlspecialchars($service_name) ?>" readonly>

            <label for="original_price">Original Price ($):</label>
            <input type="text" name="original_price" id="original_price" value="<?= number_format($original_price, 2) ?>" readonly>

            <label for="discount">Discount (%):</label>
            <input type="text" name="discount" id="discount" value="<?= htmlspecialchars($discount) ?>" readonly>

            <label for="total_price">Final Price After Discount ($):</label>
            <input type="text" name="total_price" id="total_price" value="<?= number_format($discounted_price, 2) ?>" readonly>

            <label for="service_date">Select Date:</label>
            <input type="date" name="service_date" id="service_date" required>

            <label for="service_time">Select Time:</label>
            <input type="time" name="service_time" id="service_time" required>

            <button type="submit" class="submit-btn">Confirm Booking</button>
        </form>
    </div>
</body>
</html>
