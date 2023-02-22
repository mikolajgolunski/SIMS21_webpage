<?php
require "./extras/always_require.php";

//no need to check if logged in

//no need to check if comes from proper page

$_SESSION["last_site"] = "accommodation"
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

      <title>SIMS21, Poland 2017 - Accommodation</title>
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
              <h1>Accommodation</h1>

              <p>Various levels of accommodation are available at special rates for SIMS participants, from student dormitories up to 5* class hotels. All accommodation, except student hotel &quot;Olimp&quot; are within a close vicinity of the conference site (no more than 15 minutes walking distance).</p>

              <p>Inexpensive accommodation has been arranged for participants with limited budgets at student dormitories. The price for a double-occupancy shared room is around 18 Euros a day. These rooms have either their own kitchenettes or access to shared cooking facilities. After Registration opening, the conference website will provide a forum helping to match participants willing to share a room.</p>

              <p> Accomodation reservation is handled by an external agent <strong>&quot;The Symposium Cracoviense&quot;</strong>. More datails can be found <a href="http://sims21.syskonf.pl" target="_blank">in here</a>.</p>

              <p><strong>Please direct all accommodation-related questions to representative of the Symposium Cracoviense, Ms. Kamilia Dudek at: <a href="mailto:kamilia.dudek@symposium.pl">kamilia.dudek@symposium.pl</a></strong>.</p>

              <center>
              <a href="http://sims21.syskonf.pl/Accommodation" target="_blank" class="button important centered">Go to the Accommodation Website</a>
              </center>

              <p>Below is a helpful interactive map showing hotel locations relative to the Conference Center (The Auditorium Maximum). The same map in <a href="./resources/SIMS21_Hotels.pdf" target="_blank">the pdf format</a>.</p>


              <iframe src="https://www.google.com/maps/d/embed?mid=1xUrSgXAkGPWGTNqpQLKQPj-HlWE" width="640" height="480"></iframe>

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
