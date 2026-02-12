<?php
session_start();
$category = isset($_GET['category']) ? trim($_GET['category']) : '';
$id = isset($_GET['id']) ? trim($_GET['id']) : '';
if ($category === '' || $id === '') {
    header('Location: components.php');
    exit;
}

$categories = require __DIR__ . '/config/categories.php';
if (!isset($categories[$category])) {
    header('Location: components.php');
    exit;
}

include 'connect_database.php';
$c = $categories[$category];
$table = $c['table'];
$id_col = $c['id_col'];
$name_col = $c['name_col'];
$price_col = $c['price_col'];
$id_esc = mysqli_real_escape_string($database, $id);

$res = mysqli_query($database, "SELECT `$id_col`, `$name_col`, `$price_col` FROM `$table` WHERE `$id_col` = '$id_esc' LIMIT 1");
if (!$res || !$row = mysqli_fetch_assoc($res)) {
    header('Location: components.php?category=' . urlencode($category));
    exit;
}

$price = (int) $row[$price_col];
$name = $row[$name_col];

$session_map = [
    'cabinet'       => ['price' => 'cabinet_price',       'name' => 'cabinet_full_name',       'qty' => 'cabinet_qty'],
    'processor'     => ['price' => 'cpu_price',           'name' => 'cpu_full_name',          'qty' => 'cpu_qty'],
    'gpu'           => ['price' => 'gpu_price',           'name' => 'gpu_full_name',          'qty' => 'gpu_qty'],
    'ram'           => ['price' => 'ram_price',           'name' => 'ram_full_name',          'qty' => 'ram_qty'],
    'motherboard'   => ['price' => 'mb_price',            'name' => 'mb_full_name',           'qty' => 'mb_qty'],
    'ssd'           => ['price' => 'ssd_price',           'name' => 'ssd_full_name',          'qty' => 'ssd_qty'],
    'hdd'           => ['price' => 'hdd_price',           'name' => 'hdd_full_name',          'qty' => 'hdd_qty'],
    'power_supply'  => ['price' => 'power_supply_price',  'name' => 'power_supply_full_name', 'qty' => 'power_supply_qty'],
    'cpu_cooler'    => ['price' => 'cpu_cooler_price',    'name' => 'cpu_cooler_full_name',   'qty' => 'cpu_cooler_qty'],
];

if (isset($session_map[$category])) {
    $k = $session_map[$category];
    $same_product = isset($_SESSION[$k['price']]) && (int)$_SESSION[$k['price']] === $price;
    if ($same_product) {
        $current_qty = isset($_SESSION[$k['qty']]) ? (int)$_SESSION[$k['qty']] : 1;
        $_SESSION[$k['qty']] = min(99, $current_qty + 1);
    } else {
        $_SESSION[$k['price']] = $price;
        $_SESSION[$k['name']] = $name;
        $_SESSION[$k['qty']] = 1;
    }
}

$return = isset($_GET['return']) ? trim($_GET['return']) : '';
$q = isset($_GET['q']) ? trim($_GET['q']) : '';
if ($return === 'detail') {
    $back = 'component_detail.php?category=' . urlencode($category) . '&id=' . urlencode($id) . '&added=1';
} else {
    $back = 'components.php?category=' . urlencode($category) . '&added=1';
    if ($q !== '') $back .= '&q=' . urlencode($q);
}
header('Location: ' . $back);
exit;
