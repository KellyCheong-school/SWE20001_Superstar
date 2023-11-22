<!DOCTYPE html>
<html lang="en">

<head>
<title>Destinations</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="./images/logo(icon).png" rel="icon">
  <style type="text/css">
    @import url('https://fonts.googleapis.com/css?family=Open+Sans:400,700,800');
    @import url('https://fonts.googleapis.com/css?family=Lobster');

    body {
      font-family: 'Open Sans', sans-serif;
    }

    .first_container {
      max-width: 1200px;
      margin: 20px auto;
      padding: 20px;
      background-color: white;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      text-align: center;
      /* Center the content */
    }

    .three-column-table {
      display: table;
      width: 100%;
      border-spacing: 20px;
      border-collapse: separate;
      /* Separate borders */
    }

    .table-row {
      display: table-row;
    }

    .table-column {
      display: table-cell;
      vertical-align: top;
      width: 33.33%;
      /* Equal width for each column */
      position: relative;
      /* Relative positioning for the vertical line */
      padding-right: 20px;
      /* Add padding to the right for the line */
      color: #000000;
    }

    .table-column:not(:last-child) {
      border-right: 1px solid #ccc;
      /* Vertical line style */
    }

    section {
      margin-bottom: 20px;
      text-align: center;
    }

    section h2 {
      font-weight: bold;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;

    }

    /*For changing destination name color*/
    th {
      color: #000000;
    }

    /*For changing description color*/
    td {
      color: #fff;
    }

    th,
    td {
      border: 1px solid #ddd;
      padding: 8px;
      width: 33%;
      /* Set equal width for each cell */
    }

    th {
      background-color: #f2f2f2;
    }

    .destinations {
      width: 100%;
      /* Set equal width for each image */
      height: auto;
    }

    .destinations-img {
      width: 600px;
      height: 350px;
    }

    .white-text {
      color: white;
    }

    /*.enquire-now: sets the width, margin, padding, text alignment, color, background color, border radius, 
  box shadow, font size, and font weight for the "Enquire Now" button.*/
    .enquire-now {
      display: block;
      width: 150px;
      margin: 20px auto;
      padding: 10px 20px;
      text-align: center;
      text-decoration: none;
      color: #000000;
      background-color: #FFCBA4;
      border-radius: 5px;
      box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
      font-size: 20px;
      transition: background-color 0.2s ease-in-out;
    }

    /*.enquire-now a: sets the color and text decoration for the "Enquire Now" button link.*/
    .enquire-now a {
      color: white;
      text-decoration: none;
    }

    /*.enquire-now:hover: sets the background color when hovering over the "Enquire Now" button.*/
    .enquire-now:hover {
      background-color: #fff;
      color: #000000;
    }

    .back-to-top:hover {
      color: #fff;
    }
  </style>

</head>

<body>
  <?php
  require_once('settings.php');
  session_start();

  // Check if the user is logged in
  if (isset($_SESSION['member_id'])) {
    // The user is logged in, display the welcome message
    $userId = $_SESSION['member_id'];
    $username = $_SESSION['member_username'];
  } else {
    // Redirect the user to the login page if not logged in
    header("Location: index.php");
    exit();
  }
  // Establish a database connection
  $conn = @mysqli_connect($host, $user, $pwd, $sql_db);

  // Check if the connection was successful
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  $queryUser = mysqli_query($conn, "SELECT username FROM members WHERE id = $userId");
  $userData = mysqli_fetch_assoc($queryUser);
  $username = $userData['username'];
  include 'includes/memberHeader.inc';

  $query1 = mysqli_query($conn, "SELECT * FROM destination ORDER BY RAND() LIMIT 2");

  $row1 = mysqli_fetch_array($query1);
  $row2 = mysqli_fetch_array($query1);
  ?>

  <br><br><br><br>

  <div class="first_container">
    <div class="three-column-table">
      <div class="table-row">
        <!-- First Column -->
        <div class="table-column">
          <section>
            <h2>Steps To Book</h2>
            <ol>
              <li>Select your desirable flight destination.</li>
              <li>Click "Enquire Now" button.</li>
              <li>Fill up the form and submit.</li>
              <li>Our staffs will communicate with you and <br> proceed with the booking.</li>
            </ol>
          </section>
        </div>

        <!-- Vertical Line -->
        <div class="vertical-line"></div>

        <!-- Second Column -->
        <div class="table-column">
          <section>
            <h2>Need Help?</h2>
            <p>Our customer support team is available 24/7 to assist you with any questions or issues you may have. Contact us via phone or email:</p>
            <ul>
              <li>Phone: 1-800-123-4567</li>
              <li>Email: support@aerostar.com</li>
            </ul>
          </section>
        </div>

        <!-- Vertical Line -->
        <div class="vertical-line"></div>

        <!-- Third Column -->
        <div class="table-column">
          <section>
            <h2>Cabin Classes Available</h2>
            <ul>
              <li>First Class</li>
              <li>Business Class</li>
              <li>Economy Class</li>
            </ul>
          </section>
        </div>
      </div>
    </div>
  </div>

  <br>
  <section>
    <center>
      <h2 class="white-text"> Flights</h2>
    </center>
    <br>
    <?php
    $query1 = mysqli_query($conn, "SELECT * FROM destination ORDER BY RAND() LIMIT 3");

    $row1 = mysqli_fetch_array($query1);
    $row2 = mysqli_fetch_array($query1);
    $row3 = mysqli_fetch_array($query1);
    ?>
    <table>
      <tr>
        <th><?php echo $row1['destinationname']; ?></th>
        <th><?php echo $row2['destinationname']; ?></th>
        <th><?php echo $row3['destinationname']; ?></th>
      </tr>
      <tr>
        <td>
          <img class="destinations" src="img/<?php echo $row1['destinationimg']; ?>">
        </td>
        <td>
          <img class="destinations" src="img/<?php echo $row2['destinationimg']; ?>">
        </td>
        <td>
          <img class="destinations" src="img/<?php echo $row3['destinationimg']; ?>">
        </td>
      </tr>
      <tr>
        <td>
          <?php echo $row1['destinationdesc']; ?>
        </td>
        <td>
          <?php echo $row2['destinationdesc']; ?>
        </td>
        <td>
          <?php echo $row3['destinationdesc']; ?>
        </td>
      </tr>
      <tr>
        <td>
          <a href="enquire.php" class="enquire-now">Book Now</a>
        </td>
        <td>
          <a href="enquire.php" class="enquire-now">Book Now</a>
        </td>
        <td>
          <a href="enquire.php" class="enquire-now">Book Now</a>
        </td>
      </tr>
    </table>
  </section>

  <p style="text-align:center">
    <a href="#top" class="back-to-top">Back to Top</a><br><br><br>
  </p>

  <hr>
</body>

</html>