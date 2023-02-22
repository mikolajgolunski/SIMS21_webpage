<?php
require "./extras/always_require.php";

//no need to check if logged in

//no need to check if comes from proper page

$_SESSION["last_site"] = "opportunities";
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

      <style type="text/css">
        .available {
          color: green;
        }
        
        .unavailable {
          color: red;
        }
        
        .additional {
          margin-top: 1em;
        }
      </style>
      <title>SIMS21, Poland 2017 - Exhibition/Sponsorship Opportunities</title>
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
              <h1>Exhibition/Sponsorship Opportunities</h1>

              <p>SIMS21 is an international meeting devoted to secondary ion mass spectrometry. It meets in Europe only every 6 years and will be held in 2017 in Poland. In fact, it will be held for the first time in this part of Europe. The expected attendance is at least 350 scientists from the worldwide SIMS and general surface analysis community.</p>

              <p>All sessions for this meeting will be held from 11 to 15&nbsp;September, 2017 at the Auditorium Maximum of the Jagiellonian University in Krak&oacute;w.</p>

              <p>Vendors at the conference will include manufacturers of surface analysis instrumentation, suppliers of vacuum components, analytical companies and publishers.</p>

              <p><strong>Promotional opportunities for vendors can be found in a following document</strong>: <a href="./resources/sponsorship_conditions_SIMS21_Krakow.pdf" download>Sponsorship/Exhibition Conditions</a>.</p>

              <h2 style="margin-top: 2em;">Selected Additional Opportunities</h2>
              <table>
                <thead>
                  <tr>
                    <th>Option</th>
                    <th>Cost (Euro)</th>
                    <th>Availability</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Logo on conference bag:</td>
                    <td>2&nbsp;000 + VAT</td>
                    <td class="available">
                      available
                    </td>
                  </tr>
                  <tr>
                    <td>Conference Lanyard:</td>
                    <td>1&nbsp;200 + VAT</td>
                    <td class="unavailable">
                      unavailable
                    </td>
                  </tr>
                  <tr>
                    <td>Sponsor of Welcome reception<sup>*</sup>:</td>
                    <td>4&nbsp;000 + VAT</td>
                    <td class="available">
                      available
                    </td>
                  </tr>
                  <tr>
                    <td>Sponsor of Conference Banquet<sup>*</sup>:</td>
                    <td>7&nbsp;000 + VAT</td>
                    <td class="available">
                      available
                    </td>
                  </tr>
                  <tr>
                    <td>Sponsor of Poster Session<sup>*</sup>:</td>
                    <td>2&nbsp;000 + VAT</td>
                    <td class="available">
                      available
                    </td>
                  </tr>
                  <tr>
                    <td>Sponsor of a tour<sup>*</sup>:</td>
                    <td>3&nbsp;000 + VAT</td>
                    <td class="unavailable">
                      unavailable
                    </td>
                  </tr>
                </tbody>
              </table>

              <p class="additional"><sup>*</sup> Sponsorship will be verbally acknowledged. A poster acknowledging sponsorship with sponsor logo will be prominently displayed at event.</p>
              
              <p>If you would like to discuss these opportunities, please contact our secretariat office at <a href="mailto:user@user.user">user@user.user</a>.</p>
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
