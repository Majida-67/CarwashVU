<?php
session_start();
include('config.php'); // Database connection

if (!isset($_SESSION['user_email'])) {
    header('Location: login.php');
    exit();
}

$email = $_SESSION['user_email'];

// Fetch user profile information
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $email);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $contact_details = $_POST['contact_details'];

    $sql = "UPDATE users SET name = ?, contact_details = ?, updated_at = NOW() WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $name, $contact_details, $email);
    $stmt->execute();

    header('Location: profile.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #010c3e;
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-size: 18px;
            color: #333;
            margin-bottom: 10px;
            display: block;
        }

        input[type="text"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 4px;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        input[type="text"]:focus {
            border-color: #5796cb;
            outline: none;
        }

        button {
            display: block;
            width: 100%;
            padding: 15px;
            background-color: #010c3e;
            color: white;
            font-size: 18px;
            font-weight: bold;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #5796cb;
        }

        .back-link {
            display: block;
            margin-top: 20px;
            text-align: center;
        }

        .back-link a {
            color: #010c3e;
            font-weight: bold;
            text-decoration: none;
        }

        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Your Profile</h2>
        <form method="POST">
            <label for="name">Name:</label>
            <input type="text" name="name" value="<?php echo $user['name']; ?>" required>

            <label for="contact_details">Contact Details:</label>
            <input type="text" name="contact_details" value="<?php echo $user['contact_details']; ?>" required>

            <button type="submit">Update Profile</button>
        </form>

        <div class="back-link">
            <a href="profile.php">Back to Profile</a>
        </div>
    </div>
</body>
</html>
