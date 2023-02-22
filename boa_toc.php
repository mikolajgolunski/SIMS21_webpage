<?php
require "./extras/always_require.php";

//no need to check if logged in

//no need to check if comes from proper page

require "./database/db_connect.php";

$sql = "SELECT id, title FROM abstracts";
$stmt = $conn->prepare($sql);
$stmt->execute();

$abstracts = array();
while($abstract = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $abstracts[$abstract["id"]] = array("title" => $abstract["title"]);
}

$sql = "SELECT person_id FROM abstracts_to_people WHERE abstract_id = ? AND presenting";
$stmt = $conn->prepare($sql);
foreach(array_keys($abstracts) as $id) {
  $stmt->execute(array($id));
  $person_id = $stmt->fetch(PDO::FETCH_ASSOC);
  $abstracts[$id]["person_id"] = $person_id["person_id"];
}

$sql = "SELECT full_name FROM people WHERE id=?";
$stmt = $conn->prepare($sql);
foreach(array_keys($abstracts) as $id) {
  $stmt->execute(array($abstracts[$id]["person_id"]));
  $person = $stmt->fetch(PDO::FETCH_ASSOC);
  $abstracts[$id]["full_name"] = $person["full_name"];
}

$sql = "SELECT affiliation_id FROM affiliations_to_people WHERE person_id=?";
$stmt = $conn->prepare($sql);
foreach(array_keys($abstracts) as $id) {
  $stmt->execute(array($abstracts[$id]["person_id"]));
  $abstracts[$id]["affiliations_ids"] = array();
  while($affiliation_id = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $abstracts[$id]["affiliations_ids"][] = $affiliation_id["affiliation_id"];
  }
}

$sql = "SELECT affiliation1, country FROM affiliations WHERE id=?";
$stmt = $conn->prepare($sql);
foreach(array_keys($abstracts) as $id) {
  $abstracts[$id]["affiliations"] = array();
  foreach($abstracts[$id]["affiliations_ids"] as $affiliation_id) {
    $stmt->execute(array($affiliation_id));
    $affiliation = $stmt->fetch(PDO::FETCH_ASSOC);
    $abstracts[$id]["affiliations"][] = array("affiliation1" => $affiliation["affiliation1"], "country" => $affiliation["country"]);
  }
}

$conn = null;

$_SESSION["last_site"] = "boa_toc";
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
    require('./includes/head.html');
    ?>

    <style type="text/css">
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
              
              <div class="table">
                <div class="thead">
                  <div class="tr">
                    <span class="th">Nr</span>
                    <span class="th">Title</span>
                    <span class="th">Presenting author</span>
                    <span class="th">Affiliation</span>
                    <span class="th">Country</span>
                  </div>
                </div>
                <div class="tbody">
                  <?php
                    $i = 1;
                    foreach(array_keys($abstracts) as $id) {
                      echo "<a href=\"boa.php?id=".$id."\" class=\"tr\">\n";
                      echo "<span class=\"td\">".$i."</span>\n";
                      echo "<span class=\"td\">".html_entity_decode($abstracts[$id]["title"])."</span>\n";
                      echo "<span class=\"td\">".$abstracts[$id]["full_name"]."</span>\n";
                      $affiliations1 = array();
                      $countries = array();
                      foreach($abstracts[$id]["affiliations"] as $affiliation) {
                        $affiliations1[] = $affiliation["affiliation1"];
                        $countries[] = $affiliation["country"];
                      }
                      $affiliations1 = implode("<hr>", $affiliations1);
                      echo "<span class=\"td\">".$affiliations1."</span>\n";
                      $countries = implode("<hr>", $countries);
                      echo "<span class=\"td\">".$countries."</span>\n";
                      echo "</a>\n";
                      $i++;
                    }
                  ?>
                </div>
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
