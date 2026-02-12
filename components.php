<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include 'connect_database.php';
$categories = require __DIR__ . '/config/categories.php';
$category = isset($_GET['category']) ? trim($_GET['category']) : 'processor';
if (!isset($categories[$category])) $category = 'processor';
$search = isset($_GET['q']) ? trim($_GET['q']) : '';
$in_stock = isset($_GET['in_stock']) && $_GET['in_stock'] === '1';
$price_min = isset($_GET['price_min']) ? (int)$_GET['price_min'] : null;
$price_max = isset($_GET['price_max']) ? (int)$_GET['price_max'] : null;

$c = $categories[$category];
$table = $c['table'];
$id_col = $c['id_col'];
$name_col = $c['name_col'];
$price_col = $c['price_col'];

// Only apply "in stock" filter if table has stock column
$has_stock_col = false;
$cr = @mysqli_query($database, "SHOW COLUMNS FROM `$table` LIKE 'stock'");
if ($cr && mysqli_fetch_assoc($cr)) $has_stock_col = true;

$list = [];
$sql = "SELECT * FROM `$table`";
$where = [];
if ($search !== '') {
    $search_esc = mysqli_real_escape_string($database, $search);
    $where[] = "`$name_col` LIKE '%$search_esc%'";
}
if ($in_stock && $has_stock_col) {
    $where[] = "stock > 0";
}
if ($price_min !== null && $price_min > 0) {
    $where[] = "`$price_col` >= " . (int)$price_min;
}
if ($price_max !== null && $price_max > 0) {
    $where[] = "`$price_col` <= " . (int)$price_max;
}
if (!empty($where)) $sql .= " WHERE " . implode(" AND ", $where);
$sql .= " ORDER BY `$price_col` ASC";
$res = mysqli_query($database, $sql);
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) $list[] = $row;
}

$has_stock = !empty($list) && array_key_exists('stock', $list[0]);

$query_params = [];
if ($search !== '') $query_params['q'] = $search;
if ($in_stock) $query_params['in_stock'] = '1';
if ($price_min !== null && $price_min > 0) $query_params['price_min'] = $price_min;
if ($price_max !== null && $price_max > 0) $query_params['price_max'] = $price_max;

function build_components_query($params) {
    return $params ? '?' . http_build_query($params) : '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Components | PC Builder</title>
    <link rel="stylesheet" href="./styles/components.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,300;0,500;1,300&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'navigation.php'; ?>
    <div class="components-page">
        <?php if (isset($_GET['added'])): ?>
        <p class="components-added-msg">Added to cart. Keep browsing or <a href="cart.php">view cart</a>.</p>
        <?php endif; ?>
        <h1 class="components-title">Browse components</h1>
        <p class="components-sub">Choose a category and use filters to find parts.</p>

        <div class="components-layout">
            <aside class="components-sidebar">
                <nav class="components-sidebar-nav">
                    <span class="components-sidebar-title">Categories</span>
                    <?php foreach ($categories as $key => $cat):
                        $link_params = array_merge($query_params, ['category' => $key]);
                        $href = 'components.php' . build_components_query($link_params);
                    ?>
                    <a href="<?php echo htmlspecialchars($href); ?>" class="components-sidebar-link <?php echo $key === $category ? 'active' : ''; ?>"><?php echo htmlspecialchars($cat['label']); ?></a>
                    <?php endforeach; ?>
                </nav>
                <form method="get" class="components-filters" action="components.php">
                    <input type="hidden" name="category" value="<?php echo htmlspecialchars($category); ?>">
                    <?php if ($search !== ''): ?><input type="hidden" name="q" value="<?php echo htmlspecialchars($search); ?>"><?php endif; ?>
                    <span class="components-sidebar-title">Filters</span>
                    <?php if ($has_stock_col): ?>
                    <label class="components-filter-check">
                        <input type="checkbox" name="in_stock" value="1" <?php echo $in_stock ? 'checked' : ''; ?>>
                        <span>In stock only</span>
                    </label>
                    <?php endif; ?>
                    <label class="components-filter-label">Price min (৳)</label>
                    <input type="number" name="price_min" min="0" step="100" placeholder="Min" value="<?php echo ($price_min !== null && $price_min > 0) ? (int)$price_min : ''; ?>" class="components-filter-input">
                    <label class="components-filter-label">Price max (৳)</label>
                    <input type="number" name="price_max" min="0" step="100" placeholder="Max" value="<?php echo ($price_max !== null && $price_max > 0) ? (int)$price_max : ''; ?>" class="components-filter-input">
                    <button type="submit" class="components-filter-btn">Apply</button>
                </form>
            </aside>
            <div class="components-main">
                <form method="get" class="components-search" action="components.php">
                    <input type="hidden" name="category" value="<?php echo htmlspecialchars($category); ?>">
                    <?php if ($in_stock): ?><input type="hidden" name="in_stock" value="1"><?php endif; ?>
                    <?php if ($price_min !== null && $price_min > 0): ?><input type="hidden" name="price_min" value="<?php echo (int)$price_min; ?>"><?php endif; ?>
                    <?php if ($price_max !== null && $price_max > 0): ?><input type="hidden" name="price_max" value="<?php echo (int)$price_max; ?>"><?php endif; ?>
                    <input type="search" name="q" placeholder="Search in <?php echo htmlspecialchars($c['label']); ?>..." value="<?php echo htmlspecialchars($search); ?>" class="components-search-input">
                    <button type="submit" class="components-search-btn">Search</button>
                </form>

                <div class="components-grid">
            <?php if (empty($list)): ?>
            <p class="components-empty">No components found. Try another category or search.</p>
            <?php else: ?>
            <?php foreach ($list as $row):
                $id_val = $row[$id_col];
                $name = $row[$name_col];
                $price = (int)$row[$price_col];
                $stock = $has_stock ? (int)($row['stock'] ?? 0) : null;
                $img = !empty($row['image_url']) ? $row['image_url'] : (isset($c['default_image']) ? $c['default_image'] : ('https://placehold.co/260x140/1a1a2e/36ec4e?text=' . urlencode($c['label'])));
            ?>
            <div class="component-card">
                <div class="component-image">
                    <img src="<?php echo htmlspecialchars($img); ?>" alt="" loading="lazy">
                </div>
                <div class="component-info">
                    <h3 class="component-name"><a href="component_detail.php?category=<?php echo urlencode($category); ?>&id=<?php echo urlencode($id_val); ?>" class="component-name-link"><?php echo htmlspecialchars($name); ?></a></h3>
                    <p class="component-price">৳<?php echo number_format($price); ?></p>
                    <?php if ($stock !== null): ?><p class="component-stock">Stock: <?php echo $stock; ?></p><?php endif; ?>
                    <a href="component_detail.php?category=<?php echo urlencode($category); ?>&id=<?php echo urlencode($id_val); ?>" class="component-view-details">View details</a>
                    <a href="add_to_build.php?category=<?php echo urlencode($category); ?>&id=<?php echo urlencode($id_val); ?>" class="component-add">Add to build</a>
                </div>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
