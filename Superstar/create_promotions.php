<!DOCTYPE html>
<html>

<head>
<title>Create Promotion</title>
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

        /* input[readonly].form-control {
            color:#282828;
        } */
    </style>
    <script src="scripts/enhancementsE.js"></script>
</head>

<body>

    <?php
    require_once('settings.php');
    session_start();

    // Establish a database connection
    $conn = @mysqli_connect($host, $user, $pwd, $sql_db);

    // Check if the user is logged in
    if (isset($_SESSION['manager_id'])) {
        // The user is logged in, retrieve the username from the session
        $userId = $_SESSION['manager_id'];
        $username = $_SESSION['manager_username'];
    } else {
        // Redirect the user to the login page if not logged in
        header("Location: index.php");
        exit();
    }
    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Perform form validation and register the manager if validation passes
    
        // Retrieve form data
        $promotionheader = $_POST['promotionheader'];
        $promotiondesc = $_POST['promotiondesc'];


        // Assign name, size and tmp of picture file to variables
        $fileName = $_FILES["promotionimg"]["name"];
        $fileSize = $_FILES["promotionimg"]["size"];
        $tmpName = $_FILES["promotionimg"]["tmp_name"];

        $validImageExtension = ['jpg', 'jpeg', 'png'];
        $imageExtension = explode('.', $fileName);
        $imageExtension = strtolower(end($imageExtension));

        if (!in_array($imageExtension, $validImageExtension)) {
            echo
                "<script> alert('Invalid Image Extension'); </script>";
        }

        // Limit File size to =< 1GB
        else if ($fileSize > 1000000) {
            echo
                "<script> alert('Image Size Is Too Large'); </script>";
        }

        $newImageName = uniqid();
        $newImageName .= '.' . $imageExtension;
        move_uploaded_file($tmpName, 'images/' . $newImageName);

        // Prepare and execute the SQL statement to insert the manager information
        $sql = "INSERT INTO promotion (promotionheader, promotiondesc, promotionimg) VALUES 
            ('$promotionheader', '$promotiondesc', '$newImageName')";

        if (mysqli_query($conn, $sql)) {
            echo "Promotion created successfully.";
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        // Close the database connection
        mysqli_close($conn);

        // Redirect to the manager login page
        header("Location: create_promotions.php");
        exit();
    }
    ?>
    <?php include 'includes/Managerheader.inc'; ?>
    <br><br><br><br>
    <div class="container mt-4">
        <h2 class="heading-section">Create Promotions</h2>
        <br>
        <div class="mx-auto">
            <form id="createpromotionForm" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>"
                novalidate="novalidate" enctype="multipart/form-data">
                <fieldset>
                    <div class="form-group row">
                        <label for="promotionheader" style="color:#fff;" class="col-sm-3 col-form-label">Promotion
                            Header:</label>
                        <div class="col-sm-8">
                            <input class="form-control" style="font-size: 11pt;" type="text" id="promotionheader"
                                name="promotionheader" maxlength="60" pattern="[a-zA-Z]+" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="promotiondesc" style="color:#fff;" class="col-sm-3 col-form-label">Promotion
                            Description:</label>
                        <div class="col-sm-8">
                            <input type="text" id="promotiondesc" name="promotiondesc" class="form-control"
                                style="font-size: 11pt;" pattern="[a-zA-Z]+" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="promotionimg" style="color:#fff;" class="col-sm-3 col-form-label">Promotion
                            Image:</label>
                        <div class="col-sm-8">
                            <input class="form-control-file" type="file" id="promotionimg" name="promotionimg"
                                accept=".jpg, .jpeg, .png" value="" required>
                        </div>

                    </div>
                </fieldset>
                <button type="submit" class="form-control btn btn-primary submit w-25">Create</button>
            </form>
        </div>

        <br><br>


        <hr>
        <h2 class="heading-section">List of Promotions</h2>

        <br>
        <!-- Add a row element for the order table -->
        <div class="row">
            <!-- Add a column element for the order table -->
            <div class="col-md-12">

                <table class="table table-striped table-bordered" style="color:#fff;">
                    <thead>
                        <tr id="promotionRow<?php echo $row['promotion_id']; ?>">
                            <th>Image</th>
                            <th>Header</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        require_once('settings.php');

                        // Establish a database connection
                        $conn = @mysqli_connect($host, $user, $pwd, $sql_db);

                        // Check if the connection was successful
                        if (!$conn) {
                            die("Connection failed: " . mysqli_connect_error());
                        }

                        $querypromo = "SELECT * FROM promotion";
                        $result = $conn->query($querypromo);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td><img width='200' height='100' src='images/" . $row['promotionimg'] . "' alt='Promotion Image'><br><br>
                  <button class='edit-image-button' style='display:none;' data-promotion-id='" . $row['promotion_id'] . "'>Edit Image</button>
                  <input type='file' id='imageFile_" . $row['promotion_id'] . "' style='display:none;'>
                  </td>";
                                echo "<td class='editable' data-field='promotionheader' data-promotion-id='" . $row['promotion_id'] . "' contenteditable='false'>" . $row['promotionheader'] . "</td>";
                                echo "<td class='editable' data-field='promotiondesc' data-promotion-id='" . $row['promotion_id'] . "' contenteditable='false'>" . $row['promotiondesc'] . "</td>";
                                echo "<td>
                  <button class='delete-button' onclick='deletePromotion(" . $row['promotion_id'] . ")'>Delete</button>
                  <button class='save-button' style='display:none;' data-promotion-id='" . $row['promotion_id'] . "' onclick='savePromotion(" . $row['promotion_id'] . ")'>Save</button>
                  <button  class='edit-button' data-promotion-id='" . $row['promotion_id'] . "' onclick='editPromotion(" . $row['promotion_id'] . ")'>Edit</button>
                  </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "No promotions available.";
                        }

                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <br><br>
        <a href="#top" class="back-to-top">Back to Top</a><br><br><br>
    </div>

    <hr>
    <script>
        function updatePrice() {
            var select = document.getElementById('to');
            var priceInput = document.getElementById('price');
            var selectedOption = select.options[select.selectedIndex];

            // Assuming you have a data-price attribute in your options
            var price = selectedOption.getAttribute('data-price');

            // Set the value to 0 if price is null or undefined
            priceInput.value = (price !== null && price !== undefined) ? price : '0';
        }

        // Set minimum date for departureDateTime and arrivalDateTime
        var today = new Date().toISOString().split('T')[0];
        document.getElementById('departureDateTime').min = today + 'T00:00'; // Set the time to 00:00
        document.getElementById('arrivalDateTime').min = today + 'T00:00';

        // Calculate duration on departureDateTime or arrivalDateTime change
        document.getElementById('departureDateTime').addEventListener('input', calculateDuration);
        document.getElementById('arrivalDateTime').addEventListener('input', calculateDuration);

        function calculateDuration() {
            var departureDateTime = new Date(document.getElementById('departureDateTime').value);
            var arrivalDateTime = new Date(document.getElementById('arrivalDateTime').value);

            if (departureDateTime && arrivalDateTime && departureDateTime < arrivalDateTime) {
                var durationMinutes = Math.round((arrivalDateTime - departureDateTime) / (1000 * 60));
                var hours = Math.floor(durationMinutes / 60);
                var minutes = durationMinutes % 60;

                document.getElementById('hours').value = hours;
                document.getElementById('minutes').value = minutes;
            } else {
                // Handle invalid input or show an error message
            }
        }

        function editFlight(event) {
            event.preventDefault();
            window.open(event.target.href, 'Edit Flight', 'width=600,height=500');
        }
    </script>
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>