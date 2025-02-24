<?php
include 'includes/db.php'; // Include your database connection file
session_start();

// Handle registration
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if user already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        echo "<script>alert('Please login to access your dashboard.');</script>";
    } else {
        // Register new user
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        if ($stmt->execute([$name, $email, $hashed_password])) {
            echo "<script>alert('Registration successful! Please log in.');</script>";
        } else {
            echo "<script>alert('Registration failed. Try again later.');</script>";
        }
    }
}

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    // Check if the user exists in the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Login successful
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        // header("Location: index1.php"); // Redirect to dashboard or homepage

        header("Location: admin_dashboard.php"); 
        exit();
    } else {
        // If user is not registered, show a pop-up
        echo "<script>alert('Please register first before logging in.');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Login/Register</title>
    <style>
        /* CSS styles */
        :root {
            --primary-color: #1098d9;
            --secondary-color: #381c11;
            --button-color: #f1f1f1;
            --button-hover: #2d6a4f;
            --opacity: 30;
            --degrade: linear-gradient(90deg, #063d3a, #62855c);
            --button-height: 2.5rem;
        }

        body {
            background-image: url(" https://tse2.mm.bing.net/th?id=OIP.4Okp3OJc9ntrhxK36DWRVAHaEo&pid=Api&P=0&h=220");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            /* background-color: rgba(255, 255, 255, 0.7); */
            background-color: transparent;
            border-radius: 1rem;
            width: 35%;
            padding: 3rem;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            backdrop-filter: blur(10px);
        }

        .options {
            width: 100%;
            height: var(--button-height);
            display: flex;
            justify-content: center;
            position: relative;
            margin-bottom: 1.5rem;
        }

        .option {
            width: 45%;
            height: var(--button-height);
            font-weight: bold;
            text-align: center;
            line-height: var(--button-height);
            cursor: pointer;
            /* border-radius: 50px; */
            border-radius: 90px 0px;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .option:first-child {
            font-size: 14px;

            background-color: var(--primary-color);
            color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .option:last-child {
            font-size: 14px;

            background-color: var(--button-color);
            color: var(--secondary-color);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .option.select {
            background-color: var(--secondary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .option:hover {
            transform: translateY(-3px);
        }

        input {
            width: 100%;
            height: 2.5rem;
            border: 2px solid var(--secondary-color);
            border-radius: 0.5rem;
            padding: 0 1rem;
            margin-bottom: 1.5rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        input:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        input::placeholder {
            color: var(--secondary-color);
            font-weight: bold;
        }

        .submit {
            font-size: 17px;
            width: 100%;
            height: var(--button-height);
            color: white;
            background-color: var(--primary-color);
            border-radius: 1rem;
            border: none;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .submit:hover {
            background-color: var(--button-hover);
            transform: translateY(-3px);
        }

        form {
            margin-top: 1.5rem;
        }

        .forgot-password {
            font-size: 0.9rem;
            margin: 0.5rem 0;
            text-align: right;
        }

        .forgot-password a {
            color: var(--secondary-color);
            text-decoration: none;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="options">
            <button class="option select" id="selectRegister">Register</button>
            <button class="option" id="selectLogin">Login</button>
        </div>

        <!-- Register Form -->
        <form id="registerForm" method="POST">
            <input name="name" placeholder="Name" required>
            <input name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="register" class="submit">Register</button>
        </form>

        <!-- Login Form -->
        <form id="loginForm" method="POST" style="display:none;">
            <input name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login" class="submit">Login</button>
        </form>
    </div>

    <script>
        document.getElementById("selectLogin").addEventListener("click", function() {
            document.getElementById("loginForm").style.display = "block";
            document.getElementById("registerForm").style.display = "none";
            document.getElementById("selectLogin").classList.add("select");
            document.getElementById("selectRegister").classList.remove("select");
        });

        document.getElementById("selectRegister").addEventListener("click", function() {
            document.getElementById("registerForm").style.display = "block";
            document.getElementById("loginForm").style.display = "none";
            document.getElementById("selectRegister").classList.add("select");
            document.getElementById("selectLogin").classList.remove("select");
        });
    </script>
</body>

</html>