<?php
    include "connection.php";
    $dbquery = "SELECT * FROM publishers";
    $result = $conn->query($dbquery);
    if($result && $result->num_rows>0){
        while($row = mysqli_fetch_assoc($result)){
            $resultArray['_' . $row['publisher_id']] = $row;
        }
        $return_array['result_array'] = $resultArray;
        $return_array["return_title"] = "Success";
        $return_array["return_message"] = "Publishers retrieved successfully";
        $return_array["return_type"] = "success";
        $return_array["query"] = $dbquery;
    }
    else{
        $return_array["return_title"] = "Operation Failed with $result->num_rows number of rows";
        $return_array["return_message"] = "The username and password did not match.";
        $return_array["return_type"] = "error";
        $return_array["query"] = $dbquery;
    }
    echo json_encode($return_array);

?>