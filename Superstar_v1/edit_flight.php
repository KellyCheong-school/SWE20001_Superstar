<!DOCTYPE html>
<html lang="en">

<head>
    <title>AeroStar - Edit Flight</title>
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

    include 'includes/Managerheader_ori.inc';

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
    $price = getDestinationPrice($conn, $flight['arrival_city']);

    // Check if flight ID is provided
    if (isset($_GET['id'])) {
        $flightId = $_GET['id'];

        // Retrieve flight information
        $getFlightQuery = "SELECT * FROM flights WHERE id = $flightId";
        $flightResult = mysqli_query($conn, $getFlightQuery);

        if ($flightResult && mysqli_num_rows($flightResult) > 0) {
            $flight = mysqli_fetch_assoc($flightResult);
            // Fetch the destination price after retrieving flight information
            $price = getDestinationPrice($conn, $flight['arrival_city']);
        } else {
            echo "Flight not found.";
            exit();
        }
    } else {
        echo "Flight ID not provided.";
        exit();
    }


    // Handle form submission for updating flight
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve form data
        // Add validation and sanitization as needed
        $newDepartureDateTime = $_POST['newDepartureDateTime'];
        $newArrivalDateTime = $_POST['newArrivalDateTime'];
        $newFrom = $_POST['newFrom'];
        $newTo = $_POST['newTo'];
        // Convert hours and minutes to total minutes
        $newHours = $_POST['newHours'];
        $newMinutes = $_POST['newMinutes'];
        $newDuration = $newHours * 60 + $newMinutes;
        $newPrice = $_POST['newPrice'];

        // Update the flight information using prepared statements
        $updateFlightQuery = "UPDATE flights SET
        departure_datetime = ?,
        arrival_datetime = ?,
        departure_city = ?,
        arrival_city = ?,
        duration = ?,
        price = ?
        WHERE id = ?";

        // Prepare the statement
        $stmt = mysqli_prepare($conn, $updateFlightQuery);

        // Bind parameters
        mysqli_stmt_bind_param($stmt, "ssssidi", $newDepartureDateTime, $newArrivalDateTime, $newFrom, $newTo, $newDuration, $newPrice, $flightId);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Flight updated successfully.'); window.close();</script>";
        } else {
            echo "Error updating flight: " . mysqli_error($conn);
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    }

    // Retrieve destination names from the "destination" table
    $getDestinationNamesQuery = "SELECT destinationname FROM destination";
    $destinationNamesResult = mysqli_query($conn, $getDestinationNamesQuery);

    $destinationOptions = '<option value="" disabled>Select Destination</option>'; // Set the default value to an empty string
    if ($destinationNamesResult && mysqli_num_rows($destinationNamesResult) > 0) {
        while ($row = mysqli_fetch_assoc($destinationNamesResult)) {
            $destinationName = $row['destinationname'];
            $destinationPrice = getDestinationPrice($conn, $destinationName); // Use a different variable here

            // Check if the current destination is the same as the destination of the flight being edited
            $selected = ($destinationName == $flight['arrival_city']) ? 'selected' : '';

            $destinationOptions .= "<option value=\"$destinationName\" data-price=\"$destinationPrice\" $selected>$destinationName</option>";
        }
    } else {
        echo "Error: No destination names found.";
    }


    ?>

    <div class="form-container">
        <h2>Edit Flight</h2>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $flightId; ?>">
            <!-- Display the existing flight information in the form -->
            <!-- Add any additional fields you need -->
            <label for="newDepartureDateTime">New Departure Date and Time:</label>
            <input type="datetime-local" name="newDepartureDateTime" id="newDepartureDateTime" value="<?php echo $flight['departure_datetime']; ?>" required>

            <label for="newArrivalDateTime">New Arrival Date and Time:</label>
            <input type="datetime-local" name="newArrivalDateTime" id="newArrivalDateTime" value="<?php echo $flight['arrival_datetime']; ?>" required>
            <br>

            <label for="newFrom">New From:</label>
            <input type="text" name="newFrom" id="newFrom" value="<?php echo $flight['departure_city']; ?>" readonly>

            <label for="newTo">New To:</label>
            <select name="newTo" id="newTo" required onchange="updatePrice()">
                <?php echo $destinationOptions; ?>
            </select>

            <label for="newDuration">New Duration:</label>
            <div id="newDuration-container">
                <label for="newHours">Hours:</label>
                <input type="number" name="newHours" id="newHours" min="0" max="23" placeholder="HH" required value="<?php echo floor($flight['duration'] / 60); ?>">
                <span>:</span>
                <label for="newMinutes">Minutes:</label>
                <input type="number" name="newMinutes" id="newMinutes" min="0" max="59" placeholder="MM" required value="<?php echo $flight['duration'] % 60; ?>">
            </div>
            <br>
            <label for="newPrice">New Price: RM</label>
            <input type="text" name="newPrice" id="newPrice" value="<?php echo isset($price) ? $price : '0'; ?>" readonly>

            <input type="submit" value="Update Flight">
        </form>
    </div>

    <a href="#top" class="back-to-top">Back to Top</a><br><br><br>
    <hr>
    <?php include 'includes/footer.inc'; ?>
    <script>
        function updatePrice() {
            var select = document.getElementById('newTo');
            var priceInput = document.getElementById('newPrice');
            var selectedOption = select.options[select.selectedIndex];

            // Assuming you have a data-price attribute in your options
            var price = selectedOption.getAttribute('data-price');

            // Set the value to 0 if price is null or undefined
            priceInput.value = (price !== null && price !== undefined) ? price : '0';
        }

        // Set minimum date for newDepartureDateTime and newArrivalDateTime
        var today = new Date().toISOString().split('T')[0];
        document.getElementById('newDepartureDateTime').min = today + 'T00:00'; // Set the time to 00:00
        document.getElementById('newArrivalDateTime').min = today + 'T00:00';

        // Calculate duration on newDepartureDateTime or newArrivalDateTime change
        document.getElementById('newDepartureDateTime').addEventListener('input', calculateNewDuration);
        document.getElementById('newArrivalDateTime').addEventListener('input', calculateNewDuration);

        function calculateNewDuration() {
            var newDepartureDateTime = new Date(document.getElementById('newDepartureDateTime').value);
            var newArrivalDateTime = new Date(document.getElementById('newArrivalDateTime').value);

            if (newDepartureDateTime && newArrivalDateTime && newDepartureDateTime < newArrivalDateTime) {
                var newDurationMinutes = Math.round((newArrivalDateTime - newDepartureDateTime) / (1000 * 60));
                var newHours = Math.floor(newDurationMinutes / 60);
                var newMinutes = newDurationMinutes % 60;

                document.getElementById('newHours').value = newHours;
                document.getElementById('newMinutes').value = newMinutes;
            } else {
                // Handle invalid input or show an error message
            }
        }
    </script>
</body>

</html>