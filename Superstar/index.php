<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="images/AeroStarLogo-Header.jpg" rel="icon">

    <link href="styles/loginstyle.css" rel="stylesheet">
    <link href="styles/style.css" rel="stylesheet">
</head>

<body>
    <header>
        <section class="logo-container">
            <img src="images/AeroStarLogo.png" alt="AeroStar Logo">
            <h1>AeroStar - Taking you higher</h1>
        </section>
    </header>
    <?php
    require_once('settings.php');
    session_start();

    // Establish a database connection
    $conn = @mysqli_connect($host, $user, $pwd, $sql_db);

    // Check if the connection was successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the entered username and password
        $enteredUsername = $_POST["username"];
        $enteredPassword = $_POST["password"];

        // Prepare and execute the SQL statement to retrieve the member information
        $sql = "SELECT * FROM members WHERE username = '$enteredUsername'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $member = mysqli_fetch_assoc($result);

            // Verify the password
            if ($enteredPassword == $member['password']) {
                // Password is correct, store the login status in the session
                $_SESSION['member_id'] = $member['id'];
                $_SESSION['member_username'] = $member['username'];

                // Redirect to the member web page
                header("Location: memberPage.php");
                exit();
            } else {
                // Password is incorrect
                echo "Invalid password.";
            }
        } else {
            // Member not found
            echo "Member not found.";
        }
    }

    // Close the database connection
    mysqli_close($conn);
    ?>

    <body>
        <br><br>
        <div class="form-container">
            <h2>Member Login</h2>
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required><br>

                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required><br>

                <input type="submit" value="Login">
            </form>
            <p>Not a member yet? <a href="member_registration.php">Register Now!</a></p>
        </div>
    </body>


    <div class="other-login-methods">
        <h2>Other Login Methods:</h2>
        <a class="button" href="manager_login.php">Login as Manager</a>
        <p>or</p>
        <a class="button" href="guestPage.php">Continue as Guest</a>
    </div>

    <br>
    <?php include 'includes/footer.inc'; ?>
</body>

</html>