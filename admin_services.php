<?php
// Include the database connection file
include('db_connection.php');

// Handle form submission to add a new service
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch the data from the form
    $admin_id = 1; // Use the actual admin ID or session data
    $service_name = $_POST['service_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $duration = $_POST['duration'];
    $availability = $_POST['availability'];

    // Handle image upload
    $image_url = null;
    if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] === UPLOAD_ERR_OK) {
        // Set the upload directory
        $upload_dir = 'uploads/';

        // Get the uploaded file's name and extension
        $file_name = basename($_FILES['image_url']['name']);
        $file_path = $upload_dir . $file_name;

        // Move the uploaded file to the uploads directory
        if (move_uploaded_file($_FILES['image_url']['tmp_name'], $file_path)) {
            $image_url = $file_path;  // Store the path in the database
        } else {
            echo "<div style='text-align: center; background-color: #f8d7da; color: #721c24; padding: 10px; border: 1px solid #f5c6cb; border-radius: 5px; margin: 10px;'>Failed to upload image.</div>";
        }
    }

    // Insert the new service into the database
    $query = "INSERT INTO admin_services (admin_id, service_name, description, price, duration, availability, image_url)
              VALUES (:admin_id, :service_name, :description, :price, :duration, :availability, :image_url)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':admin_id', $admin_id);
    $stmt->bindParam(':service_name', $service_name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':duration', $duration);
    $stmt->bindParam(':availability', $availability);
    $stmt->bindParam(':image_url', $image_url);

    if ($stmt->execute()) {
        echo "<div style='text-align: center; background-color: #d4edda; color: #155724; padding: 10px; border: 1px solid #c3e6cb; border-radius: 5px; margin: 10px;'>Service added successfully!</div>";
    } else {
        echo "<div style='text-align: center; background-color: #f8d7da; color: #721c24; padding: 10px; border: 1px solid #f5c6cb; border-radius: 5px; margin: 10px;'>Failed to add service!</div>";
    }
}

// Fetch the services from the database to display in the admin panel
$query = "SELECT * FROM admin_services ORDER BY created_at DESC";
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
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #eaf6ff;
            color: #333;
        }

        h2,
        h3 {
            text-align: center;
            color: #1a4d7a;
        }

        form {
            width: 80%;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border: 2px solid #1a4d7a;
        }

        form input,
        form textarea,
        form select,
        form button {
            display: block;
            width: 90%;
            margin: 10px 0;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #1a4d7a;
            border-radius: 4px;
            background-color: rgba(214, 233, 255, 0.28);
            color: #0a3a5e;
        }

        form input:focus,
        form textarea:focus,
        form select:focus {
            outline: none;
            border-color: #0a3a5e;
            background-color: rgb(220, 237, 255);
        }

        form button {
            background: #1a4d7a;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        form button:hover {
            background: #16436b;
        }

        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border: 2px solid #1a4d7a;
        }

        table th,
        table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #1a4d7a;
            color: white;
        }

        table tr:hover {
            background-color: #f1f9ff;
        }

        table img {
            max-width: 150px;
            max-height: 150px;
            border-radius: 4px;
        }

        table td a {
            color: #1a4d7a;
            text-decoration: none;
            font-weight: bold;
            margin-right: 10px;
        }

        table td a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {

            form,
            table {
                width: 95%;
            }

            table img {
                max-width: 100px;
                max-height: 100px;
            }
        }
    </style>
</head>

<body>
    <h2>Manage Car Wash Services</h2>

    <!-- Form to add a new service -->
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="service_name" placeholder="Service Name" required>
        <textarea name="description" placeholder="Description" required></textarea>
        <input type="number" step="0.01" name="price" placeholder="Price" required>
        <input type="number" name="duration" placeholder="Duration (in minutes)" required>
        <select name="availability">
            <option value="Available">Available</option>
            <option value="Unavailable">Unavailable</option>
        </select>
        <input type="file" name="image_url" accept="image/*" required>
        <button type="submit">Add Service</button>
    </form>

    <!-- Display all services -->
    <h3>Existing Services</h3>
    <table border="1">
        <tr>
            <th>Service Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Duration</th>
            <th>Availability</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($services as $service): ?>
            <tr>
                <td><?= htmlspecialchars($service['service_name']) ?></td>
                <td><?= htmlspecialchars($service['description']) ?></td>
                <td><?= htmlspecialchars($service['price']) ?></td>
                <td><?= htmlspecialchars($service['duration']) ?> min</td>
                <td><?= htmlspecialchars($service['availability']) ?></td>
                <td>
                    <?php if ($service['image_url']): ?>
                        <img src="<?= htmlspecialchars($service['image_url']) ?>" alt="Service Image">
                    <?php else: ?>
                        <img src="default_image.jpg" alt="Default Image">
                    <?php endif; ?>
                </td>
                <td>
                    <a href="admin_services_list.php?id=<?= $service['id'] ?>">Check Services List</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>