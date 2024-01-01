<?php

    include "connection.php";

    $table = $_POST["table"];
    $label = $_POST["label"];
    $value = $_POST["value"];

    $dbquery = "SELECT $label, $value FROM $table";
    if(isset($_POST["filter"])) {
        $filter = $_POST["filter"];
        $dbquery .= " WHERE country_name = '$filter'";
    }
    $result = $conn->query($dbquery);
    $resultArray = [];
    while($row = mysqli_fetch_assoc($result)){
        $resultArray[$row["$label"]]=$row["$value"];
    }

    $returnArray["dbquery"] = $dbquery;
    $returnArray["result"] = $result;
    $returnArray["values"] = $resultArray;

    $returnJSON = json_encode($returnArray);

    echo $returnJSON;

?>