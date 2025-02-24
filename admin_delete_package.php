<?php
include('db_connection.php');

if (isset($_GET['id'])) {
    $package_id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM admin_packages WHERE id = :id");
    $stmt->execute([':id' => $package_id]);

    echo "Package deleted successfully!";
    header('Location: admin_view_packages.php'); // Redirect back to the packages view page
}
?>
