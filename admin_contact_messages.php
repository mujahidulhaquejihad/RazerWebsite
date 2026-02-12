<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

include 'connect_database.php';
$admin_current_page = 'messages';

$messages = [];
$res = @mysqli_query($database, "SELECT `id`, `name`, `email`, `phone`, `message`, `created_at`, `status`, `admin_notes` FROM `contact_messages` ORDER BY `created_at` DESC LIMIT 200");
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $messages[] = $row;
    }
    mysqli_free_result($res);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact messages | Admin</title>
    <link rel="stylesheet" href="./styles/admin.css">
</head>
<body class="admin-body">
    <div class="admin-layout">
        <?php include 'includes/admin_sidebar.php'; ?>
        <main class="admin-main">
            <h1 class="admin-page-title">Contact messages</h1>
            <p style="color: #94a3b8; margin-bottom: 1.5rem;">Messages sent from the Contact Us page. Reply via email or phone and update status/notes below.</p>
            <div class="admin-card">
                <?php if (empty($messages)): ?>
                <p style="color: #94a3b8;">No messages yet.</p>
                <?php else: ?>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Email / Phone</th>
                            <th>Message</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($messages as $m): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($m['created_at'] ?? '—'); ?></td>
                            <td><?php echo htmlspecialchars($m['name'] ?? '—'); ?></td>
                            <td>
                                <a href="mailto:<?php echo htmlspecialchars($m['email'] ?? ''); ?>"><?php echo htmlspecialchars($m['email'] ?? '—'); ?></a><br>
                                <span style="font-size: 0.85rem; color: #94a3b8;"><?php echo htmlspecialchars($m['phone'] ?? '—'); ?></span>
                            </td>
                            <td style="max-width: 220px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?php echo htmlspecialchars($m['message'] ?? '—'); ?></td>
                            <td><?php echo htmlspecialchars($m['status'] ?? 'new'); ?></td>
                            <td>
                                <a href="admin_contact_message_view.php?id=<?php echo (int)$m['id']; ?>" class="admin-btn admin-btn-ghost">View / Reply</a>
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
