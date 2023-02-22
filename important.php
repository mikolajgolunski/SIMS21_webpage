<?php
require "./extras/always_require.php";

//no need to check if logged in

//no need to check if comes from proper page

$_SESSION["last_site"] = "important";
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

      <title>SIMS21, Poland 2017 - Important dates</title>
  </head>

  <body>
    <?php include_once("analyticstracking.php") ?>
    <div id="wrapper">
      <?php
    require('./includes/header.html');
    ?>

        <div id="main">
          <?php
        require("./includes/menu.php");
        ?>

            <div id="content">
              <h1>Important dates</h1>
              <table>
                <thead>
                  <tr>
                    <th></th>
                    <th class="left">Start Date</th>
                    <th class="left">End Date</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="description">Abstract Submission:</td>
                    <td class="left">February&nbsp;1,&nbsp;2017</td>
                    <td class="left">May&nbsp;15,&nbsp;2017 (Late abstracts still accepted)</td>
                  </tr>
                  <tr>
                    <td class="description">Abstract acceptance notification:</td>
                    <td class="left">June&nbsp;1,&nbsp;2017</td>
                    <td class="left">June&nbsp;6,&nbsp;2017</td>
                  </tr>
                  <tr>
                    <td class="description">Early registration:</td>
                    <td class="left">April&nbsp;1,&nbsp;2017</td>
                    <td class="left"><span style="color:red">June&nbsp;30,&nbsp;2017</span></td>
                  </tr>
                  <tr>
                    <td class="description">Late registration:</td>
                    <td class="left">July&nbsp;1,&nbsp;2017</td>
                    <td class="left">August&nbsp;31,&nbsp;2017</td>
                  </tr>
                  <tr>
                    <td class="description">On-site registration:</td>
                    <td class="left">September&nbsp;10,&nbsp;2017</td>
                    <td class="left">September&nbsp;15,&nbsp;2017</td>
                  </tr>
                  <tr>
                    <td class="description">Conference:</td>
                    <td class="left">September&nbsp;10,&nbsp;2017</td>
                    <td class="left">September&nbsp;15,&nbsp;2017</td>
                  </tr>
                  <tr>
                    <td class="description">Manuscript Submission:</td>
                    <td class="left">June&nbsp;1,&nbsp;2017</td>
                    <td class="left"><span style="color:red">December&nbsp;15,&nbsp;2017</td></span>
                  </tr>
                </tbody>
              </table>

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
