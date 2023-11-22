<!DOCTYPE html>
<html>

<head>
<title>Superstar - Guest</title>
    <meta charset="utf-8">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="This is the payment page for AeroStar.">
    <meta name="keywords" content="AeroStar, Payment">
    <meta name="author" content="Jason Tan">
    <title>Manager Page</title>
    <link href="images/AeroStarLogo-Header.jpg" rel="icon">

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="./images/logo(icon).png" rel="icon">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css?family=Open+Sans:400,700,800');
        @import url('https://fonts.googleapis.com/css?family=Lobster');

        body {
            font-family: 'Open Sans', sans-serif;
        }

        .carousel-caption h3 {
            color: #fff;
            font-weight: 5px;
        }

        .card-img-top {
            width: 100%;
            /* Make sure the image takes up the full width of the card */
            height: 100%;
            /* Make sure the image takes up the full height of the card */
            object-fit: cover;
            /* This property will make the image fill the entire space while maintaining its aspect ratio */
        }

        .flight-content {
  position: relative;
  overflow: hidden;
  display: flex;
  align-items: stretch;
  height: 100%;
  color: #fff; 
}

.flight-image {
  position: relative;
  overflow: hidden;
}

.flight-image img {
  width: 100%;
  height: auto;
  filter: blur(0); /* Initially no blur*/
  transition: filter 0.3s; /* Smooth transition for the blur effect */
}

.flight-content:hover img {
  filter: blur(25px); /* Apply blur on hover */
}

.destination-info {
  position: absolute;
  top: 50%; 
  left: 50%;
  transform: translate(-50%, -50%);
  opacity: 0; /* Initially hidden */
  transition: opacity 0.3s ease-in-out; /* Add a smooth transition */
  color: #fff; 
}

.destination-info h3 {
  color: #fff; /* Change destination name color to white */
}

.flight-content:hover .destination-info {
  opacity: 1; /* Show the info on hover */
}

.view-more {
  display: inline-block;
  padding: 5px 10px;
  background-color: #FFCBA4;
  color: #000000;
  text-decoration: none;
  border-radius: 5px; 
  margin-top: 5px;
  transition: background-color 0.3s;
}

.view-more:hover {
  background-color: #fff;
  color:black; 
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
    // Establish a database connection
    $conn = @mysqli_connect($host, $user, $pwd, $sql_db);

    // Check if the connection was successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query1 = mysqli_query($conn, "SELECT * FROM destination ORDER BY RAND() LIMIT 2");

    $row1 = mysqli_fetch_array($query1);
    $row2 = mysqli_fetch_array($query1);
    include 'includes/guestHeader.inc';
    ?>
    <br><br><br>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center mb-5">
                <h2 class="heading-section">Destinations</h2>
            </div>
        </div>
        <p style="color:#fff;">Our flight destinations vary across Asia, including Tokyo in Japan, Bali in Indonesia,
            Seoul
            in South Korea, Bangkok in Thailand, and Singapore. For European destinations, we offer flights to Paris in
            France,
            Rome in Italy, Barcelona in Spain, Amsterdam in the Netherlands, and Berlin in Germany.</p>
        <!-- Add a row element for the order table -->
        <div class="row">
            <!-- Add a column element for the order table -->
            <div class="col-md-12">
            </div>
        </div>
    
    <table class="flights">
    <tr class="flights">
      <td class="flights">
        <div class="flight-content">
          <img src="img/<?php echo $row1['destinationimg']; ?>" alt="<?php echo $row1['destinationname']; ?>" width="600" height="350">
          <div class="destination-info">
            <h3><?php echo $row1['destinationname']; ?></h3>
            <p><?php echo $row1['destinationdesc']; ?></p>
            <p>Economy class from RM <?php echo $row1['destinationprice']; ?></p>
            <a class="view-more" href="index.php">View More</a>
          </div>
        </div>
      </td>

      <td class="flights">
        <div class="flight-content">
          <img src="img/<?php echo $row2['destinationimg']; ?>" alt="<?php echo $row2['destinationname']; ?>" width="600" height="350">
          <div class="destination-info">
            <h3 ><?php echo $row2['destinationname']; ?></h3>
            <p><?php echo $row2['destinationdesc']; ?></p>
            <p>Economy class from RM <?php echo $row2['destinationprice']; ?></p>
            <a class="view-more" href="index.php">View More</a>
          </div>
        </div>
      </td>
    </tr> 
  </table>

<br><br>

<div class="d-flex justify-content-center align-items-center">
    <a href="index.php" class="btn btn-primary submit px-3 w-25">View Flight Tickets</a>
</div>

        <br><br>
        
        <hr>


        <div class="container mt-4" style="color: #fff;">
            <p>Enjoy exclusive benefits as a member:</p>
            <ul>
                <li>Priority access to promotions</li>
                <li>Book flight tickets</li>
                <li>View destinations provided and the descriptions of tourist spots</li>
            </ul>

            <p><a href="member_registration.php">Be a member now!</a></p>
        </div>
        <br><br><br><br>



        <?php // Close the database connection
        mysqli_close($conn);
        ?>

<p style="text-align:center">
  <a href="#top" class="back-to-top">Back to Top</a><br><br><br>
</p>

</body>

</html>