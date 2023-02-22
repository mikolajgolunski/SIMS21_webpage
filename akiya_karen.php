<?php
require "./extras/always_require.php";

//no need to check if logged in

//no need to check if comes from proper page

$_SESSION["last_site"] = "akiya_karen";
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

      <title>SIMS21, Poland 2017 - Dr. Akiya Karen</title>
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
              <h1>Dr. Akiya Karen (Toray Research Center)</h1>
	<p>We are very sorry to inform that Dr. Akiya Karen (Toray Research Center, Japan) passed away on 15 March 2017 at the age of 57.</p> 

        <p>Dr. Karen was a very active member of the SIMS Community, serving many times on the International Scientific Committee and Organizing Committees of SIMS conferences.</p>
        <p>Akiya will be sorely missed, both scientifically and humanly, by his many friends and colleagues.</p>
        <center><img src="./img/Dr_Akiya_Karen.jpg"></center>
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
