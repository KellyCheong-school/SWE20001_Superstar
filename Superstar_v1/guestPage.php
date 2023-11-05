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
        <div class="card-group m-5">
            <div class="card">
                <img class="card-img-top w-100" src="img/<?php echo $row1['destinationimg']; ?>"
                    alt="<?php echo $row1['destinationname']; ?>">
                <div class="card-body">
                    <h5 class="card-title">
                        <?php echo $row1['destinationname']; ?>
                    </h5>
                    <p class="card-text">
                        <?php echo $row1['destinationdesc']; ?>
                    </p>
                    <p class="card-text"><small class="text-muted">Economy class from RM
                            <?php echo $row1['destinationprice']; ?>
                        </small></p>
                    <a class="view-more" href="<?php echo $row1['destinationname']; ?>.php">View More</a>
                </div>
            </div>
            <div class="card">
                <img class="card-img-top" src="img/<?php echo $row2['destinationimg']; ?>"
                    alt="<?php echo $row2['destinationname']; ?>">
                <div class="card-body">
                    <h5 class="card-title">
                        <?php echo $row1['destinationname']; ?>
                    </h5>
                    <p class="card-text">
                        <?php echo $row1['destinationdesc']; ?>
                    </p>
                    <p class="card-text"><small class="text-muted">Economy class from RM
                            <?php echo $row2['destinationprice']; ?>
                        </small></p>
                    <a class="view-more" href="<?php echo $row1['destinationname']; ?>.php">View More</a>
                </div>
            </div>
        </div>


        <div class="d-flex justify-content-center align-items-center">
            <button href="product.php" class="form-control btn btn-primary submit px-3 w-25">View Flight
                Tickets</button>
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

        <script src="js/jquery.min.js"></script>
        <script src="js/popper.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/main.js"></script>
</body>

</html>