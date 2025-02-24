<?php
session_start();

// Logout functionality
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: NEW3.php");

    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Styled Navbar with Admin Menu</title>
    <!-- FontAwesome for icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Poppins, sans-serif;
        }

        body {

            background-color: #fff;
            color: var(--text-color, #000000);
            transition: background-color 0.3s ease, color 0.3s ease;
        }



        /* Navbar Styles */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #010c3e;
            padding: 10px 20px;
            color: #fff;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar :hover {
            color: #2980b9;
        }

        .navbar .logo a {
            text-decoration: none;
            font-size: 1.8em;
            font-weight: bold;
            color: #fff;
            display: flex;
            align-items: center;
        }

        .navbar .logo i {
            margin-right: 8px;
        }

        .navbar .menu {
            display: flex;
            gap: 23px;
        }

        .navbar .menu li {
            list-style: none;
            position: relative;
        }


        .navbar .menu li a {
            color: #fff;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 3px;
            padding: 0.7rem 2.5%;
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }


        /* Hover effect for links */
        .navbar .menu li a:hover {

            text-decoration: underline;
            color: #2980b9;
        }

        /* Logout Button */
        .logout-btn {
            background-color: #010c3e;
            color: #fff;
            font-weight: 800;
            text-decoration: none;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 3px;
            padding: 0.8rem 2.5%;
            border: none;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .logout-btn:hover {
            text-decoration: underline;
            color: #2980b9;
        }

        /* Menu Icon (Hamburger) */
        .hamburger {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
        }

        .hamburger div {
            width: 30px;
            height: 3px;
            background-color: white;
            transition: transform 0.3s ease;
        }

        .hamburger.active div:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }

        .hamburger.active div:nth-child(2) {
            opacity: 0;
        }

        .hamburger.active div:nth-child(3) {
            transform: rotate(-45deg) translate(5px, -5px);
        }

        .sidebar.active {
            right: 0;
        }

        .sidebar ul {
            list-style: none;
        }

        .sidebar ul li {
            margin: 15px 0;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
            font-size: 1.1em;
            display: block;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .sidebar ul li a:hover {
            background-color: #2980b9;
            transform: scale(1.05);
        }

        /* Admin Menu */
        .admin-menu {
            position: fixed;
            top: 56px;
            left: -250px;
            height: 100%;
            width: 250px;
            background-color: #010c3e;
            color: black;
            padding: 20px;
            transition: 0.3s ease-in-out;
        }

        .admin-menu.active {
            left: 0;
        }

        .admin-menu ul {
            list-style: none;
        }

        .admin-menu ul li {
            margin: 15px 0;
        }

        .admin-menu ul li a {
            color: white;
            text-decoration: none;
            font-size: 0.8em;
            display: block;
            padding: 10px;
            border-radius: 5px;
        }

        .admin-menu ul li a:hover {
            background-color: #2980b9;
        }

        .admin-menu button {
            /* font-size: 1.7em; */
            background-color: transparent;
            border: 2px dotted white;
            color: white;
            font-size: 1.1em;
            padding: 0px 5px;
            cursor: pointer;
            position: absolute;
            top: 15px;
            right: 15px;
            /* transition: transform 0.3s ease; */
            transition: transform cubic-bezier(0.69, -0.26, 1, 1);

        }


        .admin-menu button:hover {
            transform: scale(1.1);
        }


        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            right: -250px;
            height: 100%;
            width: 250px;
            background-color: var(--sidebar-bg-color, #34495e);
            color: white;
            padding: 20px;
            transition: 0.3s ease-in-out;
            z-index: 1002;
            /* Sidebar ko home ke upar dikhane ke liye */
            overflow-y: auto;
            /* Content agar zyada ho toh scroll hone ke liye */
        }

        /* Sidebar Active Class */
        .sidebar.active {
            right: 0;
            /* Sidebar ko visible karne ke liye */
        }

        /* Home Section Styles */
        .home {
            height: 80vh;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: top center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
            z-index: 1;
            /* Home ko sidebar ke neeche rakhne ke liye */
        }

        /* Navbar (Keep it above everything) */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #010c3e;
            padding: 10px 20px;
            color: #fff;
            position: sticky;
            top: 0;
            z-index: 1003;
            /* Navbar ko sab se upar rakhne ke liye */
        }

        /* Admin Menu Styles */
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
            z-index: 1002;
            /* Admin menu ko bhi sidebar ki level pe rakhne ke liye */
        }

        .admin-menu.active {
            left: 0;
            /* Visible karne ke liye */
        }

        /* footer */
        footer {
            background: #010c3e;
            color: white;
            padding: 30px 0;
            text-align: center;
            font-family: Arial, sans-serif;
        }

        .footer-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            max-width: 1100px;
            margin: 0 auto;
        }

        .footer-section {
            flex: 1;
            padding: 20px;
            min-width: 250px;
        }

        .footer-section h2 {
            font-size: 18px;
            margin-bottom: 15px;
            color: #4facfe;
        }

        .footer-section p,
        .footer-section ul {
            font-size: 14px;
            line-height: 1.6;
        }

        .footer-section ul {
            list-style: none;
            padding: 0;
        }

        .footer-section ul li {
            margin: 5px 0;
        }

        .footer-section ul li a {
            color: white;
            text-decoration: none;
            transition: 0.3s;
        }

        .footer-section ul li a:hover {
            color: #4facfe;
        }

        .footer-bottom {
            background: #081120;
            padding: 10px 0;
            margin-top: 20px;
        }

        .footer-bottom p {
            font-size: 14px;
            margin: 0;
        }

        /* drop down menu */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropbtn {
            background-color: #010c3e;
            font-size: 1.1rem;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .dropbtn .arrow {
            margin-left: 8px;
            transition: transform 0.3s ease;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f1f1f1;
            min-width: 160px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 10px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #ddd;
        }

        .dropdown.active .dropdown-content {
            display: block;
        }

        .dropdown.active .arrow {
            transform: rotate(180deg);
        }
    </style>
</head>

<body>
    <header>

    </header>


    <!-- Navbar -->
    <div class="navbar">
        <!-- Logo -->
        <div class="logo">
            <a href="Carwash.php"> CARWASH </a>
        </div>

        <!-- Menu (Links) -->
        <ul class="menu">

            <li><a href="Registerandlogin.php" class="nav-link">ClientsRegistration/Login</a></li>
            </li>
        </ul>

        <!-- dropdown -->
        <div class="dropdown">
            <button class="dropbtn">Employees/Admin<span class="arrow">▼</span></button>
            <div class="dropdown-content">
                <!-- <a href="employee_dashboard.php">Employee</a>
                <a href="index.php">Admin</a> -->
                <a href="login_Role.php">Employee</a>
                <a href="login_Role.php">Admin</a>
            </div>
        </div>
        <!-- drop down end  -->




        <!-- Admin Icon (Menu for Admin) -->
        <div class="admin-icon" onclick="toggleAdminMenu()">
            <i class="fas fa-bars"></i>
        </div>

        <!-- Hamburger Icon (for mobile) -->
        <div class="hamburger" onclick="toggleSidebar()">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>



    <!-- Admin Menu (Sidebar for Admin) -->
    <div class="admin-menu" id="admin-menu">
        <ul>
            <li><a href="HomeService.php">Clients Dashboard</a></li>
            <li><a href="register.php">Admin Dashboard </a></li>
            <li><a href="employee_dashboard.php">Employee Dashboard</a></li>
            <li><a href="index.php">Admin Dashboard</a></li>
            <li><a href="admin_dashboard.php"> Booking History</a></li>
        </ul>
        <button onclick="toggleAdminMenu()">X</button>
    </div>

    <section class="home">
        <div class="home-content">
            <h1>Welcome to Car Wash</h1>
            <p>Premium car wash services at your doorstep</p>
            <a href="Booking.php" class="btn">Get Started</a>
        </div>
    </section>
    <!-- footer  -->
    <footer>
        <div class="footer-container">
            <div class="footer-section about">
                <h2>About CarWash</h2>
                <p>Providing top-notch car washing services with premium quality and customer satisfaction.</p>
            </div>

            <div class="footer-section quick-links">
                <h2>Quick Links</h2>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="services.php">Services</a></li>
                    <li><a href="pricing.php">Pricing</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </div>

            <div class="footer-section contact">
                <h2>Contact Us</h2>
                <p>Email: support@carwash.com</p>
                <p>Phone: +92 123 4567890</p>
                <p>Location: Lahore, Pakistan</p>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2025 CarWash. All Rights Reserved.</p>
        </div>
    </footer>
    <script>
        // Admin Menu toggle functionality
        const adminIcon = document.querySelector('.admin-icon');
        const adminMenu = document.getElementById('admin-menu');

        function toggleAdminMenu() {
            adminMenu.classList.toggle('active');
        }

        // Sidebar toggle functionality for mobile
        const sidebar = document.getElementById('sidebar');
        const hamburger = document.querySelector('.hamburger');

        function toggleSidebar() {
            sidebar.classList.toggle('active');
            hamburger.classList.toggle('active');
        }

        // drop down 
        document.addEventListener("DOMContentLoaded", function() {
            const dropdown = document.querySelector(".dropdown");
            const dropbtn = document.querySelector(".dropbtn");

            dropbtn.addEventListener("click", function(event) {
                event.stopPropagation();
                dropdown.classList.toggle("active");
            });

            document.addEventListener("click", function(event) {
                if (!dropdown.contains(event.target)) {
                    dropdown.classList.remove("active");
                }
            });
        });
        // Logout Button functionality

        const logoutButton = document.querySelector('.logout-btn');
        logoutButton.addEventListener('click', function() {
            alert('Logged out');
            window.location.href = 'Registerandlogin.php';


        });
    </script>
</body>

</html>