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
        <h1>Enhancements</h1>
        <ul>
          <li>Responsive Design
              <p>I implemented this enhancement because it was one of the enhancements mentioned in the assignment 
                requirements. Furthermore, I think this is significant for my website as some visitors browse through
                websites using various devices. Therefore, it is important to ensure the content they view are in
                correct format.
                <br><br>
                The codes that are used for this enhancement is "@media only screen and (max-width: 767px)" and "@media only screen and (min-width: 768px) and (max-width: 1024px)" to indicate the device for.
                They are located in the enhancements.css CSS file.
                <br><br>
                To View (In Chrome): Right-click on any page and select inspect element. Then, click on the icon (Toogle Device Toolbar)
                on the left side of the word "Elements" or press Ctrl + Shift + M. Finally set the width of the screen to
                375px (for mobile) or 768px (for tablet) after choosing Dimensions: Responsive.
          </li>
          <li>
            <a href="product.php#ImageMap">Image Maps</a>
            <p>This enhancement suitable to be implemented in this assignment as it was not covered in the tutorial.
               Besides that, I think this is also important in my website as it allows visitors to know more about the
               destinations by clicking on the tourist attractions in the image.
               <br><br>
               The codes that are used in this enhancement are usemap, map and area. I did this by adding a rectangle
               to the coordinates of the tourist attraction I wanted to cover in the image.
               <br><br>
               <a href="https://www.w3schools.com/html/html_images_imagemap.asp">Source: w3schools</a>
            </p>
          </li>
          <li>
            <a href="#SocialMedia">Social Media Integration</a>
            <p>I implemented this enhancement because it was not mentioned in the assignment requirements.
              Furthermore, I think this is important in my website to allow visitors to get in touch with 
              us to catch up with the latest news and promotions of AeroStar website. 
              <br><br>
              The codes that are used in this is a button tag and CSS class from Remix Icon to implement
              the icons.
              <br><br>
              <a href="https://remixicon.com">Icons Source: Remix Icon</a>
           </p>
          </li>
        </ul>
      </section>
        <a href="#top" class="back-to-top">Back to Top</a><br><br><br>
        <hr>
        <?php include 'includes/footer.inc'; ?>

      </body>

</html>