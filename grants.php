<?php
require "./extras/always_require.php";

//no need to check if logged in

//no need to check if comes from proper page

$_SESSION["last_site"] = "grants";
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

      <title>SIMS21, Poland 2017 - Grants</title>
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
              <h1>Grants</h1>

              <p>Thanks to generous contributions from our sponsors following grants are available:</p>
              <ul>
                <li><a href="iaea_grants.php">IAEA Travel Grants.</a></li>
                <li><a href="iuvsta_grants.php">IUVSTA Short Course Grants for Students.</a></li>
                <li><a href="rowland_award.php">Rowland Hill Grants for Students.</a></li>
                <li><a href="student_grants.php">SIMS21 Student Grants.</a></li>
                <li><a href="awards.php">Best Presentation Awards.</a></li>
                <li><a href="discounted_flights.php">Discounted Flights on Star Alliance Airlines.</a></li>
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
