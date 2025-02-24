<?php
session_start();
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$query = "SELECT name, email FROM add_users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_result = $stmt->get_result();
$user = $user_result->fetch_assoc();

// Fetch user bookings
$query = "SELECT id, name, user_email, service_date, service_time, service, total_price, discount, status FROM customer_bookings WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$bookings = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Booking History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            max-width: 1000px;
            margin: 40px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #010c3e;
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #010c3e;
            color: white;
        }

        .status {
            font-weight: bold;
            padding: 6px 10px;
            border-radius: 5px;
        }

        .discount {
            color: green;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Booking History for <?php echo htmlspecialchars($user['name'] ?? 'Unknown'); ?></h2>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email'] ?? 'Not Available'); ?></p>

        <h3>My Bookings</h3>
        <?php if ($bookings->num_rows > 0) { ?>
            <table>
                <thead>
                    <tr>
                        <th>Service Name</th>
                        <th>Price</th>
                        <th>Discount</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Receipt</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($booking = $bookings->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($booking['service']); ?></td>
                            <td>$<?php echo number_format($booking['total_price'], 2); ?></td>
                            <td class="discount">
                                <?php echo ($booking['discount'] > 0) ? $booking['discount'] . '% Off' : 'No Discount'; ?>
                            </td>
                            <td><?php echo htmlspecialchars($booking['service_date']); ?></td>
                            <td><?php echo htmlspecialchars($booking['service_time']); ?></td>
                            <td>
                                <span class="status <?php echo ($booking['status'] == 1) ? 'confirmed' : 'pending'; ?>">
                                    <?php echo ($booking['status'] == 1) ? 'Confirmed' : 'Pending'; ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($booking['status'] == 1) { ?>
                                    <a href="view_receipt.php?booking_id=<?php echo $booking['id']; ?>">View Receipt</a>
                                <?php } else { ?>
                                    -
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>No bookings found.</p>
        <?php } ?>
    </div>
</body>

</html>
