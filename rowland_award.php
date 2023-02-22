<?php
require "./extras/always_require.php";

//no need to check if logged in

//no need to check if comes from proper page

$_SESSION["last_site"] = "rowland_award";
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

      <title>SIMS21, Poland 2017 - Rowland Hill Awards</title>
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
              <h1>Rowland Hill Awards</h1>

              <p>We are pleased to announce that four student travel awards, sponsored by Ionoptika in honor of Rowland Hill who made seminal developments in SIMS instrumentation, will be awarded in the amount of 500&nbsp;Euro each.</p>

              <p>In order to submit the application please send an e-mail to: <a href="mailto:grants@sims21.org?Subject=Application for the Rowland Hill Award">grants@sims21.org</a> with the Subject: &quot;Application for the Rowland Hill Award&quot; and a following attachment: a short CV and your abstract(s) submitted to the SIMS conference combined as <B>a single pdf document</B>.</p>
              <p>Selection will be made based on the supplied documents.</p>

              <p>Application process wil open on <span class="important">April&nbsp;15, 2017</span> and close on <span class="important">May&nbsp;20, 2017</span>.</p>

              <p>Information about results of qualification will be sent to applicants on <span class="important">May&nbsp;22, 2017</span>.</p>

              <h3>Remarks</h3>

              <p><I>The Award can be used to cover the costs of the conference fee, accommodation and/or travel.</I></p>

              <p><I>Travel and/or accommodation reservations must be made through the conference secretariat.</I></p>
 
              <p><I>Students must register for SIMS21 and give their presentation to receive the Award.</I></p> 

	      <p><span style="color:red"><I>The  applicants  are  kindly  asked  to create their accounts,  register at the conference website, but pay the conference fee <strong>only</strong>  after receiving notification about results of qualification</I>.</span></p>
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
