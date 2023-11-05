<!DOCTYPE html>
<html lang="en">

<head>
  <title>Superstar - Payment</title>
  <link href="images/logo.png" rel="icon">
  <script src="scripts/part2(2).js"></script>
  <link href="styles/style.css" rel="stylesheet">
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

  // Set session variable to track access
  $_SESSION['access_from_payment'] = true;

  if (
    !isset($_SERVER['HTTP_REFERER']) ||
    (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'enquire.php') === false)
  ) {
    // Invalid access attempt
    header("location: enquire.php");
    exit('Direct access to this page is not allowed.');
  }

  if (!empty($_POST['cabin'])) {
    $cabin = $_POST['cabin'];
  }
  if (!empty($_POST['features'])) {
    $features = implode(', ', $_POST['features']);
  }
  $numTickets = $_POST['numTickets'];

  // Retrieve values from enquireForm
  $selectedFlightId = $_POST['selectedFlightId'];
  $selectedDepartureDate = $_POST['selectedDepartureDate'];
  $selectedArrivalCity = $_POST['selectedArrivalCity'];
  $cabin = $_POST['cabin'];
  $features = !empty($_POST['features']) ? implode(', ', $_POST['features']) : '';
  $numTickets = $_POST['numTickets'];

  // Retrieve passenger details
  if (!empty($_POST['passengerName'])) {
    $passengerNames = $_POST['passengerName'];
    $passengerDobs = $_POST['passengerDob'];
    $passengerPassports = $_POST['passengerPassport'];
    $passengerExpiries = $_POST['passengerExpiry'];
  }

  // Retrieve member information
  $memberId = $userId;
  $memberQuery = "SELECT full_name, email, phone FROM members WHERE id = $memberId";
  $memberResult = mysqli_query($conn, $memberQuery);

  // Calculate cabin price based on selection
  $cabinPrice = 0.0;
  if ($cabin === 'First Class') {
    $cabinPrice = 500.00;
  } elseif ($cabin === 'Business Class') {
    $cabinPrice = 250.00;
  }

  // Calculate features price based on selection
  $featuresPrice = 0.0;
  if (!empty($_POST['features'])) {
    if (in_array('Flight Meal', $_POST['features'])) {
      $featuresPrice += (20.00 * $numTickets);
    }
    if (in_array('Baggage Protection', $_POST['features'])) {
      $featuresPrice += 50.00;
    }
  }

  function getFlightPrice($conn, $flightId)
  {
    $flightPriceQuery = "SELECT price FROM flights WHERE id = $flightId";
    $flightPriceResult = mysqli_query($conn, $flightPriceQuery);

    if ($flightPriceResult && mysqli_num_rows($flightPriceResult) > 0) {
      $row = mysqli_fetch_assoc($flightPriceResult);
      return $row['price'];
    }

    return 0;
  }

  $flightPrice = getFlightPrice($conn, $selectedFlightId);

  // Perform the calculation
  $totalPrice = ($flightPrice + $cabinPrice) * $numTickets + $featuresPrice;

  if ($memberResult && mysqli_num_rows($memberResult) > 0) {
    $memberData = mysqli_fetch_assoc($memberResult);

    // Retrieve additional information from the form
    $fullname = $memberData['full_name'];
    $email = $memberData['email'];
    $phone = $memberData['phone'];
    $passportNumber = $_POST['passportNumber'];
    $passportExpiryDate = $_POST['passportExpiryDate'];
  }

  include 'includes/header_ori.inc';
  ?>

  <hr>
  <div class="payment-container">
    <div class="payment">
      <h2>Payment Details</h2>

      <h3>Flight Details</h3>
      <ul>
        <li>Selected Flight ID: <?php echo $selectedFlightId; ?></li>
        <li>Selected Departure Date: <?php echo $selectedDepartureDate; ?></li>
        <li>Selected Arrival City: <?php echo $selectedArrivalCity; ?></li>
        <li>Cabin Class: <?php echo $cabin; ?></li>
        <li>Optional Features: <?php echo $features; ?></li>
        <li>Number of Tickets: <?php echo $numTickets; ?></li>
      </ul>

      <h3>Passenger Information</h3>
      <ul>
        Passenger 1 (Member):
        <li>Full Name: <?php echo $fullname; ?></li>
        <li>Email Address: <?php echo $email; ?></li>
        <li>Phone Number: <?php echo $phone; ?></li>
        <li>Passport Number: <?php echo $passportNumber; ?></li>
        <li>Passport Expiry Date: <?php echo $passportExpiryDate; ?></li>
      </ul>

      <?php if (!empty($passengerNames)) : ?>
        <ul>
          <?php for ($i = 0; $i < count($passengerNames); $i++) : ?>
            Passenger <?php echo ($i + 2); ?>:
            <li>Full Name: <?php echo $passengerNames[$i]; ?></li>
            <li>Date of Birth: <?php echo $passengerDobs[$i]; ?></li>
            <li>Passport Number: <?php echo $passengerPassports[$i]; ?></li>
            <li>Passport Expiry Date: <?php echo $passengerExpiries[$i]; ?></li>
            <br>
          <?php endfor; ?>
        </ul>
      <?php endif; ?>

      <div id="price">
        <h3>Total Price: RM<?php echo $totalPrice; ?></h3>
      </div>
    </div>
  </div>
  <div class="creditCard">
    <h3>Credit Card Details</h3>
    <form id="bookform" method="post" action="process_order.php" novalidate="novalidate" onsubmit="return validateCreditCard();">

      <!-- Hidden fields for values -->
      <input type="hidden" id="passportNumber" name="passportNumber" value="<?php echo $passportNumber; ?>">
      <input type="hidden" id="passportExpiryDate" name="passportExpiryDate" value="<?php echo $passportExpiryDate; ?>" required>
      <input type="hidden" id="flightId" name="flightId" value="<?php echo $selectedFlightId; ?>">
      <input type="hidden" id="member_id" name="member_id" value="<?php echo $userId; ?>">
      <input type="hidden" id="cabin" name="cabin" value="<?php echo $cabin; ?>">
      <input type="hidden" id="features" name="features" value="<?php echo $features; ?>">
      <input type="hidden" id="numTickets" name="numTickets" value="<?php echo $numTickets; ?>">
      <input type="hidden" id="selectedFlightId" name="selectedFlightId" value="<?php echo $selectedFlightId; ?>">
      <input type="hidden" id="selectedDepartureDate" name="selectedDepartureDate" value="<?php echo $selectedDepartureDate; ?>">
      <input type="hidden" id="selectedArrivalCity" name="selectedArrivalCity" value="<?php echo $selectedArrivalCity; ?>">
      <input type="hidden" id="totalPrice" name="totalPrice" value="<?php echo $totalPrice; ?>">

      <!-- Hidden fields for passenger details -->
      <?php if (!empty($passengerNames)) : ?>
        <?php for ($i = 0; $i < count($passengerNames); $i++) : ?>
          <input type="hidden" id="passengerName<?php echo $i + 1; ?>" name="passengerName[]" value="<?php echo $passengerNames[$i]; ?>">
          <input type="hidden" id="passengerDob<?php echo $i + 1; ?>" name="passengerDob[]" value="<?php echo $passengerDobs[$i]; ?>">
          <input type="hidden" id="passengerPassport<?php echo $i + 1; ?>" name="passengerPassport[]" value="<?php echo $passengerPassports[$i]; ?>">
          <input type="hidden" id="passengerExpiry<?php echo $i + 1; ?>" name="passengerExpiry[]" value="<?php echo $passengerExpiries[$i]; ?>">
        <?php endfor; ?>
      <?php endif; ?>

      <div class="full">
        <label for="cardType">Credit Card Type:</label>
        <select id="cardType" name="cardType">
          <option value="" selected disabled>Select a Card Type</option>
          <option value="Visa">Visa</option>
          <option value="Mastercard">Mastercard</option>
          <option value="AmEx">American Express</option>
        </select>
      </div>
      <br><br>
      <div class="half">
        <label for="cardName">Name on Credit Card:</label>
        <input type="text" id="cardName" name="cardName" maxlength="40" required>
      </div>
      <br><br>
      <div class="half">
        <label for="cardNumber">Credit Card Number:</label>
        <input type="text" id="cardNumber" name="cardNumber" required>
      </div>
      <br><br>
      <div class="half">
        <label for="expiryDate">Expiry Date (mm-yy):</label>
        <input type="text" id="expiryDate" name="expiryDate" required>
      </div>
      <br><br>
      <div class="half">
        <label for="cvv">Card Verification Value (CVV):</label>
        <input type="text" id="cvv" name="cvv" required>
      </div>
      <br><br>
      <div class="full">
        <div class="payButtons" id="prefill">
          <button type="button" id="cancelButton" onclick="cancelOrder()">Cancel Order</button>
          <button type="button" id="backForm" onclick="backToOrderForm()">Back to Order Form</button>
          <input type="submit" value="Check Out">
        </div>
      </div>
    </form>
  </div>


  <?php include 'includes/footer.inc'; ?>

  <script>
    function validateCreditCard() {
      // Get the credit card number from the input field
      var cardNumber = document.getElementById("cardNumber").value;

      // Regular expressions for different card types
      var visaPattern = /^4\d{15}$/;
      var mastercardPattern = /^5\d{15}$/;
      var amexPattern = /^3\d{14}$/;

      // Check if the card number matches any of the patterns
      if (visaPattern.test(cardNumber)) {
        document.getElementById("cardType").value = "Visa";
      } else if (mastercardPattern.test(cardNumber)) {
        document.getElementById("cardType").value = "Mastercard";
      } else if (amexPattern.test(cardNumber)) {
        document.getElementById("cardType").value = "American Express";
      } else {
        // Display an alert for invalid card number
        alert("Invalid credit card number. Please check the card type and try again.");
        return false;
      }

      // Expiry Date format: MM-YY
      var expiryDate = document.getElementById("expiryDate").value;

      // Parse the expiry date to get month and year
      var parts = expiryDate.split('-');
      var expMonth = parseInt(parts[0], 10);
      var expYear = parseInt(parts[1], 10) + 2000; // Assuming years are in the format YY

      // Get the current date
      var currentDate = new Date();
      var currentYear = currentDate.getFullYear();
      var currentMonth = currentDate.getMonth() + 1; // Months are zero-based

      // Check if the expiry year is before the current year or if it's the same year and the expiry month is before the current month
      if (expYear < currentYear || (expYear === currentYear && expMonth < currentMonth)) {
        alert("Invalid Expiry Date. Please enter a date after the current date.");
        return false;
      }

      // CVV format: 3 digits
      var cvv = document.getElementById("cvv").value;
      if (!/^\d{3}$/.test(cvv)) {
        alert("Invalid CVV. Please enter a valid 3-digit CVV.");
        return false;
      }

      // If all validations pass, the form can be submitted
      return true;
    }

    // Define JavaScript functions for onclick events
    function cancelOrder() {
      document.getElementById("bookform").reset();
      window.location.href = "customerPage.php";
    }

    function backToOrderForm() {
      // Set values directly to the form fields
      document.getElementById("cabin").value = "<?php echo $cabin; ?>";
      document.getElementById("features").value = "<?php echo $features; ?>";
      document.getElementById("numTickets").value = "<?php echo $numTickets; ?>";
      document.getElementById("selectedFlightId").value = "<?php echo $selectedFlightId; ?>";
      document.getElementById("selectedDepartureDate").value = "<?php echo $selectedDepartureDate; ?>";
      document.getElementById("selectedArrivalCity").value = "<?php echo $selectedArrivalCity; ?>";

      // Passenger details (assuming these are arrays)
      <?php if (!empty($passengerNames)) : ?>
        <?php for ($i = 0; $i < count($passengerNames); $i++) : ?>
          document.getElementById("passengerName<?php echo $i + 1; ?>").value = "<?php echo $passengerNames[$i]; ?>";
          document.getElementById("passengerDob<?php echo $i + 1; ?>").value = "<?php echo $passengerDobs[$i]; ?>";
          document.getElementById("passengerPassport<?php echo $i + 1; ?>").value = "<?php echo $passengerPassports[$i]; ?>";
          document.getElementById("passengerExpiry<?php echo $i + 1; ?>").value = "<?php echo $passengerExpiries[$i]; ?>";
        <?php endfor; ?>
      <?php endif; ?>

      // Navigate back to enquire.php
      window.location.href = "enquire.php";
    }
  </script>
</body>

</html>