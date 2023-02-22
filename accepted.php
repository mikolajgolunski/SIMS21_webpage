<?php
session_start();
require "./extras/always_require.php";

//no need to check if logged in
//TODO Add logged in check

//no need to check if comes from proper page
//TODO Add transaction site origin

$_SESSION["last_site"] = "accepted";
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
    require('./includes/head.html');
    ?>

    <style type="text/css">
    </style>
      <title>SIMS21, Poland 2017 - Payment accepted</title>
  </head>

  <body>
    <div id="wrapper">
      <?php
    require('./includes/header.html');
    ?>

        <div id="main">
          <?php
        require("./includes/menu.php");
        ?>

            <div id="content">
              <h1>Payment accepted</h1>
              
              <p>Your credit card payment has been accepted.</p>
            </div>

            <?php
          require("./includes/side.html");
          ?>

        </div>
    </div>
    <?php
  require("./includes/footer.html");
  ?>

  </body>

  </html>