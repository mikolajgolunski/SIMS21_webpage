<?php
require "./extras/always_require.php";

//no need to check if logged in

//no need to check if comes from proper page

$_SESSION["last_site"] = "ojcow";
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

      <title>SIMS21, Poland 2017 - Ojc&oacute;w</title>
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
              <img class="centered" src="img/kolaz_ojcow.png" width="603" height="512">
              
              <p>Ojc&oacute;w National Park is the smallest national park in Poland, just 16&nbsp;km from Krak&oacute;w center. It is a perfect place for a day trip from Krak&oacute;w. The Park is situated along a scenic Pr&#261;dnik river valley, and it is famous for numerous limestone cliffs, ravines, and over 400 caves. The biggest cave in the park - the &#321;okietek's Cave - is 320&nbsp;meters (1&nbsp;050&nbsp;ft) deep. The most popular activities in the park are walks along the well marked tourist paths, mountain bike excursions, visiting old castles, and meeting local fauna and flora.</p>

              <p>The most characteristic objects in the Ojc&oacute;w National Park are odd-shape rock formations, for example the famous Hercules Club, a 25&nbsp;meter limestone column.</p>

              <p>There are several castles in the Ojc&oacute;w National Park which were part of a multi-kilometer chain of fortifications protecting Krak&oacute;w in medieval times. The most well-known are Ojc&oacute;w Castle, erected in the second half of 14<sup>th</sup>&nbsp;century, and Pieskowa Ska&#322;a Castle.</p>

              <p>Ojc&oacute;w National Park has high biodiversity. There are 5&nbsp;500 species of animal (280 of them are protected), 950 vascular plant species, 230 species of mosses and liverworts, and 200 lichens. Note that rock climbing is forbidden in the park, although the local rocks appear to be attractive for vertical adventures.</p>

              <h2>Tour description</h2>
              <p>The buses will depart at 13:00 (1:00&nbsp;p.m.) from the Conference Center. The trip to the Ojc&oacute;w National Park will take approximately 35 minutes. The trip is ideal for those who enjoy walking. The initial descent towards Park main attractions, lasting approximately 40 minutes is picturesque, as shown in photos below, with some sections that may be challenging. Comfortable, slip-resistant footwear is advised. The remaining part of the walk is through a flat area. A guide will be available at all times. The return to the Conference Center is planned for 17:30 (5:30&nbsp;p.m.).</p>
              <p class="imgs">
                <img src="img/Ojcow_start.png" width="300" height="200">
                <img src="img/Ojcow_descent.png" width="300" height="200">
              </p>
              <p><img src="./img/no_wheel.gif" class="wheel-img" width="30" height="30"><span class="important">This excursion is NOT wheelchair accessible.</span></p>

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
