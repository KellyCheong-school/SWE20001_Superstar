<?php
    session_start();
    
    // Check if accessed from payment.php or fix_order.php
    if (!(isset($_SESSION['access_from_payment']) || isset($_SESSION['access_from_fix_order']))) {
        // Invalid access attempt
        header("location: enquire.php");
        exit('Direct access to this page is not allowed.');
    }

    function validateStatePostcode($state, $postcode)
    {
        $postcodeFirstDigit = substr($postcode, 0, 1);
        switch ($state) {
            case "VIC":
                return $postcodeFirstDigit === "3" || $postcodeFirstDigit === "8";
            case "NSW":
                return $postcodeFirstDigit === "1" || $postcodeFirstDigit === "2";
            case "QLD":
                return $postcodeFirstDigit === "4" || $postcodeFirstDigit === "9";
            case "NT":
                return $postcodeFirstDigit === "0";
            case "WA":
                return $postcodeFirstDigit === "6";
            case "SA":
                return $postcodeFirstDigit === "5";
            case "TAS":
                return $postcodeFirstDigit === "7";
            case "ACT":
                return $postcodeFirstDigit === "0";
        }
    }

    function isValidCreditCardNumber($cardNumber, $cardType)
    {
        if ($cardType === "Visa") {
            return preg_match('/^4\d{15}$/', $cardNumber);
        } else if ($cardType === "Mastercard") {
            return preg_match('/^5[1-5]\d{14}$/', $cardNumber);
        } else if ($cardType === "AmEx") {
            return preg_match('/^3[47]\d{13}$/', $cardNumber);
        }
        return false;
    }

    function isValidExpiryDate($expiryDate)
    {
        $currentDate = new DateTime();
        $currentYear = intval($currentDate->format('y'));
        $currentMonth = intval($currentDate->format('m'));

        $parts = explode("-", $expiryDate);
        $month = intval($parts[0]);
        $year = intval($parts[1]);

        if ($year < $currentYear || ($year === $currentYear && $month < $currentMonth)) {
            return false;
        }

        return preg_match('/^(0[1-9]|1[0-2])-\d{2}$/', $expiryDate);
    }

    function calculateFlight($flight, $cabin, $features, $numTickets) {
        // Calculate the total price of the purchase
        $flightPrice = 0;
        if ($flight === "Tokyo, Japan") {
            $flightPrice = 2000;
        }
        else if ($flight === "Bali, Indonesia") {
            $flightPrice = 500;
        }
        else if ($flight === "Singapore") {
            $flightPrice = 300;
        }
    
        $pricePerTicket = 0;
        if ($cabin === "First Class") {
            $pricePerTicket = 500;
        }
        else if ($cabin === "Business Class") {
            $pricePerTicket = 250;
        }
        else if ($cabin === "Economy Class") {
            $pricePerTicket = 0;
        }
    
        $totalFeaturesPrice = 0;
        // Split the features string into an array of optional features
        $optionalFeatures = explode(', ', $features);
        foreach ($optionalFeatures as $feature) {
            if ($feature === "Gourmet Dining") {
                $totalFeaturesPrice += 100;
            }
            else if ($feature === "Premium Entertainment") {
                $totalFeaturesPrice += 50;
            }
        }
    
        // Calculate the total price by multiplying the number of tickets with the sum of prices
        $totalPrice = $numTickets * ($pricePerTicket + $flightPrice + $totalFeaturesPrice);
    
        // Display the total price on the payment page
        return number_format($totalPrice, 2); // Format the total price with 2 decimal places
    }

    // Initialize local variables
    $errors = array();               // Stores the error message

    // Sanitize and validate the form inputs and get the values of the form inputs
    $firstname = sanitizeInput($_POST["firstname"]);
    if (!preg_match('/^[a-zA-Z]+$/', $firstname) || strlen($firstname) > 25) {
        $errors['firstname'] = 'Invalid first name';
    }

    $lastname = sanitizeInput($_POST["lastname"]);
    if (!preg_match('/^[a-zA-Z]+$/', $lastname) || strlen($lastname) > 25) {
        $errors['lastname'] = 'Invalid last name';
    }

    $email = sanitizeInput($_POST["email"]);
    if ($email === "") {
        $errors['email'] = "Please enter a valid email address.";
    }

    $phone = sanitizeInput($_POST["phone"]);
    if ($phone === "" || !preg_match('/^\d{0,10}$/', $phone)) {
        $errors['phone'] = "Please enter a valid phone number.";
    }

    $street = sanitizeInput($_POST["street"]);
    if ($street === "" || strlen($street) > 40) {
        $errors['street'] = "Please enter a valid street address.";
    }

    $suburb = sanitizeInput($_POST["suburb"]);
    if ($suburb === "" || strlen($suburb) > 20) {
        $errors['suburb'] = "Please enter a valid suburb/town.";
    }

    $state = sanitizeInput($_POST["state"]);
    if ($state != "VIC" && $state != "NSW" && $state != "QLD" && $state != "NT" && $state != "WA" && $state != "SA" && $state != "TAS" && $state != "ACT") {
        $errors['state'] = "Please select a state.";
    }

    $postcode = sanitizeInput($_POST["postcode"]);
    if (!preg_match('/^\d{4}$/', $postcode) || strlen($postcode) > 4) {
        $errors['postcode'] = "Please enter a valid postcode.";
    }

    $postcodeCheck = validateStatePostcode($state, $postcode);
    if (!$postcodeCheck) {
        $errors['postcode'] = "The postcode does not match the selected state.";
    }

    $contact = isset($_POST["contact"]) ? sanitizeInput($_POST["contact"]) : '';
    /* At least one preferred contact selected */
    if ($contact != "email" && $contact != "post" && $contact != "phone") {
        $errors['contact'] = "Please select a contact method.";
    }

    $departureDate = sanitizeInput($_POST["departureDate"]);
    if ($departureDate === "") {
        $errors['departureDate'] = "Please select a departure date.";
    }

    $returnDate = sanitizeInput($_POST["returnDate"]);
    // Validate the date format
    $date = DateTime::createFromFormat('Y-m-d', $returnDate);
    $isValidDate = $date && $date->format('Y-m-d') === $returnDate;

    if (empty($returnDate) || !$isValidDate) {
        $errors['returnDate'] = "Please select a valid return date.";
    }

    $flight = sanitizeInput($_POST["flight"]);
    if ($flight != "Tokyo, Japan" && $flight != "Bali, Indonesia" && $flight != "Singapore") {
        $errors['flight'] = "Please select a flight.";
    }

    $cabin = sanitizeInput($_POST["cabin"]);
    if ($cabin != "First Class" && $cabin != "Business Class" && $cabin != "Economy Class") {
        $errors['cabin'] = "Please select a cabin class.";
    }

    if (is_array($_POST["features"])) {
        $features = implode(', ', $_POST['features']);
        $features = sanitizeInput($features);
    }
    else{
        $features = sanitizeInput($_POST["features"]);
    }

    $numTickets = sanitizeInput($_POST["numTickets"]);
    if ($numTickets === "" || $numTickets < 0 || $numTickets == 0) {
        $errors['numTickets'] = "Please enter a valid number of tickets.";
    }

    $comment = sanitizeInput($_POST["comment"]);

    $cardType = sanitizeInput($_POST['cardType']);
    // Validate credit card type
    if (empty($cardType)) {
        $errors['cardType'] = "Please select a valid credit card type.";
    }

    $cardName = sanitizeInput($_POST['cardName']);
    // Validate name on credit card
    if (!preg_match('/^[A-Za-z\s]{1,40}$/', $cardName)) {
        $errors['cardName'] = "Please enter a valid name on credit card.";
    }

    $cardNumber = sanitizeInput($_POST['cardNumber']);
    // Validate credit card number
    if (!isValidCreditCardNumber($cardNumber, $cardType)) {
        $errors['cardNumber'] = "Please enter a valid credit card number.";
    }

    $expiryDate = sanitizeInput($_POST['expiryDate']);
    // Validate expiry date
    if (!isValidExpiryDate($expiryDate)) {
        $errors['expiryDate'] = "Please enter a valid expiry date (mm-yy).";
    }

    $cvv = sanitizeInput($_POST['cvv']);
    // Validate CVV
    if (!preg_match('/^\d{3,4}$/', $cvv)) {
        $errors['cvv'] = "Please enter a valid card verification value (CVV).";
    }

    $totalPrice = calculateFlight($flight, $cabin, $features, $numTickets);
    $totalPrice = str_replace(',', '', $totalPrice); // Remove commas from the string
    $totalPrice = floatval($totalPrice);

    // If there are errors, redirect back to "fix_order.php" with the errors and filled data
    if (!empty($errors)) {
        $params = array(
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'phone' => $phone,
            'street' => $street,
            'suburb' => $suburb,
            'contact' => $contact,
            'state' => $state,
            'postcode' => $postcode,
            'departureDate' => $departureDate,
            'returnDate' => $returnDate,
            'flight' => $flight,
            'cabin' => $cabin,
            'features' => $features,
            'numTickets' => $numTickets,
            'comment' => $comment,
            'totalPrice' => $totalPrice,
            'errors' => $errors
        );

        $url = 'fix_order.php?' . http_build_query($params);

        header('Location: ' . $url);
        exit;
    }

    // If the form is valid, submit it
    if (empty($errors)) {
        require_once('settings.php');

        // The @ operator suppresses the display of any error messages
        // mysqli_connect returns false if connection failed, otherwise a connection value
        $conn = @mysqli_connect($host, $user, $pwd, $sql_db);

        // Checks if connection is successful
        if (!$conn) {
            echo "<p>Database connection failure</p>";
        } 
        
        else {
            // Table name and column definitions
            $tableName = "orders";
            $fieldDefinitions = "order_id INT(10) AUTO_INCREMENT PRIMARY KEY,
            order_cost FLOAT,
            order_time DATETIME(6),
            order_status VARCHAR(10),
            firstname VARCHAR(25),
            lastname VARCHAR(25),
            email VARCHAR(30),
            phone VARCHAR(10),
            street VARCHAR(40),
            suburb VARCHAR(20),
            state VARCHAR(3),
            postcode VARCHAR(4),
            contact VARCHAR(5),
            departureDate DATE,
            returnDate DATE,
            flight VARCHAR(15),
            cabin VARCHAR(15),
            features VARCHAR(40),
            numTickets INT,
            comment VARCHAR(255),
            cardType VARCHAR(10),
            cardName VARCHAR(40),
            cardNumber VARCHAR(16),
            expiryDate VARCHAR(5),
            cvv VARCHAR(4)";

            // Check if the table exists
            $result = $conn->query("SHOW TABLES LIKE '$tableName'");

            // If the table doesn't exist, create it and insert the data
            if ($result->num_rows == 0) {
                // Create the table
                $createTableQuery = "CREATE TABLE $tableName ($fieldDefinitions)";
                if ($conn->query($createTableQuery) === false) {
                    echo "Error creating table: " . $conn->error;
                    exit;
                } 
            }   

            // Insert data into the table
            $insertQuery = "INSERT INTO $tableName (order_id, order_cost, order_time, order_status, firstname, lastname, email, phone, street, suburb, state, postcode, contact, departureDate, returnDate, flight, cabin, features, numTickets, comment, cardType, cardName, cardNumber, expiryDate, cvv)
            VALUES (NULL, '$totalPrice', NOW(), 'Pending', '$firstname', '$lastname', '$email', '$phone', '$street', '$suburb', '$state', '$postcode', '$contact', '$departureDate', '$returnDate', '$flight', '$cabin', '$features', $numTickets, '$comment', '$cardType', '$cardName', '$cardNumber', '$expiryDate', '$cvv')";

            if ($conn->query($insertQuery) === false) {
                echo "Error inserting data: " . $conn->error;
                exit;
            } else {
                // Redirect the user to the receipt page with the order ID
                $orderID = mysqli_insert_id($conn); // Retrieve the auto-generated order ID
                header("Location: receipt.php?order_id=$orderID");
                exit;
            }
            
            // Close the database connection
            $conn->close();
        }
    }

    function sanitizeInput($value)
    {
        $value = trim($value);
        $value = stripslashes($value);
        $value = htmlspecialchars($value);
        return $value;
    }
?>