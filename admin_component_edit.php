<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

$category = isset($_GET['category']) ? trim($_GET['category']) : '';
$id = isset($_GET['id']) ? trim($_GET['id']) : '';
$categories = require __DIR__ . '/config/categories.php';
if (!isset($categories[$category]) || $id === '') {
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
$id_esc = mysqli_real_escape_string($database, $id);

$row = null;
$res = mysqli_query($database, "SELECT * FROM `$table` WHERE `$id_col` = '$id_esc' LIMIT 1");
if ($res && $r = mysqli_fetch_assoc($res)) $row = $r;
if (!$row) {
    header("Location: admin_components_list.php?category=" . urlencode($category));
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $price = (int) ($_POST['price'] ?? 0);
    $stock = (int) ($_POST['stock'] ?? 10);
    $socket_type = trim($_POST['socket_type'] ?? '');
    $ram_type = trim($_POST['ram_type'] ?? '');
    $form_factor = trim($_POST['form_factor'] ?? '');
    $wattage = (int) ($_POST['wattage'] ?? 0);
    $description = trim($_POST['description'] ?? '');

    if ($name === '' || $price < 0) {
        $error = 'Name and price are required.';
    } else {
        $image_url = $row['image_url'] ?? null;
        if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $dir = __DIR__ . '/images/components/' . $category;
            if (!is_dir($dir)) mkdir($dir, 0755, true);
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg','jpeg','png','gif','webp'], true)) {
                $fname = $id . '.' . $ext;
                $path = $dir . '/' . $fname;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $path)) {
                    $image_url = 'images/components/' . $category . '/' . $fname;
                }
            }
        }

        $name_esc = mysqli_real_escape_string($database, $name);
        $img_esc = $image_url ? "'" . mysqli_real_escape_string($database, $image_url) . "'" : 'NULL';
        $desc_esc = $description !== '' ? "'" . mysqli_real_escape_string($database, $description) . "'" : 'NULL';
        $socket_esc = $socket_type !== '' ? "'" . mysqli_real_escape_string($database, $socket_type) . "'" : 'NULL';
        $ram_esc = $ram_type !== '' ? "'" . mysqli_real_escape_string($database, $ram_type) . "'" : 'NULL';
        $form_esc = $form_factor !== '' ? "'" . mysqli_real_escape_string($database, $form_factor) . "'" : 'NULL';

        $sets = [];
        $sets[] = "`$name_col` = '$name_esc'";
        $sets[] = "`$price_col` = $price";
        if (array_key_exists('stock', $row)) $sets[] = "stock = $stock";
        if (array_key_exists('image_url', $row)) $sets[] = "image_url = $img_esc";
        if (array_key_exists('description', $row)) $sets[] = "description = $desc_esc";
        if ($c['has_socket'] && array_key_exists('socket_type', $row)) $sets[] = "socket_type = $socket_esc";
        if ($c['has_ram_type'] && array_key_exists('ram_type', $row)) $sets[] = "ram_type = $ram_esc";
        if ($c['has_form_factor'] && array_key_exists('form_factor', $row)) $sets[] = "form_factor = $form_esc";
        if ($c['has_wattage'] && array_key_exists('wattage', $row)) $sets[] = "wattage = " . ($wattage > 0 ? $wattage : 'NULL');

        $sql = "UPDATE `$table` SET " . implode(', ', $sets) . " WHERE `$id_col` = '$id_esc'";
        if ($error === '' && mysqli_query($database, $sql)) {
            header("Location: admin_components_list.php?category=" . urlencode($category));
            exit;
        }
        if ($error === '') $error = mysqli_error($database);
    }
} else {
    $name = $row[$name_col] ?? '';
    $price = (int)($row[$price_col] ?? 0);
    $stock = (int)($row['stock'] ?? 10);
    $socket_type = $row['socket_type'] ?? '';
    $ram_type = $row['ram_type'] ?? '';
    $form_factor = $row['form_factor'] ?? '';
    $wattage = (int)($row['wattage'] ?? 0);
    $description = $row['description'] ?? '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit <?php echo htmlspecialchars($c['label']); ?> | Admin</title>
    <link rel="stylesheet" href="./styles/admin.css">
    <style>
        .admin-form label { display: block; margin-bottom: 0.35rem; color: #94a3b8; font-size: 0.9rem; }
        .admin-form input[type="text"], .admin-form input[type="number"], .admin-form textarea { width: 100%; max-width: 400px; padding: 0.6rem; background: #0f172a; border: 1px solid #334155; border-radius: 6px; color: #e2e8f0; margin-bottom: 1rem; box-sizing: border-box; }
        .admin-form textarea { min-height: 80px; }
    </style>
</head>
<body class="admin-body">
    <div class="admin-layout">
        <?php include 'includes/admin_sidebar.php'; ?>
        <main class="admin-main">
            <h1 class="admin-page-title">Edit <?php echo htmlspecialchars($c['label']); ?></h1>
            <p style="margin-bottom: 1rem;"><a href="admin_components_list.php?category=<?php echo urlencode($category); ?>" class="admin-btn admin-btn-ghost">← Back to list</a></p>
            <?php if ($error): ?><div class="admin-alert admin-alert-error"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
            <div class="admin-card">
                <form method="post" enctype="multipart/form-data" class="admin-form">
                    <label>ID (read-only)</label>
                    <input type="text" value="<?php echo htmlspecialchars($id); ?>" disabled style="opacity:0.8;">
                    <label>Name</label>
                    <input type="text" name="name" required value="<?php echo htmlspecialchars($name); ?>">
                    <label>Price</label>
                    <input type="number" name="price" required min="0" value="<?php echo $price; ?>">
                    <label>Stock</label>
                    <input type="number" name="stock" min="0" value="<?php echo $stock; ?>">
                    <label>Image (optional, upload to replace)</label>
                    <input type="file" name="image" accept="image/*" style="margin-bottom:1rem;">
                    <?php if ($c['has_socket']): ?>
                    <label>Socket type</label>
                    <input type="text" name="socket_type" value="<?php echo htmlspecialchars($socket_type); ?>">
                    <?php endif; ?>
                    <?php if ($c['has_ram_type']): ?>
                    <label>RAM type</label>
                    <input type="text" name="ram_type" value="<?php echo htmlspecialchars($ram_type); ?>">
                    <?php endif; ?>
                    <?php if ($c['has_form_factor']): ?>
                    <label>Form factor</label>
                    <input type="text" name="form_factor" value="<?php echo htmlspecialchars($form_factor); ?>">
                    <?php endif; ?>
                    <?php if ($c['has_wattage']): ?>
                    <label>Wattage</label>
                    <input type="number" name="wattage" min="0" value="<?php echo $wattage; ?>">
                    <?php endif; ?>
                    <label>Description</label>
                    <textarea name="description"><?php echo htmlspecialchars($description); ?></textarea>
                    <button type="submit" class="admin-btn admin-btn-primary">Save changes</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
