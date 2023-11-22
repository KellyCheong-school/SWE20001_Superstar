<!DOCTYPE html>
<html lang="en">

<head>
  <title>About Us</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <style type="text/css">
    @import url('https://fonts.googleapis.com/css?family=Open+Sans:400,700,800');
    @import url('https://fonts.googleapis.com/css?family=Lobster');

    body {
      font-family: 'Open Sans', sans-serif;
      text-align: center;
    }

    *,
    *:before,
    *:after {
      box-sizing: inherit;
    }

    .about-section {
      padding: 15px;
      text-align: center;
      color: white;
    }

    .row {
      display: flex;
      justify-content: center;
      align-items: stretch;
      flex-wrap: wrap;
      /* Added to allow wrapping to the next row */
    }

    .column {
      width: 20%;
      margin: 0 8px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .card {
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
      margin: 8px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      height: 100%;
    }

    .container {
      padding: 0 16px;
      text-align: left;
      flex-grow: 1;
    }

    .title {
      color: grey;
    }

    .center {
      display: block;
      margin-left: auto;
      margin-right: auto;
    }

    /* Style for email link */
    .email-link:link {
      color: green;
      background-color: transparent;
      text-decoration: none;
    }

    .email-link:visited {
      color: green;
      background-color: transparent;
      text-decoration: none;
    }

    .email-link:hover {
      color: red;
      background-color: transparent;
      text-decoration: underline;
    }

    .email-link:active {
      color: yellow;
      background-color: transparent;
      text-decoration: underline;
    }
  </style>
</head>

<body>
  <?php
  require_once('settings.php');
  session_start();
  // Establish a database connection
  $conn = @mysqli_connect($host, $user, $pwd, $sql_db);

  // Check if the connection was successful
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  $query1 = mysqli_query($conn, "SELECT * FROM destination ORDER BY RAND() LIMIT 2");

  $row1 = mysqli_fetch_array($query1);
  $row2 = mysqli_fetch_array($query1);
  include 'includes/guestHeader.inc';
  ?>
  <br><br><br><br>

  <div class="about-section">
    <h1 style="color:white;">About Us</h1>
    <p>Our group consists of 4 person and our system is known as Superstar Flight Booking System</p>
  </div>

  <h2 style="text-align:center; color:white;">Our Team</h2>
  <div class="row">
    <div class="column">
      <div class="card">
        <br>
        <img src="images/Kelly.jpg" alt="Kelly" style="width:200px; height:250px;" class="center">
        <div class="container">
          <center>
            <h2>Kelly Cheong</h2>
            <a href="mailto:104652191@student.swin.edu.au" class="email-link">104652191@student.swin.edu.au</a>
          </center>
          <center>
            <p class="title">UI & Front-end Developer</p>
          </center>
          <p>I played a key role in elevating the user experience of our project system by leading the enhancement of user interfaces. Through a meticulous evaluation of the existing UI, I identified areas for improvement and collaborated closely with the team to implement changes that aligned with project objectives. Subsequently, I took charge of the front-end development phase, translating enhanced designs into functional interfaces using Bootstrap. A crucial aspect of my contribution was ensuring seamless integration with the member's backend codes.</p>
          <br> </br>
        </div>
      </div>
    </div>

    <div class="column">
      <div class="card">
        <br>
        <img src="images/me.png" alt="Jason" style="width:200px; height:250px;" class="center">
        <div class="container">
          <center>
            <h2>Jason Tan</h2>
            <a href="mailto:104650807@student.swin.edu.au" class="email-link">104650807@student.swin.edu.au</a>
          </center>
          <center>
            <p class="title">Backend Development</p>
          </center>
          <p>In this project, I hold the crucial responsibility of managing the database architecture for various essential functionalities. My focus spans across the intricacies of register/login, payment processing, displaying flights, and facilitating the selection of flights. Additionally, I oversee the database structures for manager, member, and passenger entities. Utilizing my skills in HTML, CSS, JavaScript, and PHP, I ensure the meticulous management and optimization of data. This intricate integration of database expertise and coding proficiency serves as the backbone, guaranteeing the robust functionality and operational efficiency of our project.</p>
          <br> </br>
        </div>
      </div>
    </div>

    <div class="column">
      <div class="card">
        <br>
        <img src="images/Ervin.jpg" alt="Ervin" style="width:200px; height:250px;" class="center">
        <div class="container">
          <center>
            <h2>Ervin Tee</h2>
            <a href="mailto:104845933@student.swin.edu.au" class="email-link">104845933@student.swin.edu.au</a>
          </center>
          <center>
            <p class="title">All Rounder</p>
          </center>
          <p>As an all-rounder in the development of a comprehensive Flight Management System (FMS), I have adeptly navigated the realms of both back-end and front-end development, ensuring a seamless integration of functionalities. My responsibilities extended beyond coding, encompassing rigorous testing procedures to guarantee the system's reliability and performance under diverse conditions. In addition, my involvement in UI/UX design aimed at crafting an intuitive and visually appealing interface for users, optimizing the experience.</p>
          <br> </br>
        </div>
      </div>
    </div>

    <div class="column">
      <div class="card">
        <br>
        <img src="images/PuiSeng.jpg" alt="Pui Seng" style="width:200px; height:250px;" class="center">
        <div class="container">
          <center>
            <h2>Pui Seng Wong</h2>
            <a href="mailto:104990516@student.swin.edu.au" class="email-link">104990516@student.swin.edu.au</a>
          </center>
          <center>
            <p class="title">Front-end Developer</p>
          </center>
          <p>My professional responsible in this project is creating the visual elements and user interface of a web application, such as writing a clean, maintainable, and efficient code using HTML, CSS, and JavaScript. My primary focus is on the client side of development, ensuring that the user experience is seamless, visually appealing, and responsive across various devices and browsers.</p>
          <br> </br>
        </div>
      </div>
    </div>
  </div>

  <hr>
  <script src="js/jquery.min.js"></script>
  <script src="js/popper.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>
</body>

</html>