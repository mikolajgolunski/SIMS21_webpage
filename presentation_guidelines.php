<?php
require "./extras/always_require.php";

//no need to check if logged in

//no need to check if comes from proper page

$_SESSION["last_site"] = "presentation_guidelines";
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>
    
    <style type="text/css">
      .session_time {
        margin-left: 2em;
        font-weight: bold;
      }
    </style>

      <title>SIMS21, Poland 2017 - Presentation guidelines</title>
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
              <h1>Presentation guidelines</h1>
              <h2>Oral</h2>
              <p>Contributed Oral presentations are 20&nbsp;minutes in length, with nominally 16 minutes for your presentation and 4&nbsp;minutes for questions.</p>
              <p>Invited Oral presentations at the SIMS21 are 40&nbsp;minutes in length, with nominally 35 minutes for your presentation and 5&nbsp;minutes for questions.</p>
	      <p>Invited Oral presentations at the  Industrial Session/Workshop are 20&nbsp;minutes in length, with nominally 16 minutes for your presentation and 4&nbsp;minutes for questions.</p>
              <h2>Poster</h2>
              <p>Poster presenters are requested to be present at (or near) their poster during the times scheduled for poster viewing. Boards will be available for presenters to mount their posters at 12:00 (12:00&nbsp;noon) on Tuesday for both sessions. Posters will remain up for both sessions and must be removed immediately following the Thursday session. Please note that we cannot take responsibility for any posters left on the boards after the session. <strong>The poster boards are 1.3&nbsp;m high and 0.95&nbsp;m wide. Whatever fits within these dimensions is acceptable, but posters having A0 size are advised. </strong>Posters will be attached to boards with double-sided tape which will be provided.</p>

              <h2>Poster Session Hours</h2>
              <p class="session_time">Tuesday, September&nbsp;11,&nbsp;2017: 17:20 - 19:00 (5:20&nbsp;p.m. - 7:00&nbsp;p.m.) Exhibition Room</p>
              <p class="session_time">Thursday, September&nbsp;13,&nbsp;2017: 17:20 - 19:00 (5:20&nbsp;p.m. - 7:00&nbsp;p.m.) Exhibition Room</p>


              <h2>Audio-Visual Setup</h2>
              <p>Conference rooms will be set up with screens, microphones, LCD projectors (VGA sockets), and laptops (PCs). Organizers will provide PCs in the session rooms and switchboxes will also be available for those who bring their own computers. If you are using our computer, please load your presentation on to this computer prior to the start of the session or during a session break. In deference to all our presenters, it is important that personal computer/LCD projector compatibility issues be worked out well in advance of your presentation. Please note that PowerPoint is the recommended presentation software. The projector is expected to be compatible with both PC's and MAC's; however, we ask that you bring a copy of your presentation on a flash drive as a backup.</p>
	<p><span style="color:red">The projectors screen format is 4:3.</span></p>
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
