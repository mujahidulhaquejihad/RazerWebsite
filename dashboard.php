<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['customer']) || empty($_SESSION['customer'])) {
    header('Location: login.php');
    exit;
}
$build_saved = !empty($_SESSION['build_saved']);
if ($build_saved) unset($_SESSION['build_saved']);

include 'connect_database.php';
$user_id = mysqli_real_escape_string($database, $_SESSION['customer']);
$profile = null;
$res = mysqli_query($database, "SELECT firstname, lastname, city, country FROM user_data WHERE user_id = '$user_id' LIMIT 1");
if ($res && $row = mysqli_fetch_assoc($res)) {
    $profile = $row;
}
$name = $profile ? trim($profile['firstname'] . ' ' . $profile['lastname']) : 'User';
if ($name === '') $name = explode('@', $_SESSION['customer'])[0];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | PC Builder</title>
    <link rel="stylesheet" href="./styles/dashboard.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'navigation.php'; ?>

    <div class="dashboard">
        <header class="dashboard-topbar">
            <div class="dashboard-welcome">
                <h1 class="dashboard-title">Welcome, <?php echo htmlspecialchars($name); ?></h1>
                <p class="dashboard-sub">Manage your account and builds</p>
            </div>
            <a href="logout.php" class="dashboard-logout-btn">Logout</a>
        </header>

        <?php if ($build_saved): ?><p class="dashboard-flash">Build saved successfully.</p><?php endif; ?>

        <div class="dashboard-body<?php echo $profile ? '' : ' dashboard-body-full'; ?>">
            <div class="dashboard-cards">
                <a href="components.php" class="dashboard-card dashboard-card-primary">
                    <span class="dashboard-card-icon">⚙</span>
                    <h2>Build PC</h2>
                    <p>Browse components and add parts to your cart</p>
                </a>
                <a href="cart.php" class="dashboard-card">
                    <span class="dashboard-card-icon">🛒</span>
                    <h2>Cart</h2>
                    <p>View your current build and checkout</p>
                </a>
                <a href="my_builds.php" class="dashboard-card">
                    <span class="dashboard-card-icon">📦</span>
                    <h2>My builds</h2>
                    <p>View your saved PC builds</p>
                </a>
                <a href="order_history.php" class="dashboard-card">
                    <span class="dashboard-card-icon">📋</span>
                    <h2>Order history</h2>
                    <p>View your past orders</p>
                </a>
                <a href="myaccount.php" class="dashboard-card">
                    <span class="dashboard-card-icon">👤</span>
                    <h2>Profile</h2>
                    <p>Edit your details and address</p>
                </a>
            </div>

            <?php if ($profile): ?>
            <aside class="dashboard-sidebar">
                <section class="dashboard-info">
                    <h2>Your details</h2>
                    <div class="dashboard-info-grid">
                        <div class="dashboard-info-item">
                            <span class="label">Email</span>
                            <span class="value"><?php echo htmlspecialchars($_SESSION['customer']); ?></span>
                        </div>
                        <?php if (!empty($profile['city'])): ?>
                        <div class="dashboard-info-item">
                            <span class="label">City</span>
                            <span class="value"><?php echo htmlspecialchars($profile['city']); ?></span>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($profile['country'])): ?>
                        <div class="dashboard-info-item">
                            <span class="label">Country</span>
                            <span class="value"><?php echo htmlspecialchars($profile['country']); ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                </section>
            </aside>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
