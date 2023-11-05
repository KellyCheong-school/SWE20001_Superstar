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

        /* input[readonly].form-control {
            color:#282828;
        } */
    </style>
</head>

<body>

    <?php
    function getDestinationPrice($conn, $destinationName)
    {
        $getDestinationPriceQuery = "SELECT destinationprice FROM destination WHERE destinationname = '$destinationName'";
        $destinationPriceResult = mysqli_query($conn, $getDestinationPriceQuery);

        if ($destinationPriceResult) {
            if (mysqli_num_rows($destinationPriceResult) > 0) {
                $price = mysqli_fetch_assoc($destinationPriceResult)['destinationprice'];
                return $price;
            }
        }
        return 0;
    }

    require_once('settings.php');
    session_start();

    // Establish a database connection
    $conn = @mysqli_connect($host, $user, $pwd, $sql_db);

    // Check if the connection was successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
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

    include 'includes/Managerheader.inc';

    // Check if the 'flights' table exists, create it if not
    $checkFlightsTableQuery = "SHOW TABLES LIKE 'flights'";
    $checkFlightsTableResult = mysqli_query($conn, $checkFlightsTableQuery);

    if (!$checkFlightsTableResult || mysqli_num_rows($checkFlightsTableResult) == 0) {
        // 'flights' table does not exist, create it
        $createFlightsTableQuery = "
        CREATE TABLE flights (
            id INT AUTO_INCREMENT PRIMARY KEY,
            departure_datetime DATETIME,
            arrival_datetime DATETIME,
            departure_city VARCHAR(255),
            arrival_city VARCHAR(255),
            duration INT,
            price DECIMAL(10, 2)
        )
    ";
        if (mysqli_query($conn, $createFlightsTableQuery)) {
            echo "Table 'flights' created successfully.";
        } else {
            echo "Error creating table 'flights': " . mysqli_error($conn);
            exit();
        }
    }
    // Initialize $price variable
    $price = '0';

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve form data
        $departureDateTime = $_POST['departureDateTime'];
        $arrivalDateTime = $_POST['arrivalDateTime'];
        $from = "Kuala Lumpur, Malaysia";
        $to = $_POST['to'];
        $rawHours = $_POST['hours'];
        $rawMinutes = $_POST['minutes'];

        // Validate and sanitize the duration input
        $hours = (!empty($rawHours) && is_numeric($rawHours)) ? intval($rawHours) : 0;
        $minutes = (!empty($rawMinutes) && is_numeric($rawMinutes)) ? intval($rawMinutes) : 0;

        // Calculate total duration in minutes
        $duration = $hours * 60 + $minutes;

        // Retrieve destination information from the "destination" table
        $getDestinationInfoQuery = "SELECT destinationname, destinationprice FROM destination WHERE destinationname = '$to'";
        $destinationInfoResult = mysqli_query($conn, $getDestinationInfoQuery);

        if ($destinationInfoResult && mysqli_num_rows($destinationInfoResult) > 0) {
            $destinationInfo = mysqli_fetch_assoc($destinationInfoResult);
            $price = $destinationInfo['destinationprice'];
        } else {
            // Handle the case where destination information is not found
            echo "Error: Destination information not found.";
            exit();
        }

        // Prepare and execute the SQL statement to insert the flight information
        $sql = "INSERT INTO flights (departure_datetime, arrival_datetime, departure_city, arrival_city, duration, price) VALUES 
    ('$departureDateTime', '$arrivalDateTime', '$from', '$to', '$duration', '$price')";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Flight created successfully.'); window.location.href = 'create_flight.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        // Close the database connection
        mysqli_close($conn);
    }

    // Retrieve destination names from the "destination" table
    $getDestinationNamesQuery = "SELECT destinationname FROM destination";
    $destinationNamesResult = mysqli_query($conn, $getDestinationNamesQuery);

    $destinationOptions = '<option value="" style="color:black;" disabled selected>Select Destination</option>'; // Set the default value to an empty string
    if ($destinationNamesResult && mysqli_num_rows($destinationNamesResult) > 0) {
        while ($row = mysqli_fetch_assoc($destinationNamesResult)) {
            $destinationName = $row['destinationname'];
            $destinationPrice = getDestinationPrice($conn, $destinationName); // Use a different variable here
            $destinationOptions .= "<option style='color:black;' value=\"$destinationName\" data-price=\"$destinationPrice\">$destinationName</option>";
        }
    } else {
        echo "Error: No destination names found.";
    }

    ?>
    <?php include 'includes/Managerheader.inc'; ?>
    <br><br><br><br>
    <div class="container mt-4">
        <h2 class="heading-section">Create Flight</h2>
        <br>
        <div class="mx-auto">
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <fieldset>
                    <div class="form-group row">
                        <label for="departureDateTime" style="color:#fff;" class="col-sm-3 col-form-label">Departure
                            Date and Time:</label>
                        <div class="col-sm-8">
                            <input type="datetime-local" name="departureDateTime" id="departureDateTime" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="arrivalDateTime" style="color:#fff;" class="col-sm-3 col-form-label">Arrival Date
                            and Time:</label>
                        <div class="col-sm-8">
                            <input type="datetime-local" name="arrivalDateTime" id="arrivalDateTime" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="from" style="color:#fff;" class="col-sm-3 col-form-label">From:</label>
                        <div class="col-sm-8">
                            <input class="form-control-plaintext" style="font-size: 11pt; color:#fff;" type="text"
                                name="from" id="from" value="Kuala Lumpur, Malaysia" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="to" style="color:#fff;" class="col-sm-3 col-form-label">To:</label>
                        <div class="col-sm-8">
                            <select name="to" id="to" required onchange="updatePrice()"
                                style="font-size: 11pt; color:black;" class="form-control form-control-lg">
                                <?php echo $destinationOptions; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="duration" style="color:#fff;" class="col-sm-3 col-form-label">Duration:</label>
                        <div class="col-sm-4">
                            <input style="font-size: 11pt;" class="form-control" type="number" name="hours" id="hours"
                                min="0" max="23" placeholder="HH" required>
                        </div>
                        <span style="color:#fff;">:</span>
                        <div class="col-sm-4">
                            <input style="font-size: 11pt;" class="form-control" type="number" name="minutes"
                                id="minutes" min="0" max="59" placeholder="MM" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="price" style="color:#fff;" class="col-sm-3 col-form-label">Price: RM</label>
                        <div class="col-sm-4">
                            <input type="text" name="price" id="price" class="form-control-plaintext"
                                style="font-size: 11pt; color:#fff;" value="<?php echo isset($price) ? $price : '0'; ?>"
                                readonly>
                        </div>

                    </div>
                </fieldset>
                <button type="submit" class="form-control btn btn-primary submit w-25">Create</button>
            </form>
        </div>

        <br><br>


        <hr>
        <h2 class="heading-section">List of Flight</h2>

        <br>
        <!-- Add a row element for the order table -->
        <div class="row">
            <!-- Add a column element for the order table -->
            <div class="col-md-12">

                <?php
                // Retrieve and display flights
                $getFlightsQuery = "SELECT * FROM flights";
                $flightsResult = mysqli_query($conn, $getFlightsQuery);

                if ($flightsResult && mysqli_num_rows($flightsResult) > 0) {
                    echo '<table  class="table table-striped table-bordered" style="color:#fff;">';
                    echo '<tr>';
                    echo '<th>Departure</th>';
                    echo '<th>Arrival</th>';
                    echo '<th>From</th>';
                    echo '<th>To</th>';
                    echo '<th>Duration (minutes)</th>';
                    echo '<th>Price (RM)</th>';
                    echo '<th>Edit</th>';
                    echo '<th>Delete</th>';
                    echo '</tr>';

                    while ($row = mysqli_fetch_assoc($flightsResult)) {
                        echo '<tr>';
                        echo '<td>' . $row['departure_datetime'] . '</td>';
                        echo '<td>' . $row['arrival_datetime'] . '</td>';
                        echo '<td>' . $row['departure_city'] . '</td>';
                        echo '<td>' . $row['arrival_city'] . '</td>';
                        echo '<td>' . $row['duration'] . '</td>';
                        echo '<td>' . $row['price'] . '</td>';
                        echo '<td><a href="edit_flight.php?id=' . $row['id'] . '" onclick="editFlight(event)">Edit</a></td>';
                        echo '<td><a href="delete_flight.php?id=' . $row['id'] . '">Delete</a></td>';
                        echo '</tr>';
                    }
                    echo '</table>';
                } else {
                    echo 'No flights available.';
                }
                ?>
            </div>
        </div>
        <br><br>
        <a href="#top" class="back-to-top">Back to Top</a><br><br><br>
    </div>

    <hr>
    <script>
        function updatePrice() {
            var select = document.getElementById('to');
            var priceInput = document.getElementById('price');
            var selectedOption = select.options[select.selectedIndex];

            // Assuming you have a data-price attribute in your options
            var price = selectedOption.getAttribute('data-price');

            // Set the value to 0 if price is null or undefined
            priceInput.value = (price !== null && price !== undefined) ? price : '0';
        }

        // Set minimum date for departureDateTime and arrivalDateTime
        var today = new Date().toISOString().split('T')[0];
        document.getElementById('departureDateTime').min = today + 'T00:00'; // Set the time to 00:00
        document.getElementById('arrivalDateTime').min = today + 'T00:00';

        // Calculate duration on departureDateTime or arrivalDateTime change
        document.getElementById('departureDateTime').addEventListener('input', calculateDuration);
        document.getElementById('arrivalDateTime').addEventListener('input', calculateDuration);

        function calculateDuration() {
            var departureDateTime = new Date(document.getElementById('departureDateTime').value);
            var arrivalDateTime = new Date(document.getElementById('arrivalDateTime').value);

            if (departureDateTime && arrivalDateTime && departureDateTime < arrivalDateTime) {
                var durationMinutes = Math.round((arrivalDateTime - departureDateTime) / (1000 * 60));
                var hours = Math.floor(durationMinutes / 60);
                var minutes = durationMinutes % 60;

                document.getElementById('hours').value = hours;
                document.getElementById('minutes').value = minutes;
            } else {
                // Handle invalid input or show an error message
            }
        }

        function editFlight(event) {
            event.preventDefault();
            window.open(event.target.href, 'Edit Flight', 'width=600,height=500');
        }
    </script>
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>