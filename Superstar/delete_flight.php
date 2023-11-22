<!DOCTYPE html>
<html lang="en">

<head>
    <title>AeroStar - Delete Flight</title>
    <link href="images/AeroStarLogo-Header.jpg" rel="icon">
    <link href="styles/style.css" rel="stylesheet">
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

    // Check if flight ID is provided
    if (isset($_GET['id'])) {
        $flightId = $_GET['id'];

        // Delete the flight
        $deleteFlightQuery = "DELETE FROM flights WHERE id = $flightId";

        if (mysqli_query($conn, $deleteFlightQuery)) {
            echo "<script>alert('Flight deleted successfully.'); window.location.href = 'create_flight.php';</script>";
        } else {
            echo "Error deleting flight: " . mysqli_error($conn);
        }
    } else {
        echo "Flight ID not provided.";
    }

    // Close the database connection
    mysqli_close($conn);
    ?>

    <a href="#top" class="back-to-top">Back to Top</a><br><br><br>
    <hr>
    <?php include 'includes/footer.inc'; ?>
</body>

</html>
