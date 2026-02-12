<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

$category = isset($_GET['category']) ? trim($_GET['category']) : '';
$categories = require __DIR__ . '/config/categories.php';
if (!isset($categories[$category])) {
    header("Location: admin_components.php");
    exit();
}

$admin_current_page = 'components';
include 'connect_database.php';

$c = $categories[$category];
$table = $c['table'];
$id_col = $c['id_col'];
$name_col = $c['name_col'];
$price_col = $c['price_col'];

$list = [];
$sql = "SELECT * FROM `$table` ORDER BY `$price_col` ASC";
$res = mysqli_query($database, $sql);
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $list[] = $row;
    }
}

$has_stock = false;
if (!empty($list) && array_key_exists('stock', $list[0])) $has_stock = true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($c['label']); ?> | Admin</title>
    <link rel="stylesheet" href="./styles/admin.css">
</head>
<body class="admin-body">
    <div class="admin-layout">
        <?php include 'includes/admin_sidebar.php'; ?>
        <main class="admin-main">
            <h1 class="admin-page-title"><?php echo htmlspecialchars($c['label']); ?></h1>
            <p style="margin-bottom: 1rem;">
                <a href="admin_components.php" class="admin-btn admin-btn-ghost">← All categories</a>
                <a href="admin_component_add.php?category=<?php echo urlencode($category); ?>" class="admin-btn admin-btn-primary" style="margin-left: 0.5rem;">Add new</a>
            </p>
            <div class="admin-card">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <?php if ($has_stock): ?><th>Stock</th><?php endif; ?>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($list)): ?>
                        <tr><td colspan="<?php echo $has_stock ? 5 : 4; ?>" style="color: #94a3b8;">No components. <a href="admin_component_add.php?category=<?php echo urlencode($category); ?>">Add one</a>.</td></tr>
                        <?php else: ?>
                        <?php foreach ($list as $row): 
                            $id_val = $row[$id_col];
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($id_val); ?></td>
                            <td><?php echo htmlspecialchars($row[$name_col]); ?></td>
                            <td><?php echo htmlspecialchars($row[$price_col]); ?></td>
                            <?php if ($has_stock): ?><td><?php echo (int)($row['stock'] ?? 0); ?></td><?php endif; ?>
                            <td>
                                <a href="admin_component_edit.php?category=<?php echo urlencode($category); ?>&id=<?php echo urlencode($id_val); ?>" class="admin-btn admin-btn-ghost">Edit</a>
                                <form method="post" action="admin_component_delete.php" style="display:inline;margin-left:0.25rem;" onsubmit="return confirm('Delete this component?');">
                                    <input type="hidden" name="category" value="<?php echo htmlspecialchars($category); ?>">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id_val); ?>">
                                    <button type="submit" class="admin-btn" style="color:#f87171;background:transparent;padding:0.5rem 0.75rem;">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
