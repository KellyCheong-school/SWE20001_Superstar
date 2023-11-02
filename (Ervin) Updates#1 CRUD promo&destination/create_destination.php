<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name = "description" content="Need to make a flight enquiry with AeroStar? Use our online enquiry form to get in touch with customer service and receive all the information you need about your flight.">
    <meta name = "keywords" content="AeroStar, flight, enquiry, form">
    <meta name = "author" content="Jason Tan">

    <title>AeroStar - Create Destination</title>
    <link href="images/AeroStarLogo-Header.jpg" rel="icon">
    <script src="scripts/part2.js"></script>
    <link href = "styles/style.css" rel = "stylesheet">
    <link href = "styles/enhancements.css" rel = "stylesheet">
    <script src="scripts/enhancements.js"></script>
    <script src="scripts/enhancementsE.js"></script>
    
    </head>

    <body>

    <?php
    require_once('settings.php');
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

        if(!in_array($imageExtension, $validImageExtension)){
          echo
          "<script> alert('Invalid Image Extension'); </script>";
        }
        
        // Limit File size to =< 1GB
        else if($fileSize > 1000000){
          echo
          "<script> alert('Image Size Is Too Large'); </script>";
        }

        // Establish a database connection
        $conn = @mysqli_connect($host, $user, $pwd, $sql_db);

        // Check if the connection was successful
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

            $newImageName = uniqid();
            $newImageName .= '.' . $imageExtension;
            move_uploaded_file($tmpName, 'img/'. $newImageName);

            // Prepare and execute the SQL statement to insert the manager information
            $sql = "INSERT INTO destination (destinationname, destinationimg, destinationdesc, destinationprice) VALUES 
            ('$destinationname', '$newImageName', '$destinationdesc', '$destinationprice')";

            if (mysqli_query($conn, $sql)) {
                echo "Destination created successfully."
              ;
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
      <br><br>
      <form id="createdestinationForm" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" novalidate="novalidate" enctype="multipart/form-data">
        <fieldset>
          <legend>Create Destination</legend>
          <div class="half">
            <label for="destinationname">Destination Name:</label>
            <input type="text" id="destinationname" name="destinationname" maxlength="25" pattern="[a-zA-Z]+" required>
          </div>
          <div class="half">
            <label for="destinationdesc">Destination Description:</label>
            <input type="text" id="destinationdesc" name="destinationdesc" pattern="[a-zA-Z]+" required>
          </div>
          <div class="half">
            <label for="destinationprice">Destination Price:</label>
            <input type="price" id="destinationprice" name="destinationprice" required>
          </div>
          <div class="half">
            <label for="destinationimg">Destination Image:</label>
            <input type="file" id="destinationimg" name="destinationimg" accept=".jpg, .jpeg, .png" value="" required>
          </div>  
        </fieldset>

        <input class="view-more" type="submit" value="Create">
    </form>

    <hr>
    <h1>List of Destinations</h1>

    <table class="flights">
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
    
    <a href="#top" class="back-to-top">Back to Top</a><br><br><br>
    <hr>
    <?php include 'includes/footer.inc'; ?>
  </body>

</html>