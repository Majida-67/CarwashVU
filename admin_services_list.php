<?php
include('db_connection.php');

// Fetch all admin-managed services
$query = "SELECT * FROM admin_services ORDER BY id DESC";
$stmt = $conn->prepare($query);
$stmt->execute();
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Services</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9fc;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #004085;
        }

        /* Add Service Button */
        .add-service-btn {
            display: block;
            width: 200px;
            text-align: center;
            background-color: #004085;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            margin: 20px auto;
            font-weight: bold;
        }

        .add-service-btn:hover {
            background-color: rgb(124, 180, 240);
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px auto;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.43);
            border-radius: 5px;
            overflow: hidden;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #add;
        }

        th {
            background-color: #004085;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e8f1fc;
        }

        /* Buttons */
        .btn {
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            color: white;
            font-weight: bold;
            display: inline-block;
            margin: 5px;
        }

        .btn-edit {
            background-color: #28a745;
        }

        /* Green */
        .btn-delete {
            background-color: #dc3545;
        }

        /* Red */
        .btn-edit:hover {
            background-color: #218838;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }

        /* Image Styling */
        .service-image {
            width: 120px;
            height: auto;
            border-radius: 5px;
            border: 1px solid #ddd;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Discount Row */
        .discount-actions {
            text-align: center;
        }
    </style>
</head>

<body>
    <h1>Manage Admin Services</h1>
    <a href="admin_add_service.php" class="add-service-btn">+ Add New Service</a>

    <table>
        <tr>
            <th>Service Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Duration</th>
            <th>Availability</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($services as $service):
            $discount = $service['discount']; // Get discount
            $price = $service['price']; // Original price
            $final_price = $price - ($price * $discount / 100); // Calculate final price
        ?>
            <!-- Service Details -->
            <tr>
                <td><?= htmlspecialchars($service['service_name']) ?></td>
                <td><?= htmlspecialchars($service['description']) ?></td>
                <td>$<?= htmlspecialchars($service['price']) ?></td>
                <td><?= htmlspecialchars($service['duration']) ?> mins</td>
                <td><?= htmlspecialchars($service['availability']) ?></td>
                <td>
                    <a href="edit_service.php?id=<?= $service['id'] ?>" class="btn btn-edit">✏️ Edit Service</a>
                    <a href="delete_service.php?id=<?= $service['id'] ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this service?')">🗑️ Delete Service</a>
                </td>
            </tr>

            <!-- Image & Discount -->
            <tr>
                <td colspan="2"><img src="<?= htmlspecialchars($service['image_url'] ?? 'default_image.jpg') ?>" alt="Service Image" class="service-image"></td>
                <td colspan="2">Discount: <b><?= htmlspecialchars($service['discount']) ?>%</b></td>
                <td colspan="2"><b>Final Price: $<?= number_format($final_price, 2) ?></b></td>
            </tr>

            <!-- Discount Actions -->
            <tr>
                <td colspan="6" class="discount-actions">
                    <a href="edit_discount.php?id=<?= $service['id'] ?>" class="btn btn-edit">✏️ Edit Discount</a>
                    <a href="delete_discount.php?id=<?= $service['id'] ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this discount?')">🗑️ Delete Discount</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>