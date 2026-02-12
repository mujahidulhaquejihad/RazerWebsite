<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contact.php');
    exit;
}

$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

if ($name === '' || $email === '' || $phone === '' || $message === '') {
    header('Location: contact.php?error=1');
    exit;
}

include 'connect_database.php';

$name_esc = mysqli_real_escape_string($database, $name);
$email_esc = mysqli_real_escape_string($database, $email);
$phone_esc = mysqli_real_escape_string($database, $phone);
$message_esc = mysqli_real_escape_string($database, $message);

$sql = "INSERT INTO `contact_messages` (`name`, `email`, `phone`, `message`) VALUES ('$name_esc', '$email_esc', '$phone_esc', '$message_esc')";
if (mysqli_query($database, $sql)) {
    header('Location: contact.php?sent=1');
} else {
    header('Location: contact.php?error=1');
}
exit;
