<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['customer']) || empty($_SESSION['customer'])) {
    header('Location: login.php');
    exit;
}
include 'connect_database.php';
$user_id = mysqli_real_escape_string($database, $_SESSION['customer']);
$orders = [];
$res = mysqli_query($database, "SELECT * FROM order_details WHERE userid = '$user_id' ORDER BY timestamp DESC");
if ($res) while ($row = mysqli_fetch_assoc($res)) $orders[] = $row;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order history | PC Builder</title>
    <link rel="stylesheet" href="./styles/dashboard.css">
    <link rel="stylesheet" href="./styles/order_history.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,300;0,500;1,300&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'navigation.php'; ?>
    <div class="dashboard">
        <header class="dashboard-header">
            <h1>Order history</h1>
            <p>Your past orders</p>
        </header>
        <p><a href="dashboard.php" class="dashboard-back">← Dashboard</a></p>
        <div class="order-history-list">
            <?php if (empty($orders)): ?>
            <p class="order-history-empty">No orders yet.</p>
            <?php else: ?>
            <?php foreach ($orders as $o): ?>
            <div class="order-history-card">
                <div class="order-history-meta">
                    <span>Order #<?php echo (int)$o['id']; ?></span>
                    <span><?php echo htmlspecialchars($o['timestamp'] ?? ''); ?></span>
                </div>
                <div class="order-history-total">৳<?php echo number_format((int)($o['totalprice'] ?? 0)); ?></div>
                <div class="order-history-status"><?php echo htmlspecialchars($o['order-status'] ?? '—'); ?> · <?php echo htmlspecialchars($o['payment_method'] ?? '—'); ?></div>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
