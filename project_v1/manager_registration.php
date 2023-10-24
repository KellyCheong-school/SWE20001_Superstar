<!doctype html>
<html lang="en">

<head>
    <title>Manager Registration</title>
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

    <body class="img js-fullheight" style="background-image: url(images/bg.jpg);">
    <?php
        require_once('settings.php');
        $infoMsg = null;

        // Check if the form is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Perform form validation and register the member if validation passes

            // Retrieve form data
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Establish a database connection
            $conn = @mysqli_connect($host, $user, $pwd, $sql_db);

            // Check if the connection was successful
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Check if the username or password already exists in the managers table
            $checkUniqueQuery = "SELECT * FROM managers WHERE username = '$username' OR password = '$password'";
            $checkUniqueResult = mysqli_query($conn, $checkUniqueQuery);

            if (mysqli_num_rows($checkUniqueResult) > 0) {
                // Username or password already exists, display an error message
                $infoMsg = "Error: Username or password already exists. Please choose a different username or password.";
            } else {
                // Username and password are unique, proceed with manager registration
    
                // Prepare and execute the SQL statement to insert the manager information
                $sql = "INSERT INTO managers (username, password) VALUES ('$username', '$password')";
    
                if (mysqli_query($conn, $sql)) {
                    echo "Manager registered successfully.";

                    // Redirect to the manager login page
                    header("Location: manager_login.php");
                } else {
                    $infoMsg = "Error: " . mysqli_error($conn);
                }
    
                // Close the database connection
                mysqli_close($conn);
    
            }

            //Alert Message
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
                    <h2 class="heading-section">Manager Registration</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="login-wrap p-0">
                        <form action="#" class="signin-form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="form-group">
                                <input type="text" name="username" id="username" class="form-control"
                                    placeholder="Username" required>
                            </div>
                            <div class="form-group">
                                <input id="password-field" name="password" type="password" class="form-control"
                                    placeholder="Password" required>
                                <span toggle="#password-field"
                                    class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="form-control btn btn-primary submit px-3">Register</button>
                            </div>
                            <div class="form-group d-md-flex">
                                <div class="w-50">
                                    <a href="manager_login.php"  style="color: #fff">Login</a><br>
                                    <a href="index.php"  style="color: #fff">Back to Home</a>
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