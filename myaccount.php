<?php
session_start();
include 'connect_database.php'; 

// Check if the user is logged in
if (!isset($_SESSION['customer']) || empty($_SESSION['customer'])) {
    header('location:login.php');
    exit(); // Stop execution if user is not logged in
}

// Fetch user details from the database (assuming the session holds the user ID)
$user_id = $_SESSION['customer'];  // Assuming the customer ID is stored in the session

$sql = "SELECT * FROM user WHERE id = ?";  // Assuming 'users' is the table where the user details are stored
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

// Check if account details are already filled
$details_filled = !empty($user['first_name']) && !empty($user['last_name']) && !empty($user['contact_number']) && !empty($user['address']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Details</title>
    <link rel="stylesheet" href="./styles/myaccount.css">
</head>

<body>
    <?php include 'navigation.php'; ?>

    <section class="account">
        <h1 style='margin:40px 0'>
            <?php 
            if (isset($_SESSION['update'])) {
                echo $_SESSION['update'];
            }
            ?>
        </h1>

        <div class="address-details">
            <?php if ($details_filled): ?>
                <!-- Display user details if already filled -->
                <h3>Your Account Details</h3>
                <p><strong>First Name:</strong> <?php echo $user['first_name']; ?></p>
                <p><strong>Last Name:</strong> <?php echo $user['last_name']; ?></p>
                <p><strong>Phone:</strong> <?php echo $user['contact_number']; ?></p>
                <p><strong>Address:</strong> <?php echo $user['address']; ?></p>
                <p><strong>City:</strong> <?php echo $user['city']; ?></p>
                <p><strong>State:</strong> <?php echo $user['state']; ?></p>
                <p><strong>Country:</strong> <?php echo $user['country']; ?></p>
                <p><strong>Zip Code:</strong> <?php echo $user['zip_code']; ?></p>

                <!-- Button to allow user to update details -->
                <a href="myaccount.php?edit=true" style="padding: 10px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">Edit Details</a>

            <?php else: ?>
                <!-- Show form to update details if not filled -->
                <h3>Fill in Your Details</h3>
                <form method="post" action="register_user.php">
                    <ul class="flex-outer">
                        <li>
                            <label for="first-name">First Name</label>
                            <input type="text" id="first-name" name="first_name" placeholder="Enter your first name here" required>
                        </li>
                        <li>
                            <label for="last-name">Last Name</label>
                            <input type="text" id="last-name" name="last_name" placeholder="Enter your last name here" required>
                        </li>
                        <li>
                            <label for="phone">Contact Number</label>
                            <input type="text" id="phone" name="contact_number" placeholder="Enter your phone number here" required>
                        </li>
                        <li>
                            <label for="address">Address</label>
                            <textarea rows="6" id="address" name="address" placeholder="Enter your address here" required></textarea>
                        </li>
                        <li>
                            <label for="city">City</label>
                            <input type="text" id="city" name="city" placeholder="Enter your City" required>
                        </li>
                        <li>
                            <label for="state">State</label>
                            <input type="text" id="state" name="state" placeholder="Enter your State" required>
                        </li>
                        <li>
                            <label for="country">Country</label>
                            <input type="text" id="country" name="country" placeholder="Enter your country" required>
                        </li>
                        <li>
                            <label for="zip-code">Zip code</label>
                            <input type="text" id="zip-code" name="zip-code" placeholder="Enter your Zip Code" required>
                        </li>
                        <li>
                            <input type="submit" id="submit_button" name="submit" value="Update details">
                        </li>
                    </ul>
                </form>
            <?php endif; ?>
        </div>
    </section>

    <?php include 'footer.php'; ?>
</body>
</html>
