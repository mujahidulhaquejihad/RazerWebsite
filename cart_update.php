<?php
session_start();
$category = isset($_POST['category']) ? trim($_POST['category']) : (isset($_GET['category']) ? trim($_GET['category']) : '');
$action = isset($_POST['action']) ? trim($_POST['action']) : (isset($_GET['action']) ? trim($_GET['action']) : '');

$valid_categories = ['cabinet', 'processor', 'gpu', 'ram', 'motherboard', 'ssd', 'hdd', 'power_supply', 'cpu_cooler'];
$session_keys = [
    'cabinet'      => ['price' => 'cabinet_price',      'name' => 'cabinet_full_name',      'qty' => 'cabinet_qty'],
    'processor'    => ['price' => 'cpu_price',          'name' => 'cpu_full_name',          'qty' => 'cpu_qty'],
    'gpu'          => ['price' => 'gpu_price',          'name' => 'gpu_full_name',          'qty' => 'gpu_qty'],
    'ram'          => ['price' => 'ram_price',          'name' => 'ram_full_name',          'qty' => 'ram_qty'],
    'motherboard'  => ['price' => 'mb_price',           'name' => 'mb_full_name',           'qty' => 'mb_qty'],
    'ssd'          => ['price' => 'ssd_price',          'name' => 'ssd_full_name',          'qty' => 'ssd_qty'],
    'hdd'          => ['price' => 'hdd_price',          'name' => 'hdd_full_name',          'qty' => 'hdd_qty'],
    'power_supply' => ['price' => 'power_supply_price', 'name' => 'power_supply_full_name', 'qty' => 'power_supply_qty'],
    'cpu_cooler'   => ['price' => 'cpu_cooler_price',   'name' => 'cpu_cooler_full_name',  'qty' => 'cpu_cooler_qty'],
];

if ($category === '' || !isset($session_keys[$category])) {
    header('Location: cart.php');
    exit;
}

$keys = $session_keys[$category];

if ($action === 'remove') {
    unset($_SESSION[$keys['price']], $_SESSION[$keys['name']], $_SESSION[$keys['qty']]);
    header('Location: cart.php'); // no success message
    exit;
}

if ($action === 'setqty') {
    $qty = isset($_POST['qty']) ? (int)$_POST['qty'] : (int)($_GET['qty'] ?? 0);
    if ($qty < 1) {
        unset($_SESSION[$keys['price']], $_SESSION[$keys['name']], $_SESSION[$keys['qty']]);
    } else {
        if (!empty($_SESSION[$keys['price']])) {
            $_SESSION[$keys['qty']] = min(99, $qty);
        }
    }
    header('Location: cart.php');
    exit;
}

header('Location: cart.php');
exit;
