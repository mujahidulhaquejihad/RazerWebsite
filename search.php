<?php
if (session_status() === PHP_SESSION_NONE) session_start();
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
                $row['_stock'] = array_key_exists('stock', $row) ? (int)$row['stock'] : null;
                $row['_image_url'] = !empty($row['image_url']) ? $row['image_url'] : (isset($c['default_image']) ? $c['default_image'] : ('https://placehold.co/260x140/1a1a2e/36ec4e?text=' . urlencode($c['label'])));
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
    <title>Search<?php echo $q !== '' ? ': ' . htmlspecialchars($q) : ''; ?> | PC Builder</title>
    <link rel="stylesheet" href="./styles/components.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,300;0,500;1,300&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'navigation.php'; ?>
    <div class="components-page">
        <?php if (isset($_GET['added'])): ?>
        <p class="components-added-msg">Added to cart. <a href="cart.php">View cart</a></p>
        <?php endif; ?>
        <h1 class="components-title">Search components</h1>
        <p class="components-sub">Find any part by name or ID across all categories.</p>

        <form method="get" class="components-search" action="search.php" style="margin-bottom: 1.5rem;">
            <input type="search" name="q" placeholder="Search for a part..." value="<?php echo htmlspecialchars($q); ?>">
            <button type="submit">Search</button>
        </form>

        <?php if ($q === ''): ?>
        <p class="components-empty">Enter a search term above.</p>
        <?php elseif (empty($results)): ?>
        <p class="components-empty">No parts found for &ldquo;<?php echo htmlspecialchars($q); ?>&rdquo;. Try <a href="components.php">browsing by category</a>.</p>
        <?php else: ?>
        <p class="search-results-count"><?php echo count($results); ?> result<?php echo count($results) === 1 ? '' : 's'; ?></p>
        <ul class="search-results-list">
            <?php foreach ($results as $row):
                $cat_key = $row['_category'];
                $cat_label = $categories[$cat_key]['label'];
                $detail_url = 'component_detail.php?category=' . urlencode($cat_key) . '&id=' . urlencode($row['_id_val']);
            ?>
            <li class="search-results-item">
                <a href="<?php echo htmlspecialchars($detail_url); ?>" class="search-results-link">
                    <span class="search-results-category"><?php echo htmlspecialchars($cat_label); ?></span>
                    <span class="search-results-name"><?php echo htmlspecialchars($row['_name']); ?></span>
                    <span class="search-results-price">৳<?php echo number_format($row['_price']); ?></span>
                    <?php if ($row['_stock'] !== null): ?><span class="search-results-stock">Stock: <?php echo $row['_stock']; ?></span><?php endif; ?>
                    <span class="search-results-action">View details →</span>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
