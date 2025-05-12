<?php
session_start(); 

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php"); 
    exit();  
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles/admin_dashboard.css"> 

</head>
<body>
    <div class="container">
        <h1>Welcome to the Admin Dashboard</h1>

        <ul>
            <li><a href="manage_products.php">Manage Products</a></li>
            <li><a href="admin_logout.php">Logout</a></li>
        </ul>

            </pre>
        </div>
    </div>
</body>
</html>
