<!DOCTYPE html>
<html lang="en">

<head>
    <title>AeroStar - View Booking</title>
    <link href="images/AeroStarLogo-Header.jpg" rel="icon">
    <script src="scripts/part2(2).js"></script>
    <link href="styles/style.css" rel="stylesheet">
    <style>
        /* Add any additional styles for the table here */
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
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

    // Retrieve bookings for the current member
    $bookingsQuery = "SELECT booking.*, 
                        flights.departure_datetime, flights.arrival_datetime,
                        flights.departure_city AS flight_departure_city, flights.arrival_city AS flight_arrival_city
                    FROM booking
                    LEFT JOIN flights ON booking.selected_flight_id = flights.id
                    LEFT JOIN members ON booking.member_id = members.id
                    WHERE booking.member_id = '$userId'";
    $bookingsResult = mysqli_query($conn, $bookingsQuery);

    if ($bookingsResult && mysqli_num_rows($bookingsResult) > 0) {
    ?>
        <!-- Display Bookings Table -->
        <table id="bookingsTable" border="1">
            <thead>
                <tr>
                    <th onclick="sortTable(0)">Booking ID</th>
                    <th onclick="sortTable(1)">Cabin</th>
                    <th onclick="sortTable(2)">Features</th>
                    <th onclick="sortTable(3)">Num Tickets</th>
                    <th onclick="sortTable(4)">Booking Date</th>
                    <th onclick="sortTable(5)">Departure Date & Time</th>
                    <th onclick="sortTable(6)">Arrival Date & Time</th>
                    <th onclick="sortTable(7)">Departure City</th>
                    <th onclick="sortTable(8)">Arrival City (Flight)</th>
                    <th onclick="sortTable(9)">Booking Status</th>
                    <th>Action</th>
                    <!-- Add other columns as needed -->
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($bookingsResult)) {
                    echo "<tr>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['cabin']}</td>";
                    echo "<td>{$row['features']}</td>";
                    echo "<td>{$row['num_tickets']}</td>";
                    echo "<td>{$row['booking_date']}</td>";
                    echo "<td>{$row['departure_datetime']}</td>";
                    echo "<td>{$row['arrival_datetime']}</td>";
                    echo "<td>{$row['flight_departure_city']}</td>";
                    echo "<td>{$row['flight_arrival_city']}</td>";
                    echo "<td>{$row['booking_status']}</td>";
                    echo "<td><a href='eTicket.php?bookingId={$row['id']}'>View E-Ticket</a></td>";
                    // Add other columns as needed
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    <?php
    } else {
        echo "<p>No bookings found for the current member.</p>";
    }

    include 'includes/footer.inc';
    ?>

    <script>
        // Function to sort the table by column index
        function sortTable(columnIndex, initialDirection = "asc") {
            var table, rows, switching, i, x, y, shouldSwitch, switchcount = 0;
            table = document.getElementById("bookingsTable");
            switching = true;
            var direction = initialDirection.toLowerCase();

            while (switching) {
                switching = false;
                rows = table.rows;

                for (i = 1; i < (rows.length - 1); i++) {
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName("td")[columnIndex];
                    y = rows[i + 1].getElementsByTagName("td")[columnIndex];

                    var xValue, yValue;

                    if (columnIndex === 0) {
                        // For Booking ID column, skip sorting
                        xValue = Number(x.innerHTML);
                        yValue = Number(y.innerHTML);
                    } else {
                        // For other columns, compare as strings
                        xValue = x.innerHTML.toLowerCase();
                        yValue = y.innerHTML.toLowerCase();
                    }

                    if (direction === "asc" && xValue < yValue) {
                        shouldSwitch = true;
                        break;
                    } else if (direction === "desc" && xValue > yValue) {
                        shouldSwitch = true;
                        break;
                    }
                }

                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    switchcount++;
                } else {
                    if (switchcount === 0 && direction === "asc") {
                        // If no switching occurred and the direction is ascending, switch to descending
                        direction = "desc";
                        switching = true;
                    }
                }
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            // Set the initial sorting based on Booking ID in ascending order
            sortTable(0, "asc");
            sortTable(0, "asc");
        });
    </script>
</body>

</html>