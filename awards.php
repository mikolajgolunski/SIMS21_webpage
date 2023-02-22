<?php
require "./extras/always_require.php";

//no need to check if logged in

//no need to check if comes from proper page

$_SESSION["last_site"] = "awards";
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>
      <title>SIMS21, Poland 2017 - Best Student Presentation Awards</title>
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
              <h1>Student Presentation Awards</h1>

              <p>Awards will be conferred to students who enter the awards competition and make the best oral or poster presentations at the conference. These awards will be granted in two separate categories:</p>
              
              <h2 style="color:blue">Biointerphase Awards</h2>
              <p>Awards will be conferred to students who are deemed by the judges to have provided the best presentations <strong>related to biological or biomaterial SIMS research</strong>.</p>
              <ul>
                <li>Best Biointerphase Oral Presentation: $375</li>
                <li>Best Biointerphase Poster Presentation: $375</li>
              </ul>
                <p><u>Award winners:</u></p>
              <ul>
                <li><strong>Ms. Kaija Schaepe</strong> - Justus Liebig University of Giessen, Germany - Best Biointerphase Oral Presentation (award shared with Mr. Dunham)</li>
                <li><strong>Mr. Sage J B Dunham</strong> - University of Illinois at Urbana-Champaign, USA - Best Biointerphase Oral Presentation (award shared with Ms. Schaepe)</li>
                <li><strong>Mr. Shusuke Nakano</strong> - Seikei University, Japan  - Best Biointerphase Poster Presentation</li>
              </ul>

              <p style="color:green"><I>The Biointerphase Presentation Awards have been generously sponsored by the Bionterphases journal</I>.</p>
              <a href="http://avs.scitation.org/journal/bip" target="_blank"><img src="./img/sponsors/Biointerphases.jpg" class="centered"></a>

              <h2 style="color:blue">Rowland Hill General Awards</h2>
              <p>Awards will be conferred to students who are deemed by the judges to have provided the best presentations <strong>not related to biological or biomaterial SIMS research</strong>.</p>
              <ul>
                <li>Best General Oral Presentation: 1&nbsp;500&nbsp;PLN (~$375)</li>
                <li>Best General Poster Presentation: 1&nbsp;500&nbsp;PLN (~$375)</li>
              </ul>
              
                <p><u>Award winners:</u></p>
              <ul>
                <li><strong>Mr. Maciej Kawecki</strong> - Empa, Switzerland - Best General Oral Presentation</li>
                <li><strong>Ms. Hao Sheng Wu</strong> - Helmholtz-Zentrum Dresden-Rossendorf, Germany - Best General Poster Presentation</li>
              </ul>

              <h3>Eligibility</h3>
              <p>Any postgraduate student selected to give a talk or poster is eligible to be considered for these awards.</p>
              
              <h3>Application Procedure</h3>
              <p>Students who wish to enter the competition need to submit a letter of support (1 page max) from her/his immediate supervisor. The letter should be emailed by the supervisor as an attachment to <a href="mailto:grants@sims21.org?Subject=Application for the Best Presentation Award">grants@sims21.org</a> with the Subject Line: "Application for the Best Presentation Award".</p>
              <p style="color:red">Please email your letter of support before 15&nbsp;May&nbsp;2017.</p>
              <p><strong>The Award ceremony will take place during the Conference Banquet on Wednesday, September&nbsp;13, 2017</strong>.</p>
              
              <h3><I>Remarks</I></h3>
              <ul>
                <li>Note to supervisors: only one student per category (Biointerphase, General) is allowed to be nominated from a single research group.</li>
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
