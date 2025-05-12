<?php
session_start();
include('connect_database.php');

$username = $_POST['username'];
$password = $_POST['password'];

$username = $conn->real_escape_string($username);
$password = $conn->real_escape_string($password);

$sql = "SELECT * FROM users WHERE username='$username' LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    if (password_verify($password, $row['password'])) {
        $_SESSION['admin'] = $username;  // Start a session for the admin
        header('Location: admin_dashboard.php');  
    } else {
        echo "Invalid password!";
    }
} else {
    echo "No user found with that username!";
}

$conn->close();
?>
