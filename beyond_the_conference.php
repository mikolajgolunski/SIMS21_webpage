<?php
require "./extras/always_require.php";

//no need to check if logged in

//no need to check if comes from proper page

$_SESSION["last_site"] = "beyond_the_conference";
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

      <style type="text/css">
        .auto-style1 {
          text-align: center;
        }
        
        .auto-style2 {
          color: #800000;
        }
      </style>

      <title>SIMS21, Poland 2017 - Beyond the Conference</title>
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
              <h1>Beyond the Conference</h1>
              <p>Krak&oacute;w and its surrounding areas offer wonderful opportunities for sightseeing and activities covering a wide variety of interests. From walking or cycling, kayaking on Vistula river, hopping between restaurants, visiting the old parts of Krak&oacute;w and old Jewish city Kazimierz, to scuba-diving, rock climbing, caving, and horse riding, all are available within 30&nbsp;km from Krak&oacute;w. Further afield, wilderness walks in Bieszczady Mountains, some 200&nbsp;km from Krak&oacute;w, and alpine-style mountaineering in Tatra Mountains, just 100&nbsp;km from Krak&oacute;w. Longer trips to remote areas, and especially to the world-famous Bia&#322;owie&#380;a National Park and to the nearby Biebrza National Park, will offer the opportunity to experience primeval temperate forests and vast wetlands. Go there for serious birdwatching and kayaking, to see wolves and European bisons.</p>
              <img src="img/interesting_v1.png" class="centered" width="651" height="461">

              <p>More information about available trip options can be found, for instance, at <a href="http://www.iccpb2015.confer.uj.edu.pl/beyond-congress" target="_blank">this page</a>.</p>
              <p>It will be possible to book pre and post-conference excursions through the travel agency that handles reservation of the conference accommodation. For details, please contact <a href="mailto:kamilia.dudek@symposium.pl">Kamilia Dudek</a> from the Symposium Cracoviense.</p>
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
