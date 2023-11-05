<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>AeroStar - Enquire</title>
  <link href="images/AeroStarLogo-Header.jpg" rel="icon">
  <script src="scripts/part2.js"></script>
  <link href="styles/style.css" rel="stylesheet">
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
  include 'includes/header_ori.inc';
  ?>
  <br><br>

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
      <input class="view-more" type="submit" value="Search Flights">
    </fieldset>
  </form>

  <!-- Display Search Results -->
  <?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($searchFlightsResult) && mysqli_num_rows($searchFlightsResult) > 0) {
      echo "<h3>Available Flights</h3>";
      while ($row = mysqli_fetch_assoc($searchFlightsResult)) {
        // Display flight information here
        echo "Departure Date: " . $row['departure_datetime'] . "<br>";
        echo "Arrival City: " . $row['arrival_city'] . "<br>";
        echo "Flight Price: RM" . $row['price'] . "<br>";
        // Add a button to set variables in the enquireForm
        echo "<button type='button' onclick=\"setEnquireFormVariables('" . $row['id'] . "','" . $row['departure_datetime'] . "','" . $row['arrival_city'] . "')\">Select This Flight</button>";

        echo "<hr>";
      }
    } else {
      echo "<p>Sorry, the desired flight is unavailable. Here are some other flights based on your search:</p>";

      // Fetch other flights based on departure_datetime or arrival_city
      $otherFlightsQuery = "SELECT * FROM flights WHERE DATE(departure_datetime) >= '$searchDepartureDate' AND arrival_city = '$searchArrivalCity'";
      $otherFlightsResult = mysqli_query($conn, $otherFlightsQuery);

      if ($otherFlightsResult && mysqli_num_rows($otherFlightsResult) > 0) {
        echo "<h3>Other Available Flights</h3>";
        while ($row = mysqli_fetch_assoc($otherFlightsResult)) {
          // Display flight information here
          echo "Departure Date: " . $row['departure_datetime'] . "<br>";
          echo "Arrival City: " . $row['arrival_city'] . "<br>";
          echo "Flight Price: RM" . $row['price'] . "<br>";
          // Add a button to set variables in the enquireForm
          echo "<button type='button' onclick=\"setEnquireFormVariables('" . $row['id'] . "','" . $row['departure_datetime'] . "','" . $row['arrival_city'] . "')\">Select This Flight</button>";

          echo "<hr>";
        }
      } else {
        echo "<p>No other flights found based on the search criteria.</p>";
      }
    }
  }
  ?>

  <form id="enquireForm" action="payment.php" method="post" novalidate="novalidate">
    <input type="hidden" id="selectedFlightId" name="selectedFlightId" value="<?php echo isset($_POST['selectedFlightId']) ? $_POST['selectedFlightId'] : ''; ?>" required>
    <input type="hidden" id="selectedDepartureDate" name="selectedDepartureDate" value="<?php echo isset($_POST['selectedDepartureDate']) ? $_POST['selectedDepartureDate'] : ''; ?>" required>
    <input type="hidden" id="selectedArrivalCity" name="selectedArrivalCity" value="<?php echo isset($_POST['selectedArrivalCity']) ? $_POST['selectedArrivalCity'] : ''; ?>" required>

    <fieldset>
      <legend>Flight Preferences</legend>
      <div class="half">
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

  <a href="#top" class="back-to-top">Back to Top</a><br><br><br>
  <hr>
  <?php include 'includes/footer.inc'; ?>
</body>

</html>