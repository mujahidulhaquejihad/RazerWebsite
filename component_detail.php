<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include 'connect_database.php';
$categories = require __DIR__ . '/config/categories.php';

$category = isset($_GET['category']) ? trim($_GET['category']) : '';
$id = isset($_GET['id']) ? trim($_GET['id']) : '';
if ($category === '' || $id === '' || !isset($categories[$category])) {
    header('Location: components.php');
    exit;
}

$c = $categories[$category];
$table = $c['table'];
$id_col = $c['id_col'];
$name_col = $c['name_col'];
$price_col = 'price';
$id_esc = mysqli_real_escape_string($database, $id);

$res = mysqli_query($database, "SELECT * FROM `$table` WHERE `$id_col` = '$id_esc' LIMIT 1");
if (!$res || !$row = mysqli_fetch_assoc($res)) {
    header('Location: components.php?category=' . urlencode($category));
    exit;
}

$name = $row[$name_col];
$price = (int)$row[$price_col];
$stock = array_key_exists('stock', $row) ? (int)$row['stock'] : null;
$image_url = !empty($row['image_url']) ? $row['image_url'] : (isset($c['default_image']) ? $c['default_image'] : ('https://placehold.co/400x280/1a1a2e/36ec4e?text=' . urlencode($c['label'])));
$description = isset($row['description']) ? trim($row['description']) : '';

// Human-readable labels for spec columns
$spec_labels = [
    'socket_type' => 'Socket',
    'ram_type'    => 'RAM type',
    'form_factor' => 'Form factor',
    'wattage'     => 'Wattage',
    'stock'       => 'In stock',
    'model_name'  => 'Model',
    'cpu_id'      => 'Model',
    'gpu_id'      => 'Model',
    'mb_id'       => 'Model',
    'ram_id'      => 'Model',
    'ssd_id'      => 'Model',
    'hdd_id'      => 'Model',
    'ps_id'       => 'Model',
    'cooler_id'   => 'Model',
];
// Build full specs from row (exclude name, price, image_url, description, id column, stock shown separately)
$skip_cols = [$name_col, $price_col, 'image_url', 'description', 'stock', $id_col];
$specs = [];
foreach ($row as $col => $value) {
    if (in_array($col, $skip_cols, true) || $value === '' || $value === null) continue;
    $label = isset($spec_labels[$col]) ? $spec_labels[$col] : str_replace('_', ' ', ucfirst($col));
    $specs[$label] = $value;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($name); ?> | PC Builder</title>
    <link rel="stylesheet" href="./styles/components.css">
    <link rel="stylesheet" href="./styles/component_detail.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,300;0,500;1,300&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'navigation.php'; ?>
    <div class="components-page component-detail-page">
        <?php if (isset($_GET['added'])): ?>
        <p class="components-added-msg">Added to cart. <a href="cart.php">View cart</a> or <a href="search.php">search again</a>.</p>
        <?php endif; ?>
        <p class="component-detail-back"><a href="javascript:history.back()" class="component-detail-back-link">← Back</a></p>
        <div class="component-detail-card">
            <div class="component-detail-image-wrap">
                <div class="component-detail-image">
                    <img src="<?php echo htmlspecialchars($image_url); ?>" alt="<?php echo htmlspecialchars($name); ?>" loading="eager">
                </div>
            </div>
            <div class="component-detail-info">
                <p class="component-detail-category"><?php echo htmlspecialchars($c['label']); ?></p>
                <h1 class="component-detail-name"><?php echo htmlspecialchars($name); ?></h1>
                <p class="component-detail-model">Model / ID: <?php echo htmlspecialchars($id); ?></p>
                <p class="component-detail-price">৳<?php echo number_format($price); ?></p>
                <?php if ($stock !== null): ?>
                <p class="component-detail-stock <?php echo $stock > 0 ? 'in-stock' : 'out-of-stock'; ?>">
                    <?php echo $stock > 0 ? 'In stock: ' . $stock : 'Out of stock'; ?>
                </p>
                <?php endif; ?>
                <?php if (!empty($specs)): ?>
                <section class="component-detail-specs-section">
                    <h3 class="component-detail-section-title">Specifications</h3>
                    <dl class="component-detail-specs">
                        <?php foreach ($specs as $label => $value): ?>
                        <div class="component-detail-spec-row">
                            <dt><?php echo htmlspecialchars($label); ?></dt>
                            <dd><?php echo htmlspecialchars($value); ?></dd>
                        </div>
                        <?php endforeach; ?>
                    </dl>
                </section>
                <?php endif; ?>
                <section class="component-detail-description-section">
                    <h3 class="component-detail-section-title">Description</h3>
                    <div class="component-detail-description">
                        <?php if ($description !== ''): ?>
                        <p><?php echo nl2br(htmlspecialchars($description)); ?></p>
                        <?php else: ?>
                        <p class="component-detail-no-desc">No description available for this product.</p>
                        <?php endif; ?>
                    </div>
                </section>
                <a href="add_to_build.php?category=<?php echo urlencode($category); ?>&id=<?php echo urlencode($id); ?>&return=detail" class="component-add component-detail-add">Add to build</a>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
