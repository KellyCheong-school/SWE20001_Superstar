<!DOCTYPE html>
<html lang="en">

<head>
    <title>AeroStar - Create Flight</title>
    <link href="images/AeroStarLogo-Header.jpg" rel="icon">
    <link href="styles/style.css" rel="stylesheet">
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

    $destinationOptions = '<option value="" disabled selected>Select Destination</option>'; // Set the default value to an empty string
    if ($destinationNamesResult && mysqli_num_rows($destinationNamesResult) > 0) {
        while ($row = mysqli_fetch_assoc($destinationNamesResult)) {
            $destinationName = $row['destinationname'];
            $destinationPrice = getDestinationPrice($conn, $destinationName); // Use a different variable here
            $destinationOptions .= "<option value=\"$destinationName\" data-price=\"$destinationPrice\">$destinationName</option>";
        }
    } else {
        echo "Error: No destination names found.";
    }

    ?>

    <div class="form-container">
        <h2>Create Flight</h2>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="departureDateTime">Departure Date and Time:</label>
            <input type="datetime-local" name="departureDateTime" id="departureDateTime" required>

            <label for="arrivalDateTime">Arrival Date and Time:</label>
            <input type="datetime-local" name="arrivalDateTime" id="arrivalDateTime" required>
            <br>
            <label for="from">From:</label>
            <input type="text" name="from" id="from" value="Kuala Lumpur, Malaysia" readonly>

            <label for="to">To:</label>
            <select name="to" id="to" required onchange="updatePrice()">
                <?php echo $destinationOptions; ?>
            </select>

            <label for="duration">Duration:</label>
            <div id="duration-container">
                <label for="hours">Hours:</label>
                <input type="number" name="hours" id="hours" min="0" max="23" placeholder="HH" required>
                <span>:</span>
                <label for="minutes">Minutes:</label>
                <input type="number" name="minutes" id="minutes" min="0" max="59" placeholder="MM" required>
            </div>
            <br>
            <label for="price">Price: RM</label>
            <input type="text" name="price" id="price" value="<?php echo isset($price) ? $price : '0'; ?>" readonly>

            <input type="submit" value="Create Flight">
        </form>
    </div>

    <div class="flight-list">
        <h2>Flight List</h2>
        <?php
        // Retrieve and display flights
        $getFlightsQuery = "SELECT * FROM flights";
        $flightsResult = mysqli_query($conn, $getFlightsQuery);

        if ($flightsResult && mysqli_num_rows($flightsResult) > 0) {
            echo '<table border="1">';
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

    <a href="#top" class="back-to-top">Back to Top</a><br><br><br>
    <hr>
    <?php include 'includes/footer.inc'; ?>
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
</body>

</html>