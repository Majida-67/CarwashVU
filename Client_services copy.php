<?php
include('db_connection.php'); // Connect to the database

// Fetch available services from the database
$query = "SELECT * FROM admin_services WHERE availability = 'Available' ORDER BY id DESC";
$stmt = $conn->prepare($query);
$stmt->execute();
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .container {
            width: 99%;
            max-width: 1200px;
            margin: 20px auto;
            text-align: center;
        }

        h1 {
            color: #010c3e;
            margin-bottom: 20px;
        }

        .services-wrapper {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .service-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: #fff;
            width: 270px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .service-card:hover {
            transform: scale(1.05);
        }

        .service-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }

        .service-content {
            text-align: center;
            padding-top: 15px;
        }

        .service-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #010c3e;
        }

        .service-description {
            font-size: 14px;
            color: #555;
            margin-bottom: 15px;
        }

        .service-price {
            font-size: 16px;
            color: #333;
            font-weight: bold;
            background: #87d3d7;
            padding: 8px 15px;
            border-radius: 5px;
            display: inline-block;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Our Car Wash Services</h1>
        <div class="services-wrapper">
            <?php if ($services): ?>
                <?php foreach ($services as $service): ?>
                    <div class="service-card">
                        <img src="<?= htmlspecialchars($service['image_url'] ?? 'default_image.jpg') ?>" alt="Service Image" class="service-image">
                        <div class="service-content">
                            <div class="service-title"> <?= htmlspecialchars($service['service_name']) ?> </div>
                            <div class="service-description"> <?= htmlspecialchars($service['description']) ?> </div>
                            <div class="service-price"> Price: $<?= htmlspecialchars($service['price']) ?> </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No services available at the moment. Please check back later!</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
