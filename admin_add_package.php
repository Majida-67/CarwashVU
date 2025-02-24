<?php
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $package_name = $_POST['package_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Handle image upload
    $image_url = '';

    if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] == 0) {
        $upload_dir = 'uploads/';
        $file_name = basename($_FILES['image_url']['name']);
        $upload_file = $upload_dir . $file_name;

        // Move the uploaded file to the uploads folder
        if (move_uploaded_file($_FILES['image_url']['tmp_name'], $upload_file)) {
            $image_url = $upload_file; // Set image URL to the uploaded file path
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // Insert the new package into the database
    $query = "INSERT INTO admin_packages (package_name, description, price, image_url, availability) 
              VALUES (:package_name, :description, :price, :image_url, 'Available')";
    $stmt = $conn->prepare($query);
    $stmt->execute([
        ':package_name' => $package_name,
        ':description' => $description,
        ':price' => $price,
        ':image_url' => $image_url
    ]);

    echo "Package added successfully!";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Package</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        
        }

        .container {
            width: 90%;
            max-width: 600px;
            margin: 50px auto;
            background: #fff;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.34);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        input[type="file"] {
            width: 90%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #1a1515;
            border-radius: 4px;
            box-sizing: border-box;
        }

        textarea {
            resize: none;
            height: 100px;
        }

        button {
            display: inline-block;
            width: 90%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        .link-container {
            text-align: center;
            margin-top: 15px;
        }

        .link-container a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .link-container a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add Package</h1>
        <form method="POST" enctype="multipart/form-data" action="admin_add_package.php">
            <label for="package_name">Package Name:</label>
            <input type="text" name="package_name" id="package_name" required>
            
            <label for="description">Description:</label>
            <textarea name="description" id="description" required></textarea>
            
            <label for="price">Price:</label>
            <input type="number" name="price" id="price" required>
            
            <button type="submit">Add Package</button>
        </form>
        <div class="link-container">
            <a href="admin_view_packages.php">View Admin Packages</a>
        </div>
    </div>
</body>
</html>
