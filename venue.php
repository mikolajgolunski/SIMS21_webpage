<?php
require "./extras/always_require.php";

//no need to check if logged in

//no need to check if comes from proper page

$_SESSION["last_site"] = "venue";
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

      <title>SIMS21, Poland 2017 - Venue</title>
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
              <h1>Venue</h1>

              <p><img class="text_img" src="img/auditorium_1.png">The conference will be held at the Jagiellonian University Conference Center &quot;Auditorium Maximum&quot; located at Krupnicza&nbsp;33 street, 5&nbsp;minutes walking time to the Old City area. This is a modern conference complex. Among other amenities, participants will have a free wireless access to the Internet.</p>
	      <p>GPS: 50<sup>o</sup> 3' 45'', 19<sup>o</sup> 55' 30'' or 50.062693, 19.925251</p>

              <p>Please check a <a href="http://maximum.wkraj.pl/?v=10#/12557/0" target="_blank">virtual trip through the conference center</a> (commands in Polish only).</p>
              <p>Location of the conference venue relative to the conference hotels can be found <a href="./resources/SIMS21_Hotels.pdf" target="_blank">at this map</a>.</p>

              <h1>Krak&oacute;w</h1>
              <p><img class="text_img" src="img/Krakow_Rynek.png">Krak&oacute;w is a city of approximately one million people in the very heart of Europe. Being Poland's former capital, the cradle and pantheon of Polish kings, it is also a city of learning with one of the oldest universities in Europe. Krak&oacute;w is a city of both museums and youth: a city of one hundred fifty thousand university students. It is a city of meetings, festivals and conferences. The city of caf&eacute;s and restaurants that enchant all those who even for a moment set foot in its old town. The city has eluded destruction since the Tatar raid of 1241. Thus, Krak&oacute;w has preserved its original body of structure and buildings. The functionality of its thirteenth-century urban plan is proven by the fact that it still works today! Cultural, administrative and commercial life is focused around Krak&oacute;w's 40&nbsp;000&nbsp;square-meter town square, the largest one in Europe.</p>

              <p>More information about the city, current cultural activities and a list of some interesting places to see in the city and near Krak&oacute;w can be found in <a href="http://www.krakow-tours.com/" target="_blank">here</a> or in a pdf booklet that can be found <a href="http://www.thevisitor.pl/index.php?id=387" target="_blank">here</a>. After entering this website click cover page photo of the booklet to download PDF file with The Visitor Ma&#322;opolska present edition. There are many travel agencies that will assist you in arrangement of the selected trip.</p>
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
