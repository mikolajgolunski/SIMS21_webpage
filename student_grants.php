<?php
require "./extras/always_require.php";

//no need to check if logged in

//no need to check if comes from proper page

$_SESSION["last_site"] = "student_grants";
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

      <title>SIMS21, Poland 2017 - Student Grants</title>
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
              <h1>Student Grants</h1>

              <p>SIMS21 is pleased to announce that a limited number of student grants will be awarded to cover a half of the conference fee and the cost of accommodation in the student dormitory. The priority will be given to students coming from countries with deploying economies.</p>

              <p>Students must give a presentation during SIMS21 to receive this grant.</p>

              <p>In order to submit the application please send an e-mail to: <a href="mailto:grants@sims21.org?Subject=Application for the student grant">grants@sims21.org</a> with the Subject: &quot;Application for the student grant&quot; and the following attachment: a short curriculum; the abstract(s) submitted to the SIMS conference; a recommendation letter from your advisor combined as <strong>a single pdf file</strong>.</p>

              <p>Selection will be made based on the supplied documents.</p>

              <p>Application process wil open on <span class="important">April&nbsp;1, 2017</span> and close on <span class="important">April&nbsp;30, 2017</span>.</p>

              <p>Information about results of qualification will be sent to applicants before <span class="important">May&nbsp;15, 2017</span>.</p>

              <h3>Remarks</h3>
              <p><span style="color:red"><I>The  applicants  are  kindly  asked  to create their accounts,  register at the conference website, but pay the conference fee <strong>only</strong>  after receiving notification about results of qualification</I>.</span></p>

              <p><I>It is expected that successful applicants will pay the remaining of the conference fee before <span class="important">June&nbsp;1, 2017</span>. Otherwise, the grant will be allocated to the next person on the waiting list.</I></p>
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
