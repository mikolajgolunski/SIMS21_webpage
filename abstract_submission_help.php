<?php
require "./extras/always_require.php";

//no need to check if logged in

//no need to check if comes from proper page

$_SESSION["last_site"] = "abstract_submission_help";
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

    <style type="text/css">
      ol.steps {
        list-style: none;
        counter-reset: item;
        margin-left: 0;
        padding-left: 0;
      }
      
      ol.steps > li {
        display: block;
        margin-bottom: .5em;
        margin-left: 4em;
      }
      
      ol.steps > li:before {
        display: inline-block;
        content: "Step " counter(item, upper-roman) ". ";
        font-weight: bold;
        counter-increment: item;
        width: 4em;
        margin-left: -4em;
      }
      
      ol.steps > li > ol {
        margin-left: -2em;
      }
    </style>
      <title>SIMS21, Poland 2017 - Abstract guidelines</title>
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

              <h1>Abstract submission guidelines</h1>

              <p>Abstract submission is closed. <span class="important">Still accepting late abstracts but for a poster session only.</span></p>

              <p><span class="important">Abstract must be submitted by the presenting author.</span></p>

              <p>For abstract guidelines and the abstract template follow <a href="http://sims.confer.uj.edu.pl/abstract.php">this link</a>.

              <h2>Submission process:</h2>

              <ol class="steps">
                <li>If you do not have an account, click <span class="menu-item">Create new account</span> in <span class="menu-item">My Account</span> menu on the left and follow the procedure to create the account. <strong>The account can be created at any time</strong>. It will enable to submit abstracts, follow their status, register participants and accompanying person(s) and check the registration status.</li>
                <li>Log in into the site.</li>
                <li>Once you are logged in, choose <span class="menu-item">New submission</span> in the <span class="menu-item">My Account</span> menu. Complete the information related to the abstract, which consists of 4 steps:
                  <ol>
                    <li>Create a list of all authors. Entering of only one affiliation per author is possible. Multipe affiliations will be added later by the system.</li>
                    <li>Enter abstract title and text (necessary for the online Book of Abstracts). Copy-and-paste approach can be used but make sure that special characters, superscripts and subscripts are properly entered. <strong>Do not copy the figures into the available fields</strong> (abstract with no figures will apper on-line). Abstract file with figures, for the printed Book of Abstracts, will be uploaded in step 3. </li>
                    <li>Select program topic(s) relevant to the submitted abstract (one or more topics can be selected from the enclosed list), select a preferred form of presentation (Oral, Poster or Anything), decide if you wish to enter competition for the Student Presentation Awards, upload the file with your abstract in a Microsoft Word format (necessary for the printed Book of Abstracts).</li>
                    <li>Verify the entered data and submit your abstract by clicking the <span class="menu-item">Submit</span> button.</li>
                  </ol>
                </li>
              </ol>
                <p><font color="red">Do not break the uploading sequence by navigating to other pages as your session will be terminated, and you will lose all information entered in the current session. Only use "Next step" or "Back" buttons located at the bottom of the page.</font></p>

              <p>Once you have submitted your abstract(s), you can access your submission(s) through the <span class="menu-item">Summary</span> in the <span class="menu-item">My Account</span> menu.</p>

              <p>You can upload a new version of your abstract(s) before the abstract deadline. First delete the old abstract, then add a new version. You will have to go through the entire abstract submission process again.</p>
		<p><font color="red">It is no longer possible to modify abstracts submitted before 1 May 2017.</font></p>
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
