<?php
$dbservername = "localhost";
$dbusername = "user";
$dbpassword = "password";
$dbname = "dbname";

try {
    $conn = new PDO("mysql:host=$dbservername;dbname=$dbname;charset=utf8", $dbusername, $dbpassword);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully <br />";
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage() . "<br />";
    }
?>