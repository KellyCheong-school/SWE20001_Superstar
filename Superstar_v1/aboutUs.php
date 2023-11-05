<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Welcome to AeroStar. Browse our flights and book tickets online for affordable and comfortable trips to your desired destinations. Explore our website and discover our exciting travel deals and packages.">
  <meta name="keywords" content="AeroStar, Main Menu">
  <meta name="author" content="Jason Tan">
  <title>AeroStar - Home</title>
  <link href="images/AeroStarLogo-Header.jpg" rel="icon">

  <link href="styles/style.css" rel="stylesheet">
  <script src="scripts/enhancements2.js"></script>

  <style>
*, *:before, *:after {
  box-sizing: inherit;
}

.column {
  float: left;
  width: 23.5%;
  margin-bottom: 16px;
  padding: 0 8px;
}

.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  margin: 8px;
}

.about-section {
  padding: 15px;
  text-align: center;
  background-color: #474e5d;
  color: white;
}

.container {
  padding: 0 16px;
}

.title {
  color: grey;
}

  .center {
  display: block;
  margin-left: auto;
  margin-right: auto;
}

/*Style for email link*/
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

<div class="about-section">
  <h1>About Us</h1>
  <p>This page introduces the developers of this web application.</p>
</div>

<h2 style="text-align:center">Our Team</h2>
<div class="row">
  <div class="column">
    <div class="card">
      <br>
      <img src="img/p1.jpg" alt="Jason" style="width:200px; height:200px;" class="center">
      <div class="container">
        <h2>Jason Tan</h2>
        <p class="title">(Title)</p>
        <p>(Some text that describes yourself.)</p>
        <a href = "mailto: 104650807@student.swin.edu.au" class="email-link">104650807@student.swin.edu.au</a>
        <br> </br>
      </div>
    </div>
  </div>

  <div class="column">
    <div class="card">
    <br>
      <img src="img/p2.png" alt="Kelly" style="width:200px; height:200px;" class="center">
      <div class="container">
        <h2>Kelly Cheong</h2>
        <p class="title">(Title)</p>
        <p>(Some text that describes yourself.)</p>
        <a href = "mailto: 104652191@student.swin.edu.au" class="email-link">104652191@student.swin.edu.au</a>
        <br> </br>
      </div>
    </div>
  </div>

  <div class="column">
    <div class="card">
    <br>
      <img src="img/p3.jpg" alt="Ervin" style="width:200px; height:200px;" class="center">
      <div class="container">
        <h2>Ervin Tee</h2> 
        <p class="title">(Title)</p>
        <p>(Some text that describes yourself.)</p>
        <a href = "mailto: 104845933@student.swin.edu.au" class="email-link">104845933@student.swin.edu.au</a>
        <br> </br>
      </div>
    </div>
  </div>
</div>

<div class="column">
    <div class="card">
    <br>
      <img src="img/p4.png" alt="Pui Seng" style="width:200px; height:200px;" class="center">
      <div class="container">
        <h2>Pui Seng Wong</h2> 
        <p class="title">(Title)</p>
        <p>(Some text that describes yourself.)</p>
        <a href = "mailto: 104990516@student.swin.edu.au" class="email-link">104990516@student.swin.edu.au</a>
        <br> </br>
      </div>
    </div>
  </div>
</div>

<a href="#top" class="back-to-top">Back to Top</a><br><br><br>
  <hr>
    <?php include 'includes/footer.inc'; ?>
</body>

</html>