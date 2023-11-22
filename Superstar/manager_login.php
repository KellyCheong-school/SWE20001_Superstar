<!DOCTYPE html>
<html>

<head>
    <link href="images/AeroStarLogo-Header.jpg" rel="icon">
    <link href="styles/style.css" rel="stylesheet">
    <link href="styles/form.css" rel="stylesheet">
    <title>Manager Login</title>
</head>

<body>
    <?php
    require_once('settings.php');
    session_start();

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
                echo "Invalid password.";
            }
        } else {
            // Manager not found
            echo "Manager not found.";
        }

        // Close the database connection
        mysqli_close($conn);
    }
    ?>
    <div class="form-container">
        <h2>Manager Login</h2>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="username">Username: admin</label>
            <input type="text" name="username" id="username" required><br>

            <label for="password">Password: password</label>
            <input type="password" name="password" id="password" required><br>

            <input type="submit" value="Login">
        </form>
        <div>
            <br>
            <a href="index.php"><button>Back to Home</button></a>
        </div>
    </div>
</body>

</html>