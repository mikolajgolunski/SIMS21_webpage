<?php
require "./extras/always_require.php";

//no need to check if logged in

//no need to check if comes from proper page

$_SESSION["last_site"] = "obituary_wittmaack";
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

      <title>SIMS21, Poland 2017 - Wittmaack Obituary</title>
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
              <h1>Klaus Wittmaack</h1>
              
              <div style="text-align: center;">
                <img src="img/obituaries/wittmaack1.jpg" height="212px">
                <img src="img/obituaries/wittmaack2.png" height="212px">
              </div>

              <p>Klaus has been a prominent member of the particle-solid community ever since his early studies of Wehner spots in sputtering during PhD studies with Rudolf Sizmann in Munich in the mid 1960s.</p>
              
              <p>Shortly after graduation Klaus got a research position at the Institute for Radiation Research (GSF) in Neuherberg, where he worked until retirement, except for a sabbatical at IBM Research in Yorktown Heights.</p>
              
              <p>Klaus established an active research group at GSF within a wide variety of topics such as depth profiling and SIMS, ion beam mixing and ion-surface collisions. Although a skilled and experienced experimentalist, Klaus did not only follow theoretical progress eagerly but also developed his own theoretical concepts.</p>
              
              <p>During his later years at GSF he became enthusiastically engaged in aerosol physics. It seems that after retirement his activity even enhanced, although focusing on the kind of work that needs a desk rather than a laboratory, as he described in a nice note in Nature: <a href="https://www.nature.com/articles/522156a", target="_blank">'Workforce: The joys of research in retirement'</a>.</p>
              
              <p>Klaus demonstrated particular skill and considerable interest in distinguishing correct from incorrect experimental findings as well as theoretical conclusions. His latest papers on ion stopping and ranges and his meticulous analysis of the SRIM code demonstrate that this ability was undiminished.</p>
              
              <p>Peter Sigmund<br>
              January 2018</p>
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
