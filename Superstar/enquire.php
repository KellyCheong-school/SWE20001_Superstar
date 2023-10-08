<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name = "description" content="Need to make a flight enquiry with AeroStar? Use our online enquiry form to get in touch with customer service and receive all the information you need about your flight.">
    <meta name = "keywords" content="AeroStar, flight, enquiry, form">
    <meta name = "author" content="Jason Tan">

    <title>AeroStar - Enquire</title>
    <link href="images/AeroStarLogo-Header.jpg" rel="icon">
    <script src="scripts/part2.js"></script>
    <link href = "styles/style.css" rel = "stylesheet">
    <link href = "styles/enhancements.css" rel = "stylesheet">
    <script src="scripts/enhancements.js"></script>
    
    </head>

    <body>
      <?php include 'includes/header.inc'; ?>
      <br><br>
      <form id="enquireForm" action="payment.php" method="post" novalidate="novalidate">
        <fieldset>
          <legend>Contact Information</legend>
          <div class="half">
            <label for="firstname">First Name:</label>
            <input type="text" id="firstname" name="firstname" maxlength="25" pattern="[a-zA-Z]+" required>
          </div>
          <div class="half">
            <label for="lastname">Last Name:</label>
            <input type="text" id="lastname" name="lastname" maxlength="25" pattern="[a-zA-Z]+" required>
          </div>
          <div class="half">
            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" placeholder="e.g. abc@mail.com" required>
          </div>
          <div class="half">
            <label for="phone">Phone Number:</label>
            <input type="text" id="phone" name="phone" maxlength="10" placeholder="e.g. 1234567890" pattern="\d+" required>
          </div>
        </fieldset>
        <fieldset>
          <legend>Address</legend>
          <div class="half">
            <label for="street">Street Address:</label>
            <input type="text" id="street" name="street" maxlength="40" required>
          </div>
          <div class="half">
            <label for="suburb">Suburb/Town:</label>
            <input type="text" id="suburb" name="suburb" maxlength="20" required>
          </div>
          <div class="half">
            <label for="state">State:</label>
            <select id="state" name="state" required>
              <option value="" selected disabled>Select State</option>
              <option value="VIC">VIC</option>
              <option value="NSW">NSW</option>
              <option value="QLD">QLD</option>
              <option value="NT">NT</option>
              <option value="WA">WA</option>
              <option value="SA">SA</option>
              <option value="TAS">TAS</option>
              <option value="ACT">ACT</option>
            </select>
          </div>
          <div class="half">
            <label for="postcode">Postcode:</label>
            <input type="text" id="postcode" name="postcode" pattern="\d{4}" required>
          </div>
          <div class="full">
            <label>Preferred Contact:</label>
            <label><input type="radio" id="email_contact" name="contact" value="email" required> Email</label>
            <label><input type="radio" id="post_contact" name="contact" value="post"> Post</label>
            <label><input type="radio" id="phone_contact" name="contact" value="phone"> Phone</label>
          </div>
        </fieldset>
        
        <fieldset>
          <legend>Flight Selection</legend>
          <div class="half" id="calendar">
            <label for="departureDate">Departure Date:</label>
            <input type="date" id="departureDate" name="departureDate" required>
          </div>
          <div class="half">
            <label for="returnDate">Return Date:</label>
            <input type="date" id="returnDate" name="returnDate" required>
          </div>
          <div class="half">
            <label for="flight">Flight:</label>
            <select id="flight" name="flight" required>
              <option value="" selected disabled>Select Flight</option>
              <option value="Tokyo, Japan">Tokyo, Japan (+RM2000.00 per person)</option>
              <option value="Bali, Indonesia">Bali, Indonesia (+RM500.00 per person)</option>
              <option value="Singapore">Singapore (+RM300.00 per person)</option>
            </select>
          </div>
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
              <label>Optional Features:</label><br>
              <input type="checkbox" id="gourmet-dining" name="features[]" value="Gourmet Dining">
              <label for="gourmet-dining">Gourmet dining (+RM100.00 per person)</label><br>
              <input type="checkbox" id="premium-entertainment" name="features[]" value="Premium Entertainment">
              <label for="premium-entertainment">Premium entertainment (+RM50.00 per person)</label><br>
          </div>
          <div class="half">
            <label for="numTickets">Number of tickets (Max 10):</label><br>
            <input type="number" id="numTickets" name="numTickets" min="1" max="10" value="1">
          </div>
          
        </fieldset>

        <label for="comment">Comments</label><br>
          <textarea id="comment" name="comment" placeholder="Enter your comments here"></textarea><br>
        <input class="view-more" type="submit" value="Pay Now">
    </form>

    <a href="#top" class="back-to-top">Back to Top</a><br><br><br>
    <hr>
    <?php include 'includes/footer.inc'; ?>
  </body>

</html>