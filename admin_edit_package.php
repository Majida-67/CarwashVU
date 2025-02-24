<?php
include('db_connection.php');

// Fetch the existing package data if an ID is passed
if (isset($_GET['id'])) {
    $package_id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM admin_packages WHERE id = :id");
    $stmt->execute([':id' => $package_id]);
    $package = $stmt->fetch();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $package_name = $_POST['package_name'];
        $description = $_POST['description'];
        $price = $_POST['price'];

        // Handle image upload
        $image_url = $package['image_url']; // Default to the existing image

        if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] == 0) {
            $upload_dir = 'uploads/';
            $file_name = basename($_FILES['image_url']['name']);
            $upload_file = $upload_dir . $file_name;

            // Move the uploaded file to the uploads folder
            if (move_uploaded_file($_FILES['image_url']['tmp_name'], $upload_file)) {
                $image_url = $upload_file; // Update image URL to the new image path
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }

        // Update the package details in the database
        $update_query = "UPDATE admin_packages 
                         SET package_name = :package_name, description = :description, price = :price, image_url = :image_url
                         WHERE id = :id";
        $stmt = $conn->prepare($update_query);
        $stmt->execute([
            ':package_name' => $package_name,
            ':description' => $description,
            ':price' => $price,
            ':image_url' => $image_url,
            ':id' => $package_id
        ]);

        echo "Package updated successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Package</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 60%;
            max-width: 800px;
            margin: 40px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 8px 20px rgb(26 23 23 / 52%);

            border-radius: 8px;
        }

        h1 {
            text-align: center;
            font-size: 30px;
            color: #007bff;
            margin-bottom: 30px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 16px;
            margin-bottom: 8px;
            color: #000;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        input[type="file"] {
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #938888;
            border-radius: 5px;
            font-size: 16px;
            width: 100%;
            box-sizing: border-box;
        }

        textarea {
            height: 150px;
            resize: vertical;
        }

        button[type="submit"] {
            padding: 12px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            font-weight: bold;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
            margin-top: 10px;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        a {
            text-align: center;
            color: #007bff;
            font-size: 16px;
            margin-top: 10px;
            text-decoration: none;
            display: block;
            text-align: center;
        }

        a:hover {
            text-decoration: underline;
        }

        input[type="file"] {
            padding: 6px;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        textarea:focus {
            border-color: #007bff;
            outline: none;
        }

        button[type="submit"]:focus {
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Edit Package</h1>

        <form method="POST" enctype="multipart/form-data" action="admin_edit_package.php?id=<?= $package['id'] ?>">
            <label for="package_name">Package Name:</label>
            <input type="text" name="package_name" value="<?= $package['package_name'] ?>" required><br>

            <label for="description">Description:</label>
            <textarea name="description" required><?= $package['description'] ?></textarea><br>

            <label for="price">Price:</label>
            <input type="number" name="price" value="<?= $package['price'] ?>" required><br>


            <button type="submit">Update Package</button>
            <a href="admin_view_packages.php">View Admin packages</a>
        </form>
    </div>
</body>

</html>