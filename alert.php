<?php
session_start();
include 'db_connect.php';

// Delete item if requested
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $delete_sql = "DELETE FROM inventory WHERE id = $delete_id";
    mysqli_query($conn, $delete_sql);
    header("Location: alert.php"); // Refresh to update list and notifications
    exit();
}

// Fetch low-stock items
$sql = "SELECT * FROM inventory WHERE quantity <= 10";
$result = mysqli_query($conn, $sql);

// Get the count of low-stock items
$low_stock_count = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Low Stock Alerts</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
        table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid black;
            text-align: center;
        }
        th {
            background-color: red;
            color: white;
        }
        .low-stock {
            color: red;
            font-weight: bold;
        }
        .delete-btn {
            background-color: red;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
        .delete-btn:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>
    <h2>Low Stock Alerts</h2>
    
    <!-- Notification Icon -->
    <a href="alert.php" class="notification">
        🔔
        <?php if ($low_stock_count > 0) { ?>
            <span class="badge"><?php echo $low_stock_count; ?></span>
        <?php } ?>
    </a>

    <table>
        <tr>
            <th>Item Name</th>
            <th>Quantity</th>
            <th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td class="low-stock"><?php echo $row['item_name']; ?></td>
            <td class="low-stock"><?php echo $row['quantity']; ?></td>
            <td>
                <a href="alert.php?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this item?');">
                    <button class="delete-btn">Delete</button>
                </a>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
