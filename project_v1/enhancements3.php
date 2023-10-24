<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name = "description" content="Discover the latest enhancements made to the AeroStar webpage, providing users with a seamless and convenient experience. Learn about new features and improvements designed with customers in mind.">
    <meta name = "keywords" content="AeroStar, enhancements">
    <meta name = "author" content="Jason Tan">
    <title>AeroStar - Enhancements</title>
    <link href="images/AeroStarLogo-Header.jpg" rel="icon">

    <link href = "styles/style.css" rel = "stylesheet">
    <link href = "styles/enhancements.css" rel = "stylesheet">

  </head>
    
    <body>
      <?php include 'includes/header.inc'; ?>
        
        <hr>
      <section class="enhancements">
        <h1>Enhancements 3 (PHP)</h1>
        <ul>
          <li><a href="manager_login.php">Manager Security</a>
              <p>This enhancement is done in manager_login.php, manager_registration.php, manager_logout.php and manager.php. This enhancements
                ensure that the manager.php is safe from people that are unauthorized. Users are required to login to be able to edit and view
                the data. Users also cannot direct access to manager.php and will be required to login first. When register, the username and
                password cannot be the same as they are all unique. The entered username and password will be checked from the database during
                login and registration to see whether they match the requirements. User can also logout from the manager.php.
              </p>
                <a href="https://www.w3schools.blog/php-program-to-create-login-and-logout-using-sessions">Source: w3schools - PHP Program To Create Login And Logout Using Sessions</a>
                <br><br>
          </li>
          <li>
            <a href="manager.php#report">Advanced Manager Reports</a>
            <p>This enhancement in manager.php generates reports on the most popular product ordered by customers, orders fulfilled 
              within a specified date range entered by the vendor, calculates and displays the average number of orders placed per day.
              This is very useful for the manager by providing a useful metric for evaluating order frequency and identifying trends 
              in customer behavior. It also allows managers to analyze their performance and track order fulfillment within desired date ranges.
            </p>
              <a href="https://ubiq.co/database-blog/mysql-query-to-get-top-selling-products/">Source: ubiq - MySQL Query To Get Top Selling Products</a><br>
              <a href="https://www.scratchcode.io/how-to-select-data-between-two-dates-in-mysql/">Source: ScratchCode - How To Select Data Between Two Dates In MySQL</a><br>
              <a href="https://www.w3schools.com/sql/sql_groupby.asp">Source: w3schools - SQL GROUP BY Statement</a>
              <br><br>
          </li>
        </ul>
      </section>
        <a href="#top" class="back-to-top">Back to Top</a><br><br><br>
        <hr>
        <?php include 'includes/footer.inc'; ?>

      </body>

</html>