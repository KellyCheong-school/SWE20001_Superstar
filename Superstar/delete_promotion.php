<?php
require_once('settings.php');

if (isset($_POST['promotionId'])) {
    // Sanitize the input and get the promotion ID
    $promotionId = intval($_POST['promotionId']);

    // Establish a database connection
    $conn = @mysqli_connect($host, $user, $pwd, $sql_db);

    // Check if the connection was successful
    if ($conn) {
        // Perform the deletion in the database
        $deleteQuery = "DELETE FROM promotion WHERE promotion_id = $promotionId";
        if ($conn->query($deleteQuery) === TRUE) {
            echo 'success'; // Return a success message
        } else {
            echo 'error'; // Handle the error case
        }

        $conn->close();
    }
}
?>
