<?php
include('db_connection2.php'); // Include your database connection file

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
    $image_dir = 'uploads/' . $image; // Path to save image

    // Check if the image is uploaded successfully
    if (move_uploaded_file($image_tmp, $image_dir)) {
        // Insert service details into the database
        $query = "INSERT INTO services (name, description, price, duration, availability, image) 
                  VALUES ('$name', '$description', '$price', '$duration', '$availability', '$image')";

        if (mysqli_query($conn, $query)) {
            // Redirect to the service dashboard after successful submission
            header("Location: service_dashboard.php");
            exit(); // Ensure no further code is executed after the redirect
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        // Error in image upload
        echo "Error uploading image.";
    }
}
?>

<form method="POST" action="" enctype="multipart/form-data">
    <label>Service Name:</label>
    <input type="text" name="name" required><br>

    <label>Description:</label>
    <textarea name="description" required></textarea><br>

    <label>Price:</label>
    <input type="number" name="price" step="0.01" required><br>

    <label>Duration:</label>
    <input type="number" name="duration" required><br>

    <label>Availability:</label>
    <select name="availability" required>
        <option value="1">Active</option>
        <option value="0">Inactive</option>
    </select><br>

    <label>Service Image:</label>
    <input type="file" name="image" required><br>

    <button type="submit">Add Service</button>
</form>
