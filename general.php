<?php
require "./extras/always_require.php";

//no need to check if logged in

//no need to check if comes from proper page

$_SESSION["last_site"] = "general";
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

      <title>SIMS21, Poland 2017 - Scope</title>
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
              <h1>Scope</h1>
              <p class="important">SIMS21 will be held at the Collegium Maximum in Krak&oacute;w, Poland September 10-15, 2017.</p>

              <p>The 2017 International Conference on Secondary Ion Mass Spectrometry will provide a stimulating forum for colleagues from both academia and industries to exchange results and new ideas on Secondary Ion Mass Spectrometry and related techniques. The conference will cover advances in scientific knowledge from fundamental understanding to applications. Dedicated discussion sessions will focus on current possibilities and required developments of the technique, to address the future requirements and needs of technology and basic research.</p>

              <p>Contributions are invited, but not limited to, the following topics:</p>


              <h3>Section 1: Fundamentals</h3>
              <ul>
                <li>Sputtering/Desorption/Ionization processes - FN1</li>
                <li>Data Processing, Analysis and Interpretation - FN2</li>
                <li>Quantification, Metrology and Standardization - FN3</li>
              </ul>
              <h3>Section 2: Organic and Biological</h3>
              <ul>
                <li>Depth Profiling/Organics - OB1</li>
                <li>Polymers and Organic Coatings - OB2</li>
                <li>Cell and Tissue Imaging - OB3</li>
                <li>BioMedical  Materials and Applications - OB4</li>
              </ul>
              <h3>Section 3: Semiconductors, Metals and Nanomaterials</h3>
              <ul>
                <li>Depth Profiling/Inorganics - SN1</li>
                <li>Micro- and Optoelectronic Materials - SN2</li>
                <li>Nanomaterials/Nanostructures - SN3</li>
              </ul>
              <h3>Section 4: Other Applications</h3>
              <ul>
                <li>Geology, Geo- and Cosmochemistry - OA1</li>
                <li>Environment/Nuclear Safeguards/Forensics/Cultural Heritage - OA2</li>
                <li>Industrial Applications - OA3</li>
              </ul>
              <h3>Section 5: Pushing the boundaries</h3>
              <ul>
                <li>Novel Techniques and Instrumentation - PB1</li>
                <li>Enhanced Ionization Methodologies - PB2</li>
                <li>New Strategies for Challenging Samples - PB3</li>
              </ul>
              <h3>Section 6: Related Methods</h3>
              <ul>
                <li>Ambient Mass Spectrometry - RM1</li>
                <li>Atom Probe and Other Mass Spectrometries - RM2</li>
                <li>Multi-technique Approach to Materials Characterization - RM3</li>
              </ul>
              <p>The conference follows previous meetings that were held in M&uuml;nster, Germany (1977); Stanford, USA (1979); Budapest, Hungary (1981); Osaka, Japan (1983); Washington, USA (1985); Paris, France (1987); Monterey, USA (1989); Amsterdam, The Netherlands (1991); Yokohama, Japan (1993); M&uuml;nster, Germany (1995); Orlando, USA (1997); Brussels, Belgium (1999); Nara, Japan (2001); San Diego, USA (2003); Manchester, England (2005); Kanazawa, Japan (2007); Toronto, Canada (2009); Riva-del-Garda, Italy (2011); Jeju, South Korea (2013); Seattle, USA (2015).</p>
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
