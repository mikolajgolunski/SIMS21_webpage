<?php
require "./extras/always_require.php";

//no need to check if logged in

//no need to check if comes from proper page

$_SESSION["last_site"] = "proceedings";
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

      <title>SIMS21, Poland 2017 - Conference Proceedings</title>
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
              <h1>Conference Proceedings</h1>
              <p class="important">Manuscript Submission Opening: June&nbsp;1, 2017.<br>Manuscript Submission Deadline: December&nbsp;15, 2017.</p>
              <p>Contributions from the conference will be published in the <strong>Journal of Vacuum Science &amp; Technology B Special Issue on SIMS</strong> and the <strong>Biointerphases In-Focus on SIMS</strong>.</p>
              <p>Papers which are not related to biology should be submitted to the Journal of Vacuum Science &amp; Technology B, while manuscripts related to biology should be submitted to the Biointerphases.</p>
              <p>The focus issues are planned in collaboration with the 21<sup>st</sup> International Conference on Secondary Ion Mass Spectrometry SIMS21 to be held in Krakow, Poland during September&nbsp;10-15, 2017. While a significant fraction of the articles are expected to be based on material presented at SIMS21, <strong>research articles that are on SIMS but were not presented at this conference are also welcome.</strong> The special issue will be open to all SIMS related articles.</p>
              <p><strong>Manuscripts will be treated as regular papers, not conference proceedings papers.</strong> As a result, papers will be reviewed using the same criteria as regular AVS publications and must meet AVS standards for both technical content and written English.</p>

              <p>Manuscript must:</p>
              <ul>
                <li>Present original findings, conclusions or analysis that have not been published previously</li>
                <li>Be free of errors and ambiguities</li>
                <li>Support conclusions with data and analysis</li>
                <li>Be written clearly</li>
                <li>Have high impact in its field</li>
              </ul>

              <h2>Submission to the Journal of Vacuum Science &amp; Technology B</h2>
              <p>This Special May/June 2018 Issue will be dedicated to the science and technology of Secondary Ion Mass Spectrometry.</p>
              <p>While there are no strict page limits for the special issue, typical manuscripts are 3 (for letters) to 6 (for articles) printed pages. (There are approximately 1000 words/page and an average single column figure is equivalent to 250 words).</p>
              <p>Submit your manuscripts to JVST using the journals' online manuscript submission system at <a href="http://jvstb.peerx-press.org" target="_blank">http://jvstb.peerx-press.org</a>. In preparing your article, you should follow the <a href="http://avs.scitation.org/jvb/authors/manuscript" target="_blank">instructions for contributors</a>.</p>
              <p>Authors are encouraged to use the article templates. The easiest way to prepare your manuscript is to use the available Article Template to delete and replace text as necessary. This file and the template used to create it are available at the site above.</p>
              <p>When submitting on-line please select &quot;Special Issue on SIMS&quot;.</p>

              <h2>Submission to the Biointerphases</h2>
              <p>SIMS articles related to biomaterials, biology, or the biointerfaces will appear in a special Biointerphases SIMS In Focus issue 2/2018 in June 2018.</p>
              <p>Submit your manuscripts to Biointerphases using the journals' online manuscript submission system at <a href="http://biointerphases.peerx-press.org" target="_blank">http://biointerphases.peerx-press.org</a>. In preparing your article, you should follow the <a href="http://avs.scitation.org/bip/authors/manuscript" target="_blank">instructions for contributors</a>.</p>
              <p>Authors are encouraged to use the article templates. The easiest way to prepare your manuscript is to use the available Article Template to delete and replace text as necessary. This file and the template used to create it are available at the site above.</p>
              <p>When submitting on-line please select &quot;In-Focus on SIMS&quot;.</p>

              <h2>Submit your ToFSIMS Spectra to Surface Science Spectra</h2>
              <p>SSS encourages SIMS authors to include their recent digital data and spectra in Surface Science Spectra. SSS opened a unique web based submission form for ToF-SIMS submissions allowing for easier further expansion of the SSS SIMS library of data records. Those interested in your data will be able to download the full set of data with a single click on the spectrum accession number. Please submit this easily online at <a href="http://sss.peerx-press.org" target="blank">http://sss.peerx-press.org</a> selecting &quot;SIMS&quot;.</p>
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
