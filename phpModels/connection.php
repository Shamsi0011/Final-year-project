<?php

$dbserver = "localhost";
$dbname = "books_buying_selling";
$dbuser = "root";
$dbtable = "users";
$dbpass = "";
$conn = new mysqli($dbserver, $dbuser, $dbpass, $dbname);
if($conn->connect_error){
    die("Connection Failed" . $conn->connect_error);
}

?>
