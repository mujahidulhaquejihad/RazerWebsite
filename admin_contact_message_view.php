<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header("Location: admin_contact_messages.php");
    exit();
}

include 'connect_database.php';
$admin_current_page = 'messages';

$saved = false;
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = isset($_POST['status']) ? trim($_POST['status']) : '';
    $admin_notes = isset($_POST['admin_notes']) ? trim($_POST['admin_notes']) : '';
    $allowed = ['new', 'read', 'replied', 'closed'];
    if (!in_array($status, $allowed, true)) $status = 'read';
    $status_esc = mysqli_real_escape_string($database, $status);
    $notes_esc = mysqli_real_escape_string($database, $admin_notes);
    if (mysqli_query($database, "UPDATE `contact_messages` SET `status` = '$status_esc', `admin_notes` = '$notes_esc' WHERE `id` = $id LIMIT 1")) {
        $saved = true;
    } else {
        $error = mysqli_error($database);
    }
}

$msg = null;
$res = mysqli_query($database, "SELECT * FROM `contact_messages` WHERE `id` = $id LIMIT 1");
if ($res && $row = mysqli_fetch_assoc($res)) {
    $msg = $row;
}
if (!$msg) {
    header("Location: admin_contact_messages.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message from <?php echo htmlspecialchars($msg['name']); ?> | Admin</title>
    <link rel="stylesheet" href="./styles/admin.css">
</head>
<body class="admin-body">
    <div class="admin-layout">
        <?php include 'includes/admin_sidebar.php'; ?>
        <main class="admin-main">
            <h1 class="admin-page-title">Contact message</h1>
            <p style="margin-bottom: 1rem;"><a href="admin_contact_messages.php" class="admin-btn admin-btn-ghost">← All messages</a></p>
            <?php if ($saved): ?><div class="admin-alert" style="background: rgba(34,197,94,0.15); border-color: rgba(34,197,94,0.4); color: #86efac;">Saved.</div><?php endif; ?>
            <?php if ($error): ?><div class="admin-alert admin-alert-error"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
            <div class="admin-card" style="margin-bottom: 1.5rem;">
                <p><strong>Date</strong> <?php echo htmlspecialchars($msg['created_at'] ?? '—'); ?></p>
                <p><strong>Name</strong> <?php echo htmlspecialchars($msg['name'] ?? '—'); ?></p>
                <p><strong>Email</strong> <a href="mailto:<?php echo htmlspecialchars($msg['email'] ?? ''); ?>"><?php echo htmlspecialchars($msg['email'] ?? '—'); ?></a></p>
                <p><strong>Phone</strong> <?php echo htmlspecialchars($msg['phone'] ?? '—'); ?></p>
                <p><strong>Message</strong></p>
                <div style="background: rgba(15,23,42,0.6); padding: 1rem; border-radius: 8px; margin-top: 0.5rem; white-space: pre-wrap;"><?php echo htmlspecialchars($msg['message'] ?? ''); ?></div>
            </div>
            <div class="admin-card">
                <h2 style="font-size: 1rem; color: #94a3b8; margin-bottom: 1rem;">Update status &amp; notes</h2>
                <form method="post">
                    <p style="margin-bottom: 0.75rem;">
                        <label style="display: block; color: #94a3b8; font-size: 0.85rem; margin-bottom: 0.25rem;">Status</label>
                        <select name="status" style="padding: 0.5rem; background: #0f172a; border: 1px solid #334155; border-radius: 6px; color: #e2e8f0;">
                            <option value="new" <?php echo ($msg['status'] ?? '') === 'new' ? 'selected' : ''; ?>>New</option>
                            <option value="read" <?php echo ($msg['status'] ?? '') === 'read' ? 'selected' : ''; ?>>Read</option>
                            <option value="replied" <?php echo ($msg['status'] ?? '') === 'replied' ? 'selected' : ''; ?>>Replied</option>
                            <option value="closed" <?php echo ($msg['status'] ?? '') === 'closed' ? 'selected' : ''; ?>>Closed</option>
                        </select>
                    </p>
                    <p style="margin-bottom: 1rem;">
                        <label style="display: block; color: #94a3b8; font-size: 0.85rem; margin-bottom: 0.25rem;">Admin notes (reply drafted, next steps, etc.)</label>
                        <textarea name="admin_notes" rows="4" style="width: 100%; max-width: 500px; padding: 0.6rem; background: #0f172a; border: 1px solid #334155; border-radius: 6px; color: #e2e8f0; box-sizing: border-box;"><?php echo htmlspecialchars($msg['admin_notes'] ?? ''); ?></textarea>
                    </p>
                    <button type="submit" class="admin-btn admin-btn-primary">Save</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
