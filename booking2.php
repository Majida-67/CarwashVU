<?php
include('db_connection3.php');

// Initialize variables for filtering
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';
$date_from = isset($_GET['date_from']) ? $_GET['date_from'] : '';
$date_to = isset($_GET['date_to']) ? $_GET['date_to'] : '';
$search_query = isset($_GET['search']) ? $_GET['search'] : '';

// Build the base query
$query = "SELECT * FROM bookings WHERE 1=1";

// Add filters to the query
$params = [];
if ($status_filter) {
    $query .= " AND status = ?";
    $params[] = $status_filter;
}
if ($date_from) {
    $query .= " AND service_date >= ?";
    $params[] = $date_from;
}
if ($date_to) {
    $query .= " AND service_date <= ?";
    $params[] = $date_to;
}
if ($search_query) {
    $query .= " AND (name LIKE ? OR email LIKE ? OR phone LIKE ?)";
    $params[] = "%$search_query%";
    $params[] = "%$search_query%";
    $params[] = "%$search_query%";
}

// Execute the query
$stmt = $conn->prepare($query);
$stmt->execute($params);
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Booking History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            color: #333;
        }

        h2 {
            text-align: center;
            margin: 30px 0;
            font-size: 28px;
            color: #007bff;
        }

        form {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        form label {
            display: inline-block;
            width: 120px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #555;
        }

        form select,
        form input {
            margin-right:25px;
            width: calc(100% - 140px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #01114a;
            border-radius: 4px;
            font-size: 14px;
            transition: border 0.3s;
        }

        form select:focus,
        form input:focus {
            border-color: #007bff;
            outline: none;
        }

        form input[type="text"] {
            width: calc(100% - 140px);
        }

        form button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        form button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
            background-color: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        table th,
        table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #000;
            color: #ccc;
            font-weight: bold;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:nth-child(odd) {
            background-color: #ffffff;
        }

        table tr:hover {
            background-color: #e9f5ff;
        }

        table td[colspan="8"] {
            text-align: center;
            font-size: 18px;
            color: #999;
        }

        table td {
            color: #555;
        }

        table td:nth-child(8) {
            color: #007bff;
        }

        @media (max-width: 768px) {
            form {
                padding: 15px;
            }

            form label {
                width: 100%;
                margin-bottom: 5px;
            }

            form select,
            form input {
                width: 100%;
            }

            form button {
                width: 100%;
                padding: 12px;
            }
        }
    </style>
</head>

<body>
    <h2>Track Booking History</h2>

    <!-- Filter Form -->
    <form method="GET" action="track_booking_history.php">
        <label for="status">Status:</label>
        <select name="status" id="status">
            <option value="">All</option>
            <option value="Confirmed" <?= $status_filter == 'Confirmed' ? 'selected' : '' ?>>Confirmed</option>
            <option value="Rescheduled" <?= $status_filter == 'Rescheduled' ? 'selected' : '' ?>>Rescheduled</option>
            <option value="Cancelled" <?= $status_filter == 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
        </select>

        <label for="date_from">Date From:</label>
        <input type="date" name="date_from" id="date_from" value="<?= htmlspecialchars($date_from) ?>">

        <label for="date_to">Date To:</label>
        <input type="date" name="date_to" id="date_to" value="<?= htmlspecialchars($date_to) ?>">

        <label for="search">Search:</label>
        <input type="text" name="search" id="search" placeholder="Name, Email, or Phone" value="<?= htmlspecialchars($search_query) ?>">

        <button type="submit">Filter</button>
    </form>

    <!-- Booking History Table -->
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Service</th>
            <th>Service Date</th>
            <th>Service Time</th>
            <th>Status</th>
        </tr>
        <?php if ($bookings): ?>
            <?php foreach ($bookings as $booking): ?>
                <tr>
                    <td><?= $booking['id'] ?></td>
                    <td><?= htmlspecialchars($booking['name']) ?></td>
                    <td><?= htmlspecialchars($booking['email']) ?></td>
                    <td><?= htmlspecialchars($booking['phone']) ?></td>
                    <td><?= htmlspecialchars($booking['service']) ?></td>
                    <td><?= htmlspecialchars($booking['service_date']) ?></td>
                    <td><?= htmlspecialchars($booking['service_time']) ?></td>
                    <td><?= htmlspecialchars($booking['status']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="8">No bookings found for the selected criteria.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>

</html>