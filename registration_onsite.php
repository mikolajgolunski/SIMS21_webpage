<?php
require "./extras/always_require.php";

//no need to check if logged in

//no need to check if comes from proper page

$_SESSION["last_site"] = "fees";
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

      <style type="text/css">
        .registration_top {
          display: -webkit-box;
          display: -ms-flexbox;
          display: flex;
          -webkit-box-orient: vertical;
          -webkit-box-direction: normal;
          -ms-flex-direction: column;
          flex-direction: column;
        }
        
        .registration_row {
          display: -webkit-box;
          display: -ms-flexbox;
          display: flex;
          -ms-flex-pack: distribute;
          justify-content: space-around;
        }
        
        .day {
          width: 20em;
        }
        
        .time {
          width: 10em;
        }
        
        .place {
          width: 15em;
        }
      </style>

      <title>SIMS21, Poland 2017 - On-site registration</title>
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
            <h1>On-site registration</h1>
            
            <h2>IUVSTA Short Course Registration Hours and Location</h2>
            <div class="registration_top">
              <div class="registration_row">
                <div class="day">Sunday, 10 September 2017:</div>
                <div class="time">08:00 - 11:00</div>
                <div class="place">Entrance area</div>
              </div>
            </div>
            
            <h2>Conference Registration Hours and Location</h2>
            <div class="registration_top">
              <div class="registration_row">
                <div class="day">Sunday, 10 September 2017:</div>
                <div class="time">16:00 - 20:00</div>
                <div class="place">Entrance area</div>
              </div>
              <div class="registration_row">
                <div class="day">Monday, 11 September 2017:</div>
                <div class="time">08:00 - 17:00</div>
                <div class="place">Conference Office</div>
              </div>
              <div class="registration_row">
                <div class="day">Tuesday, 12 September 2017:</div>
                <div class="time">08:00 - 17:00</div>
                <div class="place">Conference Office</div>
              </div>
              <div class="registration_row">
                <div class="day">Wednesday, 13 September 2017:</div>
                <div class="time">08:00 - 12:00</div>
                <div class="place">Conference Office</div>
              </div>
              <div class="registration_row">
                <div class="day">Thursday, 14 September 2017:</div>
                <div class="time">08:00 - 17:00</div>
                <div class="place">Conference Office</div>
              </div>
              <div class="registration_row">
                <div class="day">Friday, 15 September 2017:</div>
                <div class="time">08:00 - 10:00</div>
                <div class="place">Conference Office</div>
              </div>
            </div>
           
	             <p>All on-site payments can be made by credit card only. Payments by American Express Card will not be accepted.</p>
 
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
