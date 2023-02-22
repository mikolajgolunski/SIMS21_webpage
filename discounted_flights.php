<?php
require "./extras/always_require.php";

//no need to check if logged in

//no need to check if comes from proper page

$_SESSION["last_site"] = "discounted_flights";
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

      <style type="text/css">
        a:link.important_link {
          color: red;
        }
        
        a:visited.important_link {
          color: darkred;
        }
        
        a:hover.important_link {
          color: palevioletred;
        }
        
        a:active.important_link {
          color: palevioletred;
        }
      </style>

      <title>SIMS21, Poland 2017 - Discounted flights</title>
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
              <h1>Discounted flights</h1>
              <p><span style="color:red"><I>The Conventions Plus Programme will be discontinued from 31 July as a result of recent Star Alliance policy changes. Tickets purchased before this dates will be honored.</span></I></p>
              <img src="./img/discounted_flights/star_alliance2_new.gif" class="centered" alt="Star Alliance" width=680px>

              <p style="font-weight: bold; margin: 0; padding: 0;">SAVE UP TO 20% ON TRAVEL WITH THE STAR ALLIANCE&trade; NETWORK</p>

              <p>The Star Alliance member airlines are pleased to be appointed as the Official Airline Network for the 21<sup>st</sup> International Conference on Secondary Ion Mass Spectrometry - SIMS21.</p>

              <p><strong>To obtain the Star Alliance Conventions Plus discounts please visit Conventions Plus online booking tool located at <a href="http://conventionsplusbookings.staralliance.com/trips/StarHome.aspx?meetingcode=LO03S17" target="_blank" class="important_link">this webpage</a>.</strong></p>

              <p><strong>Registered participants plus one accompanying person</strong> traveling to the event can qualify for a discount of up to 20%, depending on fare and class of travel booked.</p>

              <p>The participating airlines for this event are: Adria Airways, Aegean Airlines, Air Canada, Air China, Air India, Air New Zealand, ANA, Asiana Airlines, Avianca, Croatia Airlines, EgyptAir, Ethiopian Airlines, EVA Airways, LOT Polish Airlines, Scandinavian Airlines, Shenzhen Airlines, South African Airways, TAP Portugal, THAI, Turkish Airlines, United.</p>

              <p>Discounts are offered on most published <strong>business</strong> and <strong>economy class</strong> fares, excluding website/internet fares, senior and youth fares, group fares and Round the World fares.</p>

              <p>When making your travel plans please present confirmation of your registration or proof of attendance for the SIMS21.</p>

              <p>Special procedures to be followed for travel to/from Japan. Discounts may be offered by the participating airlines on their own network. To obtain these discounts please contact the respective carriers' booking office. Contact details can be found on <a href="http://www.staralliance.com/conventionsplus/delegates/" target="_blank">www.staralliance.com/conventionsplus/delegates/</a> under &quot;Conventions Plus Booking Contacts&quot;. Please quote the event code <span class="important">LO03S17</span> for ticket reservation.</p>

              <hr>

              <div>
                <?php for($i=1; $i<=27; $i++):?>
                <img src="./img/discounted_flights/<?php echo $i;?>.png" style="width: 130px; border: 0;">
                <?php endfor;?>
              </div>
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
