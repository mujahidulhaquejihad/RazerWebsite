<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

include 'connect_database.php';
$categories = require __DIR__ . '/config/categories.php';

$orders = [];
$res = mysqli_query($database, "SELECT * FROM `order_details` ORDER BY `id` DESC LIMIT 100");
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $orders[] = $row;
    }
}

// Check if builds table has order_id column (run migration_order_build_link.sql if not)
$has_order_id = false;
$check = @mysqli_query($database, "SELECT `id`, `order_id` FROM `builds` LIMIT 1");
if ($check !== false) {
    $has_order_id = true;
    @mysqli_free_result($check);
}

$order_items = [];
foreach ($orders as $o) {
    $oid = (int)($o['id'] ?? 0);
    $order_items[$oid] = ['build' => null, 'items' => []];
    if ($oid <= 0) continue;
    $bid = null;
    if ($has_order_id) {
        $build_res = mysqli_query($database, "SELECT `id` FROM `builds` WHERE `order_id` = $oid LIMIT 1");
        if ($build_res && $b = mysqli_fetch_assoc($build_res)) $bid = (int)$b['id'];
        if ($build_res) @mysqli_free_result($build_res);
    }
    // Fallback: find unlinked build by same user + total (for orders placed before order_id was set)
    if (!$bid && !empty($o['userid']) && isset($o['totalprice']) && $has_order_id) {
        $u = mysqli_real_escape_string($database, $o['userid']);
        $tp = (int)$o['totalprice'];
        $build_res2 = @mysqli_query($database, "SELECT `id` FROM `builds` WHERE `user_id` = '$u' AND `total_price` = $tp AND (`order_id` IS NULL OR `order_id` = $oid) ORDER BY `created_at` DESC LIMIT 1");
        if ($build_res2 && $b2 = mysqli_fetch_assoc($build_res2)) {
            $bid = (int)$b2['id'];
            mysqli_query($database, "UPDATE `builds` SET `order_id` = $oid WHERE `id` = $bid LIMIT 1");
        }
        if ($build_res2) @mysqli_free_result($build_res2);
    }
    if ($bid) {
        $order_items[$oid]['build'] = ['id' => $bid];
        $items_res = mysqli_query($database, "SELECT `category`, `component_name`, `price` FROM `build_items` WHERE `build_id` = $bid ORDER BY `category`");
        if ($items_res) {
            while ($item = mysqli_fetch_assoc($items_res)) {
                $order_items[$oid]['items'][] = $item;
            }
            mysqli_free_result($items_res);
        }
    }
}

$admin_current_page = 'orders';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders | Admin</title>
    <link rel="stylesheet" href="./styles/admin.css">
</head>
<body class="admin-body">
    <div class="admin-layout">
        <?php include 'includes/admin_sidebar.php'; ?>
        <main class="admin-main">
            <h1 class="admin-page-title">Manage Orders</h1>
            <?php if (!$has_order_id): ?>
            <div class="admin-alert admin-alert-error" style="margin-bottom: 1rem;">Run <strong>migration_order_build_link.sql</strong> (adds <code>order_id</code> to <code>builds</code>) so new orders show the full build here.</div>
            <?php endif; ?>
            <div class="admin-card">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($orders)): ?>
                        <tr><td colspan="7" style="color: #94a3b8;">No orders yet.</td></tr>
                        <?php else: ?>
                        <?php foreach ($orders as $o):
                            $oid = (int)($o['id'] ?? 0);
                            $info = $order_items[$oid] ?? ['build' => null, 'items' => []];
                            $items = $info['items'];
                            $status = trim($o['order-status'] ?? '');
                            $is_completed = (strtolower($status) === 'completed');
                        ?>
                        <tr>
                            <td><?php echo $oid; ?></td>
                            <td><?php echo htmlspecialchars($o['userid'] ?? '—'); ?></td>
                            <td>৳<?php echo number_format((int)($o['totalprice'] ?? 0)); ?></td>
                            <td><?php echo htmlspecialchars($status ?: '—'); ?></td>
                            <td><?php echo htmlspecialchars($o['payment_method'] ?? '—'); ?></td>
                            <td><?php echo htmlspecialchars($o['timestamp'] ?? '—'); ?></td>
                            <td>
                                <?php if (!$is_completed && !empty($info['build'])): ?>
                                <form method="post" action="admin_complete_order.php" style="display:inline;" onsubmit="return confirm('Complete this order? This will reduce component stock.');">
                                    <input type="hidden" name="order_id" value="<?php echo $oid; ?>">
                                    <button type="submit" class="admin-btn admin-btn-primary">Complete</button>
                                </form>
                                <?php elseif ($is_completed): ?>
                                <span style="color: #64748b;">—</span>
                                <?php else: ?>
                                <span style="color: #94a3b8; font-size: 0.85rem;">No build linked</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php if (!empty($items)): ?>
                        <?php
                        $grouped = [];
                        foreach ($items as $it) {
                            $key = $it['category'] . '|' . $it['component_name'] . '|' . $it['price'];
                            if (!isset($grouped[$key])) $grouped[$key] = ['name' => $it['component_name'], 'category' => $it['category'], 'price' => (int)$it['price'], 'qty' => 0];
                            $grouped[$key]['qty']++;
                        }
                        $order_total = (int)($o['totalprice'] ?? 0);
                        ?>
                        <tr class="admin-order-detail-row">
                            <td colspan="7" style="padding: 0; border-top: none; background: rgba(15,23,42,0.7);">
                                <div class="admin-order-details">
                                    <strong class="admin-order-details-title">Full build (what was ordered and paid)</strong>
                                    <table class="admin-order-build-table">
                                        <thead>
                                            <tr>
                                                <th>Category</th>
                                                <th>Component</th>
                                                <th>Unit price</th>
                                                <th>Qty</th>
                                                <th>Line total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($grouped as $g):
                                                $cat_label = isset($categories[$g['category']]) ? $categories[$g['category']]['label'] : $g['category'];
                                                $line_total = $g['price'] * $g['qty'];
                                            ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($cat_label); ?></td>
                                                <td><?php echo htmlspecialchars($g['name']); ?></td>
                                                <td>৳<?php echo number_format($g['price']); ?></td>
                                                <td><?php echo $g['qty']; ?></td>
                                                <td>৳<?php echo number_format($line_total); ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4" style="text-align:right; font-weight: 600;">Total paid</td>
                                                <td style="font-weight: 600;">৳<?php echo number_format($order_total); ?></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
