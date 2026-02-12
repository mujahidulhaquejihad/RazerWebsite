<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}
$admin_current_page = 'components';
$categories = require __DIR__ . '/config/categories.php';
include 'connect_database.php';

$counts = [];
foreach ($categories as $key => $c) {
    $t = $c['table'];
    $res = mysqli_query($database, "SELECT COUNT(*) AS c FROM `$t`");
    $counts[$key] = ($res && $row = mysqli_fetch_assoc($res)) ? (int)$row['c'] : 0;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Components | Admin</title>
    <link rel="stylesheet" href="./styles/admin.css">
</head>
<body class="admin-body">
    <div class="admin-layout">
        <?php include 'includes/admin_sidebar.php'; ?>
        <main class="admin-main">
            <h1 class="admin-page-title">Components</h1>
            <p style="color: #94a3b8; margin-bottom: 1rem;">Browse by category to add, edit, or remove components and manage stock.</p>
            <form method="get" action="admin_inventory_search.php" style="margin-bottom: 1.5rem; display: flex; gap: 0.5rem; max-width: 360px;">
                <input type="search" name="q" placeholder="Search for a part (name or ID)..." style="flex: 1; padding: 0.6rem 1rem; background: #0f172a; border: 1px solid #334155; border-radius: 8px; color: #e2e8f0; font-size: 0.95rem;">
                <button type="submit" class="admin-btn admin-btn-primary">Search inventory</button>
            </form>
            <div class="admin-card">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Count</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $key => $c): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($c['label']); ?></td>
                            <td><?php echo (int)($counts[$key] ?? 0); ?></td>
                            <td>
                                <a href="admin_components_list.php?category=<?php echo urlencode($key); ?>" class="admin-btn admin-btn-ghost">View / Edit</a>
                                <a href="admin_component_add.php?category=<?php echo urlencode($key); ?>" class="admin-btn admin-btn-primary" style="margin-left: 0.5rem;">Add</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
