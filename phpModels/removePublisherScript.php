<?php

    include "connection.php";

    $publisher_id = $_POST['publisher_id'];
    $currentUser = $_POST['currentUser'];
    $currentPassHash = $_POST['currentPassHash'];

        $dbprequery1 = "SELECT * FROM users WHERE username = \"$currentUser\" AND passwordHash = \"$currentPassHash\" AND user_type = 1;";
    $preresult1 = $conn->query($dbprequery1);
    if($preresult1->num_rows > 0){
                $dbprequery2 = "SELECT * FROM items WHERE publisher_id = \"$publisher_id\"";
        $preresult2 = $conn->query($dbprequery2);
        if($preresult2 && $preresult2->num_rows > 0){
            $return_array["return_title"] = "Failed to Remove Publisher";
            $return_array["return_message"] = "This publisher already has items associated with it. To remove the publisher, first disassociate items associated with it. ";
            $return_array["return_type"] = "error";
            $return_array["query"] = $dbprequery2;
        }
                else{
            $dbquery = "DELETE FROM publishers WHERE publisher_id = $publisher_id";
            $result = $conn->query($dbquery);
            if($result){
                $return_array["return_title"] = "Success";
                $return_array["return_message"] = "Publisher removed successfully";
                $return_array["return_type"] = "success";
                $return_array["query"] = $dbquery;
            }
            else{
                $return_array["return_title"] = "Error";
                $return_array["return_message"] = "Unknown error occured";
                $return_array["return_type"] = "error";
                $return_array["query"] = $dbquery;
            }
        }
    }
    else{
        $return_array["return_title"] = "Authentication Error";
        $return_array["return_message"] = "You must be logged in as admin to add new publishers";
        $return_array["return_type"] = "error";
        $return_array["query"] = $dbprequery1;
    }
    echo json_encode($return_array);
?>