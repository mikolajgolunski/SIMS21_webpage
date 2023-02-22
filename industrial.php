<?php
require "./extras/always_require.php";

//no need to check if logged in

//no need to check if comes from proper page

$_SESSION["last_site"] = "industrial";
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
    require('./includes/head.html');
    ?>

      <style type="text/css">
        .name {
          font-weight: bold;
        }

        .title {
          font-style: italic;
        }
      </style>

      <style type="text/css">
        #triangle {
          display: block;
          background-image: url(../img/industry_triangle.png);
          background-repeat: no-repeat;
          width: 100%;
          min-height: 500px;
        }
        
        .spacer {
          display: block;
          float: left;
          clear: left;
          height: 10px;
        }
      </style>
      <title>SIMS21, Poland 2017 - Industrial</title>
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
              <h1>Frontiers and Challenges in Industrial SIMS - Solving Problems in the Real Material World All-day Special Session/Workshop</h1>

              <div id="triangle">

                <?php
                  for($i = 1; $i <= 39; $i++) {
                    echo "<div class=\"spacer\" style=\"width: ";
                    echo 5*$i+20;
                    echo "px;\"></div>\n";
                  }
                  for($i = 1; $i <= 11; $i++) {
                    echo "<div class=\"spacer\" style=\"width: ";
                    echo 195-(17.5*$i)+30;
                    echo "px;\"></div>\n";
                  }
                ?>

                  <p style="font-weight: bold;">
                    Tuesday, September&nbsp;12, 2017<br>
                    <span class="fa-stack fa-1x">
                      <span class="fa fa-square-o fa-stack-2x"></span>
                      <span class="fa fa-clock-o fa-stack-1x"></span>
                    </span>
                    8:40 - 20:00 (8:40&nbsp;a.m. - 8:00&nbsp;p.m.)
                  </p>
                
                  <p>A Special All-Day Session/Workshop will be held on the use of SIMS in applied materials research with special emphasis on industrial applications.</p> 
		  <p>In addition to the invited and contributed talks, there will be a panel session for students where Invited speakers from Industry will discuss how to get from grad school to a fulfilling career.</p>
		  <p>Finally there will be a special section in the conference poster session on industrial applications.</p>

		<h2>Goals of the session: </h2>

			<p>- present new technologies or methodologies that could have a big impact in an industrial setting;</p>

			<p>- grant access to experts in the field (including instrument vendors) who can consult informally over lunch or during breaks about the problems encountered in an industrial setting;</p>

			<p>- learn what industrial counterparts are doing;</p> 

                  <p>- see how the SIMS technique can be applied to particular industrial problems.</p>

                  <p>This session is part of the SIMS21 Conference and is open to all registrants of the conference with no need for a separate registration or additional payment.</p>

                  <p>Non-conference registrants are invited to attend this session at a One Day Attendee registration fee. For details see <a href="fees.php" class="menu-item">Registration fee webpage.</a></p>
                
                  <p><a href="./resources/Industrial_Session_Flyer.pdf" download>Information Flyer</a></p>
                  <h2>Invited presentations</h2>
		  <p>We are currently in a process of completing a list<p>
                  <p class="additional">Only confirmed presentations are shown</p>
                  <ul>
               <li><span class="name">Chih-Hsing Chu</span>, Materials Analysis Technology Inc. (MA-tec), Taiwan - <span class="title">&quot;Quantifying the Ge concentration of Si-Ge epitaxy grown at P-MOSFET by SIMS calibrated TEM/EDX&quot;</span>.</li>
               <li><span class="name">Sungho Lee</span>, Samsung, Korea - <span class="title">&quot;Application of SIMS and APT in the field of semiconductor research&quot;</span>.</li>
	       <li><span class="name">Kathryn G. Lloyd</span>, Dupont, USA - <span class="title">&quot;Depth Profiling or &#39;Just Sputtering&#39;?  How advances in sputter beam technology and data reduction have made ToF-SIMS even more useful in a (non-semiconductor) industrial environment&quot;</span>.
               <li><span class="name">Christine M. Mahoney</span>, Corning, USA - <span class="title">&quot;ToF-SIMS analysis for glass applications&quot;</span>.</li>
               <li><span class="name">Mark Nicholas</span>, AstraZeneca R&D, Sweden  - <span class="title">&quot;Imaging and Surface Analysis of Model Dry Powder Inhaler Formulation&quot;</span>.</li>  
               <li><span class="name">Hiroyuki Noda</span>, Fujifilm Corporation, Japan - <span class="title">&quot;Surface and interfacial analysis of highly functional multilayer in the Chemical Industry&quot;</span>.</li>
               <li><span class="name">Masayuki Okamoto</span>, Kao Corporation, Japan - <span class="title">&quot;Applications of SIMS in the field of cosmetics and toiletries&quot;</span>.</li>
               <li><span class="name">Alan Spool</span>, Western Digital, USA - <span class="title">&quot;Solving Problems With Rotating Disk Drive Devices Using TOF-SIMS&quot;</span>.</li>

		  </ul>
              </div>

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
