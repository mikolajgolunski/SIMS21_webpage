<?php
require "./extras/always_require.php";

require('./database/db_connect.php');

$sql = "SELECT id, title FROM abstracts WHERE accepted AND session_assigned IS NOT NULL";
$stmt = $conn->prepare($sql);
$stmt->execute();
$abstracts = array();
while($abstract = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $abstracts[$abstract["id"]]["title"] = delete_hidden_characters($abstract["title"]);
  $abstracts[$abstract["id"]]["id"] = $abstract["id"];
}

$sql = "SELECT abstract_id, person_id FROM abstracts_to_people WHERE abstract_id=? AND presenting";
$stmt = $conn->prepare($sql);
$sql = "SELECT id, full_name FROM people WHERE id=?";
$stmt2 = $conn->prepare($sql);
foreach($abstracts as $abstract) {
  $stmt->execute(array($abstract["id"]));
  $id = $stmt->fetch(PDO::FETCH_ASSOC);
  
  $stmt2->execute(array($id["person_id"]));
  $person = $stmt2->fetch(PDO::FETCH_ASSOC);
  
  $abstracts[$abstract["id"]]["full_name"] = $person["full_name"];
}

$conn = null;

$echo_abstract_link = function($name, $abstract_id) use($abstracts) {
  $txt = "<a href=\"http://sims.confer.uj.edu.pl/boa_oral.php?id=".$abstract_id."\" onmouseover=\"javascript:showToolTip(event,'".$abstracts[$abstract_id]["full_name"]."<br><br>".$abstracts[$abstract_id]["title"]."',1)\" onmouseout=\"hideToolTip()\">".$name."</a>";
  echo $txt;
  return 0;
};
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

    <link rel="stylesheet" type="text/css" href="./css/wholepage.css">
    <style type="text/css">
      td, th {
        border: 1px solid #444;
        align-content: center;
        text-align: center;
        padding: 0.1em;
        font-size: 0.75em;
      }
      
      td.bubble {
        border: none;
      }
      
      #bubble_tooltip {
        width: 20em;
      }
      
      #bubble_tooltip .bubble_middle div {
        text-align: left;
      }
      
      tbody> tr:nth-child(even) {
        background: none;
      }
      
      tbody> tr:hover {
        background: lightgreen;
      }
      
      .info {
        background-color: lightgray;
      }
      
      .plenary {
        background-color: skyblue;
      }
      
      .none {
        background-color: black;
      }
      
      .invited {
        background-color: yellow;
      }
      
      .invited_OA3 {
        background-color: lightyellow;
      }
      
      .coffee {
        background-color: darkseagreen;
      }
      
      .bn {
        background-color: #66ff99;
      }
      
      .lunch {
        background-color: pink;
      }
      
      .vendors {
        background-color: #cc66ff;
      }
      
      .banquet {
        background-color: slateblue;
      }
      
      .poster {
        background-color: #ff8000;
      }
      
      .small {
        font-size: 75%;
        line-height: 50%;
      }
      
      .with_small {
        line-height: 100%;
      }
      
      .inside_table_cell {
        padding: 0;
        margin: 0;
      }
      
      .inside_table {
        height: 100%;
        width: 100%;
      }
      
      .inside_table tr td {
        font-size: 1em;
      }
      
      .inside_table tr:first-child td {
        border-top: 0;
      }
      
      .inside_table tr td:first-child {
        border-left: 0;
      }
      
      .inside_table tr:last-child td {
        border-bottom: 0;
      }
      
      .inside_table tr td:last-child {
        border-right: 0;
      }
      
      .inside_time {
        display: inline-block;
        text-align: right;
        padding-right: 0.5em;
        width: 6.5em;
      }
      
      .inside_name {
        display: inline-block;
        text-align: left;
      }
      
      .inside_table tr td {
        text-align: left;
        width: 12em;
      }
    </style>

      <title>SIMS21, Poland 2017 - Oral timetable</title>
  </head>

  <body>
    <div id="wrapper">
    <?php
    require('./includes/header.html');
    ?>
    <div id="main">
        <div id="content">
          <table id="bubble_tooltip">
            <tr class="bubble_middle">
              <td class="bubble">
                <div id="bubble_tooltip_content"></div>
              </td>
            </tr>
          </table>
          
          <h1>Oral timetable</h1>
          <h2 class="additional"><a href="resources/SIMS21_programme.pdf" download>Download PDF version</a></h2>
          
          <table>
            <thead>
              <tr>
                <th></th>
                <th colspan="3">Monday</th>
                <th colspan="3">Tuesday</th>
                <th colspan="2">Wednesday</th>
                <th colspan="2">Thursday</th>
                <th colspan="2">Friday</th>
              </tr>
              <tr>
                <td></td>
                
                <td>Session&nbsp;1</td>
                <td>Session&nbsp;2</td>
                <td>Session&nbsp;3</td>
                
                <td>Session&nbsp;1</td>
                <td>Session&nbsp;2</td>
                <td>Session&nbsp;3</td>
                
                <td>Session&nbsp;1</td>
                <td>Session&nbsp;2</td>
                
                <td>Session&nbsp;1</td>
                <td>Session&nbsp;2</td>
                
                <td>Session&nbsp;1</td>
                <td>Session&nbsp;2</td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>08:30</td>
                
                <td colspan="3"><span class="important">08:30 WELCOME</span></td>
                
                <td colspan="2"></td>
                <td><span class="important">Industrial</span></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
              </tr>
              <tr>
                <td></td>
                
                <td class="info with_small" colspan="3">Plenary talk<br><span class="small">Chair: Vandervorst</span></td>
                
                
                
                <td class="info with_small">FN2<br><span class="small">Chair: Graham</span></td>
                <td class="info with_small">B&amp;N Honorary<br><span class="small">Chair: Vickerman</span></td>
                <td class="info with_small">OA3<br><span class="small">Chair: </span></td>
                
                <td class="info with_small" colspan="2">Plenary talk<br><span class="small">Chair: Gilmore</span></td>
                
                
                <td class="info with_small">OB1<br><span class="small">Chair: </span></td>
                <td class="info with_small">PB3<br><span class="small">Chair: Lerach</span></td>
                
                <td class="info with_small">OB4<br><span class="small">Chair: Moon</span></td>
                <td class="info with_small">FN3<br><span class="small">Chair: Lockyer</span></td>
              </tr>
              <tr>
                <td>08:40</td>
                
                <td class="plenary with_small" colspan="3" rowspan="2"><?php $echo_abstract_link("Grovenor", "290");?> 08:40-09:20<br><span class="small">A. Benninghoven Lecture</span></td>
                
                
                
                <td><?php $echo_abstract_link("Hedberg", "70");?></td>
                <td rowspan="3" class="inside_table_cell">
                  <table class="inside_table">
                    <tr>
                      <td class="bn"><span class="small inside_time">08:40-08:45</span><span class="inside_name" onmouseover="javascript:showToolTip(event,'Zbigniew Postawa<br><br>Session Opening',1)" onmouseout="hideToolTip()">Postawa</span></td>
                    </tr>
                    <tr>
                      <td class="bn"><span class="small inside_time">08:45-08:55</span><span class="inside_name"><?php $echo_abstract_link("Vickerman", "410");?></span></td>
                    </tr>
                    <tr style="height: 4em;">
                      <td class="invited"><span class="small inside_time">08:55-09:25</span><span class="inside_name"><?php $echo_abstract_link("Wucher", "107");?></span></td>
                    </tr>
                    <tr>
                      <td class="bn"><span class="small inside_time">09:25-09:40</span><span class="inside_name"><?php $echo_abstract_link("Fisher", "407");?></span></td>
                    </tr>
                  </table>
                </td>
                <td class="invited_OA3"><?php $echo_abstract_link("Spool", "130");?></td>
                
                <td class="plenary" colspan="2" rowspan="2"><?php $echo_abstract_link("Heeren", "286");?> 08:40-09:20</td>
                
                
                <td class="invited" rowspan="2"><?php $echo_abstract_link("Havelund", "317");?></td>
                <td><?php $echo_abstract_link("Langer", "118");?></td>
                
                <td><?php $echo_abstract_link("D&uuml;rr", "235");?></td>
                <td><?php $echo_abstract_link("Vorng", "234");?></td>
              </tr>
              <tr>
                <td>09:00</td>
                
                
                
                
                
                <td><?php $echo_abstract_link("Nie", "262");?></td>
                
                <td><?php $echo_abstract_link("Sobol", "23");?></td>
                
                
                
                
                
                <td><?php $echo_abstract_link("Ellis", "295");?></td>
                
                <td><?php $echo_abstract_link("Bratek-Skicki", "346");?></td>
                <td><?php $echo_abstract_link("Gui", "367");?></td>
              </tr>
              <tr>
                <td>09:20</td>
                
                <td class="info with_small">PB1<br><span class="small">Chair: Matsuo</span></td>
                <td class="info with_small">OB2<br><span class="small">Chair: Cyganik</span></td>
                <td class="info with_small">SN1<br><span class="small">Chair: </span></td>
                
                <td><?php $echo_abstract_link("Trindade", "256");?></td>

                <td><?php $echo_abstract_link("Al Aboura", "35");?></td>
                
                <td class="plenary" colspan="2" rowspan="3">General Discussion 09:20-10:20</td>
                
                <td><?php $echo_abstract_link("Rysz", "254");?></td>
                <td><?php $echo_abstract_link("Consumi", "354");?></td>
                
                <td><?php $echo_abstract_link("Gajos", "102");?></td>
                <td><?php $echo_abstract_link("Sangely", "380");?></td>
              </tr>
              <tr>
                <td>09:40</td>
                
                <td class="invited" rowspan="2"><?php $echo_abstract_link("Ninomiya", "224");?></td>
				<td><?php $echo_abstract_link("Ossowski", "197");?></td>
				<td><?php $echo_abstract_link("Jones", "386");?></td>
                
                <td><?php $echo_abstract_link("Terlier", "33");?></td>
                <td rowspan="3" class="inside_table_cell">
                  <table class="inside_table">
                    <tr>
                      <td class="bn"><span class="small inside_time">09:40-09:55</span><span class="inside_name"><?php $echo_abstract_link("Delcorte", "404");?></span></td>
                    </tr>
                    <tr>
                      <td class="bn"><span class="small inside_time">09:55-10:10</span><span class="inside_name"><?php $echo_abstract_link("Walker", "405");?></span></td>
                    </tr>
                    <tr>
                      <td class="bn"><span class="small inside_time">10:10-10:25</span><span class="inside_name"><?php $echo_abstract_link("Kanski", "176");?></span></td>
                    </tr>
                    <tr>
                      <td class="bn"><span class="small inside_time">10:25-10:40</span><span class="inside_name"><?php $echo_abstract_link("Ewing", "409");?></span></td>
                    </tr>
                  </table>
                </td>
                <td><?php $echo_abstract_link("Chater", "132");?></td>
                
                
                
                <td><?php $echo_abstract_link("Surana", "126");?></td>
                <td class="invited" rowspan="2"><?php $echo_abstract_link("Zhu", "219");?></td>
                
                <td><?php $echo_abstract_link("T.G. Lee", "82");?></td>
                <td><?php $echo_abstract_link("Dmitrovic", "37");?></td>
              </tr>
              <tr>
                <td>10:00</td>
                
                
                <td><?php $echo_abstract_link("Awsiuk", "194");?></td>
				<td><?php $echo_abstract_link("J. Zhang", "137");?></td>
                
                <td><?php $echo_abstract_link("Thomas", "347");?></td>

                <td class="invited_OA3"><?php $echo_abstract_link("Chu", "297");?></td>
                
                
                
                <td><?php $echo_abstract_link("Prop", "358");?></td>
                
                
                <td><?php $echo_abstract_link("Nygren", "21");?></td>
                <td><?php $echo_abstract_link("L. Zhang", "40");?></td>
              </tr>
              <tr>
                <td>10:20</td>
                
				<td><?php $echo_abstract_link("Fujiwara", "222");?></td>
                <td><?php $echo_abstract_link("Hannestad", "75");?></td>
				<td><?php $echo_abstract_link("Renouf", "282");?></td>
                
                <td><?php $echo_abstract_link("Arlinghaus", "220");?></td>

                <td><?php $echo_abstract_link("Cremel", "47");?></td>
                
                <td class="coffee" colspan="2">Coffee</td>
                
                <td><?php $echo_abstract_link("Van Nuffel", "41");?></td>
                <td><?php $echo_abstract_link("Rakowska", "209");?></td>
                
                <td><?php $echo_abstract_link("Hen&szlig;", "159");?></td>
                <td><?php $echo_abstract_link("Z. Li", "42");?></td>
              </tr>
              <tr>
                <td>10:40</td>
                
                <td class="coffee" colspan="3">Coffee</td>
                
                <td class="coffee" colspan="3">Coffee</td>
                
                <td class="info with_small">OB3<br><span class="small">Chair: Castner</span></td>
                <td class="info with_small">SN3<br><span class="small">Chair: Unger</span></td>
                
                <td class="coffee" colspan="2">Coffee</td>
                
                <td class="coffee" colspan="2">Coffee</td>
              </tr>
              <tr>
                <td>10:40</td>
                
                <td class="info with_small">PB1<br><span class="small">Chair: Winograd</span></td>
                <td class="info with_small">OB2<br><span class="small">Chair: Licciardello</span></td>
                <td class="info with_small">SN1<br><span class="small">Chair: </span></td>
                
                <td class="info with_small">FN2<br><span class="small">Chair: Alexander</span></td>
                <td class="info with_small">OA1<br><span class="small">Chair: Gardella</span></td>
                <td class="info with_small">OA3<br><span class="small">Chair: Lloyd</span></td>
                
                <td><?php $echo_abstract_link("Alexander", "44");?></td>
                <td><?php $echo_abstract_link("Hua", "101");?></td>
                
                <td class="info with_small">OB1<br><span class="small">Chair: T.G. Lee</span></td>
                <td class="info with_small">RM<br><span class="small">Chair: Moritani</span></td>
                
                <td class="info with_small">PB3<br><span class="small">Chair: della Negra</span></td>
                <td class="info with_small">SN1<br><span class="small">Chair: Napolitani</span></td>
              </tr>
              <tr>
                <td>11:00</td>
                
				<td><?php $echo_abstract_link("Gilmore", "348");?></td>
                <td><?php $echo_abstract_link("Schwab", "172");?></td>
                <td class="invited" rowspan="2"><?php $echo_abstract_link("van der Heide", "56");?></td>
				
                <td><?php $echo_abstract_link("Graham", "218");?></td>
                <td class="invited" rowspan="2"><?php $echo_abstract_link("Whitehouse", "225");?></td>
                <td class="invited_OA3"><?php $echo_abstract_link("Nicholas", "122");?></td>
                
                <td><?php $echo_abstract_link("Aoyagi", "38");?></td>
                <td><?php $echo_abstract_link("Veith", "109");?></td>
                
                <td><?php $echo_abstract_link("Bejjani", "249");?></td>
                <td class="invited" rowspan="2"><?php $echo_abstract_link("Barnes", "312");?></td>
                
				<td><?php $echo_abstract_link("Mihara", "243");?></td>
                <td><?php $echo_abstract_link("Rogowski", "276");?></td>
              </tr>
              <tr>
                <td>11:20</td>
                
				<td><?php $echo_abstract_link("Hood", "311");?></td>
                <td><?php $echo_abstract_link("Pospisilova", "115");?></td>
                
				
                <td><?php $echo_abstract_link("Cumpson", "378");?></td>
                
				<td class="invited_OA3"><?php $echo_abstract_link("Okamoto", "278");?></td>
                
                <td><?php $echo_abstract_link("Dunham", "134");?></td>
                <td><?php $echo_abstract_link("Killian", "328");?></td>
                
                <td><?php $echo_abstract_link("Carr", "215");?></td>
                
				
				<td><?php $echo_abstract_link("Iida", "94");?></td>
                <td><?php $echo_abstract_link("Dai", "43");?></td>
              </tr>
              <tr>
                <td>11:40</td>
                
				<td><?php $echo_abstract_link("Fearn", "117");?></td>
                <td><?php $echo_abstract_link("Bernard", "226");?></td>
                <td><?php $echo_abstract_link("Morris", "168");?></td>
				
                <td><?php $echo_abstract_link("Gelb", "214");?></td>
                <td><?php $echo_abstract_link("Kilburn", "289");?></td>
                <td class="invited_OA3"><?php $echo_abstract_link("Noda", "106");?></td>
                
                <td><?php $echo_abstract_link("Newman", "173");?></td>
                <td><?php $echo_abstract_link("Jungnickel", "230");?></td>
                
                <td><?php $echo_abstract_link("Brunelle", "64");?></td>
                <td><?php $echo_abstract_link("Breitenstein", "108");?></td>
                
				<td><?php $echo_abstract_link("Franquet", "146");?></td>
                <td><?php $echo_abstract_link("Konarski", "313");?></td>
              </tr>
              <tr>
                <td>12:00</td>
                
				<td><?php $echo_abstract_link("Mello", "204");?></td>
                <td class="invited" rowspan="2"><?php $echo_abstract_link("Weng", "138");?></td>
                <td><?php $echo_abstract_link("Jakie&#322;a", "274");?></td>
				
                <td class="invited" rowspan="2"><?php $echo_abstract_link("Tuccitto", "205");?></td>
                <td><?php $echo_abstract_link("Remusat", "192");?></td>
                <td><?php $echo_abstract_link("Jedli&#324;ski", "287");?></td>
                
                <td><?php $echo_abstract_link("Hoang", "366");?></td>
                <td><?php $echo_abstract_link("Schweikert", "133");?></td>
                
                <td><?php $echo_abstract_link("Winograd", "362");?></td>
                <td><?php $echo_abstract_link("Sedl&aacute;&#269;ek", "193");?></td>
                
				<td><?php $echo_abstract_link("Horr&eacute;ard", "187");?></td>
                <td><?php $echo_abstract_link("Ams&uuml;ss", "247");?></td>
              </tr>
              <tr>
                <td>12:20</td>
                
				<td><?php $echo_abstract_link("Henkel", "153");?></td>
				
                <td><?php $echo_abstract_link("Kayser", "20");?></td>
                
                
                <td><?php $echo_abstract_link("Schoenenbach", "229");?></td>
                <td><?php $echo_abstract_link("Courr&egrave;ges", "162");?></td>
                
                <td><?php $echo_abstract_link("Schaepe", "237");?></td>
                <td><?php $echo_abstract_link("Kanarbik", "393");?></td>
                
                <td><?php $echo_abstract_link("Licciardello", "201");?></td>
                <td><?php $echo_abstract_link("Haberko", "257");?></td>
                
                <td><?php $echo_abstract_link("Lerach", "261");?></td>
				<td><?php $echo_abstract_link("Jaskiewicz", "355");?></td>
              </tr>
              <tr>
                <td>12:40</td>
                
				<td><?php $echo_abstract_link("Keelor", "338");?></td>
                <td><?php $echo_abstract_link("Xie", "84");?></td>
				<td><?php $echo_abstract_link("Grasso", "310");?></td>
                
                <td><?php $echo_abstract_link("Henderson", "364");?></td>
                <td><?php $echo_abstract_link("Portier", "171");?></td>
                <td><?php $echo_abstract_link("Bryan", "212");?></td>
                
                <td class="lunch" rowspan="3" colspan="2">Lunch 12:40-13:40</td>
                
                
                <td><?php $echo_abstract_link("Stevie", "45");?></td>
                <td><?php $echo_abstract_link("Matsuo", "342");?></td>
                
                <td class="lunch" rowspan="3" colspan="2">Lunch 12:40-13:40</td>
                
              </tr>
              <tr>
                <td>13:00</td>
                
                <td class="lunch" rowspan="3" colspan="3">Lunch 13:00-14:00</td>
                
                
                
                <td class="lunch" rowspan="3" colspan="3">Lunch 13:00-14:00</td>
                
                
                
                
                
                
                <td class="lunch" rowspan="3" colspan="2">Lunch 13:00-14:00</td>
                
                
                
                
              </tr>
              <tr>
                <td>13:20</td>
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
              </tr>
              <tr>
                <td>13:40</td>
                
                
                
                
                
                
                
                
                
                <td rowspan="19" colspan="2"><span class="important">EXCURSIONS</span></td>
                
                
                
                
                
                <td rowspan="21" colspan="2"></td>
                
              </tr>
              <tr>
                <td></td>
                
                <td class="info with_small">PB1<br><span class="small">Chair: Tyler</span></td>
                <td class="info with_small">FN1<br><span class="small">Chair: </span></td>
                <td class="info with_small">OA2<br><span class="small">Chair: </span></td>
                
                <td class="info with_small">OB3<br><span class="small">Chair: Aoyagi</span></td>
                <td class="info with_small">SN2<br><span class="small">Chair: L. Zhao</span></td>
                <td class="info with_small">OA3<br><span class="small">Chair: Okamoto/Spool</span></td>
                
                
                
                
                <td class="info with_small">OB3<br><span class="small">Chair: Ewing</span></td>
                <td class="info with_small">PB2<br><span class="small">Chair: Fletcher</span></td>
                
                
                
              </tr>
              <tr>
                <td>14:00</td>
                
                <td class="invited" rowspan="2"><?php $echo_abstract_link("Ovchinnikova", "344");?></td>
                <td><?php $echo_abstract_link("Gnaser", "268");?></td>
                <td><?php $echo_abstract_link("Fisher", "65");?></td>
                
                <td><?php $echo_abstract_link("Bobrowska", "246");?></td>
                <td><?php $echo_abstract_link("Mazel", "103");?></td>
                <td class="invited" rowspan="2"><?php $echo_abstract_link("Mahoney", "120");?></td>
                
                
                
                
                <td><?php $echo_abstract_link("Wang", "61");?></td>
                <td class="invited" rowspan="2"><?php $echo_abstract_link("Hanley", "62");?></td>
                
                
                
              </tr>
              <tr>
                <td>14:20</td>
                
                
                <td><?php $echo_abstract_link("Go&#322;u&#324;ski", "72");?></td>
                <td><?php $echo_abstract_link("Anderton", "255");?></td>
                
                <td><?php $echo_abstract_link("Mohammadi", "337");?></td>
                <td><?php $echo_abstract_link("Conard", "166");?></td>
                
                
                
                
                
                <td><?php $echo_abstract_link("Milillo", "331");?></td>
                
                
                
                
              </tr>
              <tr>
                <td>14:40</td>
                
                <td><?php $echo_abstract_link("Scholder", "232");?></td>
                <td><?php $echo_abstract_link("Moritani", "329");?></td>
                <td><?php $echo_abstract_link("Radovic", "269");?></td>
                
                <td><?php $echo_abstract_link("Kraft", "320");?></td>
                <td><?php $echo_abstract_link("Kawecki", "178");?></td>
                <td><?php $echo_abstract_link("Heller", "112");?></td>
                
                
                
                
                <td><?php $echo_abstract_link("Jiang", "293");?></td>
                <td><?php $echo_abstract_link("Tyler", "121");?></td>
                
                
                
              </tr>
              <tr>
                <td>15:00</td>
                
                <td><?php $echo_abstract_link("Kollmer", "179");?></td>
                <td><?php $echo_abstract_link("Miyayama", "323");?></td>
                <td class="invited" rowspan="2"><?php $echo_abstract_link("Bailey", "345");?></td>
                
                <td><?php $echo_abstract_link("Fletcher", "277");?></td>
                <td><?php $echo_abstract_link("Ding", "357");?></td>
                <td class="invited_OA3"><?php $echo_abstract_link("Lloyd", "114");?></td>
                
                
                
                
                <td><?php $echo_abstract_link("Moon", "67");?></td>
                <td><?php $echo_abstract_link("Lockyer", "191");?></td>
                
                
                
              </tr>
              <tr>
                <td>15:20</td>
                
                <td><?php $echo_abstract_link("Della Negra", "105");?></td>
                <td><?php $echo_abstract_link("Houssiau", "265");?></td>
                
                
                <td><?php $echo_abstract_link("Gamble", "309");?></td>
                <td><?php $echo_abstract_link("Merkulov", "190");?></td>
                <td><?php $echo_abstract_link("von Sydow", "113");?></td>
                
                
                
                
                <td><?php $echo_abstract_link("Walker", "281");?></td>
                <td><?php $echo_abstract_link("Breuer", "253");?></td>
                
                
                
              </tr>
              <tr>
                <td>15:40</td>
                
                <td><?php $echo_abstract_link("Verkhoturov", "76");?></td>
                <td><?php $echo_abstract_link("Fu", "207");?></td>
                <td><?php $echo_abstract_link("Cloete", "360");?></td>
                
                <td><?php $echo_abstract_link("Panina","383");?></td>
                <td><?php $echo_abstract_link("No&euml;l", "263");?></td>
                <td><?php $echo_abstract_link("Paladino", "127");?></td>
                
                
                
                
                <td><?php $echo_abstract_link("Siketic", "83");?></td>
                <td><?php $echo_abstract_link("Fujii", "343");?></td>
                
                
                
              </tr>
              <tr>
                <td>16:00</td>
                
                <td class="coffee" colspan="3">Coffee</td>
                
                
                
                <td class="coffee" colspan="3">Coffee</td>
                
                
                
                
                
                
                <td class="coffee" colspan="2">Coffee</td>
                
                
                
                
              </tr>
              <tr>
                <td></td>
                
                <td class="info with_small">PB1<br><span class="small">Chair: </span></td>
                <td class="info with_small">FN1<br><span class="small">Chair: Houssiau</span></td>
                <td class="info with_small">OA2<br><span class="small">Chair: Fearn</span></td>
                
                <td class="info with_small">PB1<br><span class="small">Chair: Schweikert</span></td>
                <td class="info with_small">OB3<br><span class="small">Chair: Belu</span></td>
                <td class="info with_small">Vendors<br><span class="small">Chair: Wucher</span></td>
                
                
                
                
                <td class="info with_small">OB4<br><span class="small">Chair: Brunelle</span></td>
                <td class="info with_small">SN3<br><span class="small">Chair: Rysz</span></td>
                
                
                
              </tr>
              <tr>
                <td>16:20</td>
                
                <td><?php $echo_abstract_link("Malmberg", "371");?></td>
                <td><?php $echo_abstract_link("Cristaudo", "300");?></td>
                <td><?php $echo_abstract_link("Gardella", "260");?></td>
                
                <td class="invited" rowspan="2"><?php $echo_abstract_link("Wirtz", "100");?></td>
                <td><?php $echo_abstract_link("Scurr", "180");?></td>
                <td class="vendors" rowspan="5">Vendors Session</td>
                
                
                
                
                <td class="invited" rowspan="2"><?php $echo_abstract_link("Belu", "330");?></td>
                <td><?php $echo_abstract_link("Cyganik", "55");?></td>
                
                
                
              </tr>
              <tr>
                <td>16:40</td>
                
                <td><?php $echo_abstract_link("Micha&#322;owski", "39");?></td>
                <td><?php $echo_abstract_link("Muramoto", "217");?></td>
                <td><?php $echo_abstract_link("Y. Lee", "81");?></td>
                
                
                <td><?php $echo_abstract_link("Munem", "259");?></td>
                
                
                
                
                
                
                <td><?php $echo_abstract_link("Ji", "165");?></td>
                
                
                
              </tr>
              <tr>
                <td>17:00</td>
                
                <td><?php $echo_abstract_link("Lorenz", "306");?></td>
                <td><?php $echo_abstract_link("Bernasik", "110");?></td>
                <td><?php $echo_abstract_link("Sodhi", "304");?></td>
                
                <td><?php $echo_abstract_link("Murdoch", "183");?></td>
                <td><?php $echo_abstract_link("Sj&ouml;vall", "292");?></td>
                
                
                
                
                
                <td><?php $echo_abstract_link("Griesser", "85");?></td>
                <td><?php $echo_abstract_link("Leonard", "49");?></td>
                
                
                
              </tr>
              <tr>
                <td>17:20</td>
                
                <td><?php $echo_abstract_link("Potocnik", "319");?></td>
                <td><?php $echo_abstract_link("Kataoka", "148");?></td>
                <td><?php $echo_abstract_link("Valle", "302");?></td>
                
                <td><?php $echo_abstract_link("Eller", "129");?></td>
                <td><?php $echo_abstract_link("Tian", "314");?></td>
                
                
                
                
                
                <td><?php $echo_abstract_link("Castner", "223");?></td>
                <td><?php $echo_abstract_link("Audinot", "157");?></td>
                
                
                
              </tr>
              <tr>
                <td>17:40</td>
                
                <td><?php $echo_abstract_link("K&ouml;rsgen", "184");?></td>
                <td><?php $echo_abstract_link("Pajek", "315");?></td>
                <td><?php $echo_abstract_link("Peres", "53");?></td>
                
                <td><?php $echo_abstract_link("Jen&#269;i&#269;", "91");?></td>
                <td><?php $echo_abstract_link("Yu", "30");?></td>
                
                
                
                
                
                <td><?php $echo_abstract_link("Pigram", "238");?></td>
                <td><?php $echo_abstract_link("Spampinato", "147");?></td>
                
                
                
              </tr>
              <tr>
                <td>18:00</td>
                
                <td colspan="3" rowspan="6"></td>
                
                <td class="poster" colspan="3" rowspan="6"><a href="boa_toc_posters.php#tuesday">Poster Session</a> 18:00-20:00</td>
                
                <td class="poster" colspan="2" rowspan="6"><a href="boa_toc_posters.php#thursday">Poster Session</a> 18:00-20:00</td>
              </tr>
              <tr>
                <td rowspan="5"></td>
              </tr>
              <tr>
              </tr>
              <tr>
              </tr>
              <tr>
                <td class="banquet" colspan="2" rowspan="2">Conference Banquet 20:00</td>
              </tr>
              <tr>
              </tr>
            </tbody>
          </table>
          
          <h2>Colour legend</h2>
          <table>
            <tbody>
              <tr>
                <td class="plenary">Plenary talk</td>
                <td class="invited">Invited talk</td>
                <td class="bn">B&amp;N talk</td>
                <td class="invited_OA3">Invited for OA3</td>
                <td class="vendors">Vendors session</td>
                <td class="poster">Poster session</td>
                <td class="coffee">Coffee break</td>
                <td class="lunch">Lunch break</td>
                <td class="banquet">Conference banquet</td>
                <td class="info">Session name</td>
              </tr>
            </tbody>
          </table>
        </div>
    </div>
      </div>
    <?php
  require("./includes/footer.html");
  ?>
  </body>

  </html>