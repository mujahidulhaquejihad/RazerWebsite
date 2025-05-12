<?php
session_start(); 

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] == true) {
    header("Location: admin_dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo "<pre>";
    print_r($_POST); // Print the POST data for debugging
    echo "</pre>";

    $admin_username = 'admin';
    $admin_password = 'password123';  // Ideally, store a hashed password in a database

    // Validate the submitted username and password
    if ($_POST['username'] == $admin_username && $_POST['password'] == $admin_password) {
        $_SESSION['admin_logged_in'] = true;  // Set the session variable
        header("Location: admin_dashboard.php");  // Redirect to the dashboard
        exit();
    } else {
        $error_message = "Invalid Username or Password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="styles/admin_login.css"> 
 
</head>
<body>

    <div class="login-container">
        <h2>Admin Login</h2>

        <!-- Display error message if login failed -->
        <?php
        if (isset($error_message)) {
            echo "<div class='error-message'>$error_message</div>";
        }
        ?>

        <!-- Login form -->
        <form action="admin_login.php" method="POST">
            <input type="text" name="username" class="input-field" placeholder="Username" required>
            <input type="password" name="password" class="input-field" placeholder="Password" required>
            <button type="submit" class="btn">Login</button>
        </form>
    </div>

</body>
</html>
