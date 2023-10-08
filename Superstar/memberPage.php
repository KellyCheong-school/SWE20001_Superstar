<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name = "description" content="Welcome to AeroStar. Browse our flights and book tickets online for affordable and comfortable trips to your desired destinations. Explore our website and discover our exciting travel deals and packages.">
    <meta name = "keywords" content="AeroStar, Main Menu">
    <meta name = "author" content="Jason Tan">
    <title>AeroStar - Home</title>
    <link href="images/AeroStarLogo-Header.jpg" rel="icon">

    <link href = "styles/style.css" rel = "stylesheet">
    <link href = "styles/enhancements.css" rel = "stylesheet">
    <script src="scripts/enhancements2.js"></script>

  </head>
 
    <body>
      <?php include 'includes/header.inc';?>
        <?php
        require_once('settings.php');

        // Establish a database connection
        $conn = @mysqli_connect($host, $user, $pwd, $sql_db);

        // Check if the connection was successful
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        
        $query1 = mysqli_query($conn,"SELECT * FROM destination ORDER BY RAND() LIMIT 2");

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
            <?php echo $row1['destinationdesc']; ?><br><br>Economy class from <br>RM <?php echo $row1['destinationprice'];?>
            <br><a class="view-more" href="<?php echo $row1['destinationname']; ?>.php">View More</a>
            <br><a class="view-more" href="enquire.php">Book Now</a>
          </td><br>
            <td class="flights"> <img src="img/<?php echo $row2['destinationimg']; ?>" width="400"><br><br><?php echo $row2['destinationname']; ?>
            <?php echo $row2['destinationdesc']; ?><br><br>Economy from <br>RM <?php echo $row2['destinationprice'];?>
            <br><a class="view-more" href="<?php echo $row2['destinationname']; ?>.php">View More</a>
            <br><a class="view-more" href="enquire.php">Book Now</a>
            </td>
          </tr>
        </table>
        <?php // Close the database connection
            mysqli_close($conn);
        ?>
        
          <a class="view-more" href="product.php">View Flight Tickets</a>
        
          <hr>
          
          <div class="slideshow-container" id="slideshow">
            <h2>Promotions & Notices</h2>
            <div class="slide">
              <img class="promotion" src="images/promo1.png" alt="FACES">
              <p class="promotion-text"><strong>FACES, a faster boarding experience</strong><br>Get ready for a quicker and seamless travel experience.</p>
            </div>
          
            <div class="slide">
              <img class="promotion" src="images/promo2.png" alt="Raya Fixed Fares">
              <p class="promotion-text"><strong>Raya Fixed Fares</strong><br>Balik Kampung to Sabah & Sarawak from RM199.</p>
            </div>
          
            <div class="slide">
              <img class="promotion" src="images/promo3.jpg" alt="Exciting Holiday">
              <p class="promotion-text"><strong>Pack up! It's go time</strong><br>All-in one-way fare from RM35*.</p>
            </div>
          
            <div class="slide">
              <img class="promotion" src="images/promo4.jpg" alt="Flight + Hotel Deal">
              <p class="promotion-text"><strong>Up to 30% off</strong><br>Save more with Flight + Hotel deals.</p>
            </div>
          
            <!-- Dot indicators -->
          <div class="dot-container">
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
          </div>

          </div>
        
        <a href="#top" class="back-to-top">Back to Top</a><br><br><br>
        <hr>
        <?php include 'includes/footer.inc'; ?>
      </body>

</html>