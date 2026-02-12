<?php
session_start();
if (!isset($_SESSION['customer']) || empty($_SESSION['customer'])) {
    header('Location: login.php');
    exit;
}

include 'connect_database.php';
$categories = require __DIR__ . '/config/categories.php';

$parts = [
    'cabinet' => (int)($_POST['cabinet'] ?? 0),
    'processor' => (int)($_POST['cpu'] ?? 0),
    'gpu' => (int)($_POST['gpu'] ?? 0),
    'ram' => (int)($_POST['ram'] ?? 0),
    'motherboard' => (int)($_POST['mb'] ?? 0),
    'ssd' => (int)($_POST['ssd'] ?? 0),
    'hdd' => (int)($_POST['hdd'] ?? 0),
    'power_supply' => (int)($_POST['power_supply'] ?? 0),
    'cpu_cooler' => (int)($_POST['cpu_cooler'] ?? 0),
];

$user_id = mysqli_real_escape_string($database, $_SESSION['customer']);
$total_price = 0;
$items = [];

foreach ($parts as $category => $price) {
    if ($price <= 0) continue;
    $c = $categories[$category];
    $table = $c['table'];
    $id_col = $c['id_col'];
    $name_col = $c['name_col'];
    $price_col = $c['price_col'];
    $res = mysqli_query($database, "SELECT `$id_col`, `$name_col`, `$price_col` FROM `$table` WHERE `$price_col` = $price LIMIT 1");
    if ($res && $row = mysqli_fetch_assoc($res)) {
        $total_price += (int)$row[$price_col];
        $items[] = [
            'category' => $category,
            'id' => $row[$id_col],
            'name' => $row[$name_col],
            'price' => (int)$row[$price_col],
        ];
    }
}

if (empty($items)) {
    $_SESSION['build_error'] = 'No valid parts selected.';
    header('Location: custom_rigs.php');
    exit;
}

$name_esc = mysqli_real_escape_string($database, 'My Build ' . date('M j, Y'));
$sql = "INSERT INTO builds (user_id, name, total_price) VALUES ('$user_id', '$name_esc', $total_price)";
if (!mysqli_query($database, $sql)) {
    $_SESSION['build_error'] = 'Could not save build.';
    header('Location: custom_rigs.php');
    exit;
}
$build_id = (int)mysqli_insert_id($database);

foreach ($items as $item) {
    $cat_esc = mysqli_real_escape_string($database, $item['category']);
    $id_esc = mysqli_real_escape_string($database, $item['id']);
    $name_esc = mysqli_real_escape_string($database, $item['name']);
    $p = (int)$item['price'];
    mysqli_query($database, "INSERT INTO build_items (build_id, category, component_id, component_name, price) VALUES ($build_id, '$cat_esc', '$id_esc', '$name_esc', $p)");
}

$_SESSION['build_saved'] = true;
header('Location: dashboard.php');
exit;
