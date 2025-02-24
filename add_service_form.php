<?php
include('db_connection2.php'); // Include database connection

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $duration = $_POST['duration'];
    $availability = $_POST['availability'];

    // Handle file upload
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_dir = 'uploads/' . $image; // Directory to save uploaded images

    // Upload image and insert data into the database
    if (move_uploaded_file($image_tmp, $image_dir)) {
        $query = "INSERT INTO services (name, description, price, duration, availability, image)
                  VALUES ('$name', '$description', '$price', '$duration', '$availability', '$image')";

        if (mysqli_query($conn, $query)) {
            // Redirect to dashboard on successful addition
            header("Location: service_dashboard.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Error uploading image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Service</title>
</head>
<body>
    <h1>Add a New Service</h1>
    <form method="POST" action="" enctype="multipart/form-data">
        <label>Service Name:</label>
        <input type="text" name="name" required><br><br>

        <label>Description:</label>
        <textarea name="description" required></textarea><br><br>

        <label>Price:</label>
        <input type="number" step="0.01" name="price" required><br><br>

        <label>Duration (minutes):</label>
        <input type="number" name="duration" required><br><br>

        <label>Availability:</label>
        <select name="availability" required>
            <option value="1">Active</option>
            <option value="0">Inactive</option>
        </select><br><br>

        <label>Service Image:</label>
        <input type="file" name="image" required><br><br>

        <button type="submit">Add Service</button>
    </form>
</body>
</html>
