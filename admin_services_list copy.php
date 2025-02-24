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

        a {
            text-decoration: none;
            color: #004085;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Button for adding new service */
        a[href="admin_add_service.php"] {
            display: inline-block;
            background-color: #004085;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
            text-align: center;
            text-decoration:none;

        }

        a[href="admin_add_service.php"]:hover {
            background-color:rgb(124, 180, 240);
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
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid  #add;
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

        /* Image in the table */
        td img {
            width: 100px;
            height: auto;
            border-radius: 5px;
            border: 1px solid #ddd;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Actions Column */
        .actions a {
            margin-right: 10px;
            padding: 5px 10px;
            color: white;
            border-radius: 3px;
        }

        .actions a:first-child {
            display:flex;
            margin-bottom: 10px;
            background-color: #218838;
            text-decoration:none;
        }

        .actions a:first-child:hover {
            background-color:rgb(176, 255, 193);
        }

        .actions a:last-child {
            background-color: #dc3545;
            text-decoration:none;

        }

        .actions a:last-child:hover {
            background-color:rgb(252, 173, 181);
        }
    </style>
</head>

<body>
    <h1>Manage Admin Services</h1>
    <a href="admin_add_service.php">Add New Service</a>
    <table>
        <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Duration</th>
            <th>Availability</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($services as $service): ?>
            <tr>
                <td><img src="<?= htmlspecialchars($service['image_url'] ?? 'default_image.jpg') ?>" alt="Image"></td>
                <td><?= htmlspecialchars($service['service_name']) ?></td>
                <td><?= htmlspecialchars($service['description']) ?></td>
                <td>$<?= htmlspecialchars($service['price']) ?></td>
                <td><?= htmlspecialchars($service['duration']) ?> mins</td>
                <td><?= htmlspecialchars($service['availability']) ?></td>
                <td class="actions">
                    <a href="edit_service.php?id=<?= $service['id'] ?>">Edit</a>
                    <a href="delete_service.php?id=<?= $service['id'] ?>" onclick="return confirm('Are you sure you want to delete this service?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>