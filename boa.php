<?php
require "./extras/always_require.php";

//no need to check if logged in

//no need to check if comes from proper page

if(!empty($_GET["id"])) {

  require "./database/db_connect.php";
  
  $sql = "SELECT COUNT(id) AS count FROM abstracts WHERE id=?";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array($_GET["id"]));
  $nr = $stmt->fetch(PDO::FETCH_ASSOC);
  if($nr["count"] > 0) {

    $sql = "SELECT id, title, text, topics, file FROM abstracts WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($_GET["id"]));
    $abstract = $stmt->fetch(PDO::FETCH_ASSOC);

    $sql = "SELECT person_id, presenting FROM abstracts_to_people WHERE abstract_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($abstract["id"]));
    $people = array();
    while($person = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $people[$person["person_id"]] = array("person_id" => $person["person_id"], "presenting" => $person["presenting"]);
    }

    $sql = "SELECT full_name FROM people WHERE id=?";
    $stmt = $conn->prepare($sql);
    foreach($people as $person) {
      $stmt->execute(array($person["person_id"]));
      $author = $stmt->fetch(PDO::FETCH_ASSOC);
      $people[$person["person_id"]]["full_name"] = $author["full_name"];
    }
    
    $sql = "SELECT affiliation_id FROM affiliations_to_people WHERE person_id=?";
    $stmt = $conn->prepare($sql);
    foreach($people as $person) {
      $stmt->execute(array($person["person_id"]));
      $people[$person["person_id"]]["affiliations_ids"] = array();
      while($affiliation_id = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $people[$person["person_id"]]["affiliations_ids"][] = $affiliation_id["affiliation_id"];
      }
    }

    $sql = "SELECT id, affiliation1, affiliation2, country, state, city, street, zipcode FROM affiliations WHERE id=?";
    $stmt = $conn->prepare($sql);
    $affiliations = array();
    $i = 1;
    foreach($people as $person) {
      foreach($person["affiliations_ids"] as $affiliation_id) {
        if(!in_array($affiliation_id, array_keys($affiliations))) {
          $stmt->execute(array($affiliation_id));
          $affiliation = $stmt->fetch(PDO::FETCH_ASSOC);
          $affiliations[$affiliation["id"]]["nr"] = $i;
          $affiliations[$affiliation["id"]]["affiliation_id"] = $affiliation["id"];
          $affiliations[$affiliation["id"]]["affiliation1"] = $affiliation["affiliation1"];
          $affiliations[$affiliation["id"]]["affiliation2"] = $affiliation["affiliation2"];
          $affiliations[$affiliation["id"]]["country"] = $affiliation["country"];
          $affiliations[$affiliation["id"]]["state"] = $affiliation["state"];
          $affiliations[$affiliation["id"]]["city"] = $affiliation["city"];
          $affiliations[$affiliation["id"]]["street"] = $affiliation["street"];
          $affiliations[$affiliation["id"]]["zipcode"] = $affiliation["zipcode"];

          $i++;
        }
      }
    }

    $conn = null;
  }
}

$_SESSION["last_site"] = "boa";
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
    require('./includes/head.html');
    ?>

    <style type="text/css">
      #presenting {
        text-decoration: underline;
      }

      #title {
        font-weight: bold;
      }
    </style>
      <title>SIMS21, Poland 2017 - Book of abstracts</title>
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
              <h1>SIMS21, Poland - Book of abstracts</h1>
              
              <?php if(!empty($_GET["id"]) && $nr["count"] > 0): ?>
              
              <div id="main_info">
                <p>File: <a href="abstracts/<?php echo $abstract["file"];?>"><?php echo $abstract["file"];?></a></p>
                <p id="title">
                  <?php echo htmlspecialchars_decode(nl2br($abstract["title"],false));?>
                </p>
                <p id="authors">
                  <?php
                  $authors = array();
                  foreach($people as $author) {
                    $author_out = "";
                    if($author["presenting"]){
                      $author_out = $author_out."<span id=\"presenting\">";
                    }
                    $author_out = $author_out.$author["full_name"];
                    if($author["presenting"]){
                      $author_out = $author_out."</span>";
                    }
                    if(count($affiliations) > 1) {
                      $affiliations_nrs = array();
                      foreach($author["affiliations_ids"] as $affiliation_id) {
                        $affiliations_nrs[] = $affiliations[$affiliation_id]["nr"];
                      }
                      sort($affiliations_nrs);
                      $affiliations_nrs = implode(",", $affiliations_nrs);
                      $author_out = $author_out."<sup>".$affiliations_nrs."</sup>";
                    }
                    $authors[] = $author_out;
                  }
                  echo implode(", ", $authors);
                  ?>
                </p>
                <p id="affiliations">
                  <?php
                  $affiliations_out = array();
                  foreach($affiliations as $affiliation) {
                    if(count($affiliations) > 1) {
                      $affiliation_out = "<sup>".$affiliation["nr"]."</sup> ";
                    } else {
                      $affiliation_out = "";
                    }
                    $affiliation_out = $affiliation_out.$affiliation["affiliation1"];
                    if (!empty($affiliation["affiliation2"]) and $affiliation["affiliation2"] != "") {
                      $affiliation_out = $affiliation_out." - ".$affiliation["affiliation2"];
                    }
                    $affiliation_out = $affiliation_out.", ".$affiliation["street"].", ";
                    if($affiliation["country"] == "United States") {
                      $affiliation_out = $affiliation_out.$affiliation["state"]." ";
                    }
                    $affiliation_out = $affiliation_out.$affiliation["zipcode"]." ".$affiliation["city"].", ".$affiliation["country"];
                    $affiliations_out[] = $affiliation_out;
                  }
                  echo implode("<br>\n", $affiliations_out);
                  ?>
                </p>
                <p>
                  <?php echo htmlspecialchars_decode(nl2br($abstract["text"], false))?>
                </p>
              </div>
              <div id="topics_info">
                <h2>Selected topics:</h2>
                <ul>
                  <?php
                  foreach(explode(";", $abstract["topics"]) as $topic) {
                    echo "<li>".$topic."</li>\n";
                  }
                  ?>
                </ul>
              </div>
              
              <?php else:?>
              
              <p>No abstract with such an ID available.</p>
              
              <?php endif;?>
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
