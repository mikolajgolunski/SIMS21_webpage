<?php
require "./extras/always_require.php";

//no need to check if logged in

//no need to check if comes from proper page

$_SESSION["last_site"] = "krakow";
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

      <title>SIMS21, Poland 2017 - Krak&oacute;w</title>
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
              <img class="centered" src="img/kolaz_krakow.png" width="603" height="512">
              
              <p>The Old Town is the historic central district of Krak&oacute;w. It was the center of Poland's political life from 1038 until King Sigismund III Vasa relocated his court to Warsaw in 1596. The Old Town was designated as a UNESCO World Heritage Site in 1978. The current architectural plan of the Old Town was drawn up in 1257. The excellence of the design is proven by the fact that it still works perfectly today!</p>

              <p>The Main Square (Rynek G&#322;&oacute;wny or just Rynek in Polish) is the heart of an old part of Krak&oacute;w. This is a gigantic meeting and walking place, surrounded by restaurants (some of which date back to medieval times), coffee bars and pubs. Summer is a good time for drinking a cup of coffee here and watching the street life.</p>

              <h2>Tour description</h2>
              <p>This is a guided walking tour. It will start from the Conference center at 14:00 (2:00&nbsp;p.m.). During a pleasant walk you will be able to see some of the most attractive parts of the Old City: Collegium Maius (the oldest building of the Jagiellonian University), the Main Square, the St. Mary's Basilica with its sculptural masterpiece, an Altarpiece of Veit Stoss of late Gothic design. You will pass through the Cloth Hall with its many trading stalls, which dates to the Renaissance. Finally, you will walk through the Royal Road towards the Wawel castle and Vistula boulevards. Return to the conference center is planned for 17:30 (5:30&nbsp;p.m.).</p>

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
