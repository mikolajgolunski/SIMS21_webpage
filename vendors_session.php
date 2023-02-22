<?php
require "./extras/always_require.php";

//no need to check if logged in

//no need to check if comes from proper page

$_SESSION["last_site"] = "vendors_session";
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>
    
    <style type="text/css">
      ul.vendors {
        /*display: block;
        width: 15em;
        margin-left: auto;
        margin-right: auto;*/
        list-style-type: none;
        /*margin: 0;
        padding: 0;
        margin-top: 1em;*/
      }
      
      ul.vendors > li {
        /*margin: 0;
        padding: 0;*/
        margin-top: 0.5em;
      }
    </style>
    
      <title>SIMS21, Poland 2017 - Vendors Session</title>
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
              <h1>Vendors Session</h1>
		      <p>A special session is organized during the SIMS21 conference to allow our sponsors to make short, flash-type presentations about recent advances and breakthroughs in their products.</p>
              <p><strong>Date:</strong> 13 September 2017 (Wednesday), 10:40 - 12:20</p>
              <p><strong>Location:</strong> Small Lecture Hall</p>
              <p><strong>Chairman:</strong> Andreas Wucher</p>

              <p><strong>Session Program:</strong></p>
              
              <ul class="vendors">
                <li>10:40 KLA-TENCOR</li>
                <li>10:50 AVS/BIOINTERPHASES</li>
                <li>11:00 WILEY</li>
                <li>11:10 SAI</li>
                <li>11:20 HIDEN</li>
                <li>11:30 IONOPTIKA</li>
                <li>11:40 CAMECA</li>
                <li>11:50 OREGON PHYSICS</li>
                <li>12:00 ION-TOF</li>
                <li>12:10 PHI</li>
              </ul>
		      <br>
              <a href="resources/vendors_session.pdf">Download Vendors Session schedule as pdf.</a>

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
