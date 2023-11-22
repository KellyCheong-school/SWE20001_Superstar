<?php
// Connect to the database and perform the update
require_once('settings.php');
$conn = @mysqli_connect($host, $user, $pwd, $sql_db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $destinationId = $_POST['destinationId'];
    $newName = $_POST['newName'];
    $newDesc = $_POST['newDesc'];
    $newPrice = $_POST['newPrice'];

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if ($conn) {
        $newImageName = null;

        if (isset($_FILES['newImage']) && $_FILES['newImage']['error'] === UPLOAD_ERR_OK) {
            // Handle the new image file (e.g., move it to a folder and update the database)
            $newImage = $_FILES['newImage'];
            $newImageName = $destinationId . '_' . $newImage['name'];
            move_uploaded_file($newImage['tmp_name'], 'img/' . $newImageName);
        
            $sql = "UPDATE destination SET destinationname=?, destinationdesc=?, destinationimg=?, destinationprice=? WHERE destination_id=?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sssii", $newName, $newDesc,  $newImageName, $newPrice, $destinationId);
        } else {
            $sql = "UPDATE destination SET destinationname=?, destinationdesc=?, destinationprice=? WHERE destination_id=?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssii", $newName, $newDesc, $newPrice, $destinationId);
        }

        if (mysqli_stmt_execute($stmt)) {
            echo "Destination updated successfully";
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        $conn->close();
    }
}
?>
