<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

include 'connect_database.php';

$search = isset($_GET['q']) ? trim($_GET['q']) : '';
$users = [];

$sql = "
    SELECT u.id, u.email, u.timestamp,
           COALESCE(u.banned, 0) AS banned,
           d.firstname, d.lastname, d.city, d.`mobile-number`, d.address, d.state, d.country
    FROM user u
    LEFT JOIN user_data d ON d.user_id = u.email
";
if ($search !== '') {
    $esc = mysqli_real_escape_string($database, $search);
    $sql .= " WHERE (
        u.email LIKE '%$esc%'
        OR d.firstname LIKE '%$esc%'
        OR d.lastname LIKE '%$esc%'
        OR d.`mobile-number` LIKE '%$esc%'
        OR d.city LIKE '%$esc%'
        OR d.address LIKE '%$esc%'
        OR d.state LIKE '%$esc%'
        OR d.country LIKE '%$esc%'
    )";
}
$sql .= " ORDER BY u.id DESC";

$res = mysqli_query($database, $sql);
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $users[] = $row;
    }
}
$admin_current_page = 'users';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users | Admin</title>
    <link rel="stylesheet" href="./styles/admin.css">
</head>
<body class="admin-body">
    <div class="admin-layout">
        <?php include 'includes/admin_sidebar.php'; ?>
        <main class="admin-main">
            <h1 class="admin-page-title">Manage Users</h1>
            <?php
            $flash = $_GET['msg'] ?? $_GET['error'] ?? null;
            if ($flash === 'banned') echo '<p class="admin-flash admin-flash-success">User banned.</p>';
            if ($flash === 'unbanned') echo '<p class="admin-flash admin-flash-success">User unbanned.</p>';
            if ($flash === 'deleted') echo '<p class="admin-flash admin-flash-success">User deleted.</p>';
            if ($flash === 'invalid') echo '<p class="admin-flash admin-flash-error">Invalid request.</p>';
            ?>
            <form method="get" action="manage_users.php" class="admin-search-form">
                <input type="search" name="q" placeholder="Search by email, name, phone, city, address, state or country..." value="<?php echo htmlspecialchars($search); ?>" class="admin-search-input">
                <button type="submit" class="admin-btn admin-btn-primary">Search</button>
                <?php if ($search !== ''): ?>
                <a href="manage_users.php" class="admin-btn admin-btn-ghost">Clear</a>
                <?php endif; ?>
            </form>
            <div class="admin-card">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($users)): ?>
                        <tr><td colspan="7" style="color: #94a3b8;"><?php echo $search !== '' ? 'No users match your search.' : 'No users found.'; ?></td></tr>
                        <?php else: ?>
                        <?php foreach ($users as $u):
                            $banned = isset($u['banned']) ? (int)$u['banned'] : 0;
                        ?>
                        <tr>
                            <td><?php echo (int)$u['id']; ?></td>
                            <td><?php echo htmlspecialchars(trim(($u['firstname'] ?? '') . ' ' . ($u['lastname'] ?? '')) ?: '—'); ?></td>
                            <td><?php echo htmlspecialchars($u['email']); ?></td>
                            <td><?php echo htmlspecialchars($u['mobile-number'] ?? '—'); ?></td>
                            <td>
                                <?php if ($banned): ?>
                                    <span class="admin-badge admin-badge-danger">Banned</span>
                                <?php else: ?>
                                    <span class="admin-badge admin-badge-ok">Active</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($u['timestamp'] ?? '—'); ?></td>
                            <td>
                                <a href="admin_user_edit.php?user_id=<?php echo urlencode($u['email']); ?>" class="admin-btn admin-btn-ghost">View / Edit</a>
                                <?php if ($banned): ?>
                                    <form method="post" action="admin_user_action.php" style="display:inline;">
                                        <input type="hidden" name="action" value="unban">
                                        <input type="hidden" name="email" value="<?php echo htmlspecialchars($u['email']); ?>">
                                        <button type="submit" class="admin-btn admin-btn-ghost">Unban</button>
                                    </form>
                                <?php else: ?>
                                    <form method="post" action="admin_user_action.php" style="display:inline;">
                                        <input type="hidden" name="action" value="ban">
                                        <input type="hidden" name="email" value="<?php echo htmlspecialchars($u['email']); ?>">
                                        <button type="submit" class="admin-btn admin-btn-ghost">Ban</button>
                                    </form>
                                <?php endif; ?>
                                <form method="post" action="admin_user_action.php" style="display:inline;" onsubmit="return confirm('Permanently delete this user? This cannot be undone.');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="email" value="<?php echo htmlspecialchars($u['email']); ?>">
                                    <button type="submit" class="admin-btn admin-btn-danger">Delete</button>
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
