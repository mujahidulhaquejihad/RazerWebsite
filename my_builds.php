<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['customer']) || empty($_SESSION['customer'])) {
    header('Location: login.php');
    exit;
}
include 'connect_database.php';
$user_id = mysqli_real_escape_string($database, $_SESSION['customer']);
$builds = [];
$res = mysqli_query($database, "SELECT * FROM builds WHERE user_id = '$user_id' ORDER BY created_at DESC");
if ($res) while ($row = mysqli_fetch_assoc($res)) $builds[] = $row;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My builds | PC Builder</title>
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
            <h1>My builds</h1>
            <p>Your saved PC builds</p>
        </header>
        <p><a href="dashboard.php" class="dashboard-back">← Dashboard</a></p>
        <div class="order-history-list">
            <?php if (empty($builds)): ?>
            <p class="order-history-empty">No saved builds. <a href="custom_rigs.php">Create one</a>.</p>
            <?php else: ?>
            <?php foreach ($builds as $b): 
                $items = [];
                $r = mysqli_query($database, "SELECT component_name, price FROM build_items WHERE build_id = " . (int)$b['id']);
                if ($r) while ($row = mysqli_fetch_assoc($r)) $items[] = $row;
            ?>
            <div class="order-history-card">
                <div class="order-history-meta">
                    <span><?php echo htmlspecialchars($b['name'] ?? 'My Build'); ?></span>
                    <span><?php echo htmlspecialchars($b['created_at'] ?? ''); ?></span>
                </div>
                <div class="order-history-total">৳<?php echo number_format((int)($b['total_price'] ?? 0)); ?></div>
                <?php if (!empty($items)): ?>
                <ul class="build-items-list">
                    <?php foreach ($items as $item): ?>
                    <li><?php echo htmlspecialchars($item['component_name']); ?> — ৳<?php echo number_format((int)$item['price']); ?></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
