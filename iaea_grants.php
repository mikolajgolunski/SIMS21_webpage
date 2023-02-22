<?php
require "./extras/always_require.php";

//no need to check if logged in

//no need to check if comes from proper page

$_SESSION["last_site"] = "iaea_grants";
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

      <title>SIMS21, Poland 2017 - IAEA Grants</title>
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
              <h1>IAEA Travel Grants</h1>

              <p>The conference is organized in cooperation with the International Atomic Energy Agency (IAEA). In the framework of the cooperation agreement the IAEA will award a limited number of grants to participants from Member States eligible to receive assistance under the IAEA's Technical Cooperation Programme. The registration fee will be waived for accepted IAEA grantees.</p>
              
              <p> The grants are to support travel to the conference and/or accommodation costs of attendees who would have difficulties attending SIMS21 without this assistance. Grants will be awarded to applicants based on eligibility (see below), financial need, and the importance of their presentation. We invite particularly young researches from countries with low economic resources to apply for the IAEA travel grant.</p>

              <p>The criteria for selection are following:</p>
              <ul>
                <li>The candidate must be a national from an IAEA Member State eligible to receive assistance under the Agency Technical Cooperation Program, i.e. states outside Western Europe/North America/Japan/South Korea/Australia/NZ (deploying economies);</li>
                <li>The candidate presentation must be accepted by the Conference Program Committee.</li>
              </ul>

              <p>In order to submit the application please send an e-mail to: <a href="mailto:grants@sims21.org?Subject=Application for the IAEA grant">grants@sims21.org</a> with the Subject: &quot;Application for the IAEA grant&quot; and a following attachment: a short CV and your abstract(s) submitted to the SIMS conference combined as <strong>a single pdf document</strong>. Please specify your needs in the email.</p>
              
              <p>Selection will be made based on the supplied documents.</p>

              <p>Application process wil open on <span class="important">April&nbsp;1, 2017</span> and close on <span class="important">May&nbsp;15, 2017</span>.</p>
              
              <p>Information about results of qualification will be sent to applicants before <span class="important">May&nbsp;18, 2017</span>.</p>
              
              <h3>Remarks</h3>
              <p><span style="color:red"><I>The  IAEA applicants  are  kindly  asked  to create their accounts,  register at the conference website, but pay the conference fee <strong>only</strong>  after receiving notification about results of qualification</I>.</span></p>
              <p><I>Both travel and/or accommodation reservations must be made through the conference secretariat.</I></p>
              <p><I>It ia assumed that applicant supported by the IAEA travel grant (in full or partially) will not be supported from other resources</I>.</p>
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
