<?php
// Include the database connection
include('db_connection.php');

// Get the service ID from the URL
$service_id = isset($_GET['id']) ? $_GET['id'] : 0;

// Fetch the service details from the database
$query = "SELECT * FROM admin_services WHERE id = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $service_id, PDO::PARAM_INT);
$stmt->execute();
$service = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if service exists
if (!$service) {
    die("Service not found!");
}

// Handle form submission to update service
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch the data from the form
    $service_name = $_POST['service_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $duration = $_POST['duration'];
    $availability = $_POST['availability'];

    // Handle image upload if a new image is provided
    $image_url = $service['image_url'];  // Keep the old image if no new one is uploaded
    if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        $file_name = basename($_FILES['image_url']['name']);
        $file_path = $upload_dir . $file_name;

        // Move the uploaded file to the uploads directory
        if (move_uploaded_file($_FILES['image_url']['tmp_name'], $file_path)) {
            $image_url = $file_path;  // Update the image URL
        } else {
            echo "Failed to upload image.";
        }
    }

    // Update the service in the database
    $query = "UPDATE admin_services SET 
                service_name = :service_name,
                description = :description,
                price = :price,
                duration = :duration,
                availability = :availability,
                image_url = :image_url
              WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':service_name', $service_name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':duration', $duration);
    $stmt->bindParam(':availability', $availability);
    $stmt->bindParam(':image_url', $image_url);
    $stmt->bindParam(':id', $service_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Service updated successfully!";
        header("Location: admin_services_list.php");

        exit;
    } else {
        echo "Failed to update service.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Service</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9fc;
            margin: 50px  10px;
            padding: 20px;
            color: #000;
        }

        h2 {
            text-align: center;
            color: #004085;
            margin-bottom: 30px;
        }

        /* Form Styles */
        form {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.51);
        }

        form input[type="text"],
        form input[type="number"],
        form textarea,
        form select {
            width: 90%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #817a7a;
            border-radius: 5px;
            font-size: 14px;
            color: #333;
            background-color: #f8f9fa;
        }

        form input[type="text"]:focus,
        form input[type="number"]:focus,
        form textarea:focus,
        form select:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        form textarea {
            height: 100px;
            resize: none;
        }

        form input[type="file"] {
            margin-bottom: 20px;
        }

        form button {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            color: #ffffff;
            background-color: #004085;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        form button:hover {
            background-color: #0056b3;
        }

        /* Image Preview Styles */
        img {
            display: block;
            margin: 10px auto 20px;
            max-width: 150px;
            max-height: 150px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <h2>Edit Car Wash Service</h2>

    <form method="POST" enctype="multipart/form-data">
        <label for="service_name">Service Name:</label>
        <input type="text" id="service_name" name="service_name" value="<?= htmlspecialchars($service['service_name']) ?>" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?= htmlspecialchars($service['description']) ?></textarea>

        <label for="price">Price:</label>
        <input type="number" step="0.01" id="price" name="price" value="<?= htmlspecialchars($service['price']) ?>" required>

        <label for="duration">Duration (minutes):</label>
        <input type="number" id="duration" name="duration" value="<?= htmlspecialchars($service['duration']) ?>" required>

        <label for="availability">Availability:</label>
        <select id="availability" name="availability">
            <option value="Available" <?= $service['availability'] === 'Available' ? 'selected' : '' ?>>Available</option>
            <option value="Unavailable" <?= $service['availability'] === 'Unavailable' ? 'selected' : '' ?>>Unavailable</option>
        </select>

        <!-- Display current image -->
        <?php if ($service['image_url']): ?>
            <img src="<?= htmlspecialchars($service['image_url']) ?>" alt="Service Image">
        <?php endif; ?>

        <label for="image_url">Upload New Image:</label>
        <input type="file" id="image_url" name="image_url" accept="image/*">

        <button type="submit">Update Service</button>
    </form>
</body>

</html>