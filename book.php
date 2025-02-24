<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "booking_system";

// Database connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_name = $_POST['customer_name'];
    $service_type = $_POST['service_type'];
    $amount = $_POST['amount'];

    // Insert the new booking
    $stmt = $conn->prepare("INSERT INTO receipts (customer_name, service_type, amount) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $customer_name, $service_type, $amount);

    if ($stmt->execute()) {
        // Get all bookings for this customer
        $fetch_query = $conn->prepare("SELECT * FROM receipts WHERE customer_name = ?");
        $fetch_query->bind_param("s", $customer_name);
        $fetch_query->execute();
        $result = $fetch_query->get_result();

        // Display all receipts for this customer
        echo "
        <div style='max-width: 600px; margin: 20px auto; padding: 20px; background: #fff; color: #010c3e; border-radius: 8px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); text-align: center;'>
            <h2 style='margin-bottom: 20px; color: #010c3e;'>Booking Receipts for $customer_name</h2>
        ";

        while ($receipt = $result->fetch_assoc()) {
            echo "
            <div style='margin-bottom: 20px; padding: 15px; background:rgb(219, 219, 219); color: #010c3e; font-size:20px;  border-radius: 8px;'>
                <p><strong>Booking ID:</strong> " . $receipt['id'] . "</p>
                <p><strong>Service Type:</strong> " . $receipt['service_type'] . "</p>
                <p><strong>Booking Date:</strong> " . $receipt['booking_date'] . "</p>
                <p><strong>Amount Paid:</strong> $" . $receipt['amount'] . "</p>
            </div>";
        }

        echo "
            <a href='HomeService.php' style='display: inline-block; margin-top: 20px; padding: 10px 20px; background: #010c3e; color: #fff; text-decoration: none; border-radius: 4px; font-weight: bold;'>Back to Home</a>
        </div>";

        $fetch_query->close();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
