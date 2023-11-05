<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Book your Superstar flight tickets online today and enjoy a hassle-free travel experience. Get great deals on flights to popular destinations across the globe with Superstar airlines. Browse our flight options and book your tickets in a few easy steps.">
  <meta name="keywords" content="Superstar, flights, tickets">
  <meta name="author" content="Jason Tan">
  <title>Superstar - Flights</title>
  <link href="images/logo.png" rel="icon">

  <link href="styles/style.css" rel="stylesheet">
  <link href="styles/enhancements.css" rel="stylesheet">

  <!--The below CSS file is sourced from RemixIcon.com. 
      This CSS file is used for the icon beside "Need Help?"-->
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">

  <style>
    .container {
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
    }

    .table-column:not(:last-child) {
      border-right: 1px solid #ccc;
      /* Vertical line style */
    }

    h2 {
      margin-top: 0;
      /* Remove default margin for h2 */
    }

    section {
      margin-bottom: 20px;
    }

    section {
      text-align: center;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
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
  </style>

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
  $queryUser = mysqli_query($conn, "SELECT username FROM members WHERE id = $userId");
  $userData = mysqli_fetch_assoc($queryUser);
  $username = $userData['username'];
  include 'includes/header_ori.inc';
  ?>
  <hr>
  <div class="container">
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
              <li>Our staffs will communicate with you and proceed with the booking.</li>
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
              <li>Email: support@Superstar.com</li>
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

  <section>
    <center>
      <h2>Flights</h2>
    </center>
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
          <p><img class="destinations" src="img/<?php echo $row1['destinationimg']; ?>"><br>
            <br>
            <?php echo $row1['destinationdesc']; ?>
            <br><br>
            <?php echo $row1['destinationtext']; ?>
          </p>
          <br>
          <a href="enquire.php" class="enquire-now">Book Now</a>
        </td>
        <td>
          <p><img class="destinations" src="img/<?php echo $row2['destinationimg']; ?>"><br>
            <?php echo $row2['destinationdesc']; ?>
            <br><br>
            <?php echo $row2['destinationtext']; ?>
          </p>
          <br>
          <a href="enquire.php" class="enquire-now">Book Now</a>
        </td>
        <td>
          <p><img class="destinations" src="img/<?php echo $row3['destinationimg']; ?>"><br>
            <?php echo $row3['destinationdesc']; ?>
            <br><br>
            <?php echo $row3['destinationtext']; ?>
          </p>
          <br>
          <a href="enquire.php" class="enquire-now">Book Now</a>
        </td>
      </tr>
    </table>
  </section>
  <a href="#top" class="back-to-top">Back to Top</a><br><br><br>
  <hr>
  <?php include 'includes/footer.inc'; ?>
</body>

</html>