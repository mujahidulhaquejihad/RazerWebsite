<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

$order_id = isset($_POST['order_id']) ? (int)$_POST['order_id'] : 0;
if ($order_id <= 0) {
    header("Location: manage_orders.php");
    exit();
}

include 'connect_database.php';
$categories = require __DIR__ . '/config/categories.php';

// Load order
$order_res = mysqli_query($database, "SELECT `id`, `order-status` FROM `order_details` WHERE `id` = $order_id LIMIT 1");
if (!$order_res || !$order = mysqli_fetch_assoc($order_res)) {
    header("Location: manage_orders.php");
    exit();
}

$status = trim($order['order-status'] ?? '');
if (strtolower($status) === 'completed') {
    header("Location: manage_orders.php");
    exit();
}

// Load build for this order
$build_res = mysqli_query($database, "SELECT `id` FROM `builds` WHERE `order_id` = $order_id LIMIT 1");
if (!$build_res || !$build = mysqli_fetch_assoc($build_res)) {
    header("Location: manage_orders.php");
    exit();
}

$build_id = (int)$build['id'];

// Mark order as completed
$status_esc = mysqli_real_escape_string($database, 'Completed');
mysqli_query($database, "UPDATE `order_details` SET `order-status` = '$status_esc' WHERE `id` = $order_id");

// Load all build_items (each row = 1 unit sold)
$items_res = mysqli_query($database, "SELECT `category`, `component_name`, `price` FROM `build_items` WHERE `build_id` = $build_id");
if ($items_res) {
    while ($item = mysqli_fetch_assoc($items_res)) {
        $cat = $item['category'];
        if (!isset($categories[$cat])) continue;
        $c = $categories[$cat];
        $table = $c['table'];
        $name_col = $c['name_col'];
        $price_col = 'price';
        $name_esc = mysqli_real_escape_string($database, $item['component_name']);
        $price = (int)$item['price'];
        // Reduce stock by 1 for one matching row (match by name and price)
        $sql = "UPDATE `$table` SET stock = GREATEST(0, stock - 1) WHERE `$name_col` = '$name_esc' AND `$price_col` = $price LIMIT 1";
        mysqli_query($database, $sql);
    }
}

header("Location: manage_orders.php");
exit();
