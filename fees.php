<?php
require "./extras/always_require.php";

//no need to check if logged in

//no need to check if comes from proper page

$_SESSION["last_site"] = "fees";
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

      <style type="text/css">
        th {
          text-align: right;
        }
        
        .additional {
          padding-top: 0;
          margin-top: 0;
        }
      </style>

      <title>SIMS21, Poland 2017 - Conference Fees</title>
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
              <div style="text-align: justify;">

                <h1>Conference Fees</h1>
                <table>
                  <thead>
                    <tr>
                      <th>Conference Fees</th>
                      <th>On or before June&nbsp;30, 2017</th>
                      <th>After June&nbsp;30, 2017</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td align="right">Full</td>
                      <td align="right"><?php echo number_format($fees["regular"]["early"],0,".","&nbsp;");?>&nbsp;PLN</td>
                      <td align="right"><?php echo number_format($fees["regular"]["late"],0,".","&nbsp;");?>&nbsp;PLN</td>
                    </tr>
                    <tr>
                      <td align="right">Student</td>
                      <td align="right"><?php echo number_format($fees["student"]["early"],0,".","&nbsp;");?>&nbsp;PLN</td>
                      <td align="right"><?php echo number_format($fees["student"]["late"],0,".","&nbsp;");?>&nbsp;PLN</td>
                    </tr>
                    <tr>
                      <td align="right">One Day Attendee</td>
                      <td align="right"><?php echo number_format($fees["one_day"]["early"],0,".","&nbsp;");?>&nbsp;PLN</td>
                      <td align="right"><?php echo number_format($fees["one_day"]["late"],0,".","&nbsp;");?>&nbsp;PLN</td>
                    </tr>
                    <tr>
                      <td align="right">IUVSTA Short Course</td>
                      <td align="right"><?php echo number_format($fees["short_course"]["early"],0,".","&nbsp;");?>&nbsp;PLN</td>
                      <td align="right"><?php echo number_format($fees["short_course"]["late"],0,".","&nbsp;");?>&nbsp;PLN</td>
                    </tr>
                    <tr>
                      <td align="right">Exhibitors</td>
                      <td align="right"><?php echo number_format($fees["exhibitor"]["early"],0,".","&nbsp;");?>&nbsp;PLN</td>
                      <td align="right"><?php echo number_format($fees["exhibitor"]["late"],0,".","&nbsp;");?>&nbsp;PLN</td>
                    </tr>
                    <tr>
                      <td align="right">Accompanying Person</td>
                      <td align="right"><?php echo number_format($fees["accomp"]["early"],0,".","&nbsp;");?>&nbsp;PLN</td>
                      <td align="right"><?php echo number_format($fees["accomp"]["late"],0,".","&nbsp;");?>&nbsp;PLN</td>
                    </tr>
                  </tbody>
                </table>
                
                <p>The <strong>Full</strong> registration fee includes: Book of Abstracts, Conference Proceedings, Welcome Reception, Excursion, Conference Dinner, Lunches, Drinks and Snacks during Coffee Breaks.</p>
                
                <p>The <strong>Student</strong> fee includes the same as the Full Registration, except for the Conference Proceedings. Students are required to deliver letters from their thesis supervisors, with the supervisor's full contact details, to confirm they will have student status on September&nbsp;10, 2017. Letters should be emailed to <a href="mailto:secretary@sims21.org?Subject=Student%20status%20confirmation%20letter">the Conference Secretariat</a> with subject &quot;Student status confirmation letter&quot; before September&nbsp;9, 2017.</p>

                <p>The <strong>One Day Attendee</strong> fee includes: Sessions, Lunch on the day registered, Drinks and Snacks during Coffee Breaks on the day registered, Book of Abstracts.</p>

                <p>The <strong>IUVSTA Short Course</strong> registration includes: Short Course Presentation Materials and Drinks and Snacks during Coffee Break. It is possible to apply for a reduced fee. For details, please consult the <a href="short_course.php" class="menu-item">IUVSTA Short Course</a> page.</p>

                <p>The <strong>Accompanying Person</strong> registration fee includes: Welcome Reception, Excursion and Conference Dinner.</p>

                <p>The conference fee can be paid by credit card or bank transfer. <strong>On-site payment can be made by credit card only. Payments by American Express Card will not be accepted.</strong></p>
                <p>Follow <a href="register_participant1.php">this link</a> to register and pay the conference fee. <strong>Registration and fee payment should be done separately for conference participants and accompanying persons</strong>. Register yourself first and then use <span class="menu-item">Add accompanying person(s)</span> from <span class="menu-item">My account</span> to register accompanying person(s). <strong>Independent registration of conference participants and their companions allows to use separate credit cards for fee payments</strong>.</p> 

                <p>The conference fees are converted into different currencies as a guide in the table below. These values are based on the current average exchange rate of the Polish National Bank. All conference payments must be made in PLN.</p>
                
                <?php
                $askGoogle = file_get_contents('http://www.nbp.pl/home.aspx?f=/kursy/kursya.html');
                $askGoogle = str_ireplace(",",".",$askGoogle);
                $askGoogle = strip_tags($askGoogle);
                $askGoogle = strstr($askGoogle,"waluty");
                $match = strstr($askGoogle,"1 EUR");
                sscanf($match,"1 EUR %f",$euro);
                $match = strstr($askGoogle,"1 USD");
                sscanf($match,"1 USD %f",$dollar);
                $match = strstr($askGoogle,"1 GBP");
                sscanf($match,"1 GBP %f",$gbp);
                $match = strstr($askGoogle,"100 JPY");
                sscanf($match,"100 JPY %f",$jpy);
                $match = strstr($askGoogle,"1 CNY");
                sscanf($match,"1 CNY %f",$cny);
                $match = strstr($askGoogle,"100 KRW");
                sscanf($match,"100 KRW %f",$krw);
                $match = strstr($askGoogle,"1 RUB");
                sscanf($match,"1 RUB %f",$rub);

                //$dollar=3.9856;
                //$euro=4.3424;
                //$gbp=4.9390;
                //$jpy=3.7538;
                //$cny=0.5865;
                //$krw=0.3452;
                //$rub=0.0628;

                $exchange_rates = array();
                $euro_s["regular"] = number_format($fees_current["regular"]/$euro,0,'.','&nbsp;');
                $dollar_s["regular"] = number_format($fees_current["regular"]/$dollar,0,'.','&nbsp;');
                $gbp_s["regular"] = number_format($fees_current["regular"]/$gbp,0,'.','&nbsp;');
                $jpy_s["regular"] = number_format($fees_current["regular"]/$jpy*100,0,'.','&nbsp;');
                $krw_s["regular"] = number_format($fees_current["regular"]/$krw*100,0,'.','&nbsp;');
                $cny_s["regular"] = number_format($fees_current["regular"]/$cny,0,'.','&nbsp;');
                $rub_s["regular"] = number_format($fees_current["regular"]/$rub,0,'.','&nbsp;');
                $pln_s["regular"] = number_format($fees_current["regular"],0,'.','&nbsp;');

                $euro_s["student"] = number_format($fees_current["student"]/$euro,0,'.','&nbsp;');
                $dollar_s["student"] = number_format($fees_current["student"]/$dollar,0,'.','&nbsp;');
                $gbp_s["student"] = number_format($fees_current["student"]/$gbp,0,'.','&nbsp;');
                $jpy_s["student"] = number_format($fees_current["student"]/$jpy*100,0,'.','&nbsp;');
                $krw_s["student"] = number_format($fees_current["student"]/$krw*100,0,'.','&nbsp;');
                $cny_s["student"] = number_format($fees_current["student"]/$cny,0,'.','&nbsp;');
                $rub_s["student"] = number_format($fees_current["student"]/$rub,0,'.','&nbsp;');
                $pln_s["student"] = number_format($fees_current["student"],0,'.','&nbsp;');

                ?>

                    <table frame="box" rules="all">
                      <thead>
                        <tr>
                          <th class="center"><img src="./img/flag_pl.png">&nbsp;PLN</th>
                          <th class="center"><img src="./img/flag_eu.png">&nbsp;EURO</th>
                          <th class="center"><img src="./img/flag_us.png">&nbsp;USD</th>
                          <th class="center"><img src="./img/flag_gb.png">&nbsp;GBP</th>
                          <th class="center"><img src="./img/flag_jp.png">&nbsp;JPY</th>
                          <th class="center"><img src="./img/flag_cn.png">&nbsp;CNY</th>
                          <th class="center"><img src="./img/flag_kr.png">&nbsp;KRW</th>
                          <th class="center"><img src="./img/flag_ru.png">&nbsp;RUB</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <th class="center">
                            <?php echo $pln_s["regular"];?>
                          </td>
                          <td class="center">
                            <?php echo $euro_s["regular"];?>
                          </td>
                          <td class="center">
                            <?php echo $dollar_s["regular"];?>
                          </td>
                          <td class="center">
                            <?php echo $gbp_s["regular"];?>
                          </td>
                          <td class="center">
                            <?php echo $jpy_s["regular"];?>
                          </td>
                          <td class="center">
                            <?php echo $cny_s["regular"];?>
                          </td>
                          <td class="center">
                            <?php echo $krw_s["regular"];?>
                          </td>
                          <td class="center">
                            <?php echo $rub_s["regular"];?>
                          </td>
                        </tr>
                        <tr>
                          <th class="center">
                            <?php echo $pln_s["student"];?>
                          </td>
                          <td class="center">
                            <?php echo $euro_s["student"];?>
                          </td>
                          <td class="center">
                            <?php echo $dollar_s["student"];?>
                          </td>
                          <td class="center">
                            <?php echo $gbp_s["student"];?>
                          </td>
                          <td class="center">
                            <?php echo $jpy_s["student"];?>
                          </td>
                          <td class="center">
                            <?php echo $cny_s["student"];?>
                          </td>
                          <td class="center">
                            <?php echo $krw_s["student"];?>
                          </td>
                          <td class="center">
                            <?php echo $rub_s["student"];?>
                          </td>
                        </tr>
                      </tbody>
                    </table>

              </div>
              <h3>Cancellations </h3>
		<p>For participants:</p>
              <ul>
                <li>Before July&nbsp;1, 2017: full reimbursement minus a 250 PLN administration fee.</li>
                <li>From July&nbsp;1, 2017 until August&nbsp;1, 2017: 50% reimbursement.</li>
                <li>After August&nbsp;1, 2017: no reimbursement.</li>
              </ul>

              <p>The cancellation of a Conference or Short Course registration must be received in writing. Any request for cancellation may be emailed to <a href="mailto:cancellation@sims21.org?Subject=Cancellation%20request">cancellation@sims21.org</a>.</p>
	     <h3>Insurance and Liability</h3>
	     <ul>
		<li>The registration fee does not include property or personal insurance. Participantes are advised to make their own arrangements regarding travel insurance and medical assistance during the conference.</li>
           	<li>The Conference Secretariat, Organizing Committees and Organizing Institutions are not able to take any responsibility, whatsoever, for injury and damage to person or properties during the meeting.</li>
    		<li>In the event that the SIMS21 conference cannot be held or is postponed due to events beyond the control of the Conference Organizers or due to events which are not attributable to wrongful intent or gross negligence of the Conference Organizers, the Conference Organizers cannot be held liable by attendees for any damages, costs, or losses incurred, such as transportation costs, accommodation costs, financial losses, or any other indirect losses or consequential damages.</li>
	     </ul>
             <p><I><font size="-2">All terms of participation at the SIMS21 conference are provided at the Conference Website. </br>Regulamin uczestnictwa w konferencji SIMS21 w j&#281;zyku polskim mo&#380;na pobra&#263; <a href="./resources/regulamin_konferencji_SIMS21.pdf">tutaj</a></I>.</p></font> 
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
