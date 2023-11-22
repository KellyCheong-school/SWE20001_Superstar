<!DOCTYPE html>
<html>

<head>
<title>Create Destination</title>
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
        $destinationname = $_POST['destinationname'];
        $destinationdesc = $_POST['destinationdesc'];
        $destinationprice = $_POST['destinationprice'];

        // Assign name, size and tmp of picture file to variables
        $fileName = $_FILES["destinationimg"]["name"];
        $fileSize = $_FILES["destinationimg"]["size"];
        $tmpName = $_FILES["destinationimg"]["tmp_name"];

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
        move_uploaded_file($tmpName, 'img/' . $newImageName);

        // Prepare and execute the SQL statement to insert the manager information
        $sql = "INSERT INTO destination (destinationname, destinationimg, destinationdesc, destinationprice) VALUES 
            ('$destinationname', '$newImageName', '$destinationdesc', '$destinationprice')";

        if (mysqli_query($conn, $sql)) {
            echo "Destination created successfully.";
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        // Close the database connection
        mysqli_close($conn);

        // Redirect to the manager login page
        header("Location: create_destination.php");
        exit();
    }
    ?>
    <?php include 'includes/Managerheader.inc'; ?>
    <br><br><br><br>
    <div class="container mt-4">
        <h2 class="heading-section">Create Destination</h2>
        <br>
        <div class="mx-auto">
            <form id="createdestinationForm" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>"
                novalidate="novalidate" enctype="multipart/form-data">
                <fieldset>
                    <div class="form-group row">
                        <label for="destinationname" style="color:#fff;" class="col-sm-3 col-form-label">Destination
                            Name:</label>
                        <div class="col-sm-8">
                            <input class="form-control" style="font-size: 11pt;" type="text" id="destinationname"
                                name="destinationname" maxlength="25" pattern="[a-zA-Z]+" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="destinationdesc" style="color:#fff;" class="col-sm-3 col-form-label">Destination
                            Description:</label>
                        <div class="col-sm-8">
                            <input class="form-control" style="font-size: 11pt;" type="text" id="destinationdesc"
                                name="destinationdesc" pattern="[a-zA-Z]+" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="destinationprice" style="color:#fff;" class="col-sm-3 col-form-label">Destination
                            Price:</label>
                        <div class="col-sm-8"><input class="form-control" style="font-size: 11pt;" type="price"
                                id="destinationprice" name="destinationprice" required></div>
                    </div>
                    <div class="form-group row">
                        <label for="destinationimg" style="color:#fff;" class="col-sm-3 col-form-label">Destination
                            Image:</label>
                        <div class="col-sm-8">
                            <input type="file" class="form-control-file" id="exampleFormControlFile1">
                        </div>

                    </div>

                </fieldset>
                <button type="submit" class="form-control btn btn-primary submit w-25">Create</button>
            </form>
        </div>

        <br><br>


        <hr>
        <h2 class="heading-section">List of Destinations</h2>

        <br>
        <!-- Add a row element for the order table -->
        <div class="row">
            <!-- Add a column element for the order table -->
            <div class="col-md-12">

                <table class='table table-striped table-bordered' style='color:#fff;'>
                    <thead>
                        <tr id="destinationRow<?php echo $row['destination_id']; ?>">
                            <th>Image</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
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

                        $querypromo = "SELECT * FROM destination";
                        $result = $conn->query($querypromo);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td><img width='200' height='100' src='img/" . $row['destinationimg'] . "' alt='Destination Image'><br><br>
                  <button class='edit-image-button' style='display:none;' data-destination-id='" . $row['destination_id'] . "'>Edit Image</button>
                  <input type='file' id='imageFile_" . $row['destination_id'] . "' style='display:none;'>
                  </td>";
                                echo "<td class='editable' data-field='destinationname' data-destination-id='" . $row['destination_id'] . "' contenteditable='false'>" . $row['destinationname'] . "</td>";
                                echo "<td class='editable' data-field='destinationdesc' data-destination-id='" . $row['destination_id'] . "' contenteditable='false'>" . $row['destinationdesc'] . "</td>";
                                echo "<td class='editable' data-field='destinationprice' data-destination-id='" . $row['destination_id'] . "' contenteditable='false'>" . $row['destinationprice'] . "</td>";
                                echo "<td>
                  <button class='delete-button' onclick='deleteDestination(" . $row['destination_id'] . ")'>Delete</button>
                  <button class='save-button' style='display:none;' data-destination-id='" . $row['destination_id'] . "' onclick='saveDestination(" . $row['destination_id'] . ")'>Save</button>
                  <button  class='edit-button' data-destination-id='" . $row['destination_id'] . "' onclick='editDestination(" . $row['destination_id'] . ")'>Edit</button>
                  </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "No destinations available.";
                        }

                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <a href="#top" class="back-to-top">Back to Top</a><br><br><br>
    </div>

    <hr>
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>