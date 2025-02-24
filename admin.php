<?php
// Database connection
include('db_connection3.php');

// Fetch bookings from the database
$query = "SELECT * FROM bookings ORDER BY created_at DESC";
$bookings = $conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Booking History</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .action-icon {
            font-size: 1.2rem;
            margin-right: 8px;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .action-icon:hover {
            transform: scale(1.2);
        }

        /* Icon Colors */
        .edit-icon {
            color: #FFA500; /* Orange */
        }

        .delete-icon {
            color: #FF6347; /* Tomato Red */
        }

        .confirm-icon {
            color: #32CD32; /* Lime Green */
        }

        .reschedule-icon {
            color: #1E90FF; /* Dodger Blue */
        }

        .cancel-icon {
            color: #808080; /* Gray */
        }

        .track-icon {
            color:rgb(209, 10, 10); /* Slate Blue */
        }
    </style>
</head>

<body class="bg-light">
    <div class="container my-4">
        <h2 class="text-center text-primary mb-4">Booking History</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark text-center">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Service</th>
                        <th>Service Date</th>
                        <th>Service Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $booking) : ?>
                        <tr>
                            <td><?= $booking['id'] ?></td>
                            <td><?= htmlspecialchars($booking['name']) ?></td>
                            <td><?= htmlspecialchars($booking['email']) ?></td>
                            <td><?= htmlspecialchars($booking['phone']) ?></td>
                            <td><?= htmlspecialchars($booking['service']) ?></td>
                            <td><?= htmlspecialchars($booking['service_date']) ?></td>
                            <td><?= htmlspecialchars($booking['service_time']) ?></td>
                            <td class="text-center">
                                <span class="badge <?= strtolower($booking['status']) === 'confirmed' ? 'bg-success' : (strtolower($booking['status']) === 'cancelled' ? 'bg-danger' : 'bg-warning') ?>">
                                    <?= htmlspecialchars($booking['status']) ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="edit_booking.php?id=<?= $booking['id'] ?>" class="action-icon edit-icon" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="delete_booking.php?id=<?= $booking['id'] ?>" class="action-icon delete-icon" title="Delete">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                                <a href="confirm_booking.php?id=<?= $booking['id'] ?>" class="action-icon confirm-icon" title="Confirm">
                                    <i class="fas fa-check-circle"></i>
                                </a>
                                <a href="reschedule_booking.php?id=<?= $booking['id'] ?>" class="action-icon reschedule-icon" title="Reschedule">
                                    <i class="fas fa-calendar-alt"></i>
                                </a>
                                <a href="cancel_booking.php?id=<?= $booking['id'] ?>" class="action-icon cancel-icon" title="Cancel">
                                    <i class="fas fa-times-circle"></i>
                                </a>
                                <a href="track_booking_history.php?id=<?= $booking['id'] ?>" class="action-icon track-icon" title="Track Booking History">
                                    <i class="fas fa-map-marker-alt"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
