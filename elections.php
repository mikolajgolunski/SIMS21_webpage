<?php
require "./extras/always_require.php";

//no need to check if logged in

//no need to check if comes from proper page

$_SESSION["last_site"] = "elections";
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

      <title>SIMS21, Poland 2017 - Committee Elections</title>
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
              <h1>Committee Elections</h1>

              <p>The International Committee (IC) comprises of 3 elected members from each of the 3 regions where SIMS is heavily practiced, Asia-Pacific, North America and Europe. Elected members serve a period of 6 years. The Chair of the IC is appointed by the IC and serves a period of up to six years. In addition the conference chairs of the past and current conferences are ex officio members serving 2 years prior and 2 years after their respective conference. Therefore, in the steady state the IC comprises of 11 members they are listed <a href="./committees.php">here</a>. Further details are given in <a href="./resources/SIMSConferenceHandbook2007r.pdf" download>the SIMS Handbook</a>.</p>

              <h2>What Does the International Committee Do?</h2>

              <p>The IC has responsibility to:</p>
              <ul>
                <li>Support and encourage the understanding, development and application of SIMS and related topics.</li>
                <li>Provide oversight of the biennial International Conferences and ensuring that the Proceedings of these Conferences are available to all scientists in the refereed literature.</li>
                <li>Ensure that suitable bids are received for hosting the biennial International Conference. The IC evaluates those bids by considering the ability of the proposing team to hold a successful conference, the proposed venue and location, the budgets and other arrangements.</li>
                <li>Develop foresight and strategic direction, for example opening up new areas and initiatives, to ensure the vitality of future conferences.</li>
              </ul>

              <h2>How are New Members Elected?</h2>

              <p>At each international SIMS conference 3 of the 9 elected IC members will retire and 3 new members are elected, one for each region. This starts now for North America and Europe using the following procedure:</p>
              <ul>
                <li>The IC will provide a slate of nominations from North America and Europe including a short biography. In addition, nominations (including a short biography) are gratefully received from those who have been a registered participant at any one of the last three International SIMS conferences. Nominations should be sent to the IC Secretary (<a href="mailto:amy.walker@utdallas.edu">amy.walker@utdallas.edu</a>) by <span class="important">1 September 2017</span>.</li>
                <li>Voting will be by region using a paper ballot at the International SIMS conference. The slate of nominations will be available on the SIMS conference website one month before the conference. A voting slip will be included in the conference bag. Only registered participants at the SIMS conference are eligible to vote. <strong>Results will be announced at the Conference General Meeting.</strong> Eligible participants may vote for one candidate in the North America region and one candidate in the European region. In the unlikely event of a tied vote, the IC chairman will have an additional casting vote.</li>
                <li>Note that in the Asia-Pacific region a separate process is being conducted. This year, the Korean representative will retire and following consultation in Korea a replacement has been selected. If you have questions, please contact Amy Walker at <a href="mailto:amy.walker@utdallas.edu">amy.walker@utdallas.edu</a>.</li>
              </ul>
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
