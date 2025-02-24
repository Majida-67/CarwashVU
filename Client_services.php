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
            transition: transform 0.3s, box-shadow 0.3s;
            position: relative;
        }

        .service-card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
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
            font-size: 25px;
            font-weight: bold;
            color: #010c3e;
            padding: 8px 15px;
            border-radius: 5px;
            display: inline-block;
            position: relative;
        }
       

        /* Discount Badge */
        .discount-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: green;
            color: white;
            padding: 5px 8px;
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
            opacity: 0.9;
        }

        /* Tooltip */
        .tooltip {
            visibility: hidden;
            background-color: black;
            color: #fff;
            text-align: center;
            border-radius: 5px;
            padding: 10px;
            position: absolute;
            z-index: 1;
            top: -30px;
            right: 10px;
            font-size: 15px;
            white-space: nowrap;
        }

        .service-card:hover .tooltip {
            visibility: visible;
        }

        /* Book Now Button */
        .book-now {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 15px;
            font-size: 16px;
            font-weight: bold;
            color: rgb(25, 137, 172);
            border:  2px solid   #010c3e;
            /* border: none; */
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.3s;
        }

        .book-now:hover {
            background-color:rgb(184, 214, 223);
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Our Car Wash Services</h1>
        <div class="services-wrapper">
            <?php if ($services): ?>
                <?php foreach ($services as $service):
                    $discount = $service['discount']; // Get discount
                    $price = $service['price']; // Original price
                    $final_price = $price - ($price * $discount / 100); // Calculate final price
                ?>
                    <div class="service-card">
                        <?php if ($discount > 0): ?>
                            <div class="discount-badge"><?= $discount ?>% OFF</div>
                            <div class="tooltip">Hurry up! Book Now and get <?= $discount ?>% off!</div>
                        <?php endif; ?>

                        <img src="<?= htmlspecialchars($service['image_url'] ?? 'default_image.jpg') ?>" alt="Service Image" class="service-image">
                        <div class="service-content">
                            <div class="service-title"> <?= htmlspecialchars($service['service_name']) ?> </div>
                            <div class="service-description"> <?= htmlspecialchars($service['description']) ?> </div>

                            <?php if ($discount > 0): ?>
                                <div class="service-price">
                                    <s>$<?= number_format($price, 2) ?></s> → $<?= number_format($final_price, 2) ?>
                                </div>
                            <?php else: ?>
                                <div class="service-price"> Price: $<?= number_format($price, 2) ?> </div>
                            <?php endif; ?>

                            <!-- Book Now Button -->

                            <a href="create_booking.php?service_name=<?= urlencode($service['service_name']) ?>&price=<?= $final_price ?>&discount=<?= $discount ?>" class="book-now">Book Now</a>


                            
                        <!-- <a href="create_booking.php?service_name=<?= urlencode($service['service_name']) ?>&price=<?= $final_price ?>" class="book-now">Book Now</a> -->
                        
                    
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