<?php
session_start();
include 'connect_database.php';

$total_price = $cabinet = $cpu = $gpu = $ram = $mb = $ssd = $hdd = $ps = $cpu_cooler = $userid = '';
if (isset($_POST['submit-order'])) {
    $total_price = isset($_SESSION['total_price']) ? (int)$_SESSION['total_price'] : 0;
    $cabinet = $_SESSION['cabinet_full_name'] ?? '';
    $cpu = $_SESSION['cpu_full_name'] ?? '';
    $gpu = $_SESSION['gpu_full_name'] ?? '';
    $ram = $_SESSION['ram_full_name'] ?? '';
    $mb = $_SESSION['mb_full_name'] ?? '';
    $ssd = $_SESSION['ssd_full_name'] ?? '';
    $hdd = $_SESSION['hdd_full_name'] ?? '';
    $ps = $_SESSION['power_supply_full_name'] ?? '';
    $cpu_cooler = $_SESSION['cpu_cooler_full_name'] ?? '';
    $userid = $_SESSION['customer'] ?? '';
    $mode_of_payment = isset($_POST['payment']) ? trim($_POST['payment']) : '';

    if ($userid === '' || $total_price <= 0) {
        header('Location: cart.php');
        exit;
    }

    $userid_esc = mysqli_real_escape_string($database, $userid);
    $cabinet_esc = mysqli_real_escape_string($database, $cabinet);
    $cpu_esc = mysqli_real_escape_string($database, $cpu);
    $gpu_esc = mysqli_real_escape_string($database, $gpu);
    $ram_esc = mysqli_real_escape_string($database, $ram);
    $mb_esc = mysqli_real_escape_string($database, $mb);
    $ssd_esc = mysqli_real_escape_string($database, $ssd);
    $hdd_esc = mysqli_real_escape_string($database, $hdd);
    $ps_esc = mysqli_real_escape_string($database, $ps);
    $cooler_esc = mysqli_real_escape_string($database, $cpu_cooler);
    $payment_esc = mysqli_real_escape_string($database, $mode_of_payment);

    // 1) Insert into order_details (for Order history)
    $order_status = 'Ordered';
    $order_status_esc = mysqli_real_escape_string($database, $order_status);
    $sql_order = "INSERT INTO `order_details` (`userid`, `totalprice`, `order-status`, `payment_method`, `timestamp`) 
                  VALUES ('$userid_esc', $total_price, '$order_status_esc', '$payment_esc', NOW())";
    if (!mysqli_query($database, $sql_order)) {
        echo "Error creating order: " . mysqli_error($database);
        exit;
    }
    $order_id = (int) mysqli_insert_id($database);

    // 2) Insert into builds + build_items (so admin always sees full build); link build to order
    $build_name = 'Order ' . date('M j, Y g:i A');
    $build_name_esc = mysqli_real_escape_string($database, $build_name);
    $sql_build = "INSERT INTO `builds` (`user_id`, `name`, `total_price`, `order_id`) VALUES ('$userid_esc', '$build_name_esc', $total_price, $order_id)";
    if (!mysqli_query($database, $sql_build)) {
        echo "Error creating build. Ensure table builds has column order_id (run migration_order_build_link.sql). " . mysqli_error($database);
        exit;
    }
    $build_id = (int) mysqli_insert_id($database);

    $items = [];
    $q = function($name, $price, $qty_key) { global $_SESSION; return isset($_SESSION[$name]) && isset($_SESSION[$price]) ? ['name' => $_SESSION[$name], 'price' => (int)$_SESSION[$price], 'qty' => isset($_SESSION[$qty_key]) ? max(1, (int)$_SESSION[$qty_key]) : 1] : null; };
    if ($x = $q('cabinet_full_name', 'cabinet_price', 'cabinet_qty')) $items[] = ['category' => 'cabinet', 'id' => (string)$x['price'], 'name' => $x['name'], 'price' => $x['price'], 'qty' => $x['qty']];
    if ($x = $q('cpu_full_name', 'cpu_price', 'cpu_qty')) $items[] = ['category' => 'processor', 'id' => (string)$x['price'], 'name' => $x['name'], 'price' => $x['price'], 'qty' => $x['qty']];
    if ($x = $q('gpu_full_name', 'gpu_price', 'gpu_qty')) $items[] = ['category' => 'gpu', 'id' => (string)$x['price'], 'name' => $x['name'], 'price' => $x['price'], 'qty' => $x['qty']];
    if ($x = $q('ram_full_name', 'ram_price', 'ram_qty')) $items[] = ['category' => 'ram', 'id' => (string)$x['price'], 'name' => $x['name'], 'price' => $x['price'], 'qty' => $x['qty']];
    if ($x = $q('mb_full_name', 'mb_price', 'mb_qty')) $items[] = ['category' => 'motherboard', 'id' => (string)$x['price'], 'name' => $x['name'], 'price' => $x['price'], 'qty' => $x['qty']];
    if ($x = $q('ssd_full_name', 'ssd_price', 'ssd_qty')) $items[] = ['category' => 'ssd', 'id' => (string)$x['price'], 'name' => $x['name'], 'price' => $x['price'], 'qty' => $x['qty']];
    if ($x = $q('hdd_full_name', 'hdd_price', 'hdd_qty')) $items[] = ['category' => 'hdd', 'id' => (string)$x['price'], 'name' => $x['name'], 'price' => $x['price'], 'qty' => $x['qty']];
    if ($x = $q('power_supply_full_name', 'power_supply_price', 'power_supply_qty')) $items[] = ['category' => 'power_supply', 'id' => (string)$x['price'], 'name' => $x['name'], 'price' => $x['price'], 'qty' => $x['qty']];
    if ($x = $q('cpu_cooler_full_name', 'cpu_cooler_price', 'cpu_cooler_qty')) $items[] = ['category' => 'cpu_cooler', 'id' => (string)$x['price'], 'name' => $x['name'], 'price' => $x['price'], 'qty' => $x['qty']];
    foreach ($items as $item) {
        $cat_esc = mysqli_real_escape_string($database, $item['category']);
        $id_esc = mysqli_real_escape_string($database, $item['id']);
        $name_esc = mysqli_real_escape_string($database, $item['name']);
        $p = (int) $item['price'];
        $qty = (int) $item['qty'];
        for ($i = 0; $i < $qty; $i++) {
            mysqli_query($database, "INSERT INTO `build_items` (`build_id`, `category`, `component_id`, `component_name`, `price`) VALUES ($build_id, '$cat_esc', '$id_esc', '$name_esc', $p)");
        }
    }

    // 3) Legacy: product_details (optional; do not block success)
    @mysqli_query($database, "INSERT INTO `product_details` (`userid`, `model_name`, `cpu_id`, `gpu_id`, `ram_id`, `mb_id`, `ssd_id`, `hdd_id`, `ps_id`, `cooler_id`, `total_price`, `mode_of_payment`) 
        VALUES ('$userid_esc', '$cabinet_esc', '$cpu_esc', '$gpu_esc', '$ram_esc', '$mb_esc', '$ssd_esc', '$hdd_esc', '$ps_esc', 'cpu_cooler', $total_price, '$payment_esc')");

    header('Location: order_success.php');
    exit;
}
