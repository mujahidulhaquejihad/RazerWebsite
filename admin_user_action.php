<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

include 'connect_database.php';

$action = isset($_POST['action']) ? trim($_POST['action']) : '';
$email  = isset($_POST['email'])  ? trim($_POST['email'])  : '';

if ($email === '' || !in_array($action, ['ban', 'unban', 'delete'], true)) {
    header("Location: manage_users.php?error=invalid");
    exit();
}

$email = mysqli_real_escape_string($database, $email);

if ($action === 'ban') {
    mysqli_query($database, "UPDATE user SET banned = 1 WHERE email = '$email'");
    header("Location: manage_users.php?msg=banned");
    exit();
}

if ($action === 'unban') {
    mysqli_query($database, "UPDATE user SET banned = 0 WHERE email = '$email'");
    header("Location: manage_users.php?msg=unbanned");
    exit();
}

if ($action === 'delete') {
    mysqli_query($database, "DELETE FROM user_data WHERE user_id = '$email'");
    mysqli_query($database, "DELETE FROM user WHERE email = '$email'");
    header("Location: manage_users.php?msg=deleted");
    exit();
}
