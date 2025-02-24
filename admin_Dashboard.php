

<?php
session_start();
include 'db_connect.php';

// Logout functionality
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: NEW3.php");
    exit();
}

// Get the count of low-stock items
$low_stock_sql = "SELECT COUNT(*) AS low_stock_count FROM inventory WHERE quantity <= 10";
$low_stock_result = mysqli_query($conn, $low_stock_sql);
$low_stock_row = mysqli_fetch_assoc($low_stock_result);
$low_stock_count = $low_stock_row['low_stock_count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar with Notifications</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Poppins, sans-serif;
        }
        body {
            background-color: #fff;
            color: #000;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #3B82F6;
            padding: 10px 20px;
            color: #fff;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .navbar .logo a {
            text-decoration: none;
            font-size: 1.8em;
            font-weight: bold;
            color: #fff;
        }
        .menu {
            display: flex;
            gap: 23px;
        }
        .menu li {
            list-style: none;
        }
        .menu li a {
            color: #fff;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 800;
            padding: 0.7rem;
            border-radius: 5px;
        }
        .menu li a:hover {
            text-decoration: underline;
            color: #000;
        }
        .notification {
            position: relative;
            font-size: 24px;
        }
        .notification .badge {
            position: absolute;
            top: -5px;
            right: -10px;
            background: red;
            color: white;
            border-radius: 50%;
            padding: 5px 10px;
            font-size: 14px;
            font-weight: bold;
        }
        .admin-menu {
            position: fixed;
            top: 56px;
            left: -250px;
            height: 100%;
            width: 250px;
            background-color: #010c3e;
            color: white;
            padding: 20px;
            transition: 0.3s ease-in-out;
        }
        .admin-menu.active {
            left: 0;
        }
        .admin-menu ul {
            list-style: none;
        }
        .admin-menu ul li a {
            color: white;
            text-decoration: none;
            font-size: 0.9em;
            display: block;
            padding: 10px;
        }
        .admin-menu ul li a:hover {
            background-color: #2980b9;
        }
        .admin-icon {
            cursor: pointer;
            font-size: 1.5em;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="logo">
            <a href="HomeService.php">CARWASH</a>
        </div>
        <ul class="menu">
            <li><a href="HomeService.php">Home</a></li>
            <li><a href="login_Role.php">Profile</a></li>
            <li><a href="admin_Dashboard.php">Dashboard</a></li>
            <li><a href="admin_add_service.php">Add Services</a></li>
            <li><a href="admin_add_package.php">Add Packages</a></li>
            <li><a href="user_form.php">Add Users</a></li>
        </ul>
        <a href="alert.php" class="notification">🔔
            <?php if ($low_stock_count > 0) { ?>
                <span class="badge"><?php echo $low_stock_count; ?></span>
            <?php } ?>
        </a>
        <div class="admin-icon" onclick="toggleAdminMenu()">
            <i class="fas fa-user-shield"></i>
        </div>
    </div>

    <div class="admin-menu" id="admin-menu">
        <ul>
            <li><a href="Client_services.php">Client Services</a></li>
            <li><a href="client_view_packages.php">Client Packages</a></li>
            <li><a href="viewbookinghistory.php">View Booking History</a></li>
            <li><a href="admin_services_list.php">View Services</a></li>
            <li><a href="admin_view_packages.php">View Packages</a></li>
            <li><a href="user_list.php">View Users</a></li>
            <li><a href="view_feedback.php">View Feedback</a></li>
            <li><a href="view_booking.php">View Booking</a></li>
        </ul>
        <button onclick="toggleAdminMenu()">X</button>
    </div>

    <script>
        function toggleAdminMenu() {
            document.getElementById('admin-menu').classList.toggle('active');
        }
    </script>
</body>
</html>
