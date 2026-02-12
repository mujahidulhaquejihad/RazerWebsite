<?php
    if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<?php //check if already logged in
        if(!isset($_SESSION['customer']) || empty($_SESSION['customer']) )
        {
            header('location:login.php');
        }
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
    <?php 
    include 'navigation.php';
    include 'connect_database.php';
    $profile = [];
    $user_id = mysqli_real_escape_string($database, $_SESSION['customer']);
    $res = mysqli_query($database, "SELECT firstname, lastname, address, city, state, country, zip_code, `mobile-number` FROM user_data WHERE user_id = '$user_id' LIMIT 1");
    if ($res && $row = mysqli_fetch_assoc($res)) {
        $profile = $row;
    }
    ?>
    <section class="account">
        
        <p style="margin: 20px 0;"><a href="dashboard.php" style="color: rgba(54, 236, 78, 0.9);">← Dashboard</a></p>
        <h1 style='margin:40px 0'>
            <?php 
                if(isset($_SESSION['update'])) {
                    echo htmlspecialchars($_SESSION['update']);
                    unset($_SESSION['update']);
                } else {
                    echo 'Your profile';
                }
            ?>
        </h1>
        <p style="margin-bottom: 1rem; color: rgba(255,255,255,0.6);">Your saved details are shown below. Edit and save only when you need to update.</p>
        <div class="address-details">
            <form method='post' action="register_user.php">
                <ul class="flex-outer">
                    <li>
                        <label for="first-name">First Name</label>
                        <input type="text" id="first-name" name='first_name' placeholder="Enter your first name" value="<?php echo htmlspecialchars($profile['firstname'] ?? ''); ?>">
                    </li>
                    <li>
                        <label for="last-name">Last Name</label>
                        <input type="text" id="last-name" name='last_name' placeholder="Enter your last name" value="<?php echo htmlspecialchars($profile['lastname'] ?? ''); ?>">
                    </li>
                    
                    <li>
                        <label for="phone">Contact Number</label>
                        <input type="text" id="phone" name='contact_number' placeholder="Enter your phone number" value="<?php echo htmlspecialchars($profile['mobile-number'] ?? ''); ?>">
                    </li>
                    <li>
                        <label for="address">Address</label>
                        <textarea rows="6" id="address" name='address' placeholder="Enter your address"><?php echo htmlspecialchars($profile['address'] ?? ''); ?></textarea>
                    </li>
                    <li>
                        <label for="city">City</label>
                        <input type="text" id="city" name='city' placeholder="Enter your city" value="<?php echo htmlspecialchars($profile['city'] ?? ''); ?>">
                    </li>
                    <li>
                        <label for="state">State</label>
                        <input type="text" id="state" name='state' placeholder="Enter your state" value="<?php echo htmlspecialchars($profile['state'] ?? ''); ?>">
                    </li>
                    <li>
                        <label for="country">Country</label>
                        <input type="text" id="country" name='country' placeholder="Enter your country" value="<?php echo htmlspecialchars($profile['country'] ?? ''); ?>">
                    </li>
                    <li>
                        <label for="zip-code">Zip code</label>
                        <input type="text" id="zip-code" name='zip-code' placeholder="Enter your zip code" value="<?php echo htmlspecialchars($profile['zip_code'] ?? ''); ?>">
                    </li>
                    
                    <li>
                        <a href="dashboard.php" style="margin-right: 1rem;">Cancel</a>
                        <input type="submit" id='submit_button' name='submit' value="Save changes">
                    </li>
                </ul>
            </form>
        </div>
    </section>

    <?php include 'footer.php';?>
</body>
</html>