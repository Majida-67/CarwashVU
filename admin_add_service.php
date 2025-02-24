<?php
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $service_name = $_POST['service_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $duration = $_POST['duration'];
    $availability = $_POST['availability'];
    $discount = $_POST['discount'];
    
    // Calculate final price after discount
    $final_price = $price - ($price * $discount / 100);

    // Handle file upload
    $image_url = null;
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "uploads/";
        $image_url = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $image_url);
    }

    $query = "INSERT INTO admin_services (service_name, description, price, discount, final_price, duration, availability, image_url) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->execute([$service_name, $description, $price, $discount, $final_price, $duration, $availability, $image_url]);

    header('Location: admin_services_list.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Admin Service</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f9f9fc; margin: 0; padding: 20px; color: #333; }
        h1 { text-align: center; color: #004085; margin-bottom: 30px; }
        form { max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.51); }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #004085; }
        input, textarea, select { width: 90%; padding: 10px; margin-bottom: 20px; border: 1px solid #817a7a; border-radius: 5px; font-size: 14px; background-color: #f8f9fa; }
        button { width: 100%; padding: 12px; font-size: 16px; font-weight: bold; color: #ffffff; background-color: #004085; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s; }
        button:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    <h1>Add New Admin Service</h1>
    <form method="POST" action="admin_add_service.php" enctype="multipart/form-data">
        <label>Service Name:</label>
        <input type="text" name="service_name" required>
        
        <label>Description:</label>
        <textarea name="description" required></textarea>
        
        <label>Price:</label>
        <input type="number" name="price" step="0.01" required>
        
        <label>Discount (%):</label>
        <input type="number" name="discount" step="0.01" min="0" max="100" required>
        
        <label>Duration (minutes):</label>
        <input type="number" name="duration" required>
        
        <label>Availability:</label>
        <select name="availability">
            <option value="Available">Available</option>
            <option value="Unavailable">Unavailable</option>
        </select>
        
        <label>Image:</label>
        <input type="file" name="image">
        
        <button type="submit">Add Service</button>
    </form>
</body>
</html>
