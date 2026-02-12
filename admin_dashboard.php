<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

include 'connect_database.php';
$admin_current_page = 'dashboard';

$user_count = 0;
$res = mysqli_query($database, "SELECT COUNT(*) AS c FROM user");
if ($res && $row = mysqli_fetch_assoc($res)) $user_count = (int)$row['c'];

$order_count = 0;
$res = mysqli_query($database, "SELECT COUNT(*) AS c FROM order_details");
if ($res && $row = mysqli_fetch_assoc($res)) $order_count = (int)$row['c'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | PC Builder</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./styles/admin.css">
</head>
<body class="admin-body">
    <div class="admin-layout">
            <?php include 'includes/admin_sidebar.php'; ?>
        <main class="admin-main">
            <h1 class="admin-page-title">Dashboard</h1>
            <div class="admin-stats">
                <div class="admin-stat">
                    <div class="admin-stat-value"><?php echo $user_count; ?></div>
                    <div class="admin-stat-label">Users</div>
                </div>
                <div class="admin-stat">
                    <div class="admin-stat-value"><?php echo $order_count; ?></div>
                    <div class="admin-stat-label">Orders</div>
                </div>
            </div>
            <div class="admin-card">
                <h2 style="margin: 0 0 1rem; font-size: 1rem; color: rgba(54, 236, 78, 0.9);">Quick links</h2>
                <p><a href="manage_users.php" class="admin-btn admin-btn-primary">Manage Users</a></p>
                <p style="margin-top: 0.5rem;"><a href="manage_orders.php" class="admin-btn admin-btn-ghost">View Orders</a></p>
                <p style="margin-top: 0.5rem;"><a href="admin_contact_messages.php" class="admin-btn admin-btn-ghost">Contact messages</a></p>
                <p style="margin-top: 0.5rem;"><a href="admin_components.php" class="admin-btn admin-btn-ghost">Components</a></p>
            </div>
        </main>
    </div>
</body>
</html>
