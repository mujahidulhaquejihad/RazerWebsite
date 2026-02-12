<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

$user_id = isset($_GET['user_id']) ? trim($_GET['user_id']) : '';
if ($user_id === '') {
    header("Location: manage_users.php");
    exit();
}

include 'connect_database.php';
$user_id_esc = mysqli_real_escape_string($database, $user_id);

$user = null;
$user_data = null;
$res = mysqli_query($database, "SELECT `id`, `email`, `timestamp` FROM `user` WHERE `email` = '$user_id_esc' LIMIT 1");
if ($res && $row = mysqli_fetch_assoc($res)) $user = $row;
if (!$user) {
    header("Location: manage_users.php");
    exit();
}

$res2 = mysqli_query($database, "SELECT * FROM `user_data` WHERE `user_id` = '$user_id_esc' LIMIT 1");
if ($res2 && $row2 = mysqli_fetch_assoc($res2)) $user_data = $row2;

$saved = false;
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = trim($_POST['firstname'] ?? '');
    $lastname = trim($_POST['lastname'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $state = trim($_POST['state'] ?? '');
    $country = trim($_POST['country'] ?? '');
    $zip_code = trim($_POST['zip_code'] ?? '');
    $mobile = trim($_POST['mobile'] ?? '');
    $fn_esc = mysqli_real_escape_string($database, $firstname);
    $ln_esc = mysqli_real_escape_string($database, $lastname);
    $addr_esc = mysqli_real_escape_string($database, $address);
    $city_esc = mysqli_real_escape_string($database, $city);
    $state_esc = mysqli_real_escape_string($database, $state);
    $country_esc = mysqli_real_escape_string($database, $country);
    $zip_esc = mysqli_real_escape_string($database, $zip_code);
    $mobile_esc = mysqli_real_escape_string($database, $mobile);

    if ($user_data) {
        $sql = "UPDATE `user_data` SET `firstname` = '$fn_esc', `lastname` = '$ln_esc', `address` = '$addr_esc', `city` = '$city_esc', `state` = '$state_esc', `country` = '$country_esc', `zip_code` = '$zip_esc', `mobile-number` = '$mobile_esc' WHERE `user_id` = '$user_id_esc' LIMIT 1";
        if (mysqli_query($database, $sql)) {
            $saved = true;
            $user_data = array_merge($user_data, ['firstname' => $firstname, 'lastname' => $lastname, 'address' => $address, 'city' => $city, 'state' => $state, 'country' => $country, 'zip_code' => $zip_code, 'mobile-number' => $mobile]);
        } else {
            $error = mysqli_error($database);
        }
    } else {
        $sql = "INSERT INTO `user_data` (`user_id`, `firstname`, `lastname`, `address`, `city`, `state`, `country`, `zip_code`, `mobile-number`) VALUES ('$user_id_esc', '$fn_esc', '$ln_esc', '$addr_esc', '$city_esc', '$state_esc', '$country_esc', '$zip_esc', '$mobile_esc')";
        if (mysqli_query($database, $sql)) {
            $saved = true;
            $user_data = ['firstname' => $firstname, 'lastname' => $lastname, 'address' => $address, 'city' => $city, 'state' => $state, 'country' => $country, 'zip_code' => $zip_code, 'mobile-number' => $mobile];
        } else {
            $error = mysqli_error($database);
        }
    }
}

$admin_current_page = 'users';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User | Admin</title>
    <link rel="stylesheet" href="./styles/admin.css">
    <style>
        .admin-form-grid { display: grid; gap: 1rem; max-width: 480px; }
        .admin-form-grid label { display: block; color: #94a3b8; font-size: 0.85rem; margin-bottom: 0.25rem; }
        .admin-form-grid input { width: 100%; padding: 0.6rem; background: #0f172a; border: 1px solid #334155; border-radius: 6px; color: #e2e8f0; box-sizing: border-box; }
        .admin-form-grid input:read-only { opacity: 0.8; }
    </style>
</head>
<body class="admin-body">
    <div class="admin-layout">
        <?php include 'includes/admin_sidebar.php'; ?>
        <main class="admin-main">
            <h1 class="admin-page-title">Manage user</h1>
            <p style="margin-bottom: 1rem;"><a href="manage_users.php" class="admin-btn admin-btn-ghost">← Back to users</a></p>
            <?php if ($saved): ?><div class="admin-alert" style="background: rgba(34,197,94,0.15); border-color: rgba(34,197,94,0.4); color: #86efac;">User details saved.</div><?php endif; ?>
            <?php if ($error): ?><div class="admin-alert admin-alert-error"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
            <div class="admin-card">
                <form method="post" class="admin-form-grid">
                    <div>
                        <label>Email (login)</label>
                        <input type="text" value="<?php echo htmlspecialchars($user['email']); ?>" read-only disabled>
                    </div>
                    <div>
                        <label>Joined</label>
                        <input type="text" value="<?php echo htmlspecialchars($user['timestamp'] ?? '—'); ?>" read-only disabled>
                    </div>
                    <div>
                        <label>First name</label>
                        <input type="text" name="firstname" value="<?php echo htmlspecialchars($user_data['firstname'] ?? ''); ?>" required>
                    </div>
                    <div>
                        <label>Last name</label>
                        <input type="text" name="lastname" value="<?php echo htmlspecialchars($user_data['lastname'] ?? ''); ?>" required>
                    </div>
                    <div>
                        <label>Address</label>
                        <input type="text" name="address" value="<?php echo htmlspecialchars($user_data['address'] ?? ''); ?>">
                    </div>
                    <div>
                        <label>City</label>
                        <input type="text" name="city" value="<?php echo htmlspecialchars($user_data['city'] ?? ''); ?>">
                    </div>
                    <div>
                        <label>State / Province</label>
                        <input type="text" name="state" value="<?php echo htmlspecialchars($user_data['state'] ?? ''); ?>">
                    </div>
                    <div>
                        <label>Country</label>
                        <input type="text" name="country" value="<?php echo htmlspecialchars($user_data['country'] ?? ''); ?>">
                    </div>
                    <div>
                        <label>ZIP / Postal code</label>
                        <input type="text" name="zip_code" value="<?php echo htmlspecialchars($user_data['zip_code'] ?? ''); ?>">
                    </div>
                    <div>
                        <label>Mobile number</label>
                        <input type="text" name="mobile" value="<?php echo htmlspecialchars($user_data['mobile-number'] ?? ''); ?>">
                    </div>
                    <div>
                        <button type="submit" class="admin-btn admin-btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
