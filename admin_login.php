<?php
session_start();
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] == true) {
    header("Location: admin_dashboard.php");
    exit();
}

$error_message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $admin_username = 'admin';
    $admin_password = 'password123';
    if (isset($_POST['username']) && isset($_POST['password']) &&
        $_POST['username'] === $admin_username && $_POST['password'] === $admin_password) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin_dashboard.php");
        exit();
    }
    $error_message = "Invalid username or password.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | PC Builder</title>
    <link rel="stylesheet" href="./styles/admin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        .admin-login-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #2d2d2d;
            padding: 2rem;
        }
        .admin-login-card {
            width: 100%;
            max-width: 380px;
            background: rgba(18, 18, 18, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
            font-family: 'Roboto Mono', monospace;
        }
        .admin-login-card h1 {
            margin: 0 0 0.35rem;
            font-size: 1.4rem;
            color: #fff;
        }
        .admin-login-card .sub {
            color: rgba(255, 255, 255, 0.55);
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }
        .admin-login-field {
            margin-bottom: 1.25rem;
        }
        .admin-login-field label {
            display: block;
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.6);
            margin-bottom: 0.4rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .admin-login-field input {
            width: 100%;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            font-family: 'Roboto Mono', monospace;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 8px;
            color: #fff;
            box-sizing: border-box;
        }
        .admin-login-field input:focus {
            outline: none;
            border-color: rgba(54, 236, 78, 0.5);
        }
        .admin-login-submit {
            width: 100%;
            padding: 0.85rem;
            margin-top: 0.5rem;
            font-size: 1rem;
            font-weight: 600;
            font-family: 'Roboto Mono', monospace;
            background: rgba(54, 236, 78, 0.9);
            color: #000;
            border: none;
            border-radius: 10px;
            cursor: pointer;
        }
        .admin-login-submit:hover {
            background: rgba(54, 236, 78, 1);
        }
    </style>
</head>
<body class="admin-body">
    <div class="admin-login-page">
        <div class="admin-login-card">
            <h1>Admin Login</h1>
            <p class="sub">PC Builder – Admin panel</p>
            <?php if ($error_message): ?>
            <div class="admin-alert admin-alert-error"><?php echo htmlspecialchars($error_message); ?></div>
            <?php endif; ?>
            <form method="POST" action="admin_login.php">
                <div class="admin-login-field">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" required autocomplete="username">
                </div>
                <div class="admin-login-field">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required autocomplete="current-password">
                </div>
                <button type="submit" class="admin-login-submit">Sign in</button>
            </form>
        </div>
    </div>
</body>
</html>
