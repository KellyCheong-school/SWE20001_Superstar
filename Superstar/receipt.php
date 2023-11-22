<!DOCTYPE html>
<html lang="en">

<head>
    <title>Receipt</title>
    <meta charset="utf-8">
    <link href="./images/logo(icon).png" rel="icon">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <style type="text/css">
        @import url('https://fonts.googleapis.com/css?family=Open+Sans:400,700,800');
        @import url('https://fonts.googleapis.com/css?family=Lobster');

        .receipt-container {
            max-width: 400px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2,
        h3 {
            color: #333;
        }

        p {
            margin: 10px 0;
        }

        hr {
            border: none;
            border-top: 1px solid #ddd;
            margin: 15px 0;
        }

        strong {
            font-weight: bold;
        }

        .ok-button {
            width: 150px;
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            display: block;
            margin: 20px auto;
        }

        .ok-button:hover {
            background-color: #45a049;
            /* Darker green color on hover */
        }
    </style>

</head>

<body class="img js-fullheight" style="background-image: url(images/bg.jpg);">
    <br><br><br>
    <?php
    require_once('settings.php');
    session_start();

    // Establish a database connection
    $conn = @mysqli_connect($host, $user, $pwd, $sql_db);

    // Check if the connection was successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Check if the user is logged in
    if (isset($_SESSION['member_id'])) {
        // The user is logged in, retrieve the username from the session
        $userId = $_SESSION['member_id'];
        $username = $_SESSION['member_username'];
    } else {
        // Redirect the user to the login page if not logged in
        header("Location: index.php");
        exit();
    }

    include 'includes/memberHeader.inc';

    // Check if the booking ID is set
    if (isset($_GET['bookingId'])) {
        $bookingId = $_GET['bookingId'];
        // Retrieve booking details along with flight and member information
        $getBookingQuery = "
        SELECT booking.*, flights.*, members.username AS member_username
        FROM booking
        JOIN flights ON booking.selected_flight_id = flights.id
        JOIN members ON booking.member_id = members.id
        WHERE booking.id = $bookingId
        ";

        $getBookingResult = mysqli_query($conn, $getBookingQuery);

        if ($getBookingResult === false) {
            echo "Query error: " . mysqli_error($conn);
            die;
        }

        if ($getBookingResult && mysqli_num_rows($getBookingResult) > 0) {
            $row = mysqli_fetch_assoc($getBookingResult);

            // Display receipt details
            echo '<div class="receipt-container">';
            echo '<h2>Flight Ticket Purchase</h2>';
            echo '<p><strong>Booking Date:</strong> ' . $row['booking_date'] . '</p>';
            echo '<p><strong>Booked by:</strong> ' . $row['member_username'] . '</p>';
            echo '<hr>';
            echo '<h3>Flight Details</h3>';
            echo '<p><strong>Departure Date & Time:</strong> ' . $row['departure_datetime'] . '</p>';
            echo '<p><strong>Arrival Date & Time:</strong> ' . $row['arrival_datetime'] . '</p>';
            echo '<p><strong>Departure City:</strong> ' . $row['departure_city'] . '</p>';
            echo '<p><strong>Arrival City:</strong> ' . $row['arrival_city'] . '</p>';

            // Convert duration from minutes to hours and minutes
            $durationHours = floor($row['duration'] / 60);
            $durationMinutes = $row['duration'] % 60;
            echo '<p><strong>Duration:</strong> ' . $durationHours . ' hours ' . $durationMinutes . ' minutes</p>';
            echo '<hr>';
            echo '<h3>Flight Preferences</h3>';
            echo '<p><strong>Cabin:</strong> ' . $row['cabin'] . '</p>';
            echo '<p><strong>Features:</strong> ' . (!empty($row['features']) ? $row['features'] : '-') . '</p>';
            echo '<p><strong>Number of Tickets:</strong> ' . $row['num_tickets'] . '</p>';
            echo '<hr>';
            // Retrieve total price from payment table based on booking_id
            $getTotalPriceQuery = "SELECT totalPrice FROM payment WHERE booking_id = $bookingId";
            $getTotalPriceResult = mysqli_query($conn, $getTotalPriceQuery);

            if ($getTotalPriceResult && mysqli_num_rows($getTotalPriceResult) > 0) {
                $totalPrice = mysqli_fetch_assoc($getTotalPriceResult)['totalPrice'];
                echo '<h3>Total Price</h3>';
                echo '<p><strong>RM:</strong> ' . $totalPrice . '</p>';
            } else {
                echo '<p><strong>Total Price:</strong> Not available</p>';
            }

            echo '</div>';
        } else {
            // Handle the case where the booking ID cannot be found
            echo '<div class="receipt-container">';
            echo '<h2>Error</h2>';
            echo '<p>Invalid Booking ID. Please contact customer support for assistance.</p>';
            echo '</div>';
        }
    } else {
        // Handle the case where the booking ID is not set
        echo '<div class="receipt-container">';
        echo '<h2>Error</h2>';
        echo '<p>Booking ID is missing. Please contact customer support for assistance.</p>';
        echo '</div>';
    }
    mysqli_close($conn);
    ?>

    <button class="ok-button" onclick="location.href='memberPage.php'">OK</button>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>