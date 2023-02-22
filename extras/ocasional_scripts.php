<?php

/*//Dodanie ludzi zapisanych na strone do bazy mailingowej

require "./extras/always_require.php";

require "./database/db_connect.php";

//$sql = "SELECT full_name, title, email, type, create_time FROM people WHERE (type IS NULL OR (type!='accomp' AND type!='author'))";
$sql = "SELECT people.email as email, CONCAT_WS(' ', people.title, people.full_name) as full_name FROM people INNER JOIN users WHERE people.id = users.person_id AND users.create_time > '2017-07-03' AND people.type != 'removed' AND people.type IS NOT NULL";
$stmt = $conn->prepare($sql);
$stmt->execute();
$people = array();
while($person = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $people[] = $person;
}

$sql = "SELECT email_send, selector FROM mail_list";
$stmt = $conn->prepare($sql);
$stmt->execute();
$selectors = array();
$emails = array();
while($selector = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $selectors[] = $selector["selector"];
  $emails[] = $selector["email_send"];
}

$sql = "INSERT INTO mail_list SET email_send=:email, full_name=:name, selector=:selector, create_time=NULL";
$stmt = $conn->prepare($sql);
foreach($people as $person) {
  $selector = generateSelector();
  while(in_array($selector, $selectors)) {
    $selector = generateSelector();
  }
  
  if(in_array($person["email"], $emails)) {
    continue;
  } else {
    $selectors[] = $selector;
    $emails[] = $person["email"];
    
    //$abc = array("email" => $person["email"], "name" => $person["title"]." ".$person["full_name"], "selector" => $selector, "time" => $person["create_time"]);
    //echo pretty_dump($abc);
    //echo "<br><br>";
    
    $stmt->execute(array("email" => $person["email"], "name" => $person["full_name"], "selector" => $selector));
  }
}

$conn = null;*/

//Przeniesienie id osoby i jej afiliacji z tabeli people do tabeli affiliations_to_people
/*require "./extras/always_require.php";

require "./database/db_connect.php";

$sql = "SELECT id, affiliation_id FROM people WHERE affiliation_id IS NOT NULL";
$stmt = $conn->prepare($sql);
$stmt->execute();
$people = array();
while($person = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $people[] = $person;
}

$sql = "INSERT INTO affiliations_to_people SET affiliation_id=:affiliation_id, person_id=:person_id, create_time=NULL";
$stmt = $conn->prepare($sql);
foreach($people as $person) {
  $stmt->execute(array("affiliation_id" => $person["affiliation_id"], "person_id" => $person["id"]));
}

$conn = null;*/
?>