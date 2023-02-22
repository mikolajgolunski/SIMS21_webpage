<?php
require "./extras/always_require.php";

//no need to check if logged in

//no need to check if comes from proper page

$_SESSION["last_site"] = "positions";
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

      <title>SIMS21, Poland 2017 - Open positions</title>
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
              <h1>Sponsors</h1>

              <p>SIMS21 provides excellent sponsorship opportunities to increase your organizations visibility and stand out from your competitors. Organizations can customize their exposure during SIMS21 by choosing the sponsorship level that best suits their promotional needs and budgets.</p>

              <p><a href="./resources/sponsorship_conditions_SIMS21_Krakow.pdf" download>Sponsorship/Exhibit Form</a> - Sponsorship <span class="important" style="color: green;">Available</span>&nbsp;/ Exhibits <span class="important" style="color: green;">Available</span></p>
              <p>Check <a href="opportunities.php">here</a> for selected additional sponsorship opportunities.</p>

              <h2>Diamond</h2>
              <p>
                <a href="http://www.iontof.com" target="_blank"><img src="./img/sponsors/iontof_logo.jpg" class="centered"></a>
              </p>

              <h2>Platinum</h2>
              <p>
                <a href="http://www.cameca.com" target="_blank"><img src="./img/sponsors/CAMECA.jpg" class="centered"></a>
              </p>
              <p>
                <a href="http://www.ionoptika.com" target="_blank"><img src="./img/sponsors/ionoptika.JPG" class="centered"></a>
              </p>
              <p>
                <a href="http://www.phi.com" target="_blank"><img src="./img/sponsors/PHI_logo.jpg" class="centered"></a>
              </p>

              <h2>Gold</h2>
              <p>
                <a href="http://www.hidenanalytical.com/" target="_blank"><img src="./img/sponsors/Hiden Logo.JPG" class="centered"></a>
              </p>
              <p>
                <a href="http://www.kla-tencor.com/" target="_blank"><img src="./img/sponsors/KLA.png" class="centered"></a>
              </p>
               <p>
                <a href="http://www.smoluchowski.fis.agh.edu.pl/" target="_blank"><img src="./img/sponsors/Know_baner.png" class="centered"></a>
              </p>
              <p>
                <a href="http://www.oregon-physics.com" target="_blank"><img src="./img/sponsors/Oregon.gif" class="centered"></a>
              </p>
	      <p>
                <a href="http://www.saiman.co.uk/" target="_blank"><img src="./img/sponsors/SAI.jpg" height = "50px" class="centered"></a>
	      </p>

              <h2>General Sponsors</h2>
              <p>
                <a href="http://www.fais.uj.edu.pl/en_GB/start-en" target="_blank"><img src="./img/sponsors/FAIS.jpg" class="centered"></a>
              </p>
	      <p>
		<a href="http://www.krakow.pl/english/business/8921,glowna.html" target="_blank"><img src="./img/logo_krakow_l.png" class="centered"></a>
	      </p>
	      <h2>Partners</h2>
	      <p><center>
		<a href="http://www.avs.org" target="_blank"><img src="./img/logo_avs_zp.gif"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               	<a href="http://www.iaea.org" target="_blank"><img src="./img/logo_iaea_zp.gif"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="http://www.iuvsta.org" target="_blank"><img src="./img/logo_iuvsta_zp.gif"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="http://www.en.uj.edu.pl/en" target="_blank"><img src="./img/logo_uj_zp.gif"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="http://www.ptp.pwr.wroc.pl/?glowna=polvac" target="_blank"><img src="./img/logo_ptp_zp.gif"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	      </center></p>
              <hr>

              <h1 id="exhibitors">Exhibitors:</h1>
               <center>
               <a href="http://www.cameca.com" target="_blank"><img src="./img/sponsors/CAMECA.jpg" height = "25px"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://www.hidenanalytical.com/" target="_blank"><img src="./img/sponsors/Hiden Logo.JPG" height = "25ps"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               <a href="http://www.kla-tencor.com/" target="_blank"><img src="./img/sponsors/KLA.png" height="29px"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://www.ionoptika.com" target="_blank"><img src="./img/sponsors/ionoptika.JPG" height="25px"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               <a href="http://www.iontof.com" target="_blank"><img src="./img/sponsors/iontof_logo.jpg" height="25px"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://www.oregon-physics.com" target="_blank"><img src="./img/sponsors/Oregon.gif" height="25px"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               <a href="http://www.phi.com" target="_blank"><img src="./img/sponsors/PHI_logo.jpg" height="26px" width="104px"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://www.saiman.co.uk/" target="_blank"><img src="./img/sponsors/SAI.jpg" height="23px" width="71px"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://www.specs.com" target="_blank"><img src="./img/sponsors/SPECS.jpg" height="23px" width="71px"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               <a href="http://www.toyama-en.com/analytical/fib_tof_sims_features.html" target="_blank"><img src="./img/sponsors/toyama.jpg" height="21px"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://www.wiley.com/go/databases" target="_blank"><img src="./img/sponsors/wiley.png" height="20px"></a>
	       </center>
	     <h1 id="map">Exhibition map</h1>
		<center>
		Exhibition room, second floor.
		<img src="./img/Exhibition.png">
		</center>
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
