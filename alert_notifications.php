<?php
include 'db_connect.php';

// Get the count of low-stock items
$low_stock_sql = "SELECT COUNT(*) AS low_stock_count FROM inventory WHERE quantity <= 10";
$low_stock_result = mysqli_query($conn, $low_stock_sql);
$low_stock_row = mysqli_fetch_assoc($low_stock_result);
$low_stock_count = $low_stock_row['low_stock_count'];
?>

<style>
    .notification {
        position: relative;
        display: inline-block;
        cursor: pointer;
        font-size: 24px;
    }
    .notification .badge {
        position: absolute;
        top: -5px;
        right: -10px;
        background: red;
        color: white;
        border-radius: 50%;
        padding: 5px 10px;
        font-size: 14px;
        font-weight: bold;
    }
</style>

<!-- Notification Icon -->
<a href="alert.php" class="notification">
    🔔
    <?php if ($low_stock_count > 0) { ?>
        <span class="badge"><?php echo $low_stock_count; ?></span>
    <?php } ?>
</a>
