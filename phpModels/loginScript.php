<?php

include_once("connection.php");


$username = $_POST["username"];
$passwordHash = $_POST['passwordHash'];

$dbquery = "SELECT * FROM $dbtable WHERE username = '$username' AND passwordHash = '$passwordHash'";

$result = $conn->query($dbquery);

$return_array = ["query" => $dbquery, "return_title" => "", "return_message" => "", "return_type" => ""];

if($result->num_rows > 0){
    $resultArray = mysqli_fetch_assoc($result);
        if($resultArray['approval']==1){
                $return_array["return_title"] = "Logged In";
        $return_array["return_message"] = "The username and password are valid.";
        $return_array["return_type"] = "success";
    }
    else{
        $return_array["return_title"] = "Unapproved Username";
        $return_array["return_message"] = "This username has not yet been approved by the administrator.";
        $return_array["return_type"] = "error";    
    }
}
else{
        $return_array["return_title"] = "Invalid username/password";
    $return_array["return_message"] = "The username and password did not match.";
    $return_array["return_type"] = "error";
}

$return_JSON = json_encode($return_array);

echo $return_JSON;
?>