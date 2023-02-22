<?php
require('db_connect.php');

$ok = false;
if ($file = file_get_contents("database.sql")){
    foreach(explode(";", $file) as $query){
        $query = trim($query);
        if (!empty($query) && $query != ";"){
            try{
                $ok = $conn->exec($query);
            } catch(PDOException $exception){
                echo $query . "<br />" . $exception->getMessage();
            }
        }
    }
    if($ok){
        echo "<br /> Database created successfuly.";
    } else {
        echo "<br /> There was an error while creating database.";
    }
} else {
    echo "<br /> Unable to open database script.";
}

$conn = null;
?>