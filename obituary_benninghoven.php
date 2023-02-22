<?php
require "./extras/always_require.php";

//no need to check if logged in

//no need to check if comes from proper page

$_SESSION["last_site"] = "obituary_benninghoven";
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

      <title>SIMS21, Poland 2017 - Benninghoven Obituary</title>
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
              <h1>Alfred Benninghoven</h1>

              <p>With deep sorrow we announce that Professor Dr Alfred Benninghoven passed away on Dec 22, 2017 at the age of eighty-five.</p>
              
              <p>With Alfred Benninghoven, the SIMS community loses one of its most notable pioneers. He influenced the development of static SIMS like no one else and laid the scientific foundation for the successful, worldwide spread of the technique.</p>
              
              <p>After studying physics in Paris and Cologne he started to work in the group of Professor Fritz Kirchner, a well-known German nuclear physicist, at the University of Cologne. In 1961 he graduated and received his post-doctoral lecture qualification in 1965. In 1973 he became a professor for experimental physics at the University of Muenster and held this position until his retirement in 1997. During this time, more than 160 master and PhD students graduated from his group and over 300 papers were published under his supervision.</p>
              
              <p>Alfred Benninghoven was a passionate and gifted scientist. The basis of his success, along with his impressive creative power and expertise, was a remarkable determination and professionalism, which made him one of the leading pioneers in the SIMS field for nearly half a century. His book “Secondary Ion Mass Spectrometry: Basic Concepts, Instrumental Aspects, Applications, and Trends”, published in 1987 together with Professor Friedrich Ruedenauer and Professor Helmut Werner, is still regarded as a crucial source of reference.</p>
              
              <p>In 1977 he set up and organised the first international SIMS conference at the University of Muenster. He acted as chairman of this well-established conference until SIMS XV. He was also very active as a thorough editor for the SIMS proceedings. In 1981 he initiated and organised a second biennial conference with the focus on ion formation from organic solids (IFOS). The subject of the conference was the rapidly developing field of ion formation from involatile, thermally labile organic compounds. The event was held in Muenster until IFOS IV. In 1999, he initiated the successful series of biennial European SIMS conferences in Muenster and was head of the local organising committee until 2008.</p>
              
              <p>Alfred Benninghoven was also recognised and decorated for his engagement in different research organisations. He was president of the German Vacuum Society from 1977 to 1983 and received the Gaede-Langmuir Award of the American Vacuum Society for the development of concepts and instrumentation in static secondary ion mass spectrometry and the demonstration of its usefulness in manifold applications in 1984. The development of ToF-SIMS instrumentation and applications was acknowledged by the German Ministry of Education and Research with the Technology Transfer prize in 1988. He was also awarded the Fritz-Pregl-Medal of the Austrian Society of Analytical Chemistry in 1990.</p>
              
              <p>In 1989 he founded the company IONTOF together with his co-workers Dr Ewald Niehuis and Thomas Heller, in order to commercialize the original research carried out at the University of Muenster. In 1997 he was a co-founder of Tascon GmbH, a testing laboratory specialized in Time-of-Flight SIMS, managed by Dr Birgit Hagenhoff.</p>
              
              <p>Despite all his achievements Alfred Benninghoven always remained a modest and approachable person. He will be remembered as a great researcher, teacher, mentor and important dialogue partner.</p>
              
              <p>Our deepest sympathy goes to his family and friends.</p>
              
              <p>Prof. Dr. Heinrich Arlinghaus, University of Muenster<br>
              Dr. Ewald Niehuis and Thomas Heller, IONTOF GmbH<br>
              Dr. Birgit Hagenhoff, Tascon GmbH<br>
              Muenster, January 2018</p>


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
