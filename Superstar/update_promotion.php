<?php
// Connect to the database and perform the update
require_once('settings.php');
$conn = @mysqli_connect($host, $user, $pwd, $sql_db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $promotionId = $_POST['promotionId'];
    $newHeader = $_POST['newHeader'];
    $newDesc = $_POST['newDesc'];

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if ($conn) {
        $newImageName = null;

        if (isset($_FILES['newImage']) && $_FILES['newImage']['error'] === UPLOAD_ERR_OK) {
            // Handle the new image file (e.g., move it to a folder and update the database)
            $newImage = $_FILES['newImage'];
            $newImageName = $promotionId . '_' . $newImage['name'];
            move_uploaded_file($newImage['tmp_name'], 'images/' . $newImageName);
        
            $sql = "UPDATE promotion SET promotionheader=?, promotiondesc=?, promotionimg=? WHERE promotion_id=?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sssi", $newHeader, $newDesc, $newImageName, $promotionId);
        } else {
            $sql = "UPDATE promotion SET promotionheader=?, promotiondesc=? WHERE promotion_id=?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssi", $newHeader, $newDesc, $promotionId);
        }

        if (mysqli_stmt_execute($stmt)) {
            echo "Promotion updated successfully";
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        $conn->close();
    }
}
?>
