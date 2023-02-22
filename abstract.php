<?php
require "./extras/always_require.php";

//no need to check if logged in

//no need to check if comes from proper page

$_SESSION["last_site"] = "abstract";
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

              <h1>Abstract guidelines</h1>

              <p><span class="important">Abstract submission deadline was 30 April 2017.</br></span></p>
	<p><span class="important">Late abstracts are still accepted but for a poster session only</span>.</p>

              <p>Abstract must be submitted as a Microsoft Word document (any version is acceptable). Its length must be limited to one A4 page with margins and font sizes as indicated <a href="./resources/abstract_template.doc" download>in the template</a>.</p>

              <p>The book of abstract will be printed in a black &amp; white format. Make sure that your figures are legible in this representation.</p>

              <h2>Remarks:</h2>
             <I> 
              <ul>
                <li>The number of poster presentations is limited to 2 per attendee to ensure that they have availability to present their work;</li>
                <li>There is no limit on the number of oral presentations. However, a single oral presentation per participant is preferred in order to ensure a variety of speakers.</li>
              </ul>
            </I>
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
