<?php
// Database Connection using PDO
$dsn = "mysql:host=localhost;dbname=carwash_user_management";
$username = "root"; // Update if needed
$password = "";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Fetch total bookings
$bookings_count = $pdo->query("SELECT COUNT(*) FROM customer_bookings")->fetchColumn();

// Fetch total services
$services_count = $pdo->query("SELECT COUNT(*) FROM services")->fetchColumn();

// Fetch total packages
$packages_count = $pdo->query("SELECT COUNT(*) FROM packages")->fetchColumn();

// Fetch total users
$users_count = $pdo->query("SELECT COUNT(*) FROM add_users")->fetchColumn();

// Fetch total feedbacks
$feedbacks_count = $pdo->query("SELECT COUNT(*) FROM feedback")->fetchColumn();
?>

<!-- Include Navbar -->
<?php include __DIR__ . '/index.php'; ?>

<!-- Dashboard HTML -->
<div class="dashboard">
    <h2>Admin Dashboard</h2>
    <div class="dashboard-grid">
        <div class="dashboard-item">Total Bookings: <?php echo $bookings_count; ?></div>
        <div class="dashboard-item">Total Services: <?php echo $services_count; ?></div>
        <div class="dashboard-item">Total Packages: <?php echo $packages_count; ?></div>
        <div class="dashboard-item">Total Users: <?php echo $users_count; ?></div>
        <div class="dashboard-item">Total Feedbacks: <?php echo $feedbacks_count; ?></div>
    </div>
</div>

<style>
    .dashboard {
        text-align: center;
        margin: 20px auto;
        width: 60%;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .dashboard-grid {
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
    }
    .dashboard-item {
        padding: 10px 20px;
        background: #007bff;
        color: white;
        font-weight: bold;
        border-radius: 5px;
        margin: 5px;
    }
</style>
