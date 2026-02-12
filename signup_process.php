<?php
include 'connect_database.php';
session_start();

if (!isset($_POST['submit'])) {
    header('Location: signup.php');
    exit;
}

$email    = isset($_POST['user_name']) ? trim($_POST['user_name']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$confirm  = isset($_POST['confirm-password']) ? $_POST['confirm-password'] : '';
$firstname = isset($_POST['first_name']) ? trim($_POST['first_name']) : '';
$lastname  = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';
$mobile    = isset($_POST['mobile']) ? trim($_POST['mobile']) : '';
$address   = isset($_POST['address']) ? trim($_POST['address']) : '';
$city      = isset($_POST['city']) ? trim($_POST['city']) : '';
$state     = isset($_POST['state']) ? trim($_POST['state']) : '';
$country   = isset($_POST['country']) ? trim($_POST['country']) : '';
$zip_code  = isset($_POST['zip_code']) ? trim($_POST['zip_code']) : '';

$_SESSION['email_error'] = '';
$_SESSION['password_error'] = '';
$_SESSION['pass_length_error'] = '';
$_SESSION['error_message'] = '';

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['email_error'] = 'Invalid email address.';
    header('Location: signup.php');
    exit;
}
if (strlen($password) < 8) {
    $_SESSION['pass_length_error'] = 'Password must be at least 8 characters.';
    header('Location: signup.php');
    exit;
}
if ($password !== $confirm) {
    $_SESSION['password_error'] = 'Passwords do not match.';
    header('Location: signup.php');
    exit;
}

$email_esc = mysqli_real_escape_string($database, $email);
$check = mysqli_query($database, "SELECT id FROM user WHERE email = '$email_esc' LIMIT 1");
if ($check && mysqli_fetch_assoc($check)) {
    $_SESSION['error_message'] = 'An account with this email already exists.';
    header('Location: signup.php');
    exit;
}

$password_hash = password_hash($password, PASSWORD_DEFAULT);
$password_esc = mysqli_real_escape_string($database, $password_hash);

$sql = "INSERT INTO user (email, password) VALUES ('$email_esc', '$password_esc')";
if (!mysqli_query($database, $sql)) {
    $_SESSION['error_message'] = 'Registration failed. Please try again.';
    header('Location: signup.php');
    exit;
}

$user_id_esc = $email_esc;
$fn = mysqli_real_escape_string($database, $firstname);
$ln = mysqli_real_escape_string($database, $lastname);
$addr = mysqli_real_escape_string($database, $address);
$city_esc = mysqli_real_escape_string($database, $city);
$state_esc = mysqli_real_escape_string($database, $state);
$country_esc = mysqli_real_escape_string($database, $country);
$zip_esc = mysqli_real_escape_string($database, $zip_code);
$mobile_esc = mysqli_real_escape_string($database, $mobile);

$sql_data = "INSERT INTO user_data (user_id, firstname, lastname, address, city, state, country, zip_code, `mobile-number`) 
             VALUES ('$user_id_esc', '$fn', '$ln', '$addr', '$city_esc', '$state_esc', '$country_esc', '$zip_esc', '$mobile_esc')";
mysqli_query($database, $sql_data);

$_SESSION['customer'] = $email;
header('Location: dashboard.php');
exit;
