<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Kelly | 19-Aug-2023 | Start -->
  </head>
 
  <body>
    <?php include 'includes/header.inc'; ?>
    
      <hr>
      <h2>Destinations</h2>
      <p>Our flight destinations vary across Asia, including Tokyo in Japan, Bali in Indonesia, Seoul 
        in South Korea, Bangkok in Thailand, and Singapore. For European destinations, we offer flights to Paris in France, 
        Rome in Italy, Barcelona in Spain, Amsterdam in the Netherlands, and Berlin in Germany.</p>
      <p class="hidden">Scroll left for more destinations!</p>
      <table class="flights">
        <tr class="flights">
          <td class="flights">
            <img class ="destinations" src="images/asia.jpg" alt="asia destination"><br>
            <a href="https://dynamic-media-cdn.tripadvisor.com/media/photo-o/14/10/2d/bd/asia.jpg?w=500&h=300&s=1">Image Source</a>
          </td>
          <td class="flights">
            <img class ="destinations" src="images/europe.jpg" alt="europe destination"><br>
            <a href="https://dynamic-media-cdn.tripadvisor.com/media/photo-o/15/33/ff/4a/europe.jpg?w=700&h=500&s=1">Image Source</a>
          </td>
          <td class="flights">
            <img class ="destinations" src="images/jungle.jpg" alt="jungle destination"><br>
            <a href="https://www.insidescience.org/sites/default/files/2020-06/Yasuni-Forest.jpg">Image Source</a>
          </td>
        </tr>
        <tr class="flights">
          <td><p>Escape to Asia's hidden gems and immerse yourself in breathtaking natural wonders, from pristine beaches to 
            exotic islands, and discover the rich cultural heritage of local communities. Embark on a journey of a lifetime and 
            experience the authentic flavors and traditions of Asia while creating memories that will last forever. Book your 
            flight now and let us take you on an unforgettable adventure to the heart of Asia.</p></td>
          <td><p>Discover the wonders of Europe's rich heritage and culture, from magnificent ancient buildings to iconic landmarks 
            and world-class museums. Be enchanted by the vibrant art scenes of Paris, immerse yourself in the history of Rome, or 
            marvel at the majestic castles of Edinburgh. Book your flight now and embark on a journey of discovery to Europe's most 
            breathtaking destinations. Let us take you on an unforgettable adventure filled with unparalleled experiences, 
            exquisite cuisine, and memories that will last a lifetime.</p></td>
          <td><p>Get ready to immerse yourself in the natural beauty of Southeast Asia. Explore the lush rainforests teeming with 
            exotic flora and fauna, bask in the sun-kissed beaches, and experience life with the indigenous people. From the bustling 
            streets of Bangkok to the tranquil rice paddies of Bali, our flights to ASEAN countries will take you on a journey 
            like no other. Embark on an adventure that will take you off the beaten path and into the heart of Southeast Asia's rich 
            cultural heritage. Book your flight now and experience the warmth, hospitality, and stunning beauty of this tropical 
            paradise.</p></td>
        </tr>
      </table>
      
        <a class="view-more" href="product.php">View Flight Tickets</a>
      
        <hr>
        
        <div class="slideshow-container" id="slideshow">
          <h2>Promotions & Notices</h2>
          <div class="slide">
            <img class="promotion" src="images/promo1.png" alt="FACES">
            <p class="promotion-text"><strong>FACES, a faster boarding experience</strong><br>Get ready for a quicker and seamless travel experience.</p>
          </div>
        
          <div class="slide">
            <img class="promotion" src="images/promo2.png" alt="Raya Fixed Fares">
            <p class="promotion-text"><strong>Raya Fixed Fares</strong><br>Balik Kampung to Sabah & Sarawak from RM199.</p>
          </div>
        
          <div class="slide">
            <img class="promotion" src="images/promo3.jpg" alt="Exciting Holiday">
            <p class="promotion-text"><strong>Pack up! It's go time</strong><br>All-in one-way fare from RM35*.</p>
          </div>
        
          <div class="slide">
            <img class="promotion" src="images/promo4.jpg" alt="Flight + Hotel Deal">
            <p class="promotion-text"><strong>Up to 30% off</strong><br>Save more with Flight + Hotel deals.</p>
          </div>
        
          <!-- Dot indicators -->
        <div class="dot-container">
          <span class="dot"></span>
          <span class="dot"></span>
          <span class="dot"></span>
          <span class="dot"></span>
        </div>

        <p>Source: <u><a href="https://www.airasia.com/en/gb">Promotion & Notice in AirAsia Homepage</a></u></p>
        </div>
      
      <a href="#top" class="back-to-top">Back to Top</a><br><br><br>
      <hr>
      <?php include 'includes/footer.inc'; ?>

      <?php include 'includes/script.inc'; ?>
    </body>

</html>