<!DOCTYPE html>
<html>
<head>
    <link href="images/AeroStarLogo-Header.jpg" rel="icon">
    <link href="styles/style.css" rel="stylesheet">
    <link href="styles/form.css" rel="stylesheet">
    <title>Manager Logout</title>
</head>
<body>
    <?php
    // Start the session
    session_start();

    // Destroy the session to log out the manager
    session_destroy();
    ?>
    <h2>Logged out successfully!</h2>
    <a href="manager_login.php"><button>Log in again</button></a>
    <a href="index.php"><button>Back to Home</button></a>
</body>
</html>
