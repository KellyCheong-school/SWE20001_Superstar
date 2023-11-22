<!DOCTYPE html>
<html>

<head>
    <link href="images/AeroStarLogo-Header.jpg" rel="icon">
    <link href="styles/style.css" rel="stylesheet">
    <link href="styles/form.css" rel="stylesheet">
    <title>Member Registration</title>
</head>

<body>
    <?php
    require_once('settings.php');
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

        // Check if the members table exists, if not, create it
        $tableCheckQuery = "SHOW TABLES LIKE 'members'";
        $tableCheckResult = mysqli_query($conn, $tableCheckQuery);

        if (!$tableCheckResult || mysqli_num_rows($tableCheckResult) == 0) {
            // Table doesn't exist, create it
            $createTableQuery = "
                CREATE TABLE members (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    username VARCHAR(255) NOT NULL,
                    password VARCHAR(255) NOT NULL
                )
            ";
            $createTableResult = mysqli_query($conn, $createTableQuery);

            if (!$createTableResult) {
                die("Error creating members table: " . mysqli_error($conn));
            }
        }

        // Check if the username or password already exists in the members table
        $checkUniqueQuery = "SELECT * FROM members WHERE username = '$username' OR password = '$password'";
        $checkUniqueResult = mysqli_query($conn, $checkUniqueQuery);

        if (mysqli_num_rows($checkUniqueResult) > 0) {
            // Username or password already exists, display an error message
            echo "Error: Username or password already exists. Please choose a different username or password.";
        } else {
            // Username and password are unique, proceed with member registration

            // Prepare and execute the SQL statement to insert the member information
            $sql = "INSERT INTO members (username, password) VALUES ('$username', '$password')";

            if (mysqli_query($conn, $sql)) {
                echo "Member registered successfully.";
            } else {
                echo "Error: " . mysqli_error($conn);
            }

            // Close the database connection
            mysqli_close($conn);

            // Redirect to the member login page
            header("Location: index.php");
            exit();
        }
    }
    ?>
    <div class="form-container">
        <h2>Member Registration</h2>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required><br>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required><br>

            <input type="submit" value="Register">
        </form>
        <div>
            <br>
            <a href="index.php"><button>Back to Login</button></a>
        </div>
    </div>
</body>

</html>