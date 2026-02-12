<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

include 'connect_database.php';

$tables = ['cabinet' => 'Cabinet', 'processor' => 'CPU', 'gpu' => 'GPU', 'ram' => 'RAM', 'motherboard' => 'Motherboard', 'ssd' => 'SSD', 'hdd' => 'HDD', 'power_supply' => 'Power Supply', 'cpu_cooler' => 'CPU Cooler'];
$counts = [];
foreach (array_keys($tables) as $t) {
    $res = mysqli_query($database, "SELECT COUNT(*) AS c FROM `$t`");
    $counts[$t] = ($res && $row = mysqli_fetch_assoc($res)) ? (int)$row['c'] : 0;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products | Admin</title>
    <link rel="stylesheet" href="./styles/admin.css">
</head>
<body class="admin-body">
    <div class="admin-layout">
        <aside class="admin-sidebar">
            <div class="admin-sidebar-brand">
                <h1>Admin Panel</h1>
            </div>
            <nav class="admin-sidebar-nav">
                <a href="admin_dashboard.php">Dashboard</a>
                <a href="manage_users.php">Manage Users</a>
                <a href="manage_orders.php">Manage Orders</a>
                <a href="manage_products.php" class="active">Manage Products</a>
            </nav>
            <div class="admin-logout">
                <a href="admin_logout.php">Logout</a>
            </div>
        </aside>
        <main class="admin-main">
            <h1 class="admin-page-title">Manage Products</h1>
            <p style="color: #94a3b8; margin-bottom: 1.5rem;">Product counts by category. Edit product data directly in the database.</p>
            <div class="admin-card">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tables as $key => $label): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($label); ?></td>
                            <td><?php echo $counts[$key]; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
