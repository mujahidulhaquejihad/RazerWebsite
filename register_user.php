<?php
session_start();
include 'connect_database.php';

if (isset($_POST['submit'])) {
    // Get and sanitize all input fields
    $firstname = isset($_POST['first_name']) ? trim($_POST['first_name']) : '';
    $lastname = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';
    $contact = isset($_POST['contact_number']) ? trim($_POST['contact_number']) : '';
    $address = isset($_POST['address']) ? trim($_POST['address']) : '';
    $city = isset($_POST['city']) ? trim($_POST['city']) : '';
    $state = isset($_POST['state']) ? trim($_POST['state']) : '';
    $country = isset($_POST['country']) ? trim($_POST['country']) : '';
    $zipcode = isset($_POST['zip-code']) ? trim($_POST['zip-code']) : '';

    $user = $_SESSION['customer'];

    // Check if user already has data
    $search = "SELECT user_id FROM user_data WHERE user_id='$user'";
    $result = $conn->query($search);

    if ($result && $result->num_rows > 0) {
        // User already exists, so UPDATE instead of DELETE + INSERT
        $update = "UPDATE user_data 
                   SET firstname='$firstname', lastname='$lastname', address='$address', city='$city', state='$state', 
                       country='$country', zip_code='$zipcode', `mobile-number`='$contact'
                   WHERE user_id='$user'";

        if ($conn->query($update) === TRUE) {
            $_SESSION['update'] = 'Details updated successfully!';
            $_SESSION['updated_successfully'] = true;
            header('Location: myaccount.php');
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        // No existing record, do INSERT
        $insert = "INSERT INTO user_data (user_id, firstname, lastname, address, city, state, country, zip_code, `mobile-number`) 
                   VALUES ('$user', '$firstname', '$lastname', '$address', '$city', '$state', '$country', '$zipcode', '$contact')";

        if ($conn->query($insert) === TRUE) {
            $_SESSION['update'] = 'Details updated successfully!';
            $_SESSION['updated_successfully'] = true;
            header('Location: myaccount.php');
            exit();
        } else {
            echo "Error inserting record: " . $conn->error;
        }
    }
}
?>
