<?php 
session_start();
include 'connect_database.php';
 
if(isset($_POST['submit']))
{
    $username = mysqli_real_escape_string($database, $_POST['username']);
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM user WHERE email='$username' ";
    $result = mysqli_query($database, $sql);
    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        header('location:login.php?message=1');
        exit;
    }

    $dbStoredPASSWORD = $row['password'];
    $banned = isset($row['banned']) ? (int)$row['banned'] : 0;

    if ($banned) {
        header('location:login.php?message=banned');
        exit;
    }

    if (password_verify($password, $dbStoredPASSWORD)) {
        $_SESSION['customer'] = $username;
        header('location:dashboard.php');
    } else {
        header('location:login.php?message=1');
        $message = 'incorrect Credentials';
    }

}

?>