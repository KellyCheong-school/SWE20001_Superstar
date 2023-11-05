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

    <script>
        // Function to sort the table by Booking ID in ascending order
        document.addEventListener("DOMContentLoaded", function () {
            sortTable(0);
        });

        window.onload = function () {
            if (chartData.length > 0) {
                var chart = new CanvasJS.Chart("pieChartContainer", {
                    theme: "light2",
                    animationEnabled: true,
                    title: {
                        text: "Most Popular Flights Ordered"
                    },
                    data: [{
                        type: "pie",
                        indexLabel: "(#percent%)", // Modified this line
                        yValueFormatString: "(#)",
                        indexLabelPlacement: "inside",
                        indexLabelFontColor: "#36454F",
                        indexLabelFontSize: 18,
                        indexLabelFontWeight: "bolder",
                        showInLegend: true,
                        legendText: "{label}",
                        dataPoints: chartData
                    }]
                });
                chart.render();
            } else {
                console.log("No data points to render the chart.");
            }

            // Check if averageOrdersJSON is set before rendering the column chart
            if (typeof averageOrdersData !== 'undefined') {
                console.log(averageOrdersData);
                var columnChart = new CanvasJS.Chart("columnChartContainer", {
                    animationEnabled: true,
                    theme: "light2",
                    title: {
                        text: "Average Number of Orders per Day"
                    },
                    axisX: {
                        title: "Day",
                        interval: 1,
                        reversed: true,
                        valueFormatString: "DDD",
                    },
                    axisY: {
                        title: "Order Count",
                        interval: 1,
                        minimum: 0 // Set the minimum value for the y-axis
                    },
                    data: [{
                        type: "column",
                        yValueFormatString: "#,##0",
                        dataPoints: averageOrdersData
                    }]
                });

                columnChart.render();
            } else {
                console.log("No data points to render the column chart.");
            }

        }
    </script>
</head>

<body>
    <?php
    require_once('settings.php');
    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', true);

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
        header("Location: manager_login.php");
        exit();
    }

    include 'includes/Managerheader.inc';
    ?>
    <?php
    // Query to retrieve the most popular flights
    $popularFlightsQuery = "SELECT selected_flight_id, COUNT(*) as count FROM booking GROUP BY selected_flight_id ORDER BY count DESC LIMIT 5";
    $popularFlightsResult = mysqli_query($conn, $popularFlightsQuery);

    if ($popularFlightsResult === false) {
        // Check for errors in the query
        die("Error in query: " . mysqli_error($conn));
    }

    $popularFlightsData = mysqli_fetch_all($popularFlightsResult, MYSQLI_ASSOC);

    // Initialize an empty array for data points
    $dataPoints = [];

    // Calculate the total count of all flights
    $totalCount = array_sum(array_column($popularFlightsData, 'count'));

    // Populate the dataPoints array with flight data and calculate percentage
    foreach ($popularFlightsData as $flightData) {
        $flightId = $flightData['selected_flight_id'];

        // Fetch flight details based on flight ID (modify the query as per your database schema)
        $flightDetailsQuery = "SELECT arrival_city FROM flights WHERE id = $flightId";
        $flightDetailsResult = mysqli_query($conn, $flightDetailsQuery);

        if ($flightDetailsResult === false) {
            // Check for errors in the query
            die("Error in query: " . mysqli_error($conn));
        }

        $flightDetails = mysqli_fetch_assoc($flightDetailsResult);

        // Calculate the percentage
        $percentage = ($flightData['count'] / $totalCount) * 100;

        // Add data point to the array
        $dataPoints[] = ["label" => $flightDetails['arrival_city'], "y" => $flightData['count'], "percentage" => $percentage];
    }

    // Convert the data points to JSON format
    $dataPointsJSON = json_encode($dataPoints, JSON_NUMERIC_CHECK);

    // Output the JSON data to be used in JavaScript
    echo "<script>var chartData = $dataPointsJSON;</script>";
    ?>

    <?php
    // Modify the query to retrieve data for the average number of orders per day
    $averageOrdersQuery = "SELECT days_of_week.day, IFNULL(COUNT(booking.id), 0) AS orderCount
    FROM (
        SELECT 'Mon' AS day
        UNION SELECT 'Tue'
        UNION SELECT 'Wed'
        UNION SELECT 'Thu'
        UNION SELECT 'Fri'
        UNION SELECT 'Sat'
        UNION SELECT 'Sun'
    ) AS days_of_week
    LEFT JOIN booking ON days_of_week.day = DATE_FORMAT(booking.booking_date, '%a')
    GROUP BY days_of_week.day
    ORDER BY FIELD(days_of_week.day, 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun')
    ";

    // Execute the query
    $averageOrdersResult = mysqli_query($conn, $averageOrdersQuery);

    if ($averageOrdersResult === false) {
        // Handle the error if the query fails
        echo "Error executing average orders query: " . mysqli_error($conn);
    } else {
        // Fetch the data as an associative array
        $averageOrdersData = mysqli_fetch_all($averageOrdersResult, MYSQLI_ASSOC);

        if (!empty($averageOrdersData)) {
            // Remove the 'x' field from each data point
            $averageOrdersData = array_map(function ($dataPoint) {
                unset($dataPoint['x']);
                return $dataPoint;
            }, $averageOrdersData);

            // Restructure the data points array
            $dataPoints = array_map(function ($dataPoint) {
                return ["label" => $dataPoint['day'], "y" => $dataPoint['orderCount']];
            }, $averageOrdersData);

            // Convert the PHP array to JSON for JavaScript
            $averageOrdersJSON = json_encode($dataPoints, JSON_NUMERIC_CHECK);

            // Output the JSON data to be used in JavaScript for column chart
            echo "<script>var averageOrdersData = $averageOrdersJSON;</script>";
        } else {
            $averageOrdersJSON = '[]';
            echo "No data available for average orders.";
        }
    }
    ?>


    <br><br><br><br>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center mb-5">
                <h2 class="heading-section">Manager Page</h2>
            </div>
        </div>
        <div class="row justify-content-center">
            <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
            <div id="pieChartContainer" style="height: 370px; width: 40%; display: inline-block;"></div>
            <span>&nbsp</span>
            <div id="columnChartContainer" style="height: 370px; width: 40%; display: inline-block;"></div>
        </div>
        <br>
        <hr>
        <h2 class="heading-section">Query Order</h2>
        <br>



        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-6">
                <div class="login-wrap p-0">
                    <form id="searchForm" method="post" action="">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="searchType">Search By:</label>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <select id="searchType" name="searchType" onchange="updateSearchInputField()"
                                            style="font-size: 11pt;" class="form-control form-control-lg">
                                            <option value="all" style="color:black;" <?php echo isset($_POST['searchType']) && $_POST['searchType'] === 'all' ? 'selected' : ''; ?>>All Bookings</option>
                                            <option value="selected_arrival_city"  style="color:black;" <?php echo isset($_POST['searchType']) && $_POST['searchType'] === 'selected_arrival_city' ? 'selected' : ''; ?>>
                                                Arrival City</option>
                                            <option value="cabin" style="color:black;" <?php echo isset($_POST['searchType']) && $_POST['searchType'] === 'cabin' ? 'selected' : ''; ?>>Cabin</option>
                                            <option value="features" style="color:black;" <?php echo isset($_POST['searchType']) && $_POST['searchType'] === 'features' ? 'selected' : ''; ?>>Features
                                            </option>
                                            <option value="pending" style="color:black;" <?php echo isset($_POST['searchType']) && $_POST['searchType'] === 'pending' ? 'selected' : ''; ?>>Pending Bookings
                                            </option>
                                            <option value="fulfilled_between_dates" style="color:black;" <?php echo isset($_POST['searchType']) && $_POST['searchType'] === 'fulfilled_between_dates' ? 'selected' : ''; ?>>
                                                Completed Booking Between
                                                Dates
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Container for the dynamic search input field -->
                        <div id="searchInputContainer">
                            <?php
                            // Display search input only for specific options
                            $searchTypesWithInput = ['selected_arrival_city', 'cabin', 'features'];
                            if (isset($_POST['searchType']) && in_array($_POST['searchType'], $searchTypesWithInput)) {
                                echo '<input type="text" class="form-control" style="font-size: 11pt;" id="searchInput" name="searchInput" placeholder="Enter search term" value="' . htmlspecialchars(isset($_POST['searchInput']) ? $_POST['searchInput'] : '') . '"><br>';
                            } elseif (isset($_POST['searchType']) && $_POST['searchType'] === 'selected_arrival_city') {
                                // Display a dropdown for Arrival City
                                $arrivalCityOptions = ['City1', 'City2', 'City3']; // Replace with your actual options
                                echo '<select id="searchInput" name="searchInput" style="font-size: 11pt;" class="form-control form-control-lg">';
                                foreach ($arrivalCityOptions as $option) {
                                    echo '<option value="' . $option . '" ' . (isset($_POST['searchInput']) && $_POST['searchInput'] === $option ? 'selected' : '') . '>' . $option . '</option>';
                                }
                                echo '</select>';
                            } elseif (isset($_POST['searchType']) && $_POST['searchType'] === 'cabin') {
                                // Display a dropdown for Cabin
                                $cabinOptions = ['Cabin1', 'Cabin2', 'Cabin3']; // Replace with your actual options
                                echo '<select id="searchInput" name="searchInput" style="font-size: 11pt;" class="form-control form-control-lg">';
                                foreach ($cabinOptions as $option) {
                                    echo '<option value="' . $option . '" ' . (isset($_POST['searchInput']) && $_POST['searchInput'] === $option ? 'selected' : '') . '>' . $option . '</option>';
                                }
                                echo '</select>';
                            } elseif (isset($_POST['searchType']) && $_POST['searchType'] === 'features') {
                                // Display a dropdown for Features
                                $featuresOptions = ['Feature1', 'Feature2', 'Feature3']; // Replace with your actual options
                                echo '<select id="searchInput" name="searchInput" style="font-size: 11pt;" class="form-control form-control-lg">';
                                foreach ($featuresOptions as $option) {
                                    echo '<option value="' . $option . '" ' . (isset($_POST['searchInput']) && $_POST['searchInput'] === $option ? 'selected' : '') . '>' . $option . '</option>';
                                }
                                echo '</select>';
                            } elseif (isset($_POST['searchType']) && $_POST['searchType'] === 'fulfilled_between_dates') {
                                // Display date input fields for fulfilled_between_dates
                                echo '<label for="startDate">Start Date:</label>';
                                echo '<input type="date" id="startDate" name="startDate" value="' . htmlspecialchars(isset($_POST['startDate']) ? $_POST['startDate'] : '') . '">';

                                echo '<label for="endDate">End Date:</label>';
                                echo '<input type="date" id="endDate" name="endDate" value="' . htmlspecialchars(isset($_POST['endDate']) ? $_POST['endDate'] : '') . '">';
                            }
                            ?>
                        </div>
                        <button type="submit" name="searchButton"
                            class="form-control btn btn-primary submit">Search</button>
                    </form>
                </div>
            </div>
        </div>
        <br><br>

        <!-- Display Bookings Table -->
        <table id="bookingsTable" class='table table-striped table-bordered' style='color:#fff;'>
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
                    <th onclick="sortTable(9)">Booked by</th>
                    <th onclick="sortTable(10)">Booking Status</th>
                    <!-- Add other columns as needed -->
                </tr>
            </thead>

            <tbody id="bookingsTableBody">
                <!-- Display bookings here using PHP -->
                <?php
                if (isset($_POST['searchButton'])) {
                    $query = "
            SELECT booking.*, flights.departure_datetime, flights.arrival_datetime,
                flights.departure_city AS flight_departure_city, flights.arrival_city AS flight_arrival_city,
                members.username AS booked_by
            FROM booking
            LEFT JOIN flights ON booking.selected_flight_id = flights.id
            LEFT JOIN members ON booking.member_id = members.id";
                    $value = isset($_POST['searchInput']) ? $_POST['searchInput'] : '';

                    switch ($_POST['searchType']) {
                        case 'all':
                            // Keep the default query
                            break;
                        case 'selected_arrival_city':
                            // Adjust the query to filter by arrival city
                            $query .= " WHERE flights.arrival_city LIKE '%$value%'";
                            break;
                        case 'cabin':
                            // Adjust the query to filter by cabin
                            $query .= " WHERE cabin LIKE '%$value%'";
                            break;
                        case 'features':
                            // Adjust the query to filter by features
                            $query .= " WHERE features LIKE '%$value%'";
                            break;
                        case 'pending':
                            // Adjust the query to filter by pending status
                            $query .= " WHERE booking_status = 'Pending'";
                            break;
                        case 'fulfilled_between_dates':
                            // Adjust the query to filter by fulfilled orders between two dates
                            $startDate = mysqli_real_escape_string($conn, $_POST['startDate']);
                            $endDate = mysqli_real_escape_string($conn, $_POST['endDate']);
                            $query .= " WHERE booking.booking_status = 'Complete' AND booking.booking_date BETWEEN '$startDate' AND '$endDate'";
                            break;
                        default:
                            break;
                    }

                    $result = mysqli_query($conn, $query);

                    if ($result) {
                        if (mysqli_num_rows($result) > 0) {
                            // Display the booking information in an HTML table
                            displayBookingInformation($result, $conn);
                        } else {
                            echo '<script>alert("No matching bookings found.");</script>';
                            // Reset the search form and reload the page after a short delay
                            echo '<script>
                                window.location.reload();
                                window.location.href = "manager.php";
                        </script>';
                        }
                    } else {
                        echo "Error retrieving booking information: " . mysqli_error($conn);
                    }
                } else {
                    // Fetch all bookings without applying any filter
                    $bookingQuery = "
            SELECT booking.*, flights.departure_datetime, flights.arrival_datetime,
                flights.departure_city AS flight_departure_city, flights.arrival_city AS flight_arrival_city,
                members.username AS booked_by
            FROM booking
            LEFT JOIN flights ON booking.selected_flight_id = flights.id
            LEFT JOIN members ON booking.member_id = members.id
        ";
                    $bookingResult = mysqli_query($conn, $bookingQuery);

                    if ($bookingResult) {
                        $bookings = mysqli_fetch_all($bookingResult, MYSQLI_ASSOC);
                        // Display the booking information in an HTML table
                        displayBookingInformation($bookings, $conn);
                    } else {
                        echo "Error retrieving booking information: " . mysqli_error($conn);
                    }
                }

                function displayBookingInformation($bookings, $conn)
                {
                    foreach ($bookings as $booking) {
                        echo '<tr>';
                        echo '<td>' . $booking['id'] . '</td>';
                        echo '<td>' . $booking['cabin'] . '</td>';
                        echo '<td>' . $booking['features'] . '</td>';
                        echo '<td>' . $booking['num_tickets'] . '</td>';
                        echo '<td>' . $booking['booking_date'] . '</td>';
                        echo '<td>' . $booking['departure_datetime'] . '</td>';
                        echo '<td>' . $booking['arrival_datetime'] . '</td>';
                        echo '<td>' . $booking['flight_departure_city'] . '</td>';
                        echo '<td>' . $booking['flight_arrival_city'] . '</td>';
                        echo '<td>' . $booking['booked_by'] . '</td>';
                        echo '<td>';
                        // Check if the form is submitted for status update
                        if (isset($_POST['updateStatus'])) {
                            $bookingId = $_POST['bookingId'];
                            $newStatus = $_POST['newStatus'];

                            // Check if the new status is "Cancel Booking"
                            if ($newStatus === 'Cancel Booking') {
                                // Perform the deletion from the database
                                $deleteQuery = "DELETE FROM booking WHERE id = $bookingId";
                                $deleteResult = mysqli_query($conn, $deleteQuery);

                                // Check if the deletion was successful
                                if ($deleteResult) {
                                    echo '<script>alert("Booking canceled successfully!");</script>';
                                    // Redirect to the same page
                                    header("Location: manager.php");
                                    exit();
                                } else {
                                    echo '<script>alert("Error canceling booking: ' . mysqli_error($conn) . '");</script>';
                                }
                            } else {
                                // Update the booking status in the database
                                $updateQuery = "UPDATE booking SET booking_status = '$newStatus' WHERE id = $bookingId";
                                $updateResult = mysqli_query($conn, $updateQuery);

                                // Check if the update was successful
                                if ($updateResult) {
                                    echo '<script>alert("Booking status updated successfully!");</script>';
                                    // Redirect to the same page
                                    header("Location: manager.php");
                                    exit();
                                } else {
                                    echo '<script>alert("Error updating booking status: ' . mysqli_error($conn) . '");</script>';
                                    header("Location: manager.php");
                                    exit();
                                }
                            }
                        }

                        // Display the form
                        echo '<form method="post" action="">';
                        echo '<input type="hidden" name="bookingId" value="' . $booking['id'] . '">';
                        echo 'Current Status: ' . $booking['booking_status'] . '<br>';
                        echo '<select name="newStatus">
                    <option value="Complete">Complete</option>
                    <option value="Pending">Pending</option>
                    <option value="Cancel Booking">Cancel Booking</option>
                    </select>';
                        echo '<input type="submit" name="updateStatus" value="Update">';
                        echo '</form>';
                        echo '</td>';
                        echo '</tr>';
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
    <script>
        // Function to update the search input field based on the selected search type
        function updateSearchInputField() {
            var searchType = document.getElementById("searchType").value;
            var searchInputContainer = document.getElementById("searchInputContainer");

            // Clear the container
            searchInputContainer.innerHTML = '';

            if (searchType === "selected_arrival_city" || searchType === "cabin" || searchType === "features") {
                // Display a text input for Arrival City, Cabin, or Features
                var textInput = document.createElement("input");
                textInput.type = "text";
                textInput.id = "searchInput";
                textInput.name = "searchInput";
                textInput.placeholder = "Enter search term";

                searchInputContainer.appendChild(textInput);
            } else if (searchType === "fulfilled_between_dates") {
                // Display date input fields for fulfilled_between_dates
                var startDateInput = document.createElement("input");
                startDateInput.type = "date";
                startDateInput.id = "startDate";
                startDateInput.name = "startDate";
                startDateInput.placeholder = "Start Date";

                var endDateInput = document.createElement("input");
                endDateInput.type = "date";
                endDateInput.id = "endDate";
                endDateInput.name = "endDate";
                endDateInput.placeholder = "End Date";

                searchInputContainer.appendChild(startDateInput);
                searchInputContainer.appendChild(endDateInput);
            }
        }


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

        document.addEventListener("DOMContentLoaded", function () {
            // Set the initial sorting based on Booking ID in ascending order
            sortTable(0, "asc");
        });
    </script>




    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>