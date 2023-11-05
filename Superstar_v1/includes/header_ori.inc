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
  </style>
</head>

<header>
        <div id="top"></div>
        <section class="logo-container">
          <img src="images/logo.png" alt="Superstar Logo">
          <h1>Superstar - Taking you higher</h1>
        </section>
        <?php include 'includes/menu.inc'; ?>

        <?php 
        echo '<div class="welcome-message">Welcome user: ' . htmlspecialchars($username) . '</div>';?>
</header>