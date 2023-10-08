<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Welcome to AeroStar. Browse our flights and book tickets online for affordable and comfortable trips to your desired destinations. Explore our website and discover our exciting travel deals and packages.">
  <meta name="keywords" content="AeroStar, Main Menu">
  <meta name="author" content="Jason Tan">
  <title>AeroStar - Home</title>
  <link href="images/AeroStarLogo-Header.jpg" rel="icon">

  <link href="styles/style.css" rel="stylesheet">
  <link href="styles/enhancements.css" rel="stylesheet">
  <script src="scripts/enhancements2.js"></script>

</head>

<body>
  <header>
    <section class="logo-container">
      <img src="images/AeroStarLogo.png" alt="AeroStar Logo">
      <h1>AeroStar - Taking you higher</h1>
    </section>

    <a class="view-more" href="index.php">Login</a><br>
  </header>
  <?php
  require_once('settings.php');

  // Establish a database connection
  $conn = @mysqli_connect($host, $user, $pwd, $sql_db);

  // Check if the connection was successful
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  $query1 = mysqli_query($conn, "SELECT * FROM destination ORDER BY RAND() LIMIT 2");

  $row1 = mysqli_fetch_array($query1);
  $row2 = mysqli_fetch_array($query1);
  ?>

  <hr>
  <h2>Destinations</h2>
  <p>Our flight destinations vary across Asia, including Tokyo in Japan, Bali in Indonesia, Seoul
    in South Korea, Bangkok in Thailand, and Singapore. For European destinations, we offer flights to Paris in France,
    Rome in Italy, Barcelona in Spain, Amsterdam in the Netherlands, and Berlin in Germany.</p>
  <p class="hidden">Scroll left for more destinations!</p>
  <table class="flights">
    <tr class="flights">
      <td class="flights"> <img src="img/<?php echo $row1['destinationimg']; ?>" width="400"><br><br><?php echo $row1['destinationname']; ?>
        <?php echo $row1['destinationdesc']; ?><br><br>Economy class from <br>RM <?php echo $row1['destinationprice']; ?>
        <br><a class="view-more" href="<?php echo $row1['destinationname']; ?>index.php">View More</a>
      </td><br>
      <td class="flights"> <img src="img/<?php echo $row2['destinationimg']; ?>" width="400"><br><br><?php echo $row2['destinationname']; ?>
        <?php echo $row2['destinationdesc']; ?><br><br>Economy from <br>RM <?php echo $row2['destinationprice']; ?>
        <br><a class="view-more" href="<?php echo $row2['destinationname']; ?>index.php">View More</a>
      </td>
    </tr>
  </table>
  <?php // Close the database connection
  mysqli_close($conn);
  ?>

  <hr>

  <div class="benefits-container">
  <p>Enjoy exclusive benefits as a member:</p>
        <ul>
            <li>Priority access to promotions</li>
            <li>Book flight tickets</li>
            <li>View destinations provided and the descriptions of tourist spots</li>
        </ul>

        <p><a href="member_registration.php">Be a member now!</a></p>
  </div>

  <a href="#top" class="back-to-top">Back to Top</a><br><br><br>
  <hr>
  <?php include 'includes/footer.inc'; ?>
</body>

</html>