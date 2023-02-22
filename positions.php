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
              <h1>Open positions</h1>
              <p>Postdoctoral fellowships and work opportunities offered by the SIMS conference participants and exhibitors are listed here.</p>

              <p>If you are interested to publish your call please send an email with suitable information to: <a href="mailto:user@user.user?Subject=Position%20available">Conference Secretariat</a>.</p>

              <hr>

              <ul>
	      	<li>
		  <span style="color:red">17 January 2018</span></br>
		  <strong>Postdoctoral position at UCLouvain </strong>
                 <br>For details follow <a href="./resources/Postdoc_UCLouvain.pdf" target="_blank">this link</a><br><br>
 		
              <hr>
                <li>
                  <strong>NanoSIMS Application Scientist or Engineer Position at CAMECA</strong>
                  <br>For details follow <a href="./resources/CAMECA_NANOSims.pdf" target="_blank">this link</a><br><br>
                </li>
                <li>
                  <strong>Scientific coworker for Max Planck Institute for Polymer Research</strong>
                  <br>For details follow <a href="./resources/Max_Planck_Polymer_Coworker.pdf" target="_blank">this link</a><br><br>
                </li>
                <li>
                  <strong>Higher research scientist NanoSIMS -  position at NiCE-MSI</strong>
                  <br>For details follow <a href="http://www.amrislive.com/wizards_v2/npl/vacancyView.php?&requirementId=65602&" target="_blank">this link</a><br><br>
                </li>
                <li>
                  <strong>Higher Research Scientist OrbiSIMS - position at NiCE-MSI</strong>
                  <br>For details follow <a href="http://www.amrislive.com/wizards_v2/npl/vacancyView.php?&requirementId=65604&" target="_blank">this link</a><br><br>
                </li>
                <li>
                  <strong>Postdoc Opening for a ToF-SIMS research Scientist at Rice University - updated.</strong>
                  <br>For details see <a href="./resources/PostdocAd_RiceU.pdf" download>this document</a>.<br><br>
                </li>
                <li>
                  <strong>Ion Source Product Engineer Position at Oregon Physics</strong>
                  <br>For details see <a href="./resources/Ion_Source_Product_Engineer_Oregon.pdf" download>this document</a>.<br>
                </li>
              </ul>
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
