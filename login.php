<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./styles/login.css">
</head>

<body>
    <?php include 'navigation.php'; ?>

    <div id="login-main">
        <h1>LOGIN</h1>

        <!-- Show login error message if login fails -->
        <?php
        if (isset($_GET['message']) && $_GET['message'] == '1') {
            echo '<div class="error-message">Invalid credentials. Please try again.</div>';
        }
        ?>

        <!-- Login Form -->
        <form method="post" action="login_process.php">
            <label for="username">Username</label>
            <input id="username" type="text" name="username" required><br><br>

            <label for="password">Password</label>
            <input id="password" type="password" name="password" required><br><br>

            <input id="button" type="submit" name="submit" value="Login"><br><br>

            <a href="signup.php">Click to Sign Up</a><br><br>
        </form>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>
