<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['customer']) || empty($_SESSION['customer'])) {
    header('Location: login.php');  // Redirect to login page if not logged in
    exit();
}

// Include the database connection
include 'connect_database.php'; 

// Clear Cart Logic
if (isset($_POST['clear_cart'])) {
    unset(
        $_SESSION['CASING_full_name'],
        $_SESSION['CASING_price'],
        $_SESSION['CPU_full_name'],
        $_SESSION['CPU_price'],
        $_SESSION['GPU_full_name'],
        $_SESSION['GPU_price'],
        $_SESSION['RAM_full_name'],
        $_SESSION['RAM_price'],
        $_SESSION['mb_full_name'],
        $_SESSION['mb_price'],
        $_SESSION['SSD_full_name'],
        $_SESSION['SSD_price'],
        $_SESSION['HDD_full_name'],
        $_SESSION['HDD_price'],
        $_SESSION['PSU_full_name'],
        $_SESSION['PSU_price'],
        $_SESSION['CPU_COOLER_full_name'],
        $_SESSION['CPU_COOLER_price'],
        $_SESSION['total_price'],
        $_SESSION['discount_percent'],
        $_SESSION['applied_coupon']
    );
    header("Location: cart.php");  // Refresh cart after clearing it
    exit();
}

// Handle Coupon Code Logic
$coupon_error = '';
if (isset($_POST['apply_coupon'])) {
    $entered_coupon = trim($_POST['coupon_code']);
    $sql_coupon = "SELECT * FROM coupons WHERE coupon_code = ? AND expiry_date >= CURDATE()"; // Check if coupon exists and is not expired
    $stmt_coupon = mysqli_prepare($conn, $sql_coupon);

    if ($stmt_coupon) {
        mysqli_stmt_bind_param($stmt_coupon, "s", $entered_coupon);
        mysqli_stmt_execute($stmt_coupon);
        $result = mysqli_stmt_get_result($stmt_coupon);

        if ($row = mysqli_fetch_assoc($result)) {
            $_SESSION['discount_percent'] = $row['discount'];
            $_SESSION['applied_coupon'] = $row['coupon_code'];
        } else {
            $coupon_error = "Invalid Coupon Code or Expired!";
            unset($_SESSION['discount_percent']);
            unset($_SESSION['applied_coupon']);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="./styles/cart.css">
</head>

<body>

    <?php include 'navigation.php'; ?>

    <div class="main_cart">
        <?php
        $total_price = 0;
        if (empty($_SESSION['CASING_full_name'])) {
            echo '<h1>Cart is Empty</h1>';
        }
        ?>
        <table class="order-table">
            <tr>
                <th>PRODUCTS</th>
                <th>PRODUCT DESCRIPTION</th>
                <th>PRICE</th>
            </tr>

            <?php
            function display_cart_item($product_name, $full_name_key, $price_key) {
                global $total_price;
                if (!empty($_SESSION[$full_name_key]) || !empty($_SESSION[$price_key])) {
                    echo "<tr>
                            <td data-th='PRODUCTS'>$product_name</td>
                            <td data-th='PRODUCT DESCRIPTION'>" . ($_SESSION[$full_name_key] ?? '') . "</td>
                            <td data-th='PRICE'>";

                    if (!empty($_SESSION[$price_key])) {
                        echo $_SESSION[$price_key];
                        $total_price += $_SESSION[$price_key];
                    } else {
                        echo '';
                    }
                    echo "</td></tr>";
                }
            }

            display_cart_item("Casing", "CASING_full_name", "CASING_price");
            display_cart_item("CPU", "CPU_full_name", "CPU_price");
            display_cart_item("GPU", "GPU_full_name", "GPU_price");
            display_cart_item("Ram", "RAM_full_name", "RAM_price");
            display_cart_item("MOTHERBOARD", "mb_full_name", "mb_price");
            display_cart_item("SSD", "SSD_full_name", "SSD_price");
            display_cart_item("HDD", "HDD_full_name", "HDD_price");
            display_cart_item("Power Supply", "PSU_full_name", "PSU_price");
            display_cart_item("CPU Cooler", "CPU_COOLER_full_name", "CPU_COOLER_price");
            ?>

            <tr>
                <td>Total</td>
                <td>--</td>
                <td>
                    <?php 
                    if ($total_price != 0) {
                        if (!empty($_SESSION['discount_percent'])) {
                            $discount = ($total_price * $_SESSION['discount_percent']) / 100;
                            $discounted_total = $total_price - $discount;
                            echo "<del>৳" . $total_price . "</del> ৳" . $discounted_total . " (" . $_SESSION['discount_percent'] . "% OFF)";
                            $_SESSION['total_price'] = $discounted_total;
                        } else {
                            echo "৳" . $total_price;
                            $_SESSION['total_price'] = $total_price;
                        }
                    } else {
                        echo '';
                    }
                    ?>
                </td>
            </tr>
        </table>

        <div class="payment-container">
            <h1>PAYMENT METHOD</h1>
            <form action="placeorder.php" method='post'>
                <div class="methods">
                    <div class="delivery-option">
                        <div class="cod">
                            <input type="radio" id="cod" name="payment" value="Cash On Delivery" checked>
                            <label for="cod">Cash on Delivery</label>
                        </div>
                        <img src="./images/cod.png" alt="" style="width:80px;">
                    </div>
                    <br>
                    <div class="delivery-option">
                        <div class="card-payment">
                            <input type="radio" id="online_payment" name="payment" value="Online Payment">
                            <label for="online_payment">Online Payment</label>
                        </div>
                        <img src="./images/credit-card.png" alt="" style="width:80px;">
                    </div>
                    <br>
                </div>
                <input id="place-order" type="submit" name='submit-order' value="Place Order">
            </form>

            <div class="coupon-section" style="margin-top: 20px;">
                <h2>Apply Coupon</h2>
                <form method="post" action="">
                    <input type="text" name="coupon_code" placeholder="Enter Coupon Code">
                    <button type="submit" name="apply_coupon">Apply Coupon</button>
                </form>
                <?php
                if (!empty($coupon_error)) {
                    echo '<p style="color:red;">'.$coupon_error.'</p>';
                } elseif (!empty($_SESSION['applied_coupon'])) {
                    echo '<p style="color:green;">Coupon "' . $_SESSION['applied_coupon'] . '" applied! (' . $_SESSION['discount_percent'] . '% OFF)</p>';
                }
                ?>
            </div>

            <!-- Clear Cart Button -->
            <form method="post" action="" style="margin-top: 20px;">
                <button type="submit" name="clear_cart" style="padding: 10px 16px; background-color: green; color: white; border: 1px solid black; border-radius: 5px; cursor: pointer;">Clear Cart</button>
            </form>

        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>
