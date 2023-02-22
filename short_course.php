<?php
require "./extras/always_require.php";

//no need to check if logged in

//no need to check if comes from proper page

if(!empty($_SESSION["login"])){
  if($_SESSION["person_id"] == 2 || $_SESSION["person_id"] == 1816 || $_SESSION["person_id"] == 1815 || $_SESSION["person_id"] == 461 || $_SESSION["person_id"] == 2206 || $_SESSION["person_id"] == 7) {
    $short_course_q = true;
  } else {
    require('./database/db_connect.php');

    $sql = "SELECT short_course FROM people WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($_SESSION["person_id"]));
    $short_course_q = $stmt->fetch(PDO::FETCH_ASSOC);
    $short_course_q = $short_course_q["short_course"];

    $conn = null;
  }
}

$_SESSION["last_site"] = "short_course";
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

      <title>SIMS21, Poland 2017 - IUVSTA Short Course</title>
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
              <h1>IUVSTA Short Course</h1>
              <p>IUVSTA-sponsored short course entitled &quot;Short course for new ideas on Secondary Ion Mass Spectrometry and related analytical techniques&quot;, will be held in conjunction with the conference on Sunday, <strong>September&nbsp;10, 2017</strong>.</p>
              
              <p>Five tutorial lectures listed below will be given by renown scientists. <strong>Each tutorial will last 80 minutes and it will consist of a general presentation (no more than 50 minutes) followed by or interwoven with extended discussion (at least 30 minutes)</strong>.</p>
              <p><strong>Location:</strong> Seminar room, second floor.</p>
              <p><strong>Short Course Program:</strong></p>
              <ul>
                <li>
                8:00 - 11:00 - Registration
		        </li>
		        <a href="http://www.npl.co.uk/people/alex-shard" target="_blank"><img style="vertical-align:middle" class="text_img" src="./img/alex.png" height = "70px" /></a><br>   
                <li>8:40 - 10:00 - <a href="./resources/Tutorial1_Alexander_Shard.pdf"><I>&quot;The meaning of SIMS and how to collect useful data&quot;</I></a> - <strong>Alexander G. Shard</strong>, National Physical Laboratory, England<br><?php if($short_course_q){echo "<a href=\"resources/Tutorial1_Handouts.pdf\">Download tutorial materials HERE</a><br>";} ?><br></li>
                <li>10:00 - 10:20 - Coffee Break<br></li>
                <a href=" https://uclouvain.be/en/directories/arnaud.delcorte" target="_blank"><img style="vertical-align:middle" class="text_img" src="./img/arnaud.png" height = "70px" /></a><br>
                <li>10:20 - 11:40 - <a href="./resources/Tutorial2_Arnaud_Delcorte.pdf"><I>&quot;SIMS: Understanding the impact&quot;</I></a> - <strong>Arnaud Delcorte</strong>, Universit&eacute; catholique de Louvain, Belgium<br><?php if($short_course_q){echo "<a href=\"resources/Tutorial2_Handouts.pdf\">Download tutorial materials HERE</a><br>";} ?><br>
		        </li>
                <li>11:40 - 12:00 - Coffee Break<br></li>
                <a href="https://www.nb.engr.washington.edu/content/dan-graham-phd" target="_blank"><img style="vertical-align:middle"  class="text_img" src="./img/dan.png" height = "70px" /></a><br>
		        <li>12:00 - 13:20 (12:00&nbsp;p.m. - 1:20&nbsp;p.m.) - <a href="./resources/Tutorial3_Daniel_J_Graham.pdf"><I>&quot;Digesting the Alphabet Soup of Multivariate Analysis</I>&quot;</a> - <strong>Daniel J. Graham</strong>, University of Washington, USA<br><?php if($short_course_q){echo "<a href=\"resources/Tutorial3_Handouts.pdf\">Download tutorial materials HERE</a><br>";} ?><br>
                </li>
                <li>13:20 - 14:20 (1:20&nbsp;p.m. - 2:20&nbsp;p.m.) - Lunch<br></li>
                <img style="vertical-align:middle" class="text_img" src="./img/birgit.png" height = "70px" /><br>
                <li>14:20 - 15:40 (2:20&nbsp;p.m. - 3:40&nbsp;p.m.) - <a href="./resources/Tutorial4_Birgit_Hagenhoff.pdf"><I>&quot;Mastering the Art of Sample Preparation&quot;</I></a> - <strong>Birgit Hagenhoff</strong>, TASCON, Germany<br><?php if($short_course_q){echo "<a href=\"resources/Tutorial4_Handouts.pdf\">Download tutorial materials HERE</a><br>";} ?><br>
		        </li>
                <li>15:40 - 16:00 (3:40&nbsp;p.m. - 4:00&nbsp;p.m.) - Coffee Break<br></li>
                <a href="https://www.aif.ncsu.edu/fred-web-site/" target="_blank"><img style="vertical-align:middle" class="text_img" src="./img/fred.png" height = "70px" /></a><br>
                <li>16:00 - 17:20 (4:00&nbsp;p.m. - 5:20&nbsp;p.m.) - <a href="./resources/Tutorial5_Fred_A_Stevie.pdf"><I>&quot;Depth Profiling&quot;</I></a> - <strong>Fred Stevie</strong>, North Carolina State University, USA<br><?php if($short_course_q){echo "<a href=\"resources/Tutorial5_Handouts.pdf\">Download tutorial materials HERE</a><br>";} ?><br>
		        </li>
              </ul>

              <p>Short Course late registration is <strong><?php echo $fees_current["short_course"];?>&nbsp;PLN (~200&nbsp;Euro)</strong> per attendee and will include Short Course Presentation Materials, Lunch, Drinks and Snacks during Coffee Break.</p>

              <p>Through the kind sponsorship of IUVSTA, a reduced fee of <strong>150&nbsp;PLN (~35&nbsp;Euro)</strong> will be available for 40 participants. For details, please <a href="iuvsta_grants.php">follow this link</a>.</p>

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
