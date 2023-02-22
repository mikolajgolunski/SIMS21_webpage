<div id="left-side">
  <?php if (!empty($_SESSION["mod"]["user_id"]) && $_SESSION["mod"]["user_id"] != $_SESSION["user_id"]):?>
  <p><a href="../mod_choose_action.php">Get my identity back.</a></p>
  <?php endif;?>
  <div id='cssmenu' onmouseover='submenu_check()'>
    <ul>

      <li class='active has-sub'><a href='#'>General Information</a>
        <ul>
          <li><a href='index.php'>Welcome</a></li>
          <li><a href='general.php'>Scope</a></li>
          <li><a href='committees.php'>Committees</a></li>
        </ul>
      </li>
      
      <li class='active has-sub'><a href='#'>IC Committee Nominations</a>
        <ul>
          <li><a href='elections.php'>Committee Elections</a></li>
          <li><a href='nominations.php'>North America</a></li>
          <li><a href='nominations.php#europe'>Europe</a></li>
          <li><a href='nominations.php#asia_pacific'>Asia-Pacific</a></li>
        </ul>
      </li>

      <li><a href='important.php'>Important Dates</a></li>

      <li class="active has-sub"><a href="#">Scientific Program</a>
        <ul>
          <li><a href="./oral_table.php" target="_blank">Schedule</a></li>
          <li><a href="./invited.php">Plenary Speakers</a></li>
          <li><a href="./invited.php">Invited Speakers</a></li>
          <li><a href="./honorary_session.php">Honorary Session</a></li>
          <li><a href="./vendors_session.php">Vendors Session</a></li>
          <li><a href="./presentation_guidelines.php">Presentation Guidelines</a></li>
          <li><a href="./proceedings.php">Proceedings</a></li>
        </ul>
      </li>

      <li class='active has-sub'><a href='#'>Social Program</a>
        <ul>
          <li><a href='social.php'>General Program</a></li>
          <li><a href='social_accomp.php'>Accompanying Persons</a></li>
        </ul>
      </li>

      <li><a href='short_course.php'>IUVSTA Short Course</a></li>

      <li><a href='industrial.php'>Industrial Session</a></li>

      <li class='active has-sub'><a href='#'>Abstracts</a>
        <ul>
          <li><a href='abstract.php'>Guidelines</a></li>
          <li><a href="abstract_submission_help.php">Submission Guidelines</a></li>
          <li><a href='abstract_upload1.php'>New submission</a></li>
          <?php /*
	<li><span class="unavailable">New submission<br><span class="unavailable-date">(Closed)</span></span></li>
	 */   ?>
        </ul>
      </li>

      <li class='active has-sub'><a href='#'>Registration</a>
        <ul>
          <li><a href='registration_onsite.php'>On-site registration</a></li>
          <li><a href='fees.php'>Fees</a></li>
          <li>
            <?php if($_SESSION["registered"]):?>
            <span class="unavailable">Registration<br><span class="unavailable-date">(already registered)</span></span>
            <?php else:?>
            <a href='register_participant1.php'>Register</a>
            <?php endif;?>
          </li>
        </ul>
      </li>

      <li class='active has-sub'><a href='#'>Travel &amp; Accommodation</a>
        <ul>
          <li><a href='venue.php'>Venue</a></li>
          <li><a href='travel_and_visas.php'>Travel and Visas</a></li>
          <li><a href='discounted_flights.php'>Discounted Flights</a></li>
          <li><a href='beyond_the_conference.php'>Beyond the Conference</a></li>
          <li><a href='accommodation.php'>Accommodation</a></li>
        </ul>
      </li>

      <li class='active has-sub'><a href='grants.php'>Grants &amp; Awards</a>
        <ul>
          <li><a href='rowland_award.php'>Rowland Hill Awards</a></li>
          <li><a href='iaea_grants.php'>IAEA Travel Grants</a></li>
          <li><a href='iuvsta_grants.php'>IUVSTA Short Course Grants</a></li>
          <li><a href='awards.php'>Student Presentation Awards</a></li>
          <li><a href='student_grants.php'>Student Grants</a></li>
          <li><a href='discounted_flights.php'>Discounted Flights</a></li>
        </ul>
      </li>

      <li class='active has-sub'><a href='#'>Exhibition&nbsp;/ Sponsorship</a>
        <ul>
          <li><a href="./opportunities.php">Oportunities</a></li>
          <li><a href="./sponsors.php">Sponsors</a></li>
          <li><a href="./sponsors.php#exhibitors">Exhibitors</a></li>
          <li><a href="./sponsors.php#map">Exhibition Map</a></li>
        </ul>
      </li>

      <li><a href='positions.php'>Open Positions</a></li>
      <li><a href='satellite_conferences.php'>Satellite Meetings</a></li>

      <li class="active has-sub"><a href="#">My Account<?php echo isset($_SESSION["login"]) ? " (".$_SESSION["login"].")" : "";?></a>
        <ul>
          <?php if(!isset($_SESSION["login"]))://not logged in?>
          <li><a href="login.php">Login</a></li>
          <li><a href="create_account.php">Create new account</a></li>
          <?php else://logged in?>
          <li><a href="user_summary.php">Summary</a></li>
          <li><a href="abstract_upload1.php">New Submission</a></li>
          <?php /*
        <li><span class="unavailable">New submission<br><span class="unavailable-date">(closed)</span></span></li>
         */   ?>
          <li>
            <?php if($_SESSION["registered"]):?>
            <span class="unavailable">Registration<br><span class="unavailable-date">(already registered)</span></span>
            <?php else:?>
            <a href='register_participant1.php'>Registration</a>
            <?php endif;?>
          </li>
          <li>
            <?php if($_SESSION["registered"] && $_SESSION["paid"]["accomp"] == 0):?>
            <a href="register_accomp1.php"><?php echo $_SESSION["accomp_nr"] > 0 ? "Edit accompanying person(s)" : "Add accompanying person(s)";?></a>
            <?php elseif($_SESSION["registered"] && $_SESSION["paid"]["accomp"] > 0):?>
            <span class="unavailable"><?php echo $_SESSION["accomp_nr"] > 0 ? "Edit accompanying person(s)" : "Add accompanying person(s)";?><br><span class="unavailable-date">(already paid)</span></span>
            <?php else:?>
            <span class="unavailable"><?php echo $_SESSION["accomp_nr"] > 0 ? "Edit accompanying person(s)" : "Add accompanying person(s)";?><br><span class="unavailable-date">(register yourself first)</span></span>
            <?php endif;?>
          </li>
          <li><a href="change_user_info.php">Change Personal Information</a></li>
          <li><a href="change_password.php">Change Password</a></li>
          <li><a href="logout.php#openModal">Logout</a></li>
          <?php endif;//end login if?>
        </ul>
      </li>
      <li><a href="photos.php"  target="_blank">Conference Photos</a></li>
      
      <li><a href='newsletter.php'>Newsletter</a></li>

      <li><a href='contacts.php'>Contacts</a></li>

      <?php if(isset($_SESSION["access_type"]) and $_SESSION["access_type"] == "admin"):?>
      <li><span class="unavailable">&nbsp;</span></li>
      <li class="active has-sub"><a href="#">Admin tools</a>
        <ul>
          <li><a href="boa_toc.php">Book of abstracts</a></li>
          <li><a href="mod_choose_user.php">Interact with user</a></li>
          <li><a href="mod_additional_payment.php">Add payment</a></li>
          <li><a href="mod_newsletter.php">Send newsletter</a></li>
          <li><a href="mod_checkdb.php">Check database</a></li>
          <li><a href="mod_backup.php">Database backup</a></li>
          <li><a href="mod_cleanup.php">Database cleanup</a></li>
        </ul>
      </li>
      <?php endif;?>

    </ul>
  </div>
  
  <hr>
  
  <img src="./img/smok_.png" alt="SIMS21 in Krak&oacute;w dragon." style="width:150px;">
</div>
