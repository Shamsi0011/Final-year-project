<?php

    include "connection.php";
        $currentUser = $_POST["currentUser"];
    $currentPassHash = $_POST["currentPassHash"];

        $dbprequery = "SELECT * FROM users WHERE users.username = \"$currentUser\" AND  users.passwordHash = \"$currentPassHash\" AND users.user_type = 1;"; 
    $preresult = $conn->query($dbprequery);
    if($preresult && $preresult->num_rows > 0){
        $dbquery = "SELECT users.username, users.passwordHash, users.user_type, user_types.user_type_title, users.join_on, users.approval, user_info.firstname, user_info.lastname, user_info.gender, user_info.date_of_birth, user_info.email, user_info.cell_no, user_info.cnic, user_info.street_address, user_info.city, user_info.country, user_info.display_pic_url FROM users, user_info, user_types WHERE users.username = user_info.username AND users.user_type = user_types.user_type_id AND approval = 0";
        $result = $conn->query($dbquery);
        if($result && $result->num_rows > 0){
            while($row = mysqli_fetch_assoc($result)){
                $resultArray['_' . $row['username']] = $row;
            }
            $returnArray["result_array"] = $resultArray;
            $returnArray["return_title"] = "Success";
            $returnArray["return_message"] = "Pending usernames were found";
            $returnArray["return_type"] = "success";
            $returnArray["query"] = $dbprequery . " and " . $dbquery;
        }
        else{
            $returnArray["error"] = "No pending users";
            $returnArray["return_title"] = "Error";
            $returnArray["return_message"] = "No pending usernames found";
            $returnArray["query"] = $dbprequery . " and " . $dbquery;
            $returnArray["return_type"] = "error";
        }
    }
    else{
        $returnArray["error"] = "Authentication failed";
        $returnArray["return_title"] = "Error";
        $returnArray["return_message"] = "Authentication error";
        $returnArray["query"] = $dbprequery . " and " . $dbquery;
        $returnArray["return_type"] = "error";
    }
    echo json_encode($returnArray);
?>