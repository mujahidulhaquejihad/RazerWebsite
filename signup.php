<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up | PC Builder</title>
    <link rel="stylesheet" href="./styles/signup.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body class="auth-body">
    <?php include 'navigation.php' ?>

    <div class="auth-page">
        <div class="auth-card">
            <div class="auth-card-header">
                <h1>Create account</h1>
                <p>Sign up to build and save your custom PC</p>
            </div>

            <?php if(!empty($_SESSION['error_message'])): ?>
            <div class="auth-alert auth-alert-error">
                <?php echo htmlspecialchars($_SESSION['error_message']); unset($_SESSION['error_message']); ?>
            </div>
            <?php endif; ?>

            <?php if(!empty($_SESSION['email_error']) || !empty($_SESSION['password_error']) || !empty($_SESSION['pass_length_error'])): ?>
            <div class="auth-alert auth-alert-error">
                <?php
                if(!empty($_SESSION['email_error'])) { echo htmlspecialchars($_SESSION['email_error']); unset($_SESSION['email_error']); }
                if(!empty($_SESSION['password_error'])) { echo '<br>'.htmlspecialchars($_SESSION['password_error']); unset($_SESSION['password_error']); }
                if(!empty($_SESSION['pass_length_error'])) { echo '<br>'.htmlspecialchars($_SESSION['pass_length_error']); unset($_SESSION['pass_length_error']); }
                ?>
            </div>
            <?php endif; ?>

            <form method="post" action="signup_process.php" class="auth-form">
                <div class="auth-row">
                    <div class="auth-field">
                        <label for="first_name">First name</label>
                        <span class="auth-input-wrap">
                            <input id="first_name" type="text" name="first_name" placeholder="John" autocomplete="given-name" required>
                        </span>
                    </div>
                    <div class="auth-field">
                        <label for="last_name">Last name</label>
                        <span class="auth-input-wrap">
                            <input id="last_name" type="text" name="last_name" placeholder="Doe" autocomplete="family-name" required>
                        </span>
                    </div>
                </div>
                <div class="auth-field">
                    <label for="user_name">Email</label>
                    <span class="auth-input-wrap">
                        <input id="user_name" type="email" name="user_name" placeholder="you@example.com" autocomplete="email" required>
                    </span>
                </div>
                <div class="auth-field">
                    <label for="mobile">Phone number</label>
                    <span class="auth-input-wrap">
                        <input id="mobile" type="tel" name="mobile" placeholder="+1 234 567 8900" autocomplete="tel" required>
                    </span>
                </div>
                <div class="auth-field">
                    <label for="address">Address</label>
                    <span class="auth-input-wrap">
                        <input id="address" type="text" name="address" placeholder="Street, building, apt" autocomplete="street-address" required>
                    </span>
                </div>
                <div class="auth-row">
                    <div class="auth-field">
                        <label for="city">City</label>
                        <span class="auth-input-wrap">
                            <input id="city" type="text" name="city" placeholder="City" autocomplete="address-level2" required>
                        </span>
                    </div>
                    <div class="auth-field">
                        <label for="state">State</label>
                        <span class="auth-input-wrap">
                            <input id="state" type="text" name="state" placeholder="State" autocomplete="address-level1" required>
                        </span>
                    </div>
                </div>
                <div class="auth-row">
                    <div class="auth-field">
                        <label for="country">Country</label>
                        <span class="auth-input-wrap">
                            <input id="country" type="text" name="country" placeholder="Country" autocomplete="country-name" required>
                        </span>
                    </div>
                    <div class="auth-field">
                        <label for="zip_code">Zip code</label>
                        <span class="auth-input-wrap">
                            <input id="zip_code" type="text" name="zip_code" placeholder="12345" autocomplete="postal-code" required>
                        </span>
                    </div>
                </div>
                <div class="auth-field">
                    <label for="password">Password</label>
                    <span class="auth-input-wrap">
                        <input id="password" type="password" name="password" placeholder="At least 8 characters" autocomplete="new-password" required>
                    </span>
                </div>
                <div class="auth-field">
                    <label for="confirm-password">Confirm password</label>
                    <span class="auth-input-wrap">
                        <input id="confirm-password" type="password" name="confirm-password" placeholder="Re-enter password" autocomplete="new-password" required>
                    </span>
                </div>
                <button type="submit" name="submit" class="auth-submit">Create account</button>
                <p class="auth-switch">
                    Already have an account? <a href="login.php">Sign in</a>
                </p>
            </form>
        </div>
    </div>

    <?php include 'footer.php' ?>
</body>
</html>
