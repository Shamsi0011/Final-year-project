<?php

include_once("connection.php");

$search_term = $_POST["search_term"];
$user_type = $_POST["user_type_title"];
$sort = $_POST["sort"];
$direction = $_POST["direction"];

$dbquery = "SELECT * FROM user_list";
if($search_term != "" && $user_type != ""){
    $dbquery .=  " WHERE (username RLIKE '$search_term' OR fullname RLIKE '$search_term')";
    $dbquery .=  " AND user_type_title = '$user_type'";
}
else if($search_term != "" && $user_type == ""){
    $dbquery .=  " WHERE (username RLIKE '$search_term' OR fullname RLIKE '$search_term')";
}
else if($search_term == "" && $user_type != ""){
    $dbquery .=  " WHERE user_type_title = \"$user_type\"";
}
else{
    $dbquery .= "";
}

$dbquery .= " ORDER BY $sort $direction;";


$result = $conn->query($dbquery);

$resultArray = array();
if($result){
    while ($row = mysqli_fetch_assoc($result)){
        $resultArray[$row['username']] = $row;
                    }
}
else{
    $resultArray["error"] = "Nothing returned";
    $resultArray["query"] = $dbquery;
    $returnJSON = json_encode($resultArray);
    echo $returnJSON;
}



if($resultArray){
$returnJSON = json_encode($resultArray);
echo $returnJSON;
}
else{
    $resultArray["error"] = "Nothing returned";
    $returnJSON = json_encode($resultArray);
    echo $returnJSON;
}

?>