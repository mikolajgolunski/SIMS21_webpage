<?php
require "./extras/always_require.php";

//no need to check if logged in

//no need to check if comes from proper page

$_SESSION["last_site"] = "satellite_conferences";
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

      <title>SIMS21, Poland 2017 - Satellite Meetings</title>
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
              <h1>Satellite Meetings</h1>
              <h2>8<sup>th</sup> AFM BioMed Conference - September&nbsp;4-8, 2017</h2>
              <p>The conference will provide a forum to exchange results and new ideas on use of atomic force microscopy (AFM) and related techniques in life sciences and medicine ranging from cell or molecular biology to clinical applications. The conference will take place in Krak&oacute;w, Poland, in the week before the SIMS21 meeting.</p>
              <p>Conference Webpage: <a href="http://afmbiomed.org/presentation.aspx" target="_blank">http://afmbiomed.org/</a></p>


              <h2>ECASIA'17 - September 24-29, 2017</h2>
              <img src="./img/ECASIA17_Banner.png" class="centered" width="600px">
              <p>The 17<sup>th</sup> European Conference on Applications of Surface and Interface Analysis, ECASIA'17, is the major event in Europe in this field, attracting an ever increasing international audience. In 2017, ECASIA will take place in Montpellier, France, from 24 to 29&nbsp;September.</p>
              <p>Conference Webpage: <a href="http://ecasia2017.org/" target="_blank">http://ecasia2017.org/</a></p>
              <h2>The 25<sup>th</sup> Plenary Meeting of the ISO/TC201/SC6</h2>
             <p>The 25<sup>th</sup> Plenary Meeting of the Technical Committee of the International Organization for Standardization (ISO/TC201/SC6) &quot;Secondary Ion Mass Spectrometry&quot; will be held on 10 September 2017 at Krak&oacute;w, Poland as a Satellite Event in SIMS21.</p>
             <p>For more details follow <a href="sc6_meeting.php">this link</a>.
 

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
