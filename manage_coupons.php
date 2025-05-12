<?php
session_start();

// Check if the user is logged in, if not, redirect to the login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php"); // Redirect to login page if not logged in
    exit();
}

include('connect_database.php');  // Include the database connection

// Check if the connection was successful
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Add Coupon Logic
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_coupon'])) {
    $coupon_code = mysqli_real_escape_string($conn, $_POST['coupon_code']);
    $discount = mysqli_real_escape_string($conn, $_POST['discount']);
    $expiry_date = mysqli_real_escape_string($conn, $_POST['expiry_date']);

    if (empty($coupon_code) || empty($discount) || empty($expiry_date)) {
        $_SESSION['message'] = "All fields are required.";
    } elseif (!is_numeric($discount)) {
        $_SESSION['message'] = "Discount must be a valid number.";
    } else {
        // Prepare the SQL query to insert into the coupons table
        $sql_coupon = "INSERT INTO coupons (coupon_code, discount, expiry_date) VALUES (?, ?, ?)";
        $stmt_coupon = mysqli_prepare($conn, $sql_coupon);

        if ($stmt_coupon) {
            mysqli_stmt_bind_param($stmt_coupon, "sds", $coupon_code, $discount, $expiry_date);

            if (mysqli_stmt_execute($stmt_coupon)) {
                $_SESSION['message'] = "Coupon added successfully.";
            } else {
                $_SESSION['message'] = "Error adding coupon: " . mysqli_error($conn);
            }
        }
    }
}

// Delete Coupon Logic
if (isset($_GET['delete_coupon_id'])) {
    $delete_coupon_id = mysqli_real_escape_string($conn, $_GET['delete_coupon_id']);
    $sql_delete_coupon = "DELETE FROM coupons WHERE id = ?";
    $stmt_delete_coupon = mysqli_prepare($conn, $sql_delete_coupon);

    if ($stmt_delete_coupon) {
        mysqli_stmt_bind_param($stmt_delete_coupon, "i", $delete_coupon_id);
        if (mysqli_stmt_execute($stmt_delete_coupon)) {
            $_SESSION['message'] = "Coupon deleted successfully.";
        } else {
            $_SESSION['message'] = "Error deleting coupon: " . mysqli_error($conn);
        }
    }
}

// Fetch all coupons
$sql = "SELECT * FROM coupons";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Coupons</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center">Manage Coupons</h1>

    <!-- Displaying message from session -->
    <?php
    if (isset($_SESSION['message'])) {
        echo "<div class='alert alert-info'>" . $_SESSION['message'] . "</div>";
        unset($_SESSION['message']);  // Clear the message after displaying
    }
    ?>

    <!-- Add Coupon Form -->
    <div class="card p-4">
        <h3>Add New Coupon</h3>
        <form action="manage_coupons.php" method="POST">
            <div class="mb-3">
                <label for="coupon_code" class="form-label">Coupon Code</label>
                <input type="text" name="coupon_code" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="discount" class="form-label">Discount (%)</label>
                <input type="number" name="discount" class="form-control" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="expiry_date" class="form-label">Expiry Date</label>
                <input type="date" name="expiry_date" class="form-control" required>
            </div>
            <button type="submit" name="add_coupon" class="btn btn-primary">Add Coupon</button>
        </form>
    </div>

    <!-- Display all coupons -->
    <div class="card p-4 mt-4">
        <h3>Existing Coupons</h3>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Coupon Code</th>
                    <th>Discount</th>
                    <th>Expiry Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                                <td>" . $row['id'] . "</td>
                                <td>" . $row['coupon_code'] . "</td>
                                <td>" . $row['discount'] . "%</td>
                                <td>" . $row['expiry_date'] . "</td>
                                <td><a href='manage_coupons.php?delete_coupon_id=" . $row['id'] . "' class='btn btn-danger btn-sm'>Delete</a></td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>No coupons found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
