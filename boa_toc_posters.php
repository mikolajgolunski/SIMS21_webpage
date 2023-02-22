<?php
require "./extras/always_require.php";

//no need to check if logged in

//no need to check if comes from proper page

require "./database/db_connect.php";

$sql = "SELECT id, title, session_assigned FROM abstracts WHERE type_assigned='poster'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$abstracts = array();
while($abstract = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $abstracts[$abstract["id"]] = array("id" => $abstract["id"], "title" => $abstract["title"], "session" => $abstract["session_assigned"]);
}

$sql = "SELECT person_id, presenting FROM abstracts_to_people WHERE abstract_id = ?";
$stmt = $conn->prepare($sql);
foreach(array_keys($abstracts) as $id) {
  $stmt->execute(array($id));
  $abstracts[$id]["people"] = array();
  while($person_id = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $abstracts[$id]["people"][$person_id["person_id"]] = array("id" => $person_id["person_id"], "presenting" => $person_id["presenting"]);
  }
}

$sql = "SELECT full_name FROM people WHERE id=?";
$stmt = $conn->prepare($sql);
foreach(array_keys($abstracts) as $id) {
  foreach($abstracts[$id]["people"] as $person) {
    $stmt->execute(array($person["id"]));
    $name = $stmt->fetch(PDO::FETCH_ASSOC);
    $abstracts[$id]["people"][$person["id"]]["full_name"] = $name["full_name"];
  }
}

$conn = null;

$tuesday = array();
$thursday = array();
$sections = array("FN" => "Fundamentals", "OB" => "Organic and Biological", "SN" => "Semiconductors, Metals and Nanomaterials", "OA" => "Other Applications", "OA3" => "Industrial Session", "PB" => "Pushing the Boundaries", "RM" => "Related Methods");

foreach($abstracts as $abstract) {
  $session = explode("-", $abstract["session"]);
  if($session[0] != "OA3") {
    $cat = substr($session[0],0,2);
  } else {
    $cat = $session[0];
  }
  if($session[1] == "Tue") {
    if(!in_array($cat, array_keys($tuesday))) {
      $tuesday[$cat] = array();
    }
    $tuesday[$cat][intval(substr($session[2],1))] = $abstract;
  } elseif($session[1] == "Thu") {
    if(!in_array($cat, array_keys($thursday))) {
      $thursday[$cat] = array();
    }
    $thursday[$cat][intval(substr($session[2],1))] = $abstract;
  }
}

foreach(array_keys($tuesday) as $category) {
  ksort($tuesday[$category]);
}
foreach(array_keys($thursday) as $category) {
  ksort($thursday[$category]);
}

$_SESSION["last_site"] = "boa_toc_posters";
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
    require('./includes/head.html');
    ?>

    <style type="text/css">
      .td, .th {
        font-size: 0.75em;
        padding-top: 0.2em;
        padding-bottom: 0.2em;
        line-height: 140%;
      }
      
      .title {
        font-weight: bold;
      }
      
      .presenting {
        text-decoration: underline;
      }
      
      .section {
        text-align: center;
        font-weight: bold;
        font-size: 1.2em;
        background-color: lightyellow;
        border-bottom: 1px solid;
        border-top: 1px solid;
        display: table-row;
      }
      
      .main_title {
        text-align: center;
        font-weight: bold;
        font-size: 1.2em;
      }
      
      .td {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: justify;
        -ms-flex-pack: justify;
        justify-content: space-between;
      }
      
      .session {
        font-style: italic;
        font-size: 90%;
        line-height: 90%;
        text-align: right;
        -webkit-box-ordinal-group: 3;
        -ms-flex-order: 2;
        order: 2;
        -ms-flex-preferred-size: auto;
        flex-basis: auto;
        min-width: 8em;
      }
      
      .poster {
        -webkit-box-ordinal-group: 2;
        -ms-flex-order: 1;
        order: 1;
      }
    </style>
      <title>SIMS21, Poland 2017 - Poster sessions</title>
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
              <h1>SIMS21, Poland - Poster sessions</h1>
              
              <div class="table" id="tuesday">
                <div class="thead">
                  <div class="tr">
                    <span class="th main_title">Tuesday</span>
                  </div>
                </div>
                <div class="tbody">
                  <?php
                    foreach(array_keys($sections) as $section_key) {
                      if(in_array($section_key, array_keys($tuesday))){
                        echo "<div class=\"section\">";
                        echo "<span class=\"th\">".$sections[$section_key]."</span>";
                        echo "</div>";
                        foreach($tuesday[$section_key] as $abstract) {
                          echo "<a href=\"boa_poster.php?id=".$abstract["id"]."\" class=\"tr\">";
                          echo "<span class=\"td\"><div class=\"session\">".$abstract["session"]."</div><div class=\"poster\"><span class=\"title\">".html_entity_decode($abstract["title"])."</span><br><span class=\"authors\">";
                          $authors = array();
                          foreach($abstract["people"] as $person) {
                            $author = "";
                            if($person["presenting"]) {
                              $author = $author."<span class=\"presenting\">";
                            }
                            $author = $author.$person["full_name"];
                            if($person["presenting"]) {
                              $author = $author."</span>";
                            }
                            $authors[] = $author;
                          }
                          $authors_out = implode(", ", $authors);
                          echo $authors_out;
                          echo "</span></div></span>";
                          echo "</a>";
                        }
                      }
                    }
                  ?>
                </div>
              </div>
              
              <br><br>
              
              <div class="table" id="thursday">
                <div class="thead">
                  <div class="tr">
                    <span class="th main_title">Thursday</span>
                  </div>
                </div>
                <div class="tbody">
                  <?php
                    foreach(array_keys($sections) as $section_key) {
                      if(in_array($section_key, array_keys($thursday))){
                        echo "<div class=\"section\">";
                        echo "<span class=\"th\">".$sections[$section_key]."</span>";
                        echo "</div>";
                        foreach($thursday[$section_key] as $abstract) {
                          echo "<a href=\"boa_poster.php?id=".$abstract["id"]."\" class=\"tr\">";
                          echo "<span class=\"td\"><div class=\"session\">".$abstract["session"]."</div><div class=\"poster\"><span class=\"title\">".html_entity_decode($abstract["title"])."</span><br><span class=\"authors\">";
                          $authors = array();
                          foreach($abstract["people"] as $person) {
                            $author = "";
                            if($person["presenting"]) {
                              $author = $author."<span class=\"presenting\">";
                            }
                            $author = $author.$person["full_name"];
                            if($person["presenting"]) {
                              $author = $author."</span>";
                            }
                            $authors[] = $author;
                          }
                          $authors_out = implode(", ", $authors);
                          echo $authors_out;
                          echo "</span></div></span>";
                          echo "</a>";
                        }
                      }
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