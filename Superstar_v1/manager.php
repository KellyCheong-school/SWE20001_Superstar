<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="This is the payment page for AeroStar.">
    <meta name="keywords" content="AeroStar, Payment">
    <meta name="author" content="Jason Tan">
    <title>Manager Page</title>
    <link href="images/AeroStarLogo-Header.jpg" rel="icon">

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css?family=Open+Sans:400,700,800');
        @import url('https://fonts.googleapis.com/css?family=Lobster');

        body {
            font-family: 'Open Sans', sans-serif;
        }
    </style>
</head>

<body>
    <?php
    require_once('settings.php');
    session_start();

    // Establish a database connection
    $conn = @mysqli_connect($host, $user, $pwd, $sql_db);

    // Check if the connection is successful
    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }
    // Check if the manager is not logged in
    if (!isset($_SESSION['manager_id']) || !isset($_SESSION['manager_username'])) {
        // Redirect to the manager login page
        header("Location: manager_login.php");
        exit();
    }
    // Check if the user is logged in
    if (isset($_SESSION['manager_id'])) {
        // The user is logged in, retrieve the username from the session
        $userId = $_SESSION['manager_id'];
        $username = $_SESSION['manager_username'];
    } else {
        // Redirect the user to the login page if not logged in
        header("Location: index.php");
        exit();
    }
    $queryUser = mysqli_query($conn, "SELECT username FROM managers WHERE id = $userId");
    $userData = mysqli_fetch_assoc($queryUser);
    $username = $userData['username'];
    include 'includes/Managerheader.inc'; ?>
    <br><br><br><br>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center mb-5">
                <h2 class="heading-section">Manager Page</h2>
            </div>
        </div>
        <?php if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_POST['query'])) { ?>
            <p>Please select a query option and submit the form to view the orders.</p>
        <?php } ?>
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-6">
                <div class="login-wrap p-0">
                    <form action="manager.php" method="POST" class="mb-4">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="query">Select Query:</label>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <select name="query" id="query" style="font-size: 11pt;"
                                            class="form-control form-control-lg">
                                            <option value="all" style="color:black;" <?php if (isset($_POST['query']) && $_POST['query'] === 'all')
                                                echo 'selected'; ?>>All
                                                Orders</option>
                                            <option value="customer" style="color:black;" <?php if (isset($_POST['query']) && $_POST['query'] === 'customer')
                                                echo 'selected'; ?>>Orders by Customer
                                            </option>
                                            <option value="product" style="color:black;" <?php if (isset($_POST['query']) && $_POST['query'] === 'product')
                                                echo 'selected'; ?>>Orders by Product
                                            </option>
                                            <option value="pending" style="color:black;" <?php if (isset($_POST['query']) && $_POST['query'] === 'pending')
                                                echo 'selected'; ?>>Pending Orders</option>
                                            <option value="cost" style="color:black;" <?php if (isset($_POST['query']) && $_POST['query'] === 'cost')
                                                echo 'selected'; ?>>
                                                Orders by Total Cost</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php if (isset($_POST['query']) && ($_POST['query'] === 'customer' || $_POST['query'] === 'product')) { ?>
                            <div class="form-group">
                                <input type="text" class="form-control" name="value" style="font-size: 11pt;"
                                    placeholder="Enter customer name or product"
                                    value="<?php echo isset($_POST['value']) ? $_POST['value'] : ''; ?>">
                            </div>

                        <?php } ?>
                        <button type="submit" class="form-control btn btn-primary submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Add a row element for the order table -->
        <div class="row">
            <!-- Add a column element for the order table -->
            <div class="col-md-12">
                <?php

                // Function to display order information in an HTML table
                function displayOrderInformation($orders)
                {
                    echo "<table class='table table-striped table-bordered' style='color:#fff;'>";
                    echo "<tr>
                            <th>Order Number</th>
                            <th>Order Date</th>
                            <th>Product Details</th>
                            <th>Product Cost</th>
                            <th>Customer Name</th>
                            <th>Order Status</th>
                            <th>Action</th>
                            </tr>";

                    while ($row = mysqli_fetch_assoc($orders)) {
                        echo "<tr>";
                        echo "<td>" . $row['order_id'] . "</td>";
                        echo "<td>" . $row['order_time'] . "</td>";
                        echo "<td>" . $row['flight'] . " (" . $row['cabin'] . ")
                <br>Departure Date: " . $row['departureDate'] . "
                <br>Return Date: " . $row['returnDate'] . "
                <br>Optional Features: " . $row['features'] . "
                <br>Ticket Quantity: " . $row['numTickets'] . "</td>";
                        echo "<td>RM" . $row['order_cost'] . "</td>";
                        echo "<td>" . $row['firstname'] . " " . $row['lastname'] . "</td>";
                        echo "<td>" . $row['order_status'] . "</td>";
                        echo "<td>";
                        if ($row['order_status'] === 'Pending') {
                            echo "<form action='manager.php' method='POST'>";
                            echo "<input type='hidden' name='order_id' value='" . $row['order_id'] . "'>";
                            echo "<input type='hidden' name='action' value='cancel'>";
                            echo "<input type='submit' value='Cancel'>";
                            echo "</form>";
                        }
                        echo "<form action='manager.php' method='POST'>";
                        echo "<input type='hidden' name='order_id' value='" . $row['order_id'] . "'>";
                        echo "<select name='status'>";
                        echo "<option value='Pending' " . ($row['order_status'] === 'Pending' ? 'selected' : '') . ">Pending</option>";
                        echo "<option value='Fulfilled' " . ($row['order_status'] === 'Fulfilled' ? 'selected' : '') . ">Fulfilled</option>";
                        echo "<option value='Paid' " . ($row['order_status'] === 'Paid' ? 'selected' : '') . ">Paid</option>";
                        echo "<option value='Archived' " . ($row['order_status'] === 'Archived' ? 'selected' : '') . ">Archived</option>";
                        echo "</select>";
                        echo "<input type='hidden' name='action' value='update'>";
                        echo "<input type='submit' value='Update'>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }

                    echo "</table>";
                }

                // Display the manager reports
                function displayManagerReports($conn)
                {
                    // Most popular product ordered
                    $popularProductQuery = "SELECT flight, cabin, COUNT(*) AS order_count FROM orders GROUP BY flight, cabin ORDER BY order_count DESC LIMIT 1";
                    $popularProductResult = mysqli_query($conn, $popularProductQuery);
                    $popularProduct = mysqli_fetch_assoc($popularProductResult);

                    echo "<hr><h2 id='report' style='color:#fff'><strong>Manager Reports</strong></h2>";
                    echo "<h3 style='color:#fff'>Most Popular Product Ordered</h3>";
                    if ($popularProduct) {
                        echo "<p>The most popular product ordered is <strong>" . $popularProduct['flight'] . " (" . $popularProduct['cabin'] . ")</strong> with " . $popularProduct['order_count'] . " orders.</p><br>";
                    } else {
                        echo "<p>No orders found.</p>";
                    }

                    // Fulfilled orders purchased between two dates
                    echo "<hr><h3 style='color:#fff'>Fulfilled Orders Purchased Between Two Dates</h3><br>";
                    echo
                        '<div class="row justify-content-center">' .
                        '<div class="col-md-6 col-lg-6">' . '
                            <div class="login-wrap p-0">' . '
                                <form action="manager.php" class="signin-form" method="POST">' . '
                                    <div class="row">' . '
                                        <div class="col-md-6">' . '
                                            <div class="form-group">' . '
                                            <label for="from_date">From:</label>' . '
                                                <input style="font-size: 11pt;" type="date" name="from_date" id="from_date" class="form-control" placeholder="From:" required>' . '
                                            </div>' . '
                                        </div>' . '
                                        <div class="col-md-6">' . '
                                            <div class="form-group">' . '
                                            <label for="from_date">To:</label>' . '
                                                <input style="font-size: 11pt;" type="date" name="to_date" id="to_date" class="form-control" placeholder="To:" required>' . '
                                            </div>' . '
                                        </div>' . '
                                    </div>' . '
                                    <div class="form-group">' . '
                                                </div>' . '
                                <button type="submit" class="form-control btn btn-primary submit px-3">Generate Report</button>' . '
                                </form><br>' . '
                            </div>' . '
                        </div>' . '
                    </div>';

                    if (isset($_POST['from_date']) && isset($_POST['to_date'])) {
                        $fromDate = $_POST['from_date'];
                        $toDate = $_POST['to_date'];

                        $fulfilledOrdersQuery = "SELECT * FROM orders WHERE order_status = 'Fulfilled' AND DATE(order_time) BETWEEN '$fromDate' AND '$toDate'";

                        $fulfilledOrdersResult = mysqli_query($conn, $fulfilledOrdersQuery);

                        if ($fulfilledOrdersResult && mysqli_num_rows($fulfilledOrdersResult) > 0) {
                            echo "<p>Fulfilled orders between $fromDate and $toDate:</p>";
                            echo "<table class='table table-striped table-bordered'>";
                            echo "<tr>";
                            echo "<th>Order ID</th>";
                            echo "<th>Order Time</th>";
                            echo "<th>Product</th>";
                            echo "<th>Order Cost</th>";
                            echo "<th>Customer</th>";
                            echo "<th>Status</th>";
                            echo "</tr>";

                            while ($row = mysqli_fetch_assoc($fulfilledOrdersResult)) {
                                echo "<tr>";
                                echo "<td>" . $row['order_id'] . "</td>";
                                echo "<td>" . $row['order_time'] . "</td>";
                                echo "<td>" . $row['flight'] . " (" . $row['cabin'] . ")
                        <br>Departure Date: " . $row['departureDate'] . "
                        <br>Return Date: " . $row['returnDate'] . "
                        <br>Optional Features: " . $row['features'] . "
                        <br>Ticket Quantity: " . $row['numTickets'] . "</td>";
                                echo "<td>RM" . $row['order_cost'] . "</td>";
                                echo "<td>" . $row['firstname'] . " " . $row['lastname'] . "</td>";
                                echo "<td>" . $row['order_status'] . "</td>";
                                echo "</tr>";
                            }

                            echo "</table>";
                        } else {
                            echo "<p>No fulfilled orders found between $fromDate and $toDate.</p>";
                        }
                    }

                    // Average number of orders per day
                    $averageOrdersQuery = "SELECT COUNT(*) as total_orders, DATE(order_time) as order_date FROM orders GROUP BY DATE(order_time)";
                    $averageOrdersResult = mysqli_query($conn, $averageOrdersQuery);
                    $totalDays = mysqli_num_rows($averageOrdersResult);

                    if ($totalDays > 0) {
                        $totalOrders = 0;

                        while ($row = mysqli_fetch_assoc($averageOrdersResult)) {
                            $totalOrders += $row['total_orders'];
                        }

                        $averageOrdersPerDay = $totalOrders / $totalDays;

                        echo "<hr><h3 style='color:#fff'>Average Number of Orders Per Day</h3>";
                        echo "<p>The average number of orders per day is <strong>" . number_format($averageOrdersPerDay, 2) . "</strong>.</p><br>";
                    } else {
                        echo "<h3 style='color:#fff'>Average Number of Orders Per Day</h3>";
                        echo "<p>No orders found.</p><br>";
                    }
                }

                // Handle form submissions or user actions
                if ($_SERVER["REQUEST_METHOD"] === "POST") {
                    // Check if the form is submitted to update the order status
                    if (isset($_POST['order_id']) && isset($_POST['status']) && isset($_POST['action'])) {
                        $order_id = $_POST['order_id'];
                        $status = $_POST['status'];
                        $action = $_POST['action'];

                        // Update the order status in the database
                        $updateQuery = "UPDATE orders SET order_status = '$status' WHERE order_id = '$order_id'";
                        $updateResult = mysqli_query($conn, $updateQuery);

                        if ($updateResult) {
                            echo "Order status updated successfully.";
                        } else {
                            echo "Error updating order status: " . mysqli_error($conn);
                        }
                    }

                    // Check if the form is submitted to cancel the order
                    if (isset($_POST['order_id']) && isset($_POST['action']) && $_POST['action'] === 'cancel') {
                        $order_id = $_POST['order_id'];

                        // Delete the order from the database
                        $deleteQuery = "DELETE FROM orders WHERE order_id = '$order_id'";
                        $deleteResult = mysqli_query($conn, $deleteQuery);

                        if ($deleteResult) {
                            echo "Order canceled successfully.";
                        } else {
                            echo "Error canceling order: " . mysqli_error($conn);
                        }
                    }
                }

                // Retrieve order information from the database based on the selected query
                if (isset($_POST['query'])) {
                    $query = "SELECT * FROM orders";
                    $value = isset($_POST['value']) ? $_POST['value'] : '';

                    switch ($_POST['query']) {
                        case 'all':
                            $query = "SELECT * FROM orders ORDER BY order_id ASC";
                            break;
                        case 'customer':
                            $query = "SELECT * FROM orders WHERE firstname LIKE '%$value%' OR lastname LIKE '%$value%'";
                            break;
                        case 'product':
                            $query = "SELECT * FROM orders WHERE flight LIKE '%$value%' OR cabin LIKE '%$value%'";
                            break;
                        case 'pending':
                            $query = "SELECT * FROM orders WHERE order_status = 'Pending'";
                            break;
                        case 'cost':
                            $query = "SELECT * FROM orders ORDER BY order_cost";
                            break;
                        default:
                            break;
                    }

                    $result = mysqli_query($conn, $query);

                    if ($result) {
                        // Display the order information in an HTML table
                        displayOrderInformation($result);
                    } else {
                        echo "Error retrieving order information: " . mysqli_error($conn);
                    }
                }

                // Display the manager reports
                displayManagerReports($conn);

                // Close the database connection
                mysqli_close($conn);
                ?>
            </div>
        </div>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>