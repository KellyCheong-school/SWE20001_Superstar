<!DOCTYPE html>
<html lang="en">

<head>
    <title>AeroStar - Boarding Pass</title>
    <link href="images/AeroStarLogo-Header.jpg" rel="icon">
    <link href="styles/style.css" rel="stylesheet">
    <style>
        .boarding-pass {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .boarding-pass-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .boarding-pass-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .boarding-pass-table th,
        .boarding-pass-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .boarding-pass-table th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
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

    include 'includes/header_ori.inc';

    // Retrieve booking details based on the booking ID from the URL
    $bookingId = $_GET['bookingId'];
    $bookingQuery = "SELECT booking.*, 
                        flights.departure_datetime, flights.arrival_datetime,
                        flights.departure_city AS flight_departure_city, flights.arrival_city AS flight_arrival_city
                    FROM booking
                    LEFT JOIN flights ON booking.selected_flight_id = flights.id
                    LEFT JOIN members ON booking.member_id = members.id
                    WHERE booking.id = '$bookingId'";
    $bookingResult = mysqli_query($conn, $bookingQuery);

    if ($bookingResult && mysqli_num_rows($bookingResult) > 0) {
        $bookingDetails = mysqli_fetch_assoc($bookingResult);
    ?>
        <div class="boarding-pass">
            <div class="boarding-pass-header">
                <h2>Boarding Pass</h2>
                <p>Flight: <?php echo $bookingDetails['flight_arrival_city']; ?></p>
            </div>
            <table class="boarding-pass-table">
                <tr>
                    <th>Booking ID</th>
                    <td><?php echo $bookingDetails['id']; ?></td>
                </tr>
                <tr>
                    <th>Cabin</th>
                    <td><?php echo $bookingDetails['cabin']; ?></td>
                </tr>
                <tr>
                    <th>Departure City</th>
                    <td><?php echo $bookingDetails['flight_departure_city']; ?></td>
                </tr>
                <tr>
                    <th>Arrival City</th>
                    <td><?php echo $bookingDetails['flight_arrival_city']; ?></td>
                </tr>
                <tr>
                    <th>Departure Date & Time</th>
                    <td><?php echo $bookingDetails['departure_datetime']; ?></td>
                </tr>
                <tr>
                    <th>Arrival Date & Time</th>
                    <td><?php echo $bookingDetails['arrival_datetime']; ?></td>
                </tr>
                <tr>
                    <th>Num Tickets</th>
                    <td><?php echo $bookingDetails['num_tickets']; ?></td>
                </tr>
                <tr>
                    <th>Booking Status</th>
                    <td><?php echo $bookingDetails['booking_status']; ?></td>
                </tr>
            </table>

            <h2>Passenger Information</h2>
            <?php
            // Retrieve member details
            $memberQuery = "SELECT * FROM members WHERE id = '$userId'";
            $memberResult = mysqli_query($conn, $memberQuery);

            // Retrieve passenger details for the current booking
            $passengerQuery = "SELECT * FROM passenger WHERE booking_id = '$bookingId'";
            $passengerResult = mysqli_query($conn, $passengerQuery);

            if ($memberResult && mysqli_num_rows($memberResult) > 0) {
                $memberDetails = mysqli_fetch_assoc($memberResult);
            ?>
                <table class="boarding-pass-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Date of Birth</th>
                            <th>Passport Number</th>
                            <th>Passport Expiry</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $memberDetails['full_name']; ?></td>
                            <td><?php echo $memberDetails['dob']; ?></td>
                            <td><?php echo $memberDetails['passport_number']; ?></td>
                            <td><?php echo $memberDetails['passport_expiry']; ?></td>
                        </tr>
                        <?php if ($passengerResult && mysqli_num_rows($passengerResult) > 0) {
                            while ($passenger = mysqli_fetch_assoc($passengerResult)) {
                                echo "<tr>";
                                echo "<td>{$passenger['name']}</td>";
                                echo "<td>{$passenger['dob']}</td>";
                                echo "<td>{$passenger['passport']}</td>";
                                echo "<td>{$passenger['expiry']}</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<p>No passenger information found for the current booking.</p>";
                        }
                        ?>
                    </tbody>
                </table>
        <?php
            }
        }
        ?>

        </div>
        <?php include 'includes/footer.inc'; ?>
</body>

</html>