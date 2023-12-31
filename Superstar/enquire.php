<!DOCTYPE html>
<html lang="en">

<head>
  <title>Enquire Page</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <style type="text/css">
    @import url('https://fonts.googleapis.com/css?family=Open+Sans:400,700,800');
    @import url('https://fonts.googleapis.com/css?family=Lobster');

    /*form: sets the margin and width*/
    form {
      margin: 0 auto;
      max-width: 800px;
    }

    /*fieldset: sets the margin, border and padding of fieldset*/
    fieldset {
      margin: auto;
      border: none;
      padding: 20px;
      color: #fff;
    }

    /*fieldset legend: sets the padding, font style and margin for legend in fieldset*/
    fieldset legend {
      padding: 0 10px;
      font-size: 24px;
      font-weight: bold;
      margin-bottom: 10px;
    }

    /*#half: sets the width, box sizing and padding for the form fields that should take up half of the width in the form*/
    .half {
      width: 50%;
      float: left;
      box-sizing: border-box;
      padding: 10px;
    }

    /*.view-more: sets the width, margin, padding, text alignment, color, background color, border radius, 
  box shadow, font size, font weight, and transition for the "View More" button.*/
    .view-more {
      display: block;
      width: 200px;
      margin: 20px auto;
      padding: 10px 20px;
      text-align: center;
      text-decoration: none;
      color: #000000;
      background-color: #FFCBA4;
      border-radius: 5px;
      box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
      font-size: 20px;
      font-weight: bold;
      transition: background-color 0.3s ease-in-out;
    }

    /*.view-more:hover: sets the background color when hovering over the "View More" button.*/
    .view-more:hover {
      background-color: #fff;
      color: black;
    }

    /* Apply styles to form inputs and labels */
    label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
    }

    input[type="text"],
    input[type="date"],
    input[type="number"],
    input[type="email"],
    input[type="tel"],
    select {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 5px;
      background-color: #fff;
      /* Set a background color for input fields */
      color: #333;
      /* Set text color for better contrast */
    }

    /* Adjust styles for date input */
    input[type="date"] {
      width: calc(100% - 22px);
      /* Adjusted width for better alignment */
    }

    .passenger-info h4 {
      color: white;
      margin-bottom: 5px;
    }

    .search-results {
      margin-top: 20px;
      text-align: center;
    }

    .flight-info {
      width: 500px;
      border: 1px solid #ddd;
      padding: 10px;
      margin: 0 auto;
      /* Center the content horizontally */
      margin-bottom: 15px;
      text-align: center;
    }


    .flight-info h4 {
      margin-bottom: 5px;
      text-align: center;
      color: white;
      /* Add this line to center the content */
    }

    .flight-info p {
      margin: 5px 0;
      text-align: center;
      color: lightgrey;
      /* Add this line to center the content */
    }

    .no-flights {
      margin-top: 20px;
      color: lightgrey;
    }
  </style>

  <link href="styles/enhancements.css" rel="stylesheet">
  <script src="scripts/enhancements.js"></script>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      var numTicketsInput = document.getElementById("numTickets");
      var passengerFormContainer = document.getElementById("passengerFormContainer");
      var passengerLegend = document.getElementById("passengerLegend");

      // Initial check and toggle
      togglePassengerForm();

      // Add event listener to numTickets input
      numTicketsInput.addEventListener("input", function() {
        togglePassengerForm();
        console.log("Debug: Num Tickets (from input):", numTicketsInput.value);
      });

      // Reset search values when the page is refreshed
      var isSearchNotSet = <?php echo (!isset($_POST['searchDepartureDate']) && !isset($_POST['searchArrivalCity'])) ? 'true' : 'false'; ?>;

      if (isSearchNotSet) {
        document.getElementById("searchDepartureDate").value = '';
        document.getElementById("searchArrivalCity").value = '';
      }

      function togglePassengerForm() {
        var numTickets = parseInt(numTicketsInput.value, 10);

        // Clear previous forms
        passengerFormContainer.innerHTML = "";

        // Toggle visibility based on the number of tickets
        if (numTickets >= 2) {
          passengerFormContainer.style.display = "block";
          passengerFormContainer.innerHTML += `<legend id="passengerLegend">Passenger Information</legend>`;
          // Create new forms
          for (var i = 1; i <= numTickets - 1; i++) {
            var passengerInfo = document.createElement("div");
            passengerInfo.className = "passenger-info";

            passengerInfo.innerHTML = `
        <h4>Passenger ${i}</h4>
        <div class="half">
          <label for="passengerName${i}">Name:</label>
          <input type="text" id="passengerName${i}" name="passengerName[]" required>
        </div>
        <div class="half">
          <label for="passengerDob${i}">Date of Birth:</label><br>
          <input type="date" id="passengerDob${i}" name="passengerDob[]" required max="<?php echo date('Y-m-d'); ?>">
        </div>
        <div class="half">
          <label for="passengerPassport${i}">Passport Number:</label>
          <input type="text" id="passengerPassport${i}" name="passengerPassport[]" pattern="A\d{8}" title="Enter a valid Malaysian passport number" placeholder="e.g., A12345678"  required>
        </div>
        <div class="half">
          <label for="passengerExpiry${i}">Passport Expiry Date:</label>
          <input type="date" id="passengerExpiry${i}" name="passengerExpiry[]" min="<?php echo date('Y-m-d'); ?>" required>
        </div>`;

            passengerFormContainer.appendChild(passengerInfo);
          }
        } else {
          passengerFormContainer.style.display = "none";
        }
      }

      function validateForm() {
        var selectedFlightId = document.getElementById("selectedFlightId").value;
        var cabin = document.getElementById("cabin").value;
        var numTickets = document.getElementById("numTickets").value;
        var fullname = document.getElementById("fullname").value;
        var email = document.getElementById("email").value;
        var phone = document.getElementById("phone").value;
        var passportNumber = document.getElementById("passportNumber").value;
        var passportExpiryDate = document.getElementById("passportExpiryDate").value;

        // Check if a flight is selected
        if (!selectedFlightId) {
          alert("Please select a flight before proceeding to payment.");
          return false;
        }

        // Check if a flight is selected
        if (numTickets <= 0) {
          alert("Please select a valid number for tickets.");
          return false;
        }

        // Check if any of the required fields is empty
        if (!selectedFlightId || !cabin || !numTickets || !fullname || !email || !phone || !passportNumber || !passportExpiryDate) {
          alert("Please fill in all required fields before proceeding to payment.");
          return false;
        }

        // Validate passport number using the pattern
        var passportPattern = /^A\d{8}$/;
        if (!passportPattern.test(passportNumber)) {
          alert("Please enter a valid Malaysian passport number starting with 'A' (e.g., A12345678).");
          return false;
        }

        // If the number of tickets is more than 2, validate passenger details
        if (parseInt(numTickets) > 1) {
          for (var i = 1; i < parseInt(numTickets); i++) {
            var passengerName = document.getElementById("passengerName" + i);
            var passengerDob = document.getElementById("passengerDob" + i);
            var passengerPassport = document.getElementById("passengerPassport" + i);
            var passengerExpiry = document.getElementById("passengerExpiry" + i);

            // Check if any passenger details are empty
            if (!passengerName.value || !passengerDob.value || !passengerPassport.value || !passengerExpiry.value) {
              alert("Please fill in all passenger details for Passenger " + (i + 1) + ".");
              return false;
            }

            if (!passportPattern.test(passengerPassport.value)) {
              alert("Please enter a valid Malaysian passport number for Passenger " + (i + 1) + ".");
              return false;
            }
          }
        }
        return true;
      }

      for (var i = 1; i < parseInt(numTickets); i++) {
        var passengerPassport = document.getElementById("passengerPassport" + i).value;

        if (passportNumber === passengerPassport) {
          alert("Main passenger's passport number cannot be the same as any other passenger's passport number.");
          return false;
        }
      }

      // Attach the validation function to the form's onsubmit event
      document.getElementById("enquireForm").addEventListener("submit", function(event) {
        if (!validateForm()) {
          event.preventDefault(); // Prevent form submission if validation fails
        }
      });
    });

    function setEnquireFormVariables(flightId, departureDate, arrivalCity) {
      document.getElementById("selectedFlightId").value = flightId;
      document.getElementById("selectedDepartureDate").value = departureDate;
      document.getElementById("selectedArrivalCity").value = arrivalCity;

      // Display flight information in the alert
      var alertMessage = "Flight Selected!\n";
      alertMessage += "Departure Date: " + departureDate + "\n";
      alertMessage += "Arrival City: " + arrivalCity;

      alert(alertMessage);
    }
  </script>
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

  $numTickets = isset($_POST['numTickets']) ? $_POST['numTickets'] : 1;

  $queryUser = mysqli_query($conn, "SELECT username FROM members WHERE id = $userId");
  $userData = mysqli_fetch_assoc($queryUser);
  $username = $userData['username'];
  include 'includes/memberHeader.inc';
  ?>
  <br><br><br>

  <?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if both search parameters are set
    if (isset($_POST['searchDepartureDate']) && isset($_POST['searchArrivalCity'])) {
      $searchDepartureDate = $_POST['searchDepartureDate'];
      $searchArrivalCity = $_POST['searchArrivalCity'];

      // Use these variables in your query to fetch flights based on the search criteria
      $searchFlightsQuery = "SELECT * FROM flights WHERE DATE(departure_datetime) = '$searchDepartureDate' AND arrival_city = '$searchArrivalCity'";
      $searchFlightsResult = mysqli_query($conn, $searchFlightsQuery);

      // Now you have $searchFlightsResult containing the flights based on the search criteria
    }
  }
  ?>

  <!-- Flight Search Section -->
  <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <fieldset>
      <legend>Flight Search</legend>
      <div class="half" id="calendar">
        <label for="searchDepartureDate">Departure Date:</label><br>
        <input type="date" id="searchDepartureDate" name="searchDepartureDate" required min="<?php echo date('Y-m-d'); ?>" value="<?php echo isset($searchDepartureDate) ? $searchDepartureDate : ''; ?>">

      </div>
      <div class="half">
        <label for="searchArrivalCity">Arrival City:</label>
        <select id="searchArrivalCity" name="searchArrivalCity" required>
          <option value="" selected disabled>Select Arrival City</option>
          <?php
          // Populate dropdown with arrival cities
          $arrivalCitiesQuery = "SELECT DISTINCT arrival_city FROM flights";
          $arrivalCitiesResult = mysqli_query($conn, $arrivalCitiesQuery);

          while ($cityRow = mysqli_fetch_assoc($arrivalCitiesResult)) {
            $selected = isset($searchArrivalCity) && $searchArrivalCity == $cityRow['arrival_city'] ? 'selected' : '';
            echo "<option value='" . $cityRow['arrival_city'] . "' $selected>" . $cityRow['arrival_city'] . "</option>";
          }
          ?>
        </select>
      </div>
      <br><br>
      <input class="view-more" type="submit" value="Search Flights">
    </fieldset>
  </form>

  <!-- Display Search Results -->
  <div class="search-results">
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if (isset($searchFlightsResult) && mysqli_num_rows($searchFlightsResult) > 0) {
        echo "<center><h3 style=\"color: white\">Available Flights</h3></center>";
        while ($row = mysqli_fetch_assoc($searchFlightsResult)) {
          // Display flight information here
          echo "<div class='flight-info'>";
          echo "<h4>Departure Date:</h4>";
          echo "<p>" . $row['departure_datetime'] . "</p>";
          echo "<h4>Arrival City:</h4>";
          echo "<p>" . $row['arrival_city'] . "</p>";
          echo "<h4>Flight Price:</h4>";
          echo "<p>RM" . $row['price'] . "</p>";
          // Add a button to set variables in the enquireForm
          echo "<button class='flight-btn' type='button' onclick=\"setEnquireFormVariables('" . $row['id'] . "','" . $row['departure_datetime'] . "','" . $row['arrival_city'] . "')\">Select This Flight</button>";
          echo "</div>";
        }
      } else {
        echo "<center><p class='no-flights'>Sorry, the desired flight is unavailable. Here are some other flights based on your search:</p></center>";

        // Fetch other flights based on departure_datetime or arrival_city
        $otherFlightsQuery = "SELECT * FROM flights WHERE DATE(departure_datetime) >= '$searchDepartureDate' AND arrival_city = '$searchArrivalCity'";
        $otherFlightsResult = mysqli_query($conn, $otherFlightsQuery);

        if ($otherFlightsResult && mysqli_num_rows($otherFlightsResult) > 0) {
          echo "<center><h3 style=\"color: white\">Other Available Flights</h3></center>";
          while ($row = mysqli_fetch_assoc($otherFlightsResult)) {
            // Display flight information here
            echo "<div class='flight-info'>";
            echo "<h4>Departure Date:</h4>";
            echo "<p>" . $row['departure_datetime'] . "</p>";
            echo "<h4>Arrival City:</h4>";
            echo "<p>" . $row['arrival_city'] . "</p>";
            echo "<h4>Flight Price:</h4>";
            echo "<p>RM" . $row['price'] . "</p>";
            // Add a button to set variables in the enquireForm
            echo "<button class='flight-btn' type='button' onclick=\"setEnquireFormVariables('" . $row['id'] . "','" . $row['departure_datetime'] . "','" . $row['arrival_city'] . "')\">Select This Flight</button>";
            echo "</div>";
          }
        } else {
          echo "<center><p class='no-flights'>No other flights found based on the search criteria.</p></center>";
        }
      }
    }
    ?>
  </div>


  <form id="enquireForm" action="payment.php" method="post" novalidate="novalidate">
    <input type="hidden" id="selectedFlightId" name="selectedFlightId" value="<?php echo isset($_POST['selectedFlightId']) ? $_POST['selectedFlightId'] : ''; ?>" required>
    <input type="hidden" id="selectedDepartureDate" name="selectedDepartureDate" value="<?php echo isset($_POST['selectedDepartureDate']) ? $_POST['selectedDepartureDate'] : ''; ?>" required>
    <input type="hidden" id="selectedArrivalCity" name="selectedArrivalCity" value="<?php echo isset($_POST['selectedArrivalCity']) ? $_POST['selectedArrivalCity'] : ''; ?>" required>

    <fieldset>
      <legend>Flight Preferences</legend>
      <div class="full">
        <label for="cabin">Cabin Class:</label>
        <select id="cabin" name="cabin" required>
          <option value="" selected disabled>Select Cabin Class</option>
          <option value="First Class">First Class (+RM500.00 per person)</option>
          <option value="Business Class">Business Class (+RM250.00 per person)</option>
          <option value="Economy Class">Economy Class (+RM0.00 per person)</option>
        </select>
      </div>
      <div id="features" class="half">
        <label>Other Add Ons:</label><br>
        <input type="checkbox" id="flight-meal" name="features[]" value="Flight Meal">
        <label for="flight-meal">Flight Meal (+RM20.00 per person)</label><br>
        <input type="checkbox" id="baggage-protection" name="features[]" value="Baggage Protection">
        <label for="baggage-protection">Baggage Protection (+RM50.00)</label><br>
      </div>
      <div class="half">
        <label for="numTickets">Number of tickets (Max 10):</label><br>
        <input type="number" id="numTickets" name="numTickets" min="1" max="10" value="1" required>
      </div>
    </fieldset>

    <?php
    // Assuming you have a $conn variable for the database connection
    $memberId = $userId;

    // Query to retrieve member information
    $memberQuery = "SELECT full_name, email, phone FROM members WHERE id = $memberId";
    $memberResult = mysqli_query($conn, $memberQuery);

    if ($memberResult && mysqli_num_rows($memberResult) > 0) {
      $memberData = mysqli_fetch_assoc($memberResult);
    ?>
      <fieldset>
        <legend>Contact Information</legend>
        <div class="full">
          <label for="fullname">Full Name:</label>
          <input type="text" id="fullname" name="fullname" maxlength="25" pattern="[a-zA-Z]+" required value="<?php echo $memberData['full_name']; ?>">
        </div>
        <div class="half">
          <label for="email">Email Address:</label>
          <input type="email" id="email" name="email" placeholder="e.g. abc@mail.com" required value="<?php echo $memberData['email']; ?>">
        </div>
        <div class="half">
          <label for="phone">Phone Number:</label><br>
          <input type="tel" id="phone" name="phone" maxlength="10" placeholder="e.g. 1234567890" pattern="\d+" required value="<?php echo $memberData['phone']; ?>">
        </div>
        <div class="half">
          <label for="passportNumber">Passport Number:</label>
          <input type="text" id="passportNumber" name="passportNumber" pattern="A\d{8}" title="Enter a valid Malaysian passport number" placeholder="e.g., A12345678" required>
        </div>
        <div class="half">
          <label for="passportExpiryDate">Passport Expiry Date:</label><br>
          <input type="date" id="passportExpiryDate" name="passportExpiryDate" min="<?php echo date('Y-m-d'); ?>" required>
        </div>
      </fieldset>

      <fieldset>
        <div id="passengerFormContainer" style="display: none;">
          <legend id="passengerLegend" style="display: none;">Passenger Information</legend>
          <!-- Hidden fields for passenger details -->
          <?php
          for ($i = 1; $i < 10; $i++) { // Assuming a maximum of 10 passengers
            echo "
          <input type='hidden' id='passengerName{$i}' name='passengerName[]' value=''>
          <input type='hidden' id='passengerDob{$i}' name='passengerDob[]' value=''>
          <input type='hidden' id='passengerPassport{$i}' name='passengerPassport[]' value=''>
          <input type='hidden' id='passengerExpiry{$i}' name='passengerExpiry[]' value=''>
        ";
          }
          ?>
        </div>
      </fieldset>
    <?php
    }
    ?>
    <input class="view-more" type="submit" value="Pay Now">
  </form>

  <br><br><br>
  <hr>
</body>

</html>