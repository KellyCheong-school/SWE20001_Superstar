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
if (isset($_SESSION['member_id'])) {
    // The user is logged in, retrieve the username from the session
    $userId = $_SESSION['member_id'];
    $username = $_SESSION['member_username'];
} else {
    // Redirect the user to the login page if not logged in
    header("Location: index.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve values from the submitted form
    $passportNumber = $_POST['passportNumber'];
    $passportExpiryDate = $_POST['passportExpiryDate'];
    $cabin = $_POST['cabin'];
    $numTickets = $_POST['numTickets'];
    $selectedFlightId = $_POST['selectedFlightId'];
    $selectedDepartureDate = $_POST['selectedDepartureDate'];
    $selectedArrivalCity = $_POST['selectedArrivalCity'];
    $flightId = $_POST['flightId'];
    $memberId = $_POST['member_id']; // Assuming this is the user ID
    $totalPrice = $_POST['totalPrice'];

    $features = isset($_POST['features']) ? $_POST['features'] : '-';
    if (empty($features)) {
        $features = '-';
    }
    // Retrieve passenger details
    $passengerNames = isset($_POST['passengerName']) ? $_POST['passengerName'] : array();
    $passengerDobs = isset($_POST['passengerDob']) ? $_POST['passengerDob'] : array();
    $passengerPassports = isset($_POST['passengerPassport']) ? $_POST['passengerPassport'] : array();
    $passengerExpiries = isset($_POST['passengerExpiry']) ? $_POST['passengerExpiry'] : array();

    // Retrieve credit card details
    $cardType = $_POST['cardType'];
    $cardName = $_POST['cardName'];
    $cardNumber = $_POST['cardNumber'];
    $expiryDate = $_POST['expiryDate'];
    $cvv = $_POST['cvv'];

    // Insert data into the booking table
    $insertQuery = "INSERT INTO booking (cabin, features, num_tickets, selected_flight_id, selected_departure_date, selected_arrival_city, flight_id, member_id, booking_date, booking_status) VALUES ('$cabin', '$features', '$numTickets', '$selectedFlightId', '$selectedDepartureDate', '$selectedArrivalCity', '$flightId', '$memberId', NOW(), 'Pending')";
    mysqli_query($conn, $insertQuery);

    // Retrieve the booking ID based on the recently inserted data
    $getBookingIdQuery = "SELECT id FROM booking WHERE flight_id = '$flightId' AND member_id = '$memberId' ORDER BY id DESC LIMIT 1";
    $getBookingIdResult = mysqli_query($conn, $getBookingIdQuery);

    if ($getBookingIdResult && mysqli_num_rows($getBookingIdResult) > 0) {
        $row = mysqli_fetch_assoc($getBookingIdResult);
        $bookingId = $row['id'];
    } else {
        // Handle the case where the booking ID cannot be retrieved
        echo '<script>alert("Invalid Order ID. Please try again.");</script>';
        header("Location: index.php");
        exit();
    }

    if (count($passengerNames) > 0) {
        // Insert passenger details into the passenger table
        for ($i = 0; $i < count($passengerNames); $i++) {
            $insertPassengerQuery = "INSERT INTO passenger (booking_id, name, dob, passport, expiry) VALUES ('$bookingId', '{$passengerNames[$i]}', '{$passengerDobs[$i]}', '{$passengerPassports[$i]}', '{$passengerExpiries[$i]}')";
            mysqli_query($conn, $insertPassengerQuery);
        }
    }

    
    $insertPassportQuery = "UPDATE members SET passport_number = '$passportNumber', passport_expiry = '$passportExpiryDate' WHERE id = '$userId'";
    mysqli_query($conn, $insertPassportQuery);

    // Insert credit card details into the payment table
    $insertPaymentQuery = "INSERT INTO payment (booking_id, card_type, card_name, card_number, expiry_date, cvv, totalPrice) VALUES ('$bookingId', '$cardType', '$cardName', '$cardNumber', '$expiryDate', '$cvv', '$totalPrice')";
    mysqli_query($conn, $insertPaymentQuery);

    // Close the database connection
    mysqli_close($conn);

    header("Location: receipt.php?bookingId=$bookingId");
    exit();
} else {
    // If the form is not submitted, redirect to the home page or any other page
    echo '<script>alert("Payment unsuccessful. Please try again.");</script>';
    header("Location: index.php");
    exit();
}
