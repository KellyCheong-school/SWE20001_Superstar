<?php
require_once('settings.php');

if (isset($_POST['destinationId'])) {
    // Sanitize the input and get the destination ID
    $destinationId = intval($_POST['destinationId']);

    // Establish a database connection
    $conn = @mysqli_connect($host, $user, $pwd, $sql_db);

    // Check if the connection was successful
    if ($conn) {
        // Perform the deletion in the database
        $deleteQuery = "DELETE FROM destination WHERE destination_id = $destinationId";
        if ($conn->query($deleteQuery) === TRUE) {
            echo 'success'; // Return a success message
        } else {
            echo 'error'; // Handle the error case
        }

        $conn->close();
    }
}
?>
