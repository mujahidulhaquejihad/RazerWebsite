<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['customer']) || empty($_SESSION['customer'])) {
    header('location: login.php');
    exit;
}

// No success message when an item is removed — clean URL and clear any message flag
if (isset($_GET['removed']) || isset($_GET['updated']) || isset($_GET['msg'])) {
    header('Location: cart.php');
    exit;
}
unset($_SESSION['cart_message'], $_SESSION['cart_removed'], $_SESSION['cart_updated']);

$cart_items = [
    'cabinet'      => ['label' => 'Cabinet',   'price' => 'cabinet_price',   'name' => 'cabinet_full_name',   'qty' => 'cabinet_qty'],
    'processor'    => ['label' => 'CPU',       'price' => 'cpu_price',       'name' => 'cpu_full_name',       'qty' => 'cpu_qty'],
    'gpu'          => ['label' => 'GPU',       'price' => 'gpu_price',       'name' => 'gpu_full_name',       'qty' => 'gpu_qty'],
    'ram'          => ['label' => 'RAM',        'price' => 'ram_price',       'name' => 'ram_full_name',       'qty' => 'ram_qty'],
    'motherboard'  => ['label' => 'Motherboard','price' => 'mb_price',       'name' => 'mb_full_name',         'qty' => 'mb_qty'],
    'ssd'          => ['label' => 'SSD',        'price' => 'ssd_price',      'name' => 'ssd_full_name',        'qty' => 'ssd_qty'],
    'hdd'          => ['label' => 'HDD',        'price' => 'hdd_price',       'name' => 'hdd_full_name',        'qty' => 'hdd_qty'],
    'power_supply' => ['label' => 'Power Supply','price' => 'power_supply_price','name' => 'power_supply_full_name','qty' => 'power_supply_qty'],
    'cpu_cooler'   => ['label' => 'CPU Cooler', 'price' => 'cpu_cooler_price','name' => 'cpu_cooler_full_name','qty' => 'cpu_cooler_qty'],
];

$lines = [];
$total_price = 0;
foreach ($cart_items as $cat => $keys) {
    $p = isset($_SESSION[$keys['price']]) ? (int)$_SESSION[$keys['price']] : 0;
    if ($p <= 0) continue;
    $qty = isset($_SESSION[$keys['qty']]) ? max(1, (int)$_SESSION[$keys['qty']]) : 1;
    $name = $_SESSION[$keys['name']] ?? '';
    $line_total = $p * $qty;
    $total_price += $line_total;
    $lines[] = [
        'category' => $cat,
        'label' => $keys['label'],
        'name' => $name,
        'price' => $p,
        'qty' => $qty,
        'line_total' => $line_total,
    ];
}
$_SESSION['total_price'] = $total_price;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./styles/cart.css">
</head>
<body>
    <?php include 'navigation.php'; ?>

    <div class="main_cart">
        <h1>Your build</h1>
        <?php if (empty($lines)): ?>
            <p class="cart-empty">Cart is empty. <a href="components.php">Add components</a> to build your PC.</p>
        <?php else: ?>
        <div class="cart-table-wrap">
        <table class="order-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Description</th>
                    <th>Unit price</th>
                    <th>Qty</th>
                    <th>Total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lines as $line): ?>
                <tr>
                    <td data-th="Product"><?php echo htmlspecialchars($line['label']); ?></td>
                    <td data-th="Description"><?php echo htmlspecialchars($line['name']); ?></td>
                    <td data-th="Unit price">৳<?php echo number_format($line['price']); ?></td>
                    <td data-th="Qty" class="cart-qty-cell">
                        <form method="post" action="cart_update.php" class="cart-qty-form">
                            <input type="hidden" name="action" value="setqty">
                            <input type="hidden" name="category" value="<?php echo htmlspecialchars($line['category']); ?>">
                            <button type="submit" name="qty" value="<?php echo max(1, $line['qty'] - 1); ?>" class="cart-qty-btn" title="Decrease">−</button>
                            <span class="cart-qty-num"><?php echo $line['qty']; ?></span>
                            <button type="submit" name="qty" value="<?php echo min(99, $line['qty'] + 1); ?>" class="cart-qty-btn" title="Increase">+</button>
                        </form>
                    </td>
                    <td data-th="Total">৳<?php echo number_format($line['line_total']); ?></td>
                    <td class="cart-remove-cell">
                        <form method="post" action="cart_update.php" class="cart-remove-form" onsubmit="return confirm('Remove this item?');">
                            <input type="hidden" name="action" value="remove">
                            <input type="hidden" name="category" value="<?php echo htmlspecialchars($line['category']); ?>">
                            <button type="submit" class="cart-remove-btn">Remove</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="cart-total-row">
                    <td colspan="4">Total</td>
                    <td>৳<?php echo number_format($total_price); ?></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
        </div>

        <div class="payment-container">
            <h1>Payment method</h1>
            <form action="placeorder.php" method="post">
                <div class="methods">
                    <div class="delivery-option">
                        <div class="cod">
                            <input type="radio" id="cod" name="payment" value="Cash On Delivery" checked>
                            <label for="cod">Cash on Delivery</label>
                        </div>
                        <img src="./images/cod.png" alt="" style="width:80px;">
                    </div>
                    <div class="delivery-option">
                        <div class="card-payment">
                            <input type="radio" id="online_payment" name="payment" value="Online Payment">
                            <label for="online_payment">Online Payment</label>
                        </div>
                        <img src="./images/credit-card.png" alt="" style="width:80px;">
                    </div>
                </div>
                <input id="place-order" type="submit" name="submit-order" value="Place Order">
            </form>
        </div>
        <?php endif; ?>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
