<?php
require "./extras/always_require.php";

//no need to check if logged in

//no need to check if comes from proper page

$_SESSION["last_site"] = "sc6_meeting";
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

      <title>SIMS21, Poland 2017 - ISO/TC201/SC6 meeting</title>
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
              <h1>The 25<sup>th</sup> Plenary Meeting of the ISO/TC201/SC6</h1>
<p>The 25<sup>th</sup> Plenary Meeting of the Technical Committee of the International Organization for Standardization (ISO/TC201/SC6) &quot;Secondary Ion Mass Spectrometry&quot; will be held on 10 September 2017 at the Auditorium Maximum, Krak&oacute;w, Poland as a Satellite Event in SIMS21.</p>

<p><strong>Venue:</strong> Conference room at the second floor of the Auditorium Maximum, Krupnicza 35, Krak&oacute;w, Poland.</p>

<p><strong>Start time:</strong> 10.30 (10.30 am)</p>

<p><strong>Chairman:</strong> Prof. Ian Gilmore of National Physical Laboratory.</p>

<p><strong>Secretary:</strong> Dr. Hideo Iwai of National Institute of Material Science.</p>
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
