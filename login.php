<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | PC Builder</title>
    <link rel="stylesheet" href="./styles/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,300;0,500;1,300&display=swap" rel="stylesheet">
</head>
<body class="auth-body">
    <?php include 'navigation.php' ?>

    <div class="auth-page">
        <div class="auth-card">
            <div class="auth-card-header">
                <h1>Login</h1>
                <p>Sign in to your account</p>
            </div>

            <?php if(isset($_REQUEST['message']) && $_GET['message'] == '1'): ?>
            <div class="auth-alert auth-alert-error">
                Invalid username or password. Please try again.
            </div>
            <?php endif; ?>
            <?php if(isset($_REQUEST['message']) && $_GET['message'] === 'banned'): ?>
            <div class="auth-alert auth-alert-error">
                Your account has been banned. Contact support if you believe this is an error.
            </div>
            <?php endif; ?>

            <form method="post" action="login_process.php" class="auth-form">
                <div class="auth-field">
                    <label for="username">Username</label>
                    <span class="auth-input-wrap">
                        <input id="username" type="text" name="username" placeholder="Enter your username" autocomplete="username" required>
                    </span>
                </div>
                <div class="auth-field">
                    <label for="password">Password</label>
                    <span class="auth-input-wrap">
                        <input id="password" type="password" name="password" placeholder="Enter your password" autocomplete="current-password" required>
                    </span>
                </div>
                <button type="submit" name="submit" class="auth-submit">
                    <span class="auth-submit-text">Sign in</span>
                    <span class="auth-submit-arrow">→</span>
                </button>
                <p class="auth-switch">
                    Don't have an account? <a href="signup.php">Create account</a>
                </p>
            </form>
        </div>
    </div>

    <?php include 'footer.php' ?>
</body>
</html>
