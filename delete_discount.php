<?php
include('db_connection.php');

if(isset($_GET['id'])) {
    $id = $_GET['id'];

    $deleteQuery = "UPDATE admin_services SET discount = 0 WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->execute([$id]);

    header("Location: admin_services.php");
    exit();
}
?>
