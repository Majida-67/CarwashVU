<?php
include('db_connection.php');

if(isset($_GET['id'])) {
    $id = $_GET['id'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $new_discount = $_POST['discount'];

        $updateQuery = "UPDATE admin_services SET discount = ? WHERE id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->execute([$new_discount, $id]);

        header("Location: admin_services.php");
        exit();
    }

    $query = "SELECT * FROM admin_services WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$id]);
    $service = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Discount</title>
</head>
<body>
    <h2>Edit Discount</h2>
    <form method="post">
        <label>Discount (%)</label>
        <input type="number" name="discount" value="<?= $service['discount'] ?>" required>
        <button type="submit">Update Discount</button>
    </form>
</body>
</html>
