

<?php
session_start(); // Start the session

// Check if the user is logged in, if not, redirect to the login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php"); // Redirect to login page if not logged in
    exit();  // Stop further execution
}

include('connect_database.php');  // Include the database connection

// Check if the connection was successful
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    // Sanitize and fetch the data from POST
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);

    // Validation
    if (empty($name) || empty($price) || empty($category)) {
        $_SESSION['message'] = "All fields are required.";
    } elseif (!is_numeric($price)) {
        $_SESSION['message'] = "Price must be a valid number.";
    } else {
        // Prepare the SQL query to insert into the products table (WITHOUT `id` as it is auto-increment)
        $sql_product = "INSERT INTO products (name, price, category) VALUES (?, ?, ?)";
        $stmt_product = mysqli_prepare($conn, $sql_product);

        // Bind parameters and execute the query
        if ($stmt_product) {
            mysqli_stmt_bind_param($stmt_product, "sds", $name, $price, $category);  // 's' for string, 'd' for double (price)

            if (mysqli_stmt_execute($stmt_product)) {
                $_SESSION['message'] = "New product added successfully to the products table.";

                // Insert into category-specific table based on the category
                if ($category == 'CPU') {
                    $sql_cpu = "INSERT INTO cpu (cpu_full_name, price) VALUES (?, ?)";
                    $stmt_cpu = mysqli_prepare($conn, $sql_cpu);
                    mysqli_stmt_bind_param($stmt_cpu, "sd", $name, $price); // Correctly binding parameters for CPU
                    if (mysqli_stmt_execute($stmt_cpu)) {
                        $_SESSION['message'] .= " CPU product added successfully.";
                    } else {
                        $_SESSION['message'] .= " Error adding CPU product: " . mysqli_error($conn);
                    }
                } elseif ($category == 'GPU') {
                    $sql_gpu = "INSERT INTO gpu (GPU_full_name, price) VALUES (?, ?)";
                    $stmt_gpu = mysqli_prepare($conn, $sql_gpu);
                    mysqli_stmt_bind_param($stmt_gpu, "sd", $name, $price); // Correctly binding parameters for GPU
                    if (mysqli_stmt_execute($stmt_gpu)) {
                        $_SESSION['message'] .= " GPU product added successfully.";
                    } else {
                        $_SESSION['message'] .= " Error adding GPU product: " . mysqli_error($conn);
                    }
                } elseif ($category == 'Casing') {
                    $sql_casing = "INSERT INTO casing (full_name, price) VALUES (?, ?)";
                    $stmt_casing = mysqli_prepare($conn, $sql_casing);
                    mysqli_stmt_bind_param($stmt_casing, "sd", $name, $price); // Correctly binding parameters for Casing
                    if (mysqli_stmt_execute($stmt_casing)) {
                        $_SESSION['message'] .= " Casing product added successfully.";
                    } else {
                        $_SESSION['message'] .= " Error adding Casing product: " . mysqli_error($conn);
                    }
                } elseif ($category == 'MOTHERBOARD') {
                    $sql_mb = "INSERT INTO motherboard (mb_full_name, price) VALUES (?, ?)";
                    $stmt_mb = mysqli_prepare($conn, $sql_mb);
                    mysqli_stmt_bind_param($stmt_mb, "sd", $name, $price); // Correctly binding parameters for Motherboard
                    if (mysqli_stmt_execute($stmt_mb)) {
                        $_SESSION['message'] .= " Motherboard product added successfully.";
                    } else {
                        $_SESSION['message'] .= " Error adding Motherboard product: " . mysqli_error($conn);
                    }
                } elseif ($category == 'PSU') {
                    $sql_psu = "INSERT INTO psu (ps_full_name, price) VALUES (?, ?)";
                    $stmt_psu = mysqli_prepare($conn, $sql_psu);
                    mysqli_stmt_bind_param($stmt_psu, "sd", $name, $price); // Correctly binding parameters for PSU
                    if (mysqli_stmt_execute($stmt_psu)) {
                        $_SESSION['message'] .= " PSU product added successfully.";
                    } else {
                        $_SESSION['message'] .= " Error adding PSU product: " . mysqli_error($conn);
                    }
                } elseif ($category == 'CPU Cooler') {
                    $sql_cpu_cooler = "INSERT INTO cpu_cooler (cooler_full_name, price) VALUES (?, ?)";
                    $stmt_cpu_cooler = mysqli_prepare($conn, $sql_cpu_cooler);
                    mysqli_stmt_bind_param($stmt_cpu_cooler, "sd", $name, $price); // Correctly binding parameters for CPU Cooler
                    if (mysqli_stmt_execute($stmt_cpu_cooler)) {
                        $_SESSION['message'] .= " CPU Cooler product added successfully.";
                    } else {
                        $_SESSION['message'] .= " Error adding CPU Cooler product: " . mysqli_error($conn);
                    }
                } elseif ($category == 'SSD') {
                    $sql_ssd = "INSERT INTO ssd (ssd_full_name, price) VALUES (?, ?)";
                    $stmt_ssd = mysqli_prepare($conn, $sql_ssd);
                    mysqli_stmt_bind_param($stmt_ssd, "sd", $name, $price); // Correctly binding parameters for SSD
                    if (mysqli_stmt_execute($stmt_ssd)) {
                        $_SESSION['message'] .= " SSD product added successfully.";
                    } else {
                        $_SESSION['message'] .= " Error adding SSD product: " . mysqli_error($conn);
                    }
                } elseif ($category == 'HDD') {
                    $sql_hdd = "INSERT INTO hdd (hdd_full_name, price) VALUES (?, ?)";
                    $stmt_hdd = mysqli_prepare($conn, $sql_hdd);
                    mysqli_stmt_bind_param($stmt_hdd, "sd", $name, $price); // Correctly binding parameters for HDD
                    if (mysqli_stmt_execute($stmt_hdd)) {
                        $_SESSION['message'] .= " HDD product added successfully.";
                    } else {
                        $_SESSION['message'] .= " Error adding HDD product: " . mysqli_error($conn);
                    }
                } elseif ($category == 'RAM') {
                    $sql_ram = "INSERT INTO ram (ram_full_name, price) VALUES (?, ?)";
                    $stmt_ram = mysqli_prepare($conn, $sql_ram);
                    mysqli_stmt_bind_param($stmt_ram, "sd", $name, $price); // Correctly binding parameters for RAM
                    if (mysqli_stmt_execute($stmt_ram)) {
                        $_SESSION['message'] .= " RAM product added successfully.";
                    } else {
                        $_SESSION['message'] .= " Error adding RAM product: " . mysqli_error($conn);
                    }
                }

            } else {
                $_SESSION['message'] = "Error adding product to the products table: " . mysqli_error($conn);
            }
        }
    }

    // Redirect to prevent form resubmission
    header("Location: manage_products.php");
    exit();
}





// Delete Product Logic
if (isset($_GET['delete_id'])) {
    $delete_id = mysqli_real_escape_string($conn, $_GET['delete_id']);
    
    // Prepare the SQL query to delete the product
    $sql = "DELETE FROM products WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    
    // Bind parameters and execute the query
    mysqli_stmt_bind_param($stmt, "i", $delete_id);
    
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = "Product deleted successfully.";
    } else {
        $_SESSION['message'] = "Error deleting product: " . mysqli_error($conn);
    }
}

// Fetch products based on selected category
$category_filter = isset($_GET['category']) ? $_GET['category'] : '';

// If a category is selected, filter by that category
if ($category_filter != '') {
    $sql = "SELECT * FROM products WHERE category = '$category_filter'";
} else {
    // If no category is selected, show all products
    $sql = "SELECT * FROM products";
}

$result = mysqli_query($conn, $sql);

// Debugging: Check if the query ran successfully
if (!$result) {
    die("Error executing query: " . mysqli_error($conn));  // If there's an error executing the query
}

// Check if we have any rows in the result
$products_found = mysqli_num_rows($result) > 0 ? true : false;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <!-- Adding Bootstrap CSS for better styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        table {
            margin-top: 30px;
        }
        .alert {
            margin-top: 20px;
        }
        .btn-danger {
            background-color: #e74c3c;
            border-color: #e74c3c;
        }
        .btn-danger:hover {
            background-color: #c0392b;
            border-color: #c0392b;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Manage Products</h1>

        <!-- Displaying message from session -->
        <?php
        if (isset($_SESSION['message'])) {
            echo "<div class='alert alert-info'>" . $_SESSION['message'] . "</div>";
            unset($_SESSION['message']);  // Clear the message after displaying
        }
        ?>
 <div class="mb-3">
            <a href="manage_coupons.php" class="btn btn-success">Manage Coupons</a>
        </div>

        <!-- Add Product Form -->
        <div class="card p-4">
            <h3>Add New Product</h3>
            <form action="manage_products.php" method="POST">
 
                <div class="mb-3">
                    <label for="name" class="form-label">Product Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" name="price" class="form-control" step="0.01" required>
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select name="category" class="form-control" required>
                        <option value="CPU">CPU</option>
                        <option value="GPU">GPU</option>
                        <option value="MOTHERBOARD">MOTHERBOARD</option>
                        <option value="PSU">PSU</option>
                        <option value="Casing">Casing</option>
                        <option value="RAM">RAM</option>
                        <option value="HDD">HDD</option>
                        <option value="SSD">SSD</option>
                        <option value="CPU Cooler">CPU Cooler</option>
                    </select>
                </div>
                <button type="submit" name="add_product" class="btn btn-primary">Add Product</button>
            </form>
        </div>

<?php
$category_filter = isset($_GET['category']) ? $_GET['category'] : '';

// Create the base query for filtering products
$sql = "SELECT * FROM products WHERE 1";

// Add category filter if selected
if ($category_filter != '') {
    $category_filter = mysqli_real_escape_string($conn, $category_filter);
    $sql .= " AND category = '$category_filter'";
}

// Execute the query
$result = mysqli_query($conn, $sql);

// Check if products were found
$products_found = mysqli_num_rows($result) > 0;

// Handle product deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // SQL query to delete the product
    $delete_sql = "DELETE FROM products WHERE id = $delete_id";
    if (mysqli_query($conn, $delete_sql)) {
        $_SESSION['message'] = "Product deleted successfully.";
        header("Location: manage_products.php");  // Redirect to refresh the page after deletion
        exit();
    } else {
        $_SESSION['message'] = "Error deleting product: " . mysqli_error($conn);
    }
}
?>

<<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            padding-top: 20px;
        }
        .container {
            max-width: 1200px;
        }
        .card {
            margin-top: 20px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .btn-danger {
            background-color: #e74c3c;
            border-color: #e74c3c;
        }
        .btn-danger:hover {
            background-color: #c0392b;
            border-color: #c0392b;
        }
        .btn-info {
            background-color: #3498db;
            border-color: #3498db;
        }
        .btn-info:hover {
            background-color: #2980b9;
            border-color: #2980b9;
        }
        .form-label {
            font-weight: bold;
        }
        .form-select {
            padding: 0.75rem;
            font-size: 1rem;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .table {
            margin-top: 30px;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f9f9f9;
        }
        .table-bordered {
            border: 1px solid #ddd;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #ddd;
        }
        .alert-info {
            background-color: #d9edf7;
            border-color: #bce8f1;
            color: #31708f;
            padding: 10px;
            border-radius: 5px;
            font-size: 1.1rem;
            margin-top: 20px;
        }
        .alert-info a {
            text-decoration: none;
            color: #31708f;
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Filter Products by Category -->
        <div class="card p-4">
            <h3>Filter Products</h3>
            <form action="manage_products.php" method="GET">
                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select name="category" class="form-select">
                        <option value="">All Categories</option>
                        <option value="CPU" <?php echo ($category_filter == 'CPU') ? 'selected' : ''; ?>>CPU</option>
                        <option value="GPU" <?php echo ($category_filter == 'GPU') ? 'selected' : ''; ?>>GPU</option>
                        <option value="MOTHERBOARD" <?php echo ($category_filter == 'MOTHERBOARD') ? 'selected' : ''; ?>>MOTHERBOARD</option>
                        <option value="PSU" <?php echo ($category_filter == 'PSU') ? 'selected' : ''; ?>>PSU</option>
                        <option value="Casing" <?php echo ($category_filter == 'Casing') ? 'selected' : ''; ?>>Casing</option>
                        <option value="RAM" <?php echo ($category_filter == 'RAM') ? 'selected' : ''; ?>>RAM</option>
                        <option value="SSD" <?php echo ($category_filter == 'SSD') ? 'selected' : ''; ?>>SSD</option>
                        <option value="HDD" <?php echo ($category_filter == 'HDD') ? 'selected' : ''; ?>>HDD</option>
                        <option value="CPU Cooler" <?php echo ($category_filter == 'CPU Cooler') ? 'selected' : ''; ?>>CPU Cooler</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-info">Filter</button>
            </form>
        </div>

        <!-- ৳ Table -->
        <div class="card p-4 mt-4">
            <h3>৳</h3>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($products_found) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td>" . $row['name'] . "</td>
                                    <td>" . $row['price'] . "</td>
                                    <td>" . $row['category'] . "</td>
                                    <td><a href='manage_products.php?delete_id=" . $row['id'] . "' class='btn btn-danger btn-sm'>Delete</a></td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>No products found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
