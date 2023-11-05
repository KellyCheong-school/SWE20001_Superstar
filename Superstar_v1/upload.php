<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8">

    <?php
    require_once('settings.php');
        // Establish a database connection
        $conn = @mysqli_connect($host, $user, $pwd, $sql_db);
    ?>

    </head>
 
    <body>
        <?php
        $sql = "SELECT id, username, email FROM users";
        $result = $conn->query($sql);
        
        ?>

        <?php foreach($rows as $row) : ?>
            <tr>
            <?php
            // Fetch and display data
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<td>";?> <img src="<?php echo $row["destinationimg"]; ?>" <?php
                }
            } else {
                echo "No results found.";
            }

            $conn->close();

            ?>
            <hr>
            <?php endforeach; ?>
    </body>

</html>