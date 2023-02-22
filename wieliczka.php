<?php
require "./extras/always_require.php";

//no need to check if logged in

//no need to check if comes from proper page

$_SESSION["last_site"] = "wieliczka";
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

      <title>SIMS21, Poland 2017 - Wieliczka</title>
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
              <span></span><img class="centered" src="img/kolaz_wieliczka.png" width="603" height="512">

              <p>The Wieliczka Salt Mine is one of the most important monuments of material and spiritual culture in Poland. Each year it is visited by more than one million tourists from all over the world.</p>

              <p>The underground trail leads through magical drifts, galleries and magnificent chambers chiseled out of the surrounding rock salt, where traces of mining activity have been preserved. Amazing underground saline lakes, majestic timber constructions and unique statues sculpted in salt. The microclimate of the mine is reported to have benefits for visitors who suffer from asthma and allergies. You will not become tired as you wonder through 3 km of underground corridors. </p>

              <h2>Tour description</h2>
              <p>The buses will leave from the Conference center at 17:00 (5:00&nbsp;p.m.). This is a walking tour. The tour starts with a descent down stairs to the depth of 64&nbsp;meters. There is an elevator for visitors who require it. Visitors are led through a stupendous chambers and shown underground lakes, shrines and salt monuments. The trip finishes at the level of 135 meters below the surface. </p>

              <p>The temperature in the Wieliczka Salt Mine is a uniform 15&nbsp;&deg;C (59&nbsp;&deg;F) at any time of year. As walking is the main means of transportation wearing comfortable footwear is advised.</p>
              
              <p>The Conference Dinner takes place in the underground banquet chamber of the Wieliczka Salt Mine. Therefore participants in this tour will not return to the conference center after the tour, but stay at the salt mine for the banquet.</p>

              <p><img src="./img/wheel.gif" class="wheel-img" width="30" height="30">This excursion is wheelchair accessible. Please let us know if you need assistance.</p>

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
