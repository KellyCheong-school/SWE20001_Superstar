<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="This is the payment page for AeroStar.">
    <meta name="keywords" content="AeroStar, Payment">
    <meta name="author" content="Jason Tan">
    <title>Manager Page</title>
    <link href="images/AeroStarLogo-Header.jpg" rel="icon">
    <link href="styles/style.css" rel="stylesheet">
    <link href="styles/manager.css" rel="stylesheet">
</head>

<body class="manager">
    <?php
    session_start();
    // Check if the manager is not logged in
    if (!isset($_SESSION['manager_id']) || !isset($_SESSION['manager_username'])) {
        // Redirect to the manager login page
        header("Location: manager_login.php");
        exit();
    }
    include 'includes/header.inc'; ?>
    <br><br>
    <h1>Manager Page</h1>
    <a href="manager_logout.php"><button>Logout</button></a><br>
    <form action="manager.php" method="POST">
        <label for="query">Select Query:</label>
        <select name="query" id="query">
            <option value="all" <?php if (isset($_POST['query']) && $_POST['query'] === 'all') echo 'selected'; ?>>All Orders</option>
            <option value="customer" <?php if (isset($_POST['query']) && $_POST['query'] === 'customer') echo 'selected'; ?>>Orders by Customer</option>
            <option value="product" <?php if (isset($_POST['query']) && $_POST['query'] === 'product') echo 'selected'; ?>>Orders by Product</option>
            <option value="pending" <?php if (isset($_POST['query']) && $_POST['query'] === 'pending') echo 'selected'; ?>>Pending Orders</option>
            <option value="cost" <?php if (isset($_POST['query']) && $_POST['query'] === 'cost') echo 'selected'; ?>>Orders by Total Cost</option>
        </select>

        <?php if (isset($_POST['query']) && ($_POST['query'] === 'customer' || $_POST['query'] === 'product')) { ?>
            <input type="text" name="value" placeholder="Enter customer name or product" value="<?php echo isset($_POST['value']) ? $_POST['value'] : ''; ?>">
        <?php } ?>

        <input type="submit" value="Submit">
    </form>

    <?php if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_POST['query'])) { ?>
        <p>Please select a query option and submit the form to view the orders.</p>
    <?php } ?>

    <div class="order-table-container">
        <?php
        require_once('settings.php');

        // Establish a database connection
        $conn = @mysqli_connect($host, $user, $pwd, $sql_db);

        // Check if the connection is successful
        if (!$conn) {
            die("Database connection failed: " . mysqli_connect_error());
        }

        // Function to display order information in an HTML table
        function displayOrderInformation($orders)
        {
            echo "<table class='order-table'>";
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

            echo "<hr><h2 id='report'>Manager Reports</h2>";
            echo "<h3>Most Popular Product Ordered</h3>";
            if ($popularProduct) {
                echo "<p>The most popular product ordered is " . $popularProduct['flight'] . " (" . $popularProduct['cabin'] . ") with " . $popularProduct['order_count'] . " orders.</p>";
            } else {
                echo "<p>No orders found.</p>";
            }

            // Fulfilled orders purchased between two dates
            echo "<hr><h3>Fulfilled Orders Purchased Between Two Dates</h3>";
            echo "<form action='manager.php' method='POST'>";
            echo "<label for='from_date'>From:</label>";
            echo "<input type='date' id='from_date' name='from_date'>";
            echo "<label for='to_date'>To:</label>";
            echo "<input type='date' id='to_date' name='to_date'>";
            echo "<br><input type='submit' value='Generate Report'>";
            echo "</form><hr>";

            if (isset($_POST['from_date']) && isset($_POST['to_date'])) {
                $fromDate = $_POST['from_date'];
                $toDate = $_POST['to_date'];

                $fulfilledOrdersQuery = "SELECT * FROM orders WHERE order_status = 'Fulfilled' AND DATE(order_time) BETWEEN '$fromDate' AND '$toDate'";

                $fulfilledOrdersResult = mysqli_query($conn, $fulfilledOrdersQuery);

                if ($fulfilledOrdersResult && mysqli_num_rows($fulfilledOrdersResult) > 0) {
                    echo "<p>Fulfilled orders between $fromDate and $toDate:</p>";
                    echo "<table class='order-table'>";
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

                echo "<h3>Average Number of Orders Per Day</h3>";
                echo "<p>The average number of orders per day is " . number_format($averageOrdersPerDay, 2) . ".</p>";
            } else {
                echo "<h3>Average Number of Orders Per Day</h3>";
                echo "<p>No orders found.</p>";
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
        include 'includes/footer.inc';
        ?>

    </div>

</body>

</html>