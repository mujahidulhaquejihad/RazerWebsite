<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: admin_components.php");
    exit();
}

$category = trim($_POST['category'] ?? '');
$id = trim($_POST['id'] ?? '');
$categories = require __DIR__ . '/config/categories.php';
if (!isset($categories[$category]) || $id === '') {
    header("Location: admin_components.php");
    exit();
}

include 'connect_database.php';
$c = $categories[$category];
$table = $c['table'];
$id_col = $c['id_col'];
$id_esc = mysqli_real_escape_string($database, $id);
mysqli_query($database, "DELETE FROM `$table` WHERE `$id_col` = '$id_esc'");
header("Location: admin_components_list.php?category=" . urlencode($category));
exit;
