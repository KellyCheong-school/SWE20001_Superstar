<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name = "description" content="This is the payment page for AeroStar.">
    <meta name = "keywords" content="AeroStar, Payment">
    <meta name = "author" content="Jason Tan">
    <title>AeroStar - Payment</title>
    <link href="images/AeroStarLogo-Header.jpg" rel="icon">
    <script src="scripts/part2(2).js"></script>
    <link href = "styles/style.css" rel = "stylesheet">

  </head>
 
    <body>
      <?php 
        session_start();
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

        if (!empty($_POST['flight'])){
        $flight =  $_POST['flight'];
        }
        if (!empty($_POST['cabin'])){
        $cabin = $_POST['cabin'];
        }
        if (!empty($_POST['features'])) {
          $features = implode(', ', $_POST['features']);
        }
        $numTickets = $_POST['numTickets'];
      ?>

      <?php include 'includes/header.inc'; ?>
        <hr>
        <div class="payment-container">
          <div class = "payment">
            <h2>Payment Details</h2>
            <h3>Customer Details</h3>
            <ul>
              <li>First Name: <span id="firstname"><?php echo $_POST['firstname']; ?></span></li>
              <li>Last Name: <span id="lastname"><?php echo $_POST['lastname']; ?></span></li>
              <li>Email: <span id="email"><?php echo $_POST['email']; ?></span></li>
              <li>Phone: <span id="phone"><?php echo $_POST['phone']; ?></span></li>
              <li>Address: <span id="address"><?php echo $_POST['street'] . ', ' . $_POST['suburb']; ?></span></li>
              <li>Preferred Contact: <span id="contact"><?php if (!empty($_POST['contact'])) echo $_POST['contact']; ?></span></li>
              <li>State: <span id="state"><?php if (!empty($_POST['state'])) echo  $_POST['state'] ; ?></span></li>
              <li>Postcode: <span id="postcode"><?php echo $_POST['postcode']; ?></span></li>
            </ul>
          
            <h3>Flight Details</h3>
            <ul>
              <li>Departure Date: <span id="departureDate"><?php echo $_POST['departureDate']; ?></span></li>
              <li>Return Date: <span id="returnDate"><?php if (!empty($_POST['returnDate'])) echo $_POST['returnDate']; ?></span></li>
              <li>Flight: <span id="flight"><?php if (!empty($_POST['flight'])) echo $_POST['flight']; ?></span></li>
              <li>Cabin: <span id="cabin"><?php if (!empty($_POST['cabin'])) echo $_POST['cabin']; ?></span></li>
              <li>Optional Features: <span id="features"><?php if (!empty($_POST['features'])) echo $features; ?></span></li>
              <li>Number of Tickets: <span id="numTickets"><?php echo $_POST['numTickets']; ?></span></li>
              <li>Comments: <span id="comment"><?php echo $_POST['comment']; ?></span></li>
            </ul>
        
            <div id="price">
              <?php
              function calculateFlight($flight, $cabin, $features, $numTickets) {
                // Calculate the total price of the purchase
                $flightPrice = 0;
                if ($flight === "Tokyo, Japan") {
                    $flightPrice = 2000;
                }
                else if ($flight === "Bali, Indonesia") {
                    $flightPrice = 500;
                }
                else if ($flight === "Singapore") {
                    $flightPrice = 300;
                }
            
                $pricePerTicket = 0;
                if ($cabin === "First Class") {
                    $pricePerTicket = 500;
                }
                else if ($cabin === "Business Class") {
                    $pricePerTicket = 250;
                }
                else if ($cabin === "Economy Class") {
                    $pricePerTicket = 0;
                }
            
                $totalFeaturesPrice = 0;
                // Split the features string into an array of optional features
                $optionalFeatures = explode(', ', $features);
                foreach ($optionalFeatures as $feature) {
                    if ($feature === "Gourmet Dining") {
                        $totalFeaturesPrice += 100;
                    }
                    else if ($feature === "Premium Entertainment") {
                        $totalFeaturesPrice += 50;
                    }
                }
            
                // Calculate the total price by multiplying the number of tickets with the sum of prices
                $totalPrice = $numTickets * ($pricePerTicket + $flightPrice + $totalFeaturesPrice);
            
                // Display the total price on the payment page
                return number_format($totalPrice, 2); // Format the total price with 2 decimal places
            }
            
              ?>
              <h3>Total Price: RM<span id="totalPrice">
                <?php 
                if (!empty($flight) && !empty($cabin) && !empty($features) && !empty($numTickets))
                echo calculateFlight($flight, $cabin, $features, $numTickets); 
                ?></span></h3>
            </div>
        </div>
      </div>
      <div class="creditCard">
          <h3>Credit Card Details</h3>
          <form id="bookform" method="post" action="process_order.php" novalidate="novalidate">
            <input type="hidden" name="Firstname" id="Firstname">
            <input type="hidden" name="Lastname" id="Lastname">
            <input type="hidden" name="Email" id="Email">
            <input type="hidden" name="Phone" id="Phone">
            <input type="hidden" name="Street" id="Street">
            <input type="hidden" name="Suburb" id="Suburb">
            <input type="hidden" name="Contacts" id="Contacts">
            <input type="hidden" name="State" id="State">
            <input type="hidden" name="Postcode" id="Postcode">
            <input type="hidden" name="DepartureDate" id="DepartureDate">
            <input type="hidden" name="ReturnDate" id="ReturnDate">
            <input type="hidden" name="Flight" id="Flight">
            <input type="hidden" name="Cabin" id="Cabin">
            <input type="hidden" name="Features" id="Features">
            <input type="hidden" name="NumTickets" id="NumTickets">
            <input type="hidden" name="Comment" id="Comment">
            <input type="hidden" name="TotalPrice" id="TotalPrice">

            <input type="hidden" name="firstname" id="firstname" value="<?php echo $_POST['firstname']; ?>">
            <input type="hidden" name="lastname" id="lastname" value="<?php echo $_POST['lastname']; ?>">
            <input type="hidden" name="email" id="email" value="<?php echo $_POST['email']; ?>">
            <input type="hidden" name="phone" id="phone" value="<?php echo $_POST['phone']; ?>">
            <input type="hidden" name="street" id="street" value="<?php echo $_POST['street']; ?>">
            <input type="hidden" name="suburb" id="suburb" value="<?php echo $_POST['suburb']; ?>">
            <input type="hidden" name="contact" id="contact" value="<?php echo $_POST['contact']; ?>">
            <input type="hidden" name="state" id="state" value="<?php echo $_POST['state']; ?>">
            <input type="hidden" name="postcode" id="postcode" value="<?php echo $_POST['postcode']; ?>">
            <input type="hidden" name="departureDate" id="departureDate" value="<?php echo $_POST['departureDate']; ?>">
            <input type="hidden" name="returnDate" id="returnDate" value="<?php echo $_POST['returnDate']; ?>">
            <input type="hidden" name="flight" id="flight" value="<?php echo $_POST['flight']; ?>">
            <input type="hidden" name="cabin" id="cabin" value="<?php echo $_POST['cabin']; ?>">
            <input type="hidden" name="features" id= "features" value="<?php echo $features; ?>">
            <input type="hidden" name="numTickets" id="numTickets" value="<?php echo $_POST['numTickets']; ?>">
            <input type="hidden" name="comment" id="comment" value="<?php echo $_POST['comment']; ?>">
            <input type="hidden" name="totalPrice" id="totalPrice" value="<?php echo calculateFlight($flight, $cabin, $features, $numTickets); ?>">

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
                <button type="button" id="cancelButton">Cancel Order</button>
                <button type="button" id="backForm">Back to Order Form</button>
                <input type="submit" value="Check Out">
              </div>
            </div>
          </form>
        </div>
        
        
       <?php include 'includes/footer.inc'; ?>
      </body>

</html>