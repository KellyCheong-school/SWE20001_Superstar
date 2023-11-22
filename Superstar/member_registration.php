<!doctype html>
<html lang="en">

<head>
    <title>Member Registration</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css?family=Open+Sans:400,700,800');
        @import url('https://fonts.googleapis.com/css?family=Lobster');

        body {
            font-family: 'Open Sans', sans-serif;
        }

        .alert-danger {
            background-color: transparent;
            background-color: rgba(255, 255, 255, .3);
        }
    </style>
</head>

<body class="img" style="background-image: url(images/bg.jpg);">
    <?php
    require_once('settings.php');

    $infoMsg = null;

    // Initialize variables to hold form data
    $usernameValue = isset($_POST['username']) ? $_POST['username'] : '';
    $passwordValue = isset($_POST['password']) ? $_POST['password'] : '';
    $fullNameValue = isset($_POST['full_name']) ? $_POST['full_name'] : '';
    $dobValue = isset($_POST['dob']) ? $_POST['dob'] : '';
    $emailValue = isset($_POST['email']) ? $_POST['email'] : '';
    $phoneValue = isset($_POST['phone']) ? $_POST['phone'] : '';

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)) {
        // Perform form validation and register the member if validation passes
        // Retrieve form data
        $username = $usernameValue;
        $password = $passwordValue;
        $fullName = $fullNameValue;
        $dob = $dobValue;
        $email = $emailValue;
        $phone = $phoneValue;

        // Establish a database connection
        $conn = @mysqli_connect($host, $user, $pwd, $sql_db);

        // Check if the connection was successful
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        if (!ctype_alpha(str_replace(' ', '', $fullName))) {
            echo "<script>alert('Full name can only contain alphabets.');</script>";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert('Invalid email format.');</script>";
        } else {
            $dobTimestamp = strtotime($dob);
            $minAgeTimestamp = strtotime('-18 years');

            if ($dobTimestamp > $minAgeTimestamp) {
                echo "<script>alert('You must be 18 years or older to register.');</script>";
            } else {
                // Continue with the rest of your code for database connection and registration

                // Check if the username already exists in the members table
                $checkUniqueQuery = "SELECT * FROM members WHERE username = '$username'";
                $checkUniqueResult = mysqli_query($conn, $checkUniqueQuery);

                if (mysqli_num_rows($checkUniqueResult) > 0) {
                    echo "<script>alert('Error: Username already exists. Please choose a different username.');</script>";
                } else {
                    // Proceed with member registration

                    // Prepare and execute the SQL statement to insert the member information
                    $sql = "INSERT INTO members (username, password, full_name, dob, email, phone, passport_expiry) VALUES ('$username', '$password', '$fullName', '$dob', '$email', '$phone', '')";

                    if (mysqli_query($conn, $sql)) {
                        echo "<script>alert('Member registered successfully.'); window.location.href='index.php';</script>";
                    } else {
                        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
                    }

                    // Close the database connection
                    mysqli_close($conn);
                }
            }
        }

        // Check if the members table exists, if not, create it
        $tableCheckQuery = "SHOW TABLES LIKE 'members'";
        $tableCheckResult = mysqli_query($conn, $tableCheckQuery);

        if (!$tableCheckResult || mysqli_num_rows($tableCheckResult) == 0) {
            // Table doesn't exist, create it
            $createTableQuery = "
                CREATE TABLE members (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    username VARCHAR(255) NOT NULL,
                    password VARCHAR(255) NOT NULL,
                    full_name VARCHAR(255) NOT NULL,
                    dob DATE NOT NULL,
                    email VARCHAR(255) NOT NULL,
                    phone VARCHAR(20) NOT NULL
                )
            ";
            $createTableResult = mysqli_query($conn, $createTableQuery);

            if (!$createTableResult) {
                die("Error creating members table: " . mysqli_error($conn));
            }
        } else {
            // Check for missing fields and add them if necessary
            $fieldsToCheck = array('full_name', 'dob', 'email', 'phone', 'passport_expiry');
            $missingFields = array();

            foreach ($fieldsToCheck as $field) {
                $checkFieldQuery = "SHOW COLUMNS FROM members LIKE '$field'";
                $checkFieldResult = mysqli_query($conn, $checkFieldQuery);

                if (!$checkFieldResult || mysqli_num_rows($checkFieldResult) == 0) {
                    $missingFields[] = $field;
                }
            }

            if (!empty($missingFields)) {
                // Add missing fields to the members table
                foreach ($missingFields as $field) {
                    $addFieldQuery = "ALTER TABLE members ADD COLUMN $field VARCHAR(255) NOT NULL";
                    $addFieldResult = mysqli_query($conn, $addFieldQuery);

                    if (!$addFieldResult) {
                        die("Error adding $field to members table: " . mysqli_error($conn));
                    }
                }
            }
        }

        // Alert Message
        if ($infoMsg != null) {
            echo "<div class='col-md-10 mx-auto p-2' style='background-color:transparent;'><div class='alert alert-danger alert-dismissible fade show mx-auto' role='alert'>
                        <p class='mb-0' style='font-size: 10pt; color: #b04002;'>$infoMsg</p>
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div></div>";
        }

        // Close the database connection
        mysqli_close($conn);
    }
    ?>
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center mb-5">
                    <h2 class="heading-section">Member Registration</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-6">
                    <div class="login-wrap p-0">
                        <form action="#" class="signin-form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Left column -->
                                    <div class="form-group">
                                        <input type="text" name="username" id="username" class="form-control" placeholder="Username" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!-- Right column -->
                                    <div class="form-group">
                                        <div class="form-outline datepicker">
                                            <input type="date" class="form-control" id="dob" name="dob" placeholder="Birth date (dd/mm/yyyy)" required />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" name="full_name" id="full_name" class="form-control" pattern="^[A-Za-z\s]+$" placeholder="Full name" required>
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" id="email" class="form-control" pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" placeholder="Email (example@gmail.com)" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="phone" id="phone" class="form-control" pattern="^60-([0-9]{8}|[0-9]{9})$" placeholder="Phone Number (60-123456789)" required>
                            </div>
                            <div class="form-group">
                                <input id="password-field" name="password" type="password" class="form-control" pattern=".{6,}" placeholder="Password (Minimum 6 characters)" required>
                                <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="form-control btn btn-primary submit px-3">Register</button>
                            </div>
                            <div class="form-group d-md-flex">
                                <div class="w-50">
                                    <a href="index.php" style="color: #fff">Back to Homepage</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>

</body>

</html>