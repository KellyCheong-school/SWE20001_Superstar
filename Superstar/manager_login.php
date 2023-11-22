<!doctype html>
<html lang="en">

<head>
    <title>Manager Login</title>
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
    session_start();

    $infoMsg = null;

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the entered username and password
        $enteredUsername = $_POST["username"];
        $enteredPassword = $_POST["password"];

        // Establish a database connection
        $conn = @mysqli_connect($host, $user, $pwd, $sql_db);

        // Check if the connection was successful
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Prepare and execute the SQL statement to retrieve the manager information
        $sql = "SELECT * FROM managers WHERE username = '$enteredUsername'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $manager = mysqli_fetch_assoc($result);

            // Verify the password
            if ($enteredPassword == $manager['password']) {
                // Password is correct, store the login status in the session
                $_SESSION['manager_id'] = $manager['id'];
                $_SESSION['manager_username'] = $manager['username'];

                // Redirect to the manager web page
                header("Location: manager.php");
                exit();
            } else {
                // Password is incorrect
                $infoMsg = "Incorrect password.";
            }
        } else {
            // Manager not found
            $infoMsg = "Username is not found.";
        }

        // Close the database connection
        mysqli_close($conn);
    }
    include 'includes/guestHeader.inc';
    ?>
    <br><br><br>

    <section class="ftco-section">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center mb-5">
                <?php
                //Alert Message
                if ($infoMsg != null) {
                    echo "<div class='col-md-8 mx-auto p-2' style='background-color:transparent;'><div class='alert alert-danger alert-dismissible fade show mx-auto' role='alert'>
                      <p class='mb-0' style='font-size: 10pt; color: #b04002;'>$infoMsg</p>
                      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                          <span aria-hidden='true'>&times;</span>
                      </button>
                  </div></div>";

                }
                ?>
            </div>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center mb-5">
                    <h2 class="heading-section">Manager Login Page</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="login-wrap p-0">
                        <form action="#" class="signin-form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="form-group">
                                <input style="font-size: 11pt;" type="text" name="username" id="username"
                                    class="form-control" placeholder="Username" required>
                            </div>
                            <div class="form-group">
                                <input style="font-size: 11pt;" id="password-field" name="password" type="password"
                                    class="form-control" placeholder="Password" required>
                                <span toggle="#password-field"
                                    class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="form-control btn btn-primary submit px-3">Login</button>
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