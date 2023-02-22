<?php
require "./extras/always_require.php";

//no need to check if logged in

//no need to check if comes from proper page

$_SESSION["last_site"] = "honorary_session";
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

      <style type="text/css">
        figure {
          display: inline-block;
          text-align: center;
        }
        
        #pictures {
          text-align: center;
        }
        
        .program {
          display: table;
        }
        
        .element {
          display: table-row;
        }
        
        .time {
          display: table-cell;
          min-width: 7em;
          text-align: right;
          padding: 0.1em 0.5em 0.6em 0.5em;
        }
        
        .author {
          display: table-cell;
          min-width: 9em;
          padding: 0.1em 0.5em 0.6em 0.5em;
        }
        
        .title {
          display: table-cell;
          font-style: italic;
          padding: 0.1em 0.5em 0.6em 0.5em;
        }
      </style>

      <title>SIMS21, Poland 2017 - Honorary session</title>
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
              <h1>Garrison &amp; Winograd Special Session</h1>
              <p>
                <i>Theory and Experiment - Synergy in Life and Science</i>
                <br><br>
                A special session to honor lifetime achievements of Barbara Garrison and Nicholas Winograd from the Pennsylvania State University is organized during the SIMS21 conference.
              </p> 
              <p><strong>Date:</strong> 12 September 2017 (Tuesday), 8:40 - 10:40</p>
              <p><strong>Location:</strong> Medium Lecture Hall A</p>
              <p><strong>Chair and Host:</strong> John C. Vickerman</p>

              <div id="pictures">
                <figure>
                  <img src="img/bjg.gif" alt="Barbara J. Garrison">
                  <figcaption>Barbara Jane Garrison</figcaption>
                </figure>
                <figure>
                  <img src="img/nw.gif" alt="Nicholas Winograd">
                  <figcaption>Nicolas Winograd</figcaption>
                </figure>
                <div class="clearfix"></div>
              </div>
              
              <div id="program">
                <h3>Session Program:</h3>
                <div class="element">
                  <div class="time">
                    8:40 - 8:45
                  </div>
                  <div class="author">
                    Zbigniew Postawa
                  </div>
                  <div class="title">
                    Opening
                  </div>
                </div>
                <div class="element">
                  <div class="time">
                    8:45 - 8:55
                  </div>
                  <div class="author">
                    John Vickerman
                  </div>
                  <div class="title">
                    <a href="http://sims.confer.uj.edu.pl/boa_oral.php?id=410">Nick and Barbara - a wonderful partnership in science and much else!</a> - Tribute
                  </div>
                </div>
                <div class="element">
                  <div class="time">
                    8:55 - 9:25
                  </div>
                  <div class="author">
                    Andreas Wucher
                  </div>
                  <div class="title">
                    <a href="http://sims.confer.uj.edu.pl/boa_oral.php?id=107">Molecular Ionization Probability in Cluster-SIMS</a><I> - Invited talk for SIMS21</I>
                  </div>
                </div>
                <div class="element">
                  <div class="time">
                    9:25 - 9:40
                  </div>
                  <div class="author">
                    Gregory Fisher
                  </div>
                  <div class="title">
                    <a href="http://sims.confer.uj.edu.pl/boa_oral.php?id=407">Fun with Nick &amp; Barbara: Adventures in Physics, Chemistry, and Biology</a>
                  </div>
                </div>
                <div class="element">
                  <div class="time">
                    9:40 - 9:55
                  </div>
                  <div class="author">
                    Arnaud Delcorte
                  </div>
                  <div class="title">
                    <a href="http://sims.confer.uj.edu.pl/boa_oral.php?id=404">Relationships between crater and sputtered material characteristics in large gas cluster sputtering of polymers: Results from MD simulations</a>
                  </div>
                </div>
                <div class="element">
                  <div class="time">
                    9:55 - 10:10
                  </div>
                  <div class="author">
                    Amy Walker
                  </div>
                  <div class="title">
                    <a href="http://sims.confer.uj.edu.pl/boa_oral.php?id=405">Nick and Barbara: Adventures in the Development of Materials Characterization Techniques</a>
                  </div>
                </div>
                <div class="element">
                  <div class="time">
                    10:10 - 10:25
                  </div>
                  <div class="author">
                    Micha&#322; Ka&#324;ski
                  </div>
                  <div class="title">
                    <a href="http://sims.confer.uj.edu.pl/boa_oral.php?id=176">Adventures with Barbara Garrison into the Simulation Universe: Effect of the impact angle on the energy-resolved angular distributions of ßcarotene molecules sputtered by a 10 keV Ar­2000 projectiles. A molecular dynamics study</a>
                  </div>
                </div>
		</div>
                <div class="element">
                  <div class="time">
                    10:25 - 10:40
                  </div>
                  <div class="author">
                    Andrew Ewing
                  </div>
                  <div class="title">
                    <a href="http://sims.confer.uj.edu.pl/boa_oral.php?id=409">ToF-SIMS imaging, the quest to find and quantify neuro-related lipid and neurotransmitter changes in cells and vesicles</a>
                  </div>
                </div>
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
