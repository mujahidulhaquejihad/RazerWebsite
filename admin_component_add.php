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

$needs_id = in_array($category, ['cabinet', 'processor', 'gpu'], true);

$error = '';
$done = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $price = (int) ($_POST['price'] ?? 0);
    $stock = (int) ($_POST['stock'] ?? 10);
    $component_id = $needs_id ? trim($_POST['component_id'] ?? '') : '';
    $socket_type = trim($_POST['socket_type'] ?? '');
    $ram_type = trim($_POST['ram_type'] ?? '');
    $form_factor = trim($_POST['form_factor'] ?? '');
    $wattage = (int) ($_POST['wattage'] ?? 0);
    $description = trim($_POST['description'] ?? '');

    if ($name === '' || $price < 0) {
        $error = 'Name and price are required.';
    } elseif ($needs_id && $component_id === '') {
        $error = 'Component ID is required for this category.';
    } else {
        $image_url = null;
        if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $dir = __DIR__ . '/images/components/' . $category;
            if (!is_dir($dir)) mkdir($dir, 0755, true);
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg','jpeg','png','gif','webp'], true)) {
                $fname = ($needs_id ? $component_id : ('id_' . time())) . '.' . $ext;
                $path = $dir . '/' . $fname;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $path)) {
                    $image_url = 'images/components/' . $category . '/' . $fname;
                }
            }
        }

        $name_esc = mysqli_real_escape_string($database, $name);
        $stock_esc = $stock;
        $img_esc = $image_url ? "'" . mysqli_real_escape_string($database, $image_url) . "'" : 'NULL';
        $desc_esc = $description !== '' ? "'" . mysqli_real_escape_string($database, $description) . "'" : 'NULL';
        $socket_esc = $socket_type !== '' ? "'" . mysqli_real_escape_string($database, $socket_type) . "'" : 'NULL';
        $ram_esc = $ram_type !== '' ? "'" . mysqli_real_escape_string($database, $ram_type) . "'" : 'NULL';
        $form_esc = $form_factor !== '' ? "'" . mysqli_real_escape_string($database, $form_factor) . "'" : 'NULL';

        if ($category === 'cabinet') {
            $id_esc = mysqli_real_escape_string($database, $component_id);
            $sql = "INSERT INTO `$table` (model_name, full_name, price, stock, image_url, description) VALUES ('$id_esc', '$name_esc', $price, $stock_esc, $img_esc, $desc_esc)";
        } elseif ($category === 'processor') {
            $id_esc = mysqli_real_escape_string($database, $component_id);
            $sql = "INSERT INTO `$table` (cpu_id, cpu_full_name, price, stock, image_url, socket_type, description) VALUES ('$id_esc', '$name_esc', $price, $stock_esc, $img_esc, $socket_esc, $desc_esc)";
        } elseif ($category === 'gpu') {
            $id_esc = mysqli_real_escape_string($database, $component_id);
            $sql = "INSERT INTO `$table` (gpu_id, gpu_full_name, price, stock, image_url, description) VALUES ('$id_esc', '$name_esc', $price, $stock_esc, $img_esc, $desc_esc)";
        } elseif ($category === 'motherboard') {
            $sql = "INSERT INTO `$table` (mb_full_name, price, stock, image_url, socket_type, ram_type, form_factor, description) VALUES ('$name_esc', $price, $stock_esc, $img_esc, $socket_esc, $ram_esc, $form_esc, $desc_esc)";
        } elseif ($category === 'ram') {
            $sql = "INSERT INTO `$table` (ram_full_name, price, stock, image_url, ram_type, description) VALUES ('$name_esc', $price, $stock_esc, $img_esc, $ram_esc, $desc_esc)";
        } elseif ($category === 'power_supply') {
            $watt = $wattage > 0 ? $wattage : 'NULL';
            $sql = "INSERT INTO `$table` (ps_full_name, price, stock, image_url, wattage, description) VALUES ('$name_esc', $price, $stock_esc, $img_esc, $watt, $desc_esc)";
        } else {
            $sql = "INSERT INTO `$table` ({$name_col}, price, stock, image_url, description) VALUES ('$name_esc', $price, $stock_esc, $img_esc, $desc_esc)";
        }

        if ($error === '' && mysqli_query($database, $sql)) {
            header("Location: admin_components_list.php?category=" . urlencode($category));
            exit;
        }
        if ($error === '') $error = mysqli_error($database);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add <?php echo htmlspecialchars($c['label']); ?> | Admin</title>
    <link rel="stylesheet" href="./styles/admin.css">
    <style>
        .admin-form label { display: block; margin-bottom: 0.35rem; color: #94a3b8; font-size: 0.9rem; }
        .admin-form input[type="text"], .admin-form input[type="number"], .admin-form textarea { width: 100%; max-width: 400px; padding: 0.6rem; background: #0f172a; border: 1px solid #334155; border-radius: 6px; color: #e2e8f0; margin-bottom: 1rem; box-sizing: border-box; }
        .admin-form textarea { min-height: 80px; }
        .admin-form button[type="submit"] { margin-top: 0.5rem; }
    </style>
</head>
<body class="admin-body">
    <div class="admin-layout">
        <?php include 'includes/admin_sidebar.php'; ?>
        <main class="admin-main">
            <h1 class="admin-page-title">Add <?php echo htmlspecialchars($c['label']); ?></h1>
            <p style="margin-bottom: 1rem;"><a href="admin_components_list.php?category=<?php echo urlencode($category); ?>" class="admin-btn admin-btn-ghost">← Back to list</a></p>
            <?php if ($error): ?><div class="admin-alert admin-alert-error"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
            <div class="admin-card">
                <form method="post" enctype="multipart/form-data" class="admin-form">
                    <?php if ($needs_id): ?>
                    <label>Component ID (unique)</label>
                    <input type="text" name="component_id" required value="<?php echo htmlspecialchars($_POST['component_id'] ?? ''); ?>" placeholder="e.g. Corsair04 or i9">
                    <?php endif; ?>
                    <label>Name (display name)</label>
                    <input type="text" name="name" required value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" placeholder="e.g. Corsair Spec04 - 6,000 Rs">
                    <label>Price</label>
                    <input type="number" name="price" required min="0" value="<?php echo (int)($_POST['price'] ?? 0); ?>">
                    <label>Stock</label>
                    <input type="number" name="stock" min="0" value="<?php echo (int)($_POST['stock'] ?? 10); ?>">
                    <label>Image (optional)</label>
                    <input type="file" name="image" accept="image/*" style="margin-bottom:1rem;">
                    <?php if ($c['has_socket']): ?>
                    <label>Socket type (compatibility)</label>
                    <input type="text" name="socket_type" value="<?php echo htmlspecialchars($_POST['socket_type'] ?? ''); ?>" placeholder="e.g. LGA1200, AM4">
                    <?php endif; ?>
                    <?php if ($c['has_ram_type']): ?>
                    <label>RAM type</label>
                    <input type="text" name="ram_type" value="<?php echo htmlspecialchars($_POST['ram_type'] ?? ''); ?>" placeholder="e.g. DDR4, DDR5">
                    <?php endif; ?>
                    <?php if ($c['has_form_factor']): ?>
                    <label>Form factor</label>
                    <input type="text" name="form_factor" value="<?php echo htmlspecialchars($_POST['form_factor'] ?? ''); ?>" placeholder="e.g. ATX, MicroATX">
                    <?php endif; ?>
                    <?php if ($c['has_wattage']): ?>
                    <label>Wattage (PSU)</label>
                    <input type="number" name="wattage" min="0" value="<?php echo (int)($_POST['wattage'] ?? 0); ?>">
                    <?php endif; ?>
                    <label>Description (optional)</label>
                    <textarea name="description"><?php echo htmlspecialchars($_POST['description'] ?? ''); ?></textarea>
                    <button type="submit" class="admin-btn admin-btn-primary">Add component</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
