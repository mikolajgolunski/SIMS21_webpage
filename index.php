<?php
require "./extras/always_require.php";

//no need to check if logged in

//no need to check if comes from proper page

$_SESSION["last_site"] = "index";
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
    require('./includes/head.html');
    ?>

    <style type="text/css">
      .chairman {
        text-align: center;
      }

      .cochairman {
        text-align: center;
      }

      .cochairman .person {
        float: left;
        width: 50%;
      }
    </style>
      <title>SIMS21, Poland 2017</title>
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
              <h1>SIMS21 - Krak&oacute;w, Poland</h1>
              
              <p>We are pleased to announce that the 21<sup>st</sup> International Conference on Secondary Ion Mass Spectrometry - <strong>SIMS21</strong> will be held in a beautiful city of Krak&oacute;w, Poland, from <strong>10 till 15&nbsp;September 2017</strong>.</p>

              <p>The conference will provide a global forum for researchers and users from academia, research organizations and industries to exchange results and new ideas on Secondary Ion Mass Spectrometry and related techniques. The conference will cover advancements of scientific knowledge from fundamental understanding to new applications.</p>

              <p>The motto of the conference is <strong>&quot;New frontiers&quot;</strong>: it will focus on recent advances and breakthroughs in Fundamentals and Applications, participation by young researchers is particularly encouraged and this is the first time the International SIMS conference will be located in one of the former eastern block countries.</p>

              <p>The IUVSTA-sponsored <a href="./short_course.php"><strong>Short Course</strong></a> will be held in conjunction with the conference on September&nbsp;10, 2017.</p> 
              
              <p>An <strong>All-day Special Session/Workshop</strong> entitled &quot;<I><a href="industrial.php">Frontiers and Challenges in Industrial SIMS</a></I>&quot; will be held on the use of SIMS in applied materials research with emphasis on industrial applications.</p>

              <p>The low student conference fee and inexpensive housing at University dormitories are provided to strongly encourage students to participate in the meeting.</p>

              <p>We cordially invite you to attend SIMS21 in Krak&oacute;w. We hope that you will enjoy not only the scientific atmosphere during the conference, but also a beautiful city with its outstanding historical heritage and modern cultural activities.</p>

              <div class="chairman">
                <h2>Chairman</h2>
                <div class="person">
                  Prof. Zbigniew Postawa<br>
                  Jagiellonian University, Poland<br>
                  <a href="mailto:zbigniew.postawa@uj.edu.pl">zbigniew.postawa@uj.edu.pl</a>
                </div>
              </div>

              <div class="cochairman">
                <h2>Co-chairmen</h2>
                <div class="person">
                  Prof. Arnaud Delcorte<br>
                  Universit&eacute; catholique de Louvain, Belgium<br>
                  <a href="mailto:arnaud.delcorte@uclouvain.be">arnaud.delcorte@uclouvain.be</a>
                </div>

                <div class="person">
                  Dr. Alex Shard<br>
                  National Physical Laboratory, England<br>
                  <a href="mailto:alex.shard@npl.co.uk">alex.shard@npl.co.uk</a>
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
