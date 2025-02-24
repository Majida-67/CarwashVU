<?php
include('db_connection.php');

// Fetch all packages from the database
$query = "SELECT * FROM admin_packages ORDER BY id DESC";
$stmt = $conn->prepare($query);
$stmt->execute();
$packages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - View Packages</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        /* Basic styling for the page */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fc;
        }
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 40px auto;
        }
        
        /* Heading Styling */
        h1 {
            text-align: center;
            font-size: 28px;
            color: #fff;
            margin-bottom: 20px;
            padding: 15px 0;
            background-color: #010c3e;
            border-radius: 8px;
            position: relative;
        }

        h1::after {
            content: '';
            display: block;
            width: 60px;
            height: 3px;
            background-color: #0056b3;
            margin: 10px auto 0;
        }

        /* Grid layout for the packages */
        .package-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }
        
        /* Styling for individual package cards */
        .package-card {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            background-image: linear-gradient(to right, #f7f7f7, #ffffff);
            padding: 1px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        
        .package-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            border: 2px solid #007bff;
        }

        .package-card-inner {
            background-color: #fff;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }

        .package-image {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .package-title {
            font-size: 25px;
            justify-content: center;
            align-content: center;
            font-weight: 500;
            color: #fff;
            height:60px;
            background-color: #010c3e;
            margin-bottom: 10px;
            text-align: center;
        }

        /* Round shape for price */
        .price-badge {
            display: inline-block;
            background-color: #87d3d7;
            color: #fff;
            padding: 10px 20px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 18px;
            margin: 15px 0;
            text-align: center;
        }

        .package-description {
            font-size: 14px;
            color: #777;
            margin-bottom: 15px;
            text-align: center; /* Centering description */
        }

        .package-actions {
            display: flex;
            justify-content: flex-start;
            gap: 10px;
            margin-top: auto; /* Push buttons to the bottom */
        }

        .package-actions a {
            text-decoration: none;
            background-color: #fff;
            color: #010c3e;
            border:1px solid #010c3e;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: 500;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .package-actions a:hover {
            background-color:#87d3d7;
            transform: scale(1.05); /* Slight scaling effect */
        }

    
        .package-actions a.delete:hover {
            background-color:#87d3d7;
        }

        .no-packages {
            text-align: center;
            font-size: 18px;
            color: #666;
            margin-top: 20px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .package-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .package-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Manage Car Wash Packages</h1>
        
        <?php if ($packages): ?>
            <div class="package-grid">
                <?php foreach ($packages as $package): ?>
                    <div class="package-card">
                        <div class="package-card-inner">
                            <div class="package-title"><?= htmlspecialchars($package['package_name']) ?></div>
                            <!-- Round Price Badge -->
                            <div class="price-badge">$<?= htmlspecialchars($package['price']) ?></div>
                            <div class="package-description"><?= htmlspecialchars($package['description']) ?></div>
                            <div class="package-actions">
                                <a href="admin_edit_package.php?id=<?= $package['id'] ?>">Edit</a>
                                <a href="admin_delete_package.php?id=<?= $package['id'] ?>" class="delete" onclick="return confirm('Are you sure you want to delete this package?')">Delete</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="no-packages">No packages available at the moment. Please add some packages!</p>
        <?php endif; ?>
    </div>
</body>
</html>
