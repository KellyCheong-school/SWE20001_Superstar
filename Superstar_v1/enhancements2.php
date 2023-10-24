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
        <h1>Enhancements 2 (JavaScript)</h1>
        <ul>
          <li><a href="index.php#slideshow">Slideshow</a>
              <p>This enhancement in index.html is automatically triggered when the page is loaded and the slide will automatically change after 5 seconds. 
                User can click on the dots to manually change the slides. To make this enhancement, the previous table need to be separated 
                into a few 'div'. Then, in the JavaScript, I need to hide the other slides and only make one slide visible. Next, I also set
                the event listener of the dots to change when clicked.
              </p>
                <a href="https://www.w3schools.com/howto/howto_js_slideshow_gallery.asp">Source: w3schools - Slideshow Gallery</a>
                <br><br>
          </li>
          <li>
            <a href="enquire.php#calendar">Calendar</a>
            <p>This enhancement in enquire.html will be triggered when the HTML document has been completely loaded and parsed. This enhancement is to
              ensure the users select only departure date starting from today onwards and return date starting from the selected departure
              date. In this enhancment, I had set the maximum departure date to 2 years from today and maximum return date to 2 years from
              departure date. Other than that, users can only select return date after the departure date had been selected. To implement 
              this code, I had set the time zone to Malaysia. Next, I set the min and max for departure date and return date which will 
              change upon user selection.
            </p>
              <a href="https://www.w3schools.com/js/js_date_methods.asp">Source: w3schools - JavaScript Get Date Methods</a><br>
              <a href="https://www.w3schools.com/jsref/jsref_gettimezoneoffset.asp">Source: w3schools - JavaScript Date getTimezoneOffset()</a><br>
              <a href="https://www.w3schools.com/jsref/jsref_toisostring.asp">Source: w3schools - JavaScript Date toISOString()</a>
              <br><br>
          </li>
          <li>
            <a href="payment.php#prefill">Prefill Form</a>
            <p>I implemented this enhancement in enquire.html because it was not mentioned in the assignment requirements. To trigger this enhancement,
              user need to click on the "Back to Order Form" button in payment.html. After clicking, the user will be redirected back
              to the enquire.html with the fields prefilled with the values selected by the user. To implement this code, I need to get
              the value of the fields and set them using the values in sessionStorage.
              <br>
              <p>Source: Lab 6 - Optional Tasks</p>
           </p>
          </li>
        </ul>
      </section>
        <a href="#top" class="back-to-top">Back to Top</a><br><br><br>
        <hr>
        <?php include 'includes/footer.inc'; ?>

      </body>

</html>