<?php
session_start();
include('connect_database.php'); // Your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to check if the user exists and is an admin
    $query = "SELECT * FROM users WHERE username = :username AND role = 'admin'";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':username' => $username]);

    $user = $stmt->fetch();

    // If user exists and password matches
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        header('Location: admin_dashboard.php'); // Redirect to dashboard
    } else {
        echo "Invalid login credentials.";
    }
}
?>
