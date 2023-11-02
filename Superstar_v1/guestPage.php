<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="This is the payment page for AeroStar.">
    <meta name="keywords" content="AeroStar, Payment">
    <meta name="author" content="Jason Tan">
    <title>Manager Page</title>
    <link href="images/AeroStarLogo-Header.jpg" rel="icon">

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css?family=Open+Sans:400,700,800');
        @import url('https://fonts.googleapis.com/css?family=Lobster');

        body {
            font-family: 'Open Sans', sans-serif;
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
    <br><br><br><br>
    <hr>
    <h2>Destinations</h2>
    <p>Our flight destinations vary across Asia, including Tokyo in Japan, Bali in Indonesia, Seoul
        in South Korea, Bangkok in Thailand, and Singapore. For European destinations, we offer flights to Paris in
        France,
        Rome in Italy, Barcelona in Spain, Amsterdam in the Netherlands, and Berlin in Germany.</p>
    <p class="hidden">Scroll left for more destinations!</p>
    <table class="flights">
        <tr class="flights">
            <td class="flights"> <img src="img/<?php echo $row1['destinationimg']; ?>" width="400"><br><br>
                <?php echo $row1['destinationname']; ?>
                <?php echo $row1['destinationdesc']; ?><br><br>Economy class from <br>RM
                <?php echo $row1['destinationprice']; ?>
                <br><a class="view-more" href="<?php echo $row1['destinationname']; ?>.php">View More</a>
            </td><br>
            <td class="flights"> <img src="img/<?php echo $row2['destinationimg']; ?>" width="400"><br><br>
                <?php echo $row2['destinationname']; ?>
                <?php echo $row2['destinationdesc']; ?><br><br>Economy from <br>RM
                <?php echo $row2['destinationprice']; ?>
                <br><a class="view-more" href="<?php echo $row2['destinationname']; ?>.php">View More</a>
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
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>