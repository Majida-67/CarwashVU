<?php include('db_config.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Wash Booking</title>
    <!-- Link Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Poppins, sans-serif;

        }

        body {
            background-size: 100vw;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            background-color: rgba(255, 255, 255, 0.5);
            transition: background-color 0.3s ease, color 0.3s ease;
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #010c3e;
        }

        h1 {
            text-align: center;
            margin: 50px 0;
            font-size: 2.5rem;
            color: #010c3e;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }



        form {
            width: 600px;
            margin: 0 auto;
            padding: 30px;
            background-color: rgb(255 255 255 / 25%);
            border-radius: 10px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.3);
            animation: slide-in 1s ease-out;
        }

        @keyframes slide-in {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 8px;
        }

        .input-container {
            position: relative;
            margin-bottom: 20px;
        }

        .input-container i {
            position: absolute;
            left: 10px;
            top: 67%;
            transform: translateY(-50%);
            color: #010c3e;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"],
        input[type="service"],
        input[type="time"] {
            width: 100%;
            padding: 10px 10px 10px 35px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            transition: box-shadow 0.3s ease, border 0.3s ease;
        }

        #service {
            width: 100%;
            padding: 10px 10px 10px 35px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            transition: box-shadow 0.3s ease, border 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="date"]:focus,
        input[type="time"]:focus {
            outline: none;
            border: 1px solid #010c3e;
            box-shadow: 0px 0px 8px rgba(1, 12, 62, 0.5);
        }

        input[type="submit"] {
            width: 100%;
            background-color: #010c3e;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1rem;
            text-transform: uppercase;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        input[type="submit"]:hover {
            background-color: #87d3d7;
            transform: scale(1.05);
        }

        input[type="submit"]:active {
            transform: scale(0.98);
        }


        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #010c3e;
            padding: 10px 20px;
            color: #777;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar .logo a {
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
            padding: 0.5rem 2.5%;
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .navbar .menu li a:hover {

            text-decoration: underline;
            color: #5796cb;
        }

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

        header p {
            background-color: #fff;
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


        /* #0a1230e0   */

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
            font-size: 1.1em;
            display: block;
            padding: 10px;
            border-radius: 5px;
        }

        .admin-menu ul li a:hover {
            background-color: #2980b9;
            color: black;

        }

        .admin-menu button {
            /* font-size: 1.7em; */
            background-color: transparent;
            border: 2px dotted white;
            color: white;
            font-size: 1.3em;
            padding: 5px 11px;
            cursor: pointer;
            position: absolute;
            top: 20px;
            right: 20px;
            transition: transform 0.3s ease;
        }

        .admin-menu button:hover {
            transform: scale(1.1);
        }


        /* Dropdown Styles */
        .navbar .dropdown {
            position: relative;
        }

        .navbar .dropdown .dropdown-menu {
            display: none;
            position: absolute;
            top: 105%;
            left: 10px;
            background-color: #fff;
            padding: 10px 10px;
            list-style: none;
            margin: 0;
            border-radius: 5px;
            min-width: 250px;
        }

        .navbar .dropdown:hover .dropdown-menu {
            display: block;
        }

        .navbar .dropdown-menu li a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            display: block;
            font-size: 1em;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .navbar .dropdown-menu li a:hover {
            background-color: #777;
        }

        .navbar .dropdown .fa-chevron-down {
            margin-left: 5px;
        }

        .admin-icon {
            font-size: 1.2em;
            color: #000;

        }



        .footer-section {
            height: 65px;
            font-size: 15px;
            align-items: center;
            text-align: center;
            color: #fff;
            background-color: #010c3e;
            display: flex;
            justify-content: space-between;
            padding: 5px 5px;
        }

        /* Basic icon style */
        a {
            margin: 8px 8px;
            font-size: 18px;
            padding: 5px 5px;
            text-decoration: none;
            border-radius: 50%;
            transition: background-color 0.3s ease, color 0.3s ease;

        }

        @media (max-width: 480px) {
            a {
                margin: 8px 8px;
                font-size: 10px;
                padding: 5px 5px;
                text-decoration: none;
                border-radius: 50%;
                transition: background-color 0.3s ease, color 0.3s ease;
            }

            .footer-section {
                height: 65px;
                font-size: 10px;
                align-items: center;
                text-align: center;
                color: #fff;
                background-color: #010c3e;
                display: flex;
                justify-content: space-between;
                padding: 5px 5px;
            }

            .faq-question {
                width: 100%;
                text-align: left;
                padding: 18px;
                background-color: #fff;
                color: #010c3e;
                font-size: 10px;
                border: 2px solid #010c3e;
                cursor: pointer;
                display: flex;
                justify-content: space-between;
                align-items: center;
                border-radius: 5px;
                transition: background-color 0.3s ease, transform 0.3s ease;
                position: relative;
            }

            .faq-question::after {
                content: "×";
                /* Cross symbol for the button */
                font-size: 30px;
                color: #010c3e;
                position: absolute;
                right: 20px;
                transition: transform 0.3s ease, scale 0.3s ease;
            }

            button {
                background-color: #87d3d7;
                color: #010c3e;
                padding: 12px 20px;
                border: none;
                border-radius: 5px;
                width: 60%;
                cursor: pointer;
                font-size: 16px;
            }


        }

        /* WhatsApp */
        .whatsapp {
            background-color: #ffff;
            color: #010c3e;
        }

        .whatsapp:hover {
            background-color: green;
        }

        /* Facebook */
        .facebook {
            background-color: #ffff;
            color: #010c3e;
        }

        .facebook:hover {
            background-color: #155D9B;

        }

        .email {
            background-color: #ffff;
            color: #010c3e;

        }

        .email:hover {
            background-color: red;
        }

        a:hover {
            color: #fff;
        }

        .social-icons a[href^="tel:"] {
            color: #fff;
            text-decoration: none;
            font-size: 14px;
        }

        .social-icons a[href^="tel:"]:hover {
            color: #87d3d7;
        }


        .container1 {
            background-color: #fff;
            /* border:2px solid blue; */
            display: flex;
            flex-direction: row;
            align-items: center;
        }

        .payment-method {
            margin: -3px;
        }

        .payment-method img {
            width: 70px;
            background-color: transparent;
            height: auto;
            border-radius: 10px;
            transition: transform 0.3s ease, opacity 0.3s ease;
            box-shadow: 0 4px 8px rgb(37 39 40 / 63%);

        }

        .payment-method img:hover {
            transform: scale(1.05);
            opacity: 0.9;
        }

        footer {
            margin-top: 50px;
            color: #777;
            font-size: 14px;
        }

        /* Designer Name Highlight */
        .designer-name {
            color: #87d3d7;
            font-size: 19px;

        }

        .home {
            height: 20vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
            background-color: #55555508;

        }

        .home::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgb(0 0 0 / 12%);
            z-index: 1;
        }

        .home-content {
            position: relative;
            z-index: 2;
        }

        .home-content h1 {
            font-size: 3rem;
            color: #010c3e;
            font-weight: bolder;
            margin-bottom: 5px;
            margin-top: 10px;
        }



        .home-content .btn {
            padding: 15px 35px;
            font-size: 1.5rem;
            color: #fff;
            background-color: #87d3d7;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .home-content .btn:hover {
            background-color: #010c3e;

        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <div class="navbar">
        <div class="logo">
            <a href="index.php"> CARWASH </a>
        </div>

        <!-- Menu (Links) -->
        <ul class="menu">
            <li><a href="HomeService.php" class="nav-link">Home</a></li>
            <li><a href="SERVICES.PHP" class="nav-link">Services</a></li>
            <li><a href="Booking.php" class="nav-link">Booking</a></li>
            <li class="dropdown">
                <a href="profile.php" class="nav-link">MyAccount </a>
            </li>
            <!-- Logout Button -->
            <li><button class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</button></li>
        </ul>

        <div class="hamburger" onclick="toggleSidebar()">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <div class="sidebar" id="sidebar">
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Courses</a></li>
            <li><a href="#">Tutorial</a></li>
            <li><a href="#">Blog</a></li>
            <li><a href="#">Contact</a></li>
        </ul>
    </div>



    <section class="home">
        <div class="home-content">
            <h1>Book Now</h1>
            <h3>Home/Booking</h3>
        </div>
    </section>

        <form action="submit_booking.php" method="POST">
            <div class="input-container">
                <i class="fas fa-user"></i>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" placeholder="Enter your name" required>
            </div>

            <div class="input-container">
                <i class="fas fa-envelope"></i>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>

            <div class="input-container">
                <i class="fas fa-phone"></i>
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" placeholder="Enter your phone number" required>
            </div>

            <div class="input-container">
                <i class="fas fa-concierge-bell"></i>
                <label for="service">Select a Service:</label>
                <select id="service" name="service" required>
                    <option value="" disabled selected>-- Select Service --</option>
                    <option value="Underbody Wash">Underbody Wash</option>
                    <option value="Ceramic Coating">Ceramic Coating</option>
                    <option value="Interior Cleaning">Interior Cleaning</option>
                    <option value="Exterior Wash and Wax">Exterior Wash and Wax </option>
                    <option value="Engine Cleaning">Engine Cleaning</option>
                    <option value="Tire and Wheel Cleaning">Tire and Wheel Cleaning</option>

                </select>
            </div>

            <div class="input-container">
                <i class="fas fa-calendar-alt"></i>
                <label for="date">Service Date:</label>
                <input type="date" name="service_date" required>
            </div>


            <!-- <input type="date" name="booking_date" required> -->



            <div class="input-container">
                <i class="fas fa-clock"></i>
                <label for="time">Service Time:</label>
                <input type="time" id="time" name="service_time" required>
            </div>

            <input type="submit" value="Book Now">
        </form>
    </footer>
    <!-- Center Section -->
    <div class="footer-section">

        <p>Design by <strong class="designer-name">Majida Muqadas</strong></p>

        <div class="footer-section right">
            <nav class="social-icons">
                <!-- Social Icons -->
                <!-- Contact Info -->
                <i class="fas fa-phone-alt"></i> <a href="tel:+1234567890">+23091234919</a>
                <i class="fas fa-phone-alt"></i> <a href="tel:+1234567890">+1234567890</a>
                <a href="https://www.facebook.com/yourprofile" class="facebook" target="_blank"><i class="fab fa-facebook-f"></i></a>
                <a href="https://wa.me/1234567890" class="whatsapp" target="_blank"><i class="fab fa-whatsapp"></i></a>
                <a href="mailto:yourmail@example.com" class="email" target="_blank"><i class="fas fa-envelope"></i></a>


            </nav>
        </div>

        <!-- footer ends -->
</body>

</html>