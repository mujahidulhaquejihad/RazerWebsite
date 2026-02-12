<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

$admin_current_page = 'components';
include 'connect_database.php';
$categories = require __DIR__ . '/config/categories.php';

$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$results = [];

if ($q !== '') {
    $q_esc = mysqli_real_escape_string($database, $q);
    $like = "'%" . $q_esc . "%'";
    foreach ($categories as $cat_key => $c) {
        $table = $c['table'];
        $id_col = $c['id_col'];
        $name_col = $c['name_col'];
        $price_col = 'price';
        $sql = "SELECT * FROM `$table` WHERE `$name_col` LIKE $like OR `$id_col` LIKE $like ORDER BY `$name_col` ASC";
        $res = @mysqli_query($database, $sql);
        if ($res) {
            while ($row = mysqli_fetch_assoc($res)) {
                $row['_category'] = $cat_key;
                $row['_id_val'] = $row[$id_col];
                $row['_name'] = $row[$name_col];
                $row['_price'] = (int)$row[$price_col];
                $row['_stock'] = array_key_exists('stock', $row) ? (int)$row['stock'] : '—';
                $results[] = $row;
            }
            mysqli_free_result($res);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search inventory | Admin</title>
    <link rel="stylesheet" href="./styles/admin.css">
</head>
<body class="admin-body">
    <div class="admin-layout">
        <?php include 'includes/admin_sidebar.php'; ?>
        <main class="admin-main">
            <h1 class="admin-page-title">Search inventory</h1>
            <p style="color: #94a3b8; margin-bottom: 1rem;">Find a part by name or ID across all categories.</p>
            <form method="get" action="admin_inventory_search.php" class="admin-inventory-search-form" style="margin-bottom: 1.5rem; display: flex; gap: 0.5rem; max-width: 400px;">
                <input type="search" name="q" value="<?php echo htmlspecialchars($q); ?>" placeholder="Part name or ID..." style=" flex: 1; padding: 0.6rem 1rem; background: #0f172a; border: 1px solid #334155; border-radius: 8px; color: #e2e8f0; font-size: 1rem;">
                <button type="submit" class="admin-btn admin-btn-primary">Search</button>
            </form>
            <div class="admin-card">
                <?php if ($q === ''): ?>
                <p style="color: #94a3b8;">Enter a search term above.</p>
                <?php elseif (empty($results)): ?>
                <p style="color: #94a3b8;">No parts found for &ldquo;<?php echo htmlspecialchars($q); ?>&rdquo;.</p>
                <?php else: ?>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Part</th>
                            <th>ID</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $r): 
                            $cat_label = $categories[$r['_category']]['label'];
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($cat_label); ?></td>
                            <td><?php echo htmlspecialchars($r['_name']); ?></td>
                            <td><?php echo htmlspecialchars($r['_id_val']); ?></td>
                            <td>৳<?php echo number_format($r['_price']); ?></td>
                            <td><?php echo $r['_stock']; ?></td>
                            <td>
                                <a href="admin_component_edit.php?category=<?php echo urlencode($r['_category']); ?>&id=<?php echo urlencode($r['_id_val']); ?>" class="admin-btn admin-btn-ghost">Edit</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>
