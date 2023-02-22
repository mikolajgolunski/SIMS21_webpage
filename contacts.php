<?php
require "./extras/always_require.php";

//no need to check if logged in

//no need to check if comes from proper page

$_SESSION["last_site"] = "contacts";
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

      <title>SIMS21, Poland 2017 - Contact</title>
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
              <h1>Contact</h1>
              <div class="contact">
                <h2>Conference Chairman</h2>
                <h3>Prof. Zbigniew Postawa</h3> Institute of Physics<br> Jagiellonian University<br> ul. &#321;ojasiewicza 11<br> 30-348 Krak&#243;w<br> Poland
                <br> email: <a href="mailto:zbigniew.postawa@uj.edu.pl">zbigniew.postawa@uj.edu.pl</a><br> Tel: +48 12 664-4626
              </div>

              <div class="contact">
                <h2>Conference Secretary</h2>
                <h3>Mrs. Dorota &#346;wierz</h3> Institute of Physics<br> Jagiellonian University<br> ul. &#321;ojasiewicza 11<br> 30-348 Krak&#243;w<br> Poland
                <br> email: <a href="mailto:user@user.user">user@user.user</a><br> Tel: +48 12 664-4560
              </div>

              <div class="contact">
                <h2>Equipment exhibition - technical aspects</h2>
                <h3>Mr. Piotr Pi&#261;tkowski</h3> Institute of Physics<br> Jagiellonian University<br> ul. &#321;ojasiewicza 11<br> 30-348 Krak&#243;w<br> Poland
                <br> email: <a href="mailto:piotr.piatkowski@uj.edu.pl">piotr.piatkowski@uj.edu.pl</a><br> Tel: +48 12 664-4623
              </div>
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
