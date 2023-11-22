<head>
  <style>
    .welcome-message {
    text-align: right;
    font-size: 20px;
    color: #555;
    margin-right: 20px;
    border: 1px solid #ddd; /* Added border */
    padding: 5px 10px; /* Added padding */
    border-radius: 5px; /* Added border-radius */
  }

  nav ul ul {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    background-color: #fff;
    box-shadow: 0 2px 2px rgba(0, 0, 0, 0.1);
    padding: 0; /* Add this line to remove padding */
    margin: 0; /* Add this line to remove margin */
  }

  nav ul li:hover > ul {
    display: block;
  }

  nav ul ul li {
    width: 200px;
    float: none;
    display: list-item;
    position: relative;
  }

  /* Added styles for background color, font color, and hover color */
  nav ul ul a {
    background-color: #0074D9;
    color: #fff;
    padding: 8px;
    text-decoration: none;
    display: block;
  }
  </style>
</head>

<header>
        <div id="top"></div>
        <section class="logo-container">
          <img src="images/AeroStarLogo.png" alt="AeroStar Logo">
          <h1>AeroStar - Taking you higher</h1>
        </section>
        <nav>
          <ul>
            <li><a href="aboutUs.php">About Us</a></li>
            <li><a href="manager.php">Manager Page</a></li>
            <li><a href="manager_registration.php">Manager Registration</a></li>
            <li><a href="#">Manage</a>
              <ul>
                <li><a href="create_destination.php">Destination</a></li>
                <li><a href="create_flight.php">Flight</a></li>
                <li><a href="create_promotions.php">Promotions</a></li>
              </ul>
            </li>
          </ul>
        </nav>
        <a href="manager_logout.php"><button>Logout</button></a><br>
        <?php echo '<div class="welcome-message">Welcome admin: ' . htmlspecialchars($username) . '</div>';?>
</header>