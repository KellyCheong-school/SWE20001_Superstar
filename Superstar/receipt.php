<?php
require_once('settings.php');

if (
    !isset($_SERVER['HTTP_REFERER']) ||
    (isset($_SERVER['HTTP_REFERER']) &&
        (strpos($_SERVER['HTTP_REFERER'], 'process_order.php') === false 
        && strpos($_SERVER['HTTP_REFERER'], 'fix_order.php') === false
        && strpos($_SERVER['HTTP_REFERER'], 'payment.php') === false)
    )
) {
    // Invalid access attempt
    header("Location: enquire.php");
    exit('Direct access to this page is not allowed.');
}

// Retrieve the order information from the database based on the order_id
if (isset($_GET['order_id'])) {
    $orderID = $_GET['order_id'];

    // Establish a database connection
    $conn = mysqli_connect($host, $user, $pwd, $sql_db);

    // Check if the connection is successful
    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    // Retrieve the order information from the table
    $query = "SELECT * FROM orders WHERE order_id = $orderID";
    $result = mysqli_query($conn, $query);

    // Check if the query execution was successful
    if ($result) {
        // Fetch the order data as an associative array
        $orderData = mysqli_fetch_assoc($result);

        // Check if the order exists
        if ($orderData) {
            // Display the order information
            echo "<h1>Order Receipt</h1>";
            echo "<table>";
            echo "<tr><td>Field</td><td>Value</td></tr>";
            echo "<tr><td>Order ID:</td><td>" . $orderData['order_id'] . "</td></tr>";
            echo "<tr><td>Order Status:</td><td>" . $orderData['order_status'] . "</td></tr>";
            echo "<tr><td>Order Cost:</td><td>RM" . $orderData['order_cost'] . "</td></tr>";
            echo "<tr><td>Order Time:</td><td>" . $orderData['order_time'] . "</td></tr>";
            echo "<tr><td>First Name:</td><td>" . $orderData['firstname'] . "</td></tr>";
            echo "<tr><td>Last Name:</td><td>" . $orderData['lastname'] . "</td></tr>";
            echo "<tr><td>Email:</td><td>" . $orderData['email'] . "</td></tr>";
            echo "<tr><td>Phone:</td><td>" . $orderData['phone'] . "</td></tr>";
            echo "<tr><td>Street:</td><td>" . $orderData['street'] . "</td></tr>";
            echo "<tr><td>Suburb:</td><td>" . $orderData['suburb'] . "</td></tr>";
            echo "<tr><td>State:</td><td>" . $orderData['state'] . "</td></tr>";
            echo "<tr><td>Postcode:</td><td>" . $orderData['postcode'] . "</td></tr>";
            echo "<tr><td>Contact:</td><td>" . $orderData['contact'] . "</td></tr>";
            echo "<tr><td>Departure Date:</td><td>" . $orderData['departureDate'] . "</td></tr>";
            echo "<tr><td>Return Date:</td><td>" . $orderData['returnDate'] . "</td></tr>";
            echo "<tr><td>Flight:</td><td>" . $orderData['flight'] . "</td></tr>";
            echo "<tr><td>Cabin:</td><td>" . $orderData['cabin'] . "</td></tr>";
            echo "<tr><td>Features:</td><td>" . $orderData['features'] . "</td></tr>";
            echo "<tr><td>Number of Tickets:</td><td>" . $orderData['numTickets'] . "</td></tr>";
            echo "<tr><td>Comment:</td><td>" . $orderData['comment'] . "</td></tr>";
            echo "<tr><td>Card Type:</td><td>" . $orderData['cardType'] . "</td></tr>";
            echo "<tr><td>Card Name:</td><td>" . $orderData['cardName'] . "</td></tr>";
            echo "<tr><td>Card Number:</td><td>" . str_repeat("*", strlen($orderData['cardNumber']) - 4) . substr($orderData['cardNumber'], -4) . "</td></tr>";
            echo "<tr><td>Expiry Date:</td><td>" . $orderData['expiryDate'] . "</td></tr>";
            echo "<tr><td>CVV:</td><td>" . str_repeat("*", strlen($orderData['cvv'])) . "</td></tr>";
            echo "</table>";

        } else {
            echo "<p>Order not found.</p>";
        }
    } else {
        echo "<p>Error retrieving order information: " . mysqli_error($conn) . "</p>";
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    echo "<p>Invalid order ID.</p>";
}
?>
