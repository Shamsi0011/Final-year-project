<?php

include_once("connection.php");

var_dump($_POST);
$cartItemId = $_POST["cartItemId"];
$currentUser = $_POST["currentUser"];
$currentPassHash = $_POST["currentPassHash"];

$dbprequery = "SELECT * FROM users WHERE username = \"$currentUser\" AND passwordHash = \"$currentPassHash\";";
$preresult = $conn->query($dbprequery);
if($preresult && $preresult->num_rows > 0){
    $dbquery = "DELETE FROM cart_items WHERE `user_id` = \"$currentUser\" AND id = \"$cartItemId\"";
    $result = $conn->query($dbquery);
    if($result){
        echo "Deleted successfully";
        var_dump($result);
        echo $dbquery;
    }
    else{
        echo $dbquery;
        echo "Could not delete";
    }
}
else{
    $current_credentials = false;
    echo "Current Username & Password could not be verified";
    echo $dbprequery;
    var_dump($preresult);
    echo $preresult->num_rows;
}


?>