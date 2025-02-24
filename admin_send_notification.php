<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_id = $_POST['employee_id'];
    $message = $_POST['message'];

    $query = "INSERT INTO employee_notifications (employee_id, message, status) VALUES (?, ?, 'unread')";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("is", $employee_id, $message);
    
    if ($stmt->execute()) {
        echo "Notification sent!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Send Notification</title>
</head>
<body>
    <h2>Send Notification to Employee</h2>
    <form method="POST">
        <label for="employee_id">Select Employee:</label>
        <select name="employee_id">
            <?php
            $result = $conn->query("SELECT id, name FROM add_users WHERE role = 'employee'");
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['id']}'>{$row['name']}</option>";
            }
            ?>
        </select>
        <br><br>
        <label for="message">Message:</label>
        <textarea name="message" required></textarea>
        <br><br>
        <button type="submit">Send Notification</button>
    </form>
</body>
</html>
