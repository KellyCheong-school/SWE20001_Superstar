<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name = "description" content="Need to make a flight enquiry with AeroStar? Use our online enquiry form to get in touch with customer service and receive all the information you need about your flight.">
    <meta name = "keywords" content="AeroStar, flight, enquiry, form">
    <meta name = "author" content="Jason Tan">

    <title>AeroStar - Create Promotions</title>
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
        $promotionheader = $_POST['promotionheader'];
        $promotiondesc = $_POST['promotiondesc'];
        

        // Assign name, size and tmp of picture file to variables
        $fileName = $_FILES["promotionimg"]["name"];
        $fileSize = $_FILES["promotionimg"]["size"];
        $tmpName = $_FILES["promotionimg"]["tmp_name"];

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
            move_uploaded_file($tmpName, 'images/'. $newImageName);

            // Prepare and execute the SQL statement to insert the manager information
            $sql = "INSERT INTO promotion (promotionheader, promotiondesc, promotionimg) VALUES 
            ('$promotionheader', '$promotiondesc', '$newImageName')";

            if (mysqli_query($conn, $sql)) {
                echo "Promotion created successfully."
              ;
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
      <br><br>
      <form id="createpromotionForm" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" novalidate="novalidate" enctype="multipart/form-data">
        <fieldset>
          <legend>Create Promotions</legend>
          <div class="half">
            <label for="promotionheader">Promotion Header:</label>
            <input type="text" id="promotionheader" name="promotionheader" maxlength="60" pattern="[a-zA-Z]+" required>
          </div>
          <div class="half">
            <label for="promotiondesc">Promotion Description:</label>
            <input type="text" id="promotiondesc" name="promotiondesc" pattern="[a-zA-Z]+" required>
          </div>
          <div class="half">
            <label for="promotionimg">Promotion Image:</label>
            <input type="file" id="promotionimg" name="promotionimg" accept=".jpg, .jpeg, .png" value="" required>
          </div>  
        </fieldset>

        <input class="view-more" type="submit" value="Create">
    </form>

    <hr>
    <h1>List of Promotions</h1>

    <table class="flights">
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
    
    <a href="#top" class="back-to-top">Back to Top</a><br><br><br>
    <hr>
    <?php include 'includes/footer.inc'; ?>
  </body>

</html>