<?php
session_start();

$_SESSION['access_from_fix_order'] = true;

// Check if the file is accessed through a valid flow
$validAccess = isset($_SERVER['HTTP_REFERER']) && (strpos($_SERVER['HTTP_REFERER'], 'payment.php') !== false || strpos($_SERVER['HTTP_REFERER'], 'fix_order.php') !== false);
$validFormSubmission = isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_ORIGIN']) && (strpos($_SERVER['HTTP_ORIGIN'], 'paymentform') !== false || strpos($_SERVER['HTTP_ORIGIN'], 'fixorderform') !== false);

if (!$validAccess && !$validFormSubmission) {
  // Invalid access attempt
  header("location: enquire.php");
  exit('Direct access to this page is not allowed.');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fix Order</title>
  <link href="images/AeroStarLogo-Header.jpg" rel="icon">
  <link href="styles/style.css" rel="stylesheet">
  <script src="scripts/enhancements.js"></script>
</head>

<body>
  <h1 >Fix Order</h1>
  <form id="fixOrderForm" method="post" action="process_order.php" novalidate="novalidate">
    <!-- Display the error messages next to the form fields -->
    <div class="half">
      <label for="firstname">First Name:
        <?php if (isset($_GET['errors']['firstname'])) : ?>
          <span class="error-message"><?php echo 'Error - ' . $_GET['errors']['firstname']; ?></span>
        <?php endif; ?>
      </label>
      <input type="text" id="firstname" name="firstname" value="<?php echo $_GET['firstname']; ?>" required>
    </div>

    <div class="half">
      <label for="lastname">Last Name:
        <?php if (isset($_GET['errors']['lastname'])) : ?>
          <span class="error-message"><?php echo 'Error - ' . $_GET['errors']['lastname']; ?></span>
        <?php endif; ?>
      </label>
      <input type="text" id="lastname" name="lastname" value="<?php echo $_GET['lastname']; ?>" required>
    </div>

    <div class="half">
      <label for="email">Email Address:
        <?php if (isset($_GET['errors']['email'])) : ?>
          <span class="error-message"><?php echo 'Error - ' . $_GET['errors']['email']; ?></span>
        <?php endif; ?>
      </label>
      <input type="email" id="email" name="email" value="<?php echo $_GET['email']; ?>" required>
    </div>

    <div class="half">
      <label for="phone">Phone Number:
        <?php if (isset($_GET['errors']['phone'])) : ?>
          <span class="error-message"><?php echo 'Error - ' . $_GET['errors']['phone']; ?></span>
        <?php endif; ?>
      </label>
      <input type="text" id="phone" name="phone" value="<?php echo $_GET['phone']; ?>" required>
    </div>

    <div class="half">
      <label for="street">Street Address:
        <?php if (isset($_GET['errors']['street'])) : ?>
          <span class="error-message"><?php echo 'Error - ' . $_GET['errors']['street']; ?></span>
        <?php endif; ?>
      </label>
      <input type="text" id="street" name="street" value="<?php echo $_GET['street']; ?>" required>
    </div>

    <div class="half">
      <label for="suburb">Suburb/Town:
        <?php if (isset($_GET['errors']['suburb'])) : ?>
          <span class="error-message"><?php echo 'Error - ' . $_GET['errors']['suburb']; ?></span>
        <?php endif; ?>
      </label>
      <input type="text" id="suburb" name="suburb" value="<?php echo $_GET['suburb']; ?>" required>
    </div>

    <div class="half">
      <label for="state">State:
        <?php if (isset($_GET['errors']['state'])) : ?>
          <span class="error-message"><?php echo 'Error - ' . $_GET['errors']['state']; ?></span>
        <?php endif; ?>
      </label>
      <select id="state" name="state" required>
        <option value="" selected disabled>Select State</option>
        <option value="VIC" <?php if ($_GET['state'] === 'VIC') echo 'selected'; ?>>VIC</option>
        <option value="NSW" <?php if ($_GET['state'] === 'NSW') echo 'selected'; ?>>NSW</option>
        <option value="QLD" <?php if ($_GET['state'] === 'QLD') echo 'selected'; ?>>QLD</option>
        <option value="NT" <?php if ($_GET['state'] === 'NT') echo 'selected'; ?>>NT</option>
        <option value="WA" <?php if ($_GET['state'] === 'WA') echo 'selected'; ?>>WA</option>
        <option value="SA" <?php if ($_GET['state'] === 'SA') echo 'selected'; ?>>SA</option>
        <option value="TAS" <?php if ($_GET['state'] === 'TAS') echo 'selected'; ?>>TAS</option>
        <option value="ACT" <?php if ($_GET['state'] === 'ACT') echo 'selected'; ?>>ACT</option>
      </select>
    </div>

    <div class="half">
      <label for="postcode">Postcode:
        <?php if (isset($_GET['errors']['postcode'])) : ?>
          <span class="error-message"><?php echo 'Error - ' . $_GET['errors']['postcode']; ?></span>
        <?php endif; ?>
      </label>
      <input type="text" id="postcode" name="postcode" value="<?php echo $_GET['postcode']; ?>" required>
    </div>

    <div class="full">
      <label>Preferred Contact:
        <?php if (isset($_GET['errors']['contact'])) : ?>
          <span class="error-message"><?php echo 'Error - ' . $_GET['errors']['contact']; ?></span>
        <?php endif; ?>
      </label><br>
      <label><input type="radio" id="email_contact" name="contact" value="email" <?php if ($_GET['contact'] === 'email') echo 'checked'; ?> required> Email</label>
      <label><input type="radio" id="post_contact" name="contact" value="post" <?php if ($_GET['contact'] === 'post') echo 'checked'; ?>> Post</label>
      <label><input type="radio" id="phone_contact" name="contact" value="phone" <?php if ($_GET['contact'] === 'phone') echo 'checked'; ?>> Phone</label>
    </div>


    <div class="half">
      <label for="departureDate">Departure Date:
        <?php if (isset($_GET['errors']['departureDate'])) : ?>
          <span class="error-message"><?php echo 'Error - ' . $_GET['errors']['departureDate']; ?></span>
        <?php endif; ?>
      </label>
      <input type="date" id="departureDate" name="departureDate" value="<?php echo $_GET['departureDate']; ?>" required>
    </div>

    <div class="half">
      <label for="returnDate">Return Date:
        <?php if (isset($_GET['errors']['returnDate'])) : ?>
          <span class="error-message"><?php echo 'Error - ' . $_GET['errors']['returnDate']; ?></span>
        <?php endif; ?>
      </label>
      <input type="date" id="returnDate" name="returnDate" value="<?php echo $_GET['returnDate']; ?>" required>
    </div>

    <div class="half">
      <label for="flight">Flight:
        <?php if (isset($_GET['errors']['flight'])) : ?>
          <span class="error-message"><?php echo 'Error - ' . $_GET['errors']['flight']; ?></span>
        <?php endif; ?>
      </label>
      <select id="flight" name="flight" required>
        <option value="" selected disabled>Select Flight</option>
        <option value="Tokyo, Japan" <?php if ($_GET['flight'] === 'Tokyo, Japan') echo 'selected'; ?>>Tokyo, Japan (+RM2000.00 per person)</option>
        <option value="Bali, Indonesia" <?php if ($_GET['flight'] === 'Bali, Indonesia') echo 'selected'; ?>>Bali, Indonesia (+RM500.00 per person)</option>
        <option value="Singapore" <?php if ($_GET['flight'] === 'Singapore') echo 'selected'; ?>>Singapore (+RM300.00 per person)</option>
      </select>
    </div>

    <div class="half">
      <label for="cabin">Cabin Class:
        <?php if (isset($_GET['errors']['cabin'])) : ?>
          <span class="error-message"><?php echo 'Error - ' . $_GET['errors']['cabin']; ?></span>
        <?php endif; ?>
      </label>
      <select id="cabin" name="cabin" required>
        <option value="" selected disabled>Select Cabin Class</option>
        <option value="First Class" <?php if ($_GET['cabin'] === 'First Class') echo 'selected'; ?>>First Class (+RM500.00 per person)</option>
        <option value="Business Class" <?php if ($_GET['cabin'] === 'Business Class') echo 'selected'; ?>>Business Class (+RM250.00 per person)</option>
        <option value="Economy Class" <?php if ($_GET['cabin'] === 'Economy Class') echo 'selected'; ?>>Economy Class (+RM0.00 per person)</option>
      </select>
    </div>

    <div class="half">
      <label>Optional Features:
        <?php if (isset($_GET['errors']['features'])) : ?>
          <span class="error-message"><?php echo 'Error - ' . $_GET['errors']['features']; ?></span>
        <?php endif; ?>
      </label><br>
      <?php
      $features = isset($_GET['features']) ? explode(', ', $_GET['features']) : []; // Assuming features are passed as comma-separated values in the URL

      $availableFeatures = ['Gourmet Dining', 'Premium Entertainment'];

      foreach ($availableFeatures as $feature) {
        $isChecked = in_array($feature, $features) ? 'checked' : '';
        echo '<input type="checkbox" id="' . strtolower(str_replace(' ', '-', $feature)) . '" name="features[]" value="' . $feature . '" ' . $isChecked . '>';
        echo '<label for="' . strtolower(str_replace(' ', '-', $feature)) . '">' . $feature . ' (+RM100.00 per person)</label><br>';
      }
      ?>
    </div>

    <div class="half">
      <label for="numTickets">Number of tickets (Max 10):
        <?php if (isset($_GET['errors']['numTickets'])) : ?>
          <span class="error-message"><?php echo 'Error - ' . $_GET['errors']['numTickets']; ?></span>
        <?php endif; ?>
      </label><br>
      <input type="number" id="numTickets" name="numTickets" min="1" max="10" value="<?php echo $_GET['numTickets']; ?>">
    </div>

    <div class="full">
      <label for="comment">Comment:
        <?php if (isset($_GET['errors']['comment'])) : ?>
          <span class="error-message"><?php echo 'Error - ' . $_GET['errors']['comment']; ?></span>
        <?php endif; ?>
      </label><br>
      <textarea id="comment" name="comment"><?php echo $_GET['comment']; ?></textarea>
    </div>

    <input type="hidden" name="totalPrice" id="totalPrice" value="<?php echo $_GET['totalPrice']; ?>">

    <div class="full">
      <label for="cardType">Credit Card Type:
        <?php if (isset($_GET['errors']['cardType'])) : ?>
          <span class="error-message"><?php echo 'Error - ' . $_GET['errors']['cardType']; ?></span>
        <?php endif; ?>
      </label>
      <select id="cardType" name="cardType">
        <option value="" selected disabled>Select a Card Type</option>
        <option value="Visa">Visa</option>
        <option value="Mastercard">Mastercard</option>
        <option value="AmEx">American Express</option>
      </select>
    </div>

    <div class="half">
      <label for="cardName">Name on Credit Card:
        <?php if (isset($_GET['errors']['cardName'])) : ?>
          <span class="error-message"><?php echo 'Error - ' . $_GET['errors']['cardName']; ?></span>
        <?php endif; ?>
      </label>
      <input type="text" id="cardName" name="cardName" maxlength="40">
    </div>

    <div class="half">
      <label for="cardNumber">Credit Card Number:
        <?php if (isset($_GET['errors']['cardNumber'])) : ?>
          <span class="error-message"><?php echo 'Error - ' . $_GET['errors']['cardNumber']; ?></span>
        <?php endif; ?>
      </label>
      <input type="text" id="cardNumber" name="cardNumber">
    </div>

    <div class="half">
      <label for="expiryDate">Expiry Date (mm-yy):
        <?php if (isset($_GET['errors']['expiryDate'])) : ?>
          <span class="error-message"><?php echo 'Error - ' . $_GET['errors']['expiryDate']; ?></span>
        <?php endif; ?>
      </label>
      <input type="text" id="expiryDate" name="expiryDate">
    </div>

    <div class="half">
      <label for="cvv">Card Verification Value (CVV):
        <?php if (isset($_GET['errors']['cvv'])) : ?>
          <span class="error-message"><?php echo 'Error - ' . $_GET['errors']['cvv']; ?></span>
        <?php endif; ?>
      </label>
      <input type="text" id="cvv" name="cvv">
    </div>

    <!-- The form should submit back to "process_order.php" using the POST method -->
    <input class="view-more" type="submit" value="Submit">
  </form>

</body>

</html>