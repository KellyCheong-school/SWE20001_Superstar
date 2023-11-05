<head>
  <style>
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
    width: 150px;
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


<nav>
    <ul>
    <li><a href="memberPage.php">Home</a></li>
    <li><a href="product.php">Flights</a></li>
    <li><a href="#">Booking</a>
        <ul>
        <li><a href="enquire.php">Book Now</a></li>
        <li><a href="viewBooking.php">View Booking</a></li>
        </ul>
    </li>
    <li><a href="aboutUs.php">About Us</a></li>
    <li><a href="member_logout.php">Logout</a></li>
    </ul>
</nav>