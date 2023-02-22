<?php
require "./extras/always_require.php";

//no need to check if logged in

//no need to check if comes from proper page

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

              <h1>IUVSTA grants</h1>
              <p>Through the kind sponsorship of IUVSTA, a reduced fee of <strong>150&nbsp;PLN (~35&nbsp;Euro)</strong> will be available for some participants of <a href="short_course.php">the IUVSTA Short Course</a>.</p>

              <p>To apply for the reduced fee please send an email to the conference chairman at <a href="mailto:grants@sims21.org?Subject=Application%20for%20the%20IUVSTA%20Grant">grants@sims21.org</a> with the Subject: &quot;Application for the IUVSTA Grant&quot;.</p>
              
              <p>The email should contain a short information about applicant (name, nationality, research/study institution, research interests). 

<?php /*
              <p>Application process wil open on <span class="important">April&nbsp;1, 2017</span>.</p> 
*/ ?>

	<p><B>Thanks to additional funding we can still offer the IUVSTA grants to all interested</B>. Applications will be considered on the &quot;first come, first serve&quot; basis until all funds are exhausted.</p>
<?php 
/*
              <p>Information about results of qualification will be sent to applicants before <span class="important">June&nbsp;1, 2017</span>.</p>
              <p>It is expected that successful applicants will pay the reduced IUVSTA Short Course registration fee before <span class="important">June&nbsp;15, 2017</span>. Otherwise, the grant will be allocated to the next person on the waiting list.</p>
*/ ?>
              <h3>Remarks</h3>
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
