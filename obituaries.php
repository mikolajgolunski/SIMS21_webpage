<?php
require "./extras/always_require.php";

//no need to check if logged in

//no need to check if comes from proper page

$_SESSION["last_site"] = "obituaries";
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

      <title>SIMS21, Poland 2017 - Obituaries</title>
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
              <h1>Obituaries</h1>
              
              <p>We are sorry to inform about passing away of several distinguished collegues from the SIMS community. Their obituaries can be found in the following sites:</p>
              <ul>
                <li><a href="obituary_benninghoven.php">Alfred Benninghoven</a> - &#x2020;22 December 2017</li>
                <li><a href="obituary_briggs.php">David Briggs</a> - &#x2020;10 January 2018</li>
                <li><a href="obituary_wittmaack.php">Klaus Wittmaack</a> - &#x2020;December 2017</li>
              </ul>
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
