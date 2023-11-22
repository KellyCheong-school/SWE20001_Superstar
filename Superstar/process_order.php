<!DOCTYPE html>
<html lang="en">

<head>
    <title>Processing Order</title>
    <style type="text/css">
        .loader {
            border: 8px solid #f3f3f3;
            border-top: 8px solid #FFCBA4;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Show the loading spinner
            document.getElementById("loading-spinner").style.display = "block";

            // Set a timeout to hide the loading spinner after 3 seconds
            setTimeout(function() {
                document.getElementById("loading-spinner").style.display = "none";
            }, 5000); // 50000 milliseconds (5 seconds)
        });
    </script>
</head>

<body>
    <?php
    require_once('settings.php');
    session_start();

    $conn = @mysqli_connect($host, $user, $pwd, $sql_db);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if (isset($_SESSION['member_id'])) {
        $userId = $_SESSION['member_id'];
        $username = $_SESSION['member_username'];
    } else {
        header("Location: index.php");
        exit();
    }

     echo '<div id="loading-spinner" style="text-align: center;">';
     echo '<p style="color: #000000;">Payment is in process...</p>';
     echo '<div class="loader"></div>';
     echo '</div>';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $passportNumber = $_POST['passportNumber'];
        $passportExpiryDate = $_POST['passportExpiryDate'];
        $cabin = $_POST['cabin'];
        $numTickets = $_POST['numTickets'];
        $selectedFlightId = $_POST['selectedFlightId'];
        $selectedDepartureDate = $_POST['selectedDepartureDate'];
        $selectedArrivalCity = $_POST['selectedArrivalCity'];
        $flightId = $_POST['flightId'];
        $memberId = $_POST['member_id'];
        $totalPrice = $_POST['totalPrice'];

        $features = isset($_POST['features']) ? $_POST['features'] : '-';
        if (empty($features)) {
            $features = '-';
        }

        $passengerNames = isset($_POST['passengerName']) ? $_POST['passengerName'] : array();
        $passengerDobs = isset($_POST['passengerDob']) ? $_POST['passengerDob'] : array();
        $passengerPassports = isset($_POST['passengerPassport']) ? $_POST['passengerPassport'] : array();
        $passengerExpiries = isset($_POST['passengerExpiry']) ? $_POST['passengerExpiry'] : array();

        $cardType = $_POST['cardType'];
        $cardName = $_POST['cardName'];
        $cardNumber = $_POST['cardNumber'];
        $expiryDate = $_POST['expiryDate'];
        $cvv = $_POST['cvv'];

        $insertQuery = "INSERT INTO booking (cabin, features, num_tickets, selected_flight_id, selected_departure_date, selected_arrival_city, flight_id, member_id, booking_date, booking_status) VALUES ('$cabin', '$features', '$numTickets', '$selectedFlightId', '$selectedDepartureDate', '$selectedArrivalCity', '$flightId', '$memberId', NOW(), 'Pending')";
        mysqli_query($conn, $insertQuery);

        $getBookingIdQuery = "SELECT id FROM booking WHERE flight_id = '$flightId' AND member_id = '$memberId' ORDER BY id DESC LIMIT 1";
        $getBookingIdResult = mysqli_query($conn, $getBookingIdQuery);

        if ($getBookingIdResult && mysqli_num_rows($getBookingIdResult) > 0) {
            $row = mysqli_fetch_assoc($getBookingIdResult);
            $bookingId = $row['id'];
        } else {
            echo '<script>alert("Invalid Order ID. Please try again.");</script>';
            header("Location: index.php");
            exit();
        }

        if (count($passengerNames) > 0) {
            for ($i = 0; $i < count($passengerNames); $i++) {
                $insertPassengerQuery = "INSERT INTO passenger (booking_id, name, dob, passport, expiry) VALUES ('$bookingId', '{$passengerNames[$i]}', '{$passengerDobs[$i]}', '{$passengerPassports[$i]}', '{$passengerExpiries[$i]}')";
                mysqli_query($conn, $insertPassengerQuery);
            }
        }

        $insertPassportQuery = "UPDATE members SET passport_number = '$passportNumber', passport_expiry = '$passportExpiryDate' WHERE id = '$userId'";
        mysqli_query($conn, $insertPassportQuery);

        $insertPaymentQuery = "INSERT INTO payment (booking_id, card_type, card_name, card_number, expiry_date, cvv, totalPrice) VALUES ('$bookingId', '$cardType', '$cardName', '$cardNumber', '$expiryDate', '$cvv', '$totalPrice')";
        mysqli_query($conn, $insertPaymentQuery);

        mysqli_close($conn);

        echo '<script>';
        echo 'window.location.href = "receipt.php?bookingId=' . $bookingId . '";';
        echo '</script>';
        exit();
    } else {
        echo '<script>alert("Payment unsuccessful. Please try again.");</script>';
        echo '<script>window.location.href = "payment.php";</script>';
        exit();
    }
    ?>
</body>

</html>