<?php

    include "connection.php";
    $publisher_id = $_POST['publisher_id'];
    $publisher_name = $_POST['publisher_name'];
    $currentUser = $_POST['currentUser'];
    $currentPassHash = $_POST['currentPassHash'];

        $dbprequery1 = "SELECT * FROM users WHERE username = \"$currentUser\" AND passwordHash = \"$currentPassHash\" AND user_type = 1;";
    $preresult1 = $conn->query($dbprequery1);
    if($preresult1->num_rows > 0){
                $dbprequery2 = "SELECT * FROM publishers WHERE publisher_name = \"$publisher_name\"";
        $preresult2 = $conn->query($dbprequery2);
        if($preresult2 && $preresult2->num_rows > 0){
            $return_array["return_title"] = "Publisher Already Exists";
            $return_array["return_message"] = "The publisher name you entered already exists in the database. Please choose a different one";
            $return_array["return_type"] = "error";
            $return_array["query"] = $dbprequery2;
        }
                else{
            $dbquery = "UPDATE publishers SET publisher_name = \"$publisher_name\" WHERE publisher_id = $publisher_id;";
            $result = $conn->query($dbquery);
            if($result){
                $return_array["return_title"] = "Success";
                $return_array["return_message"] = "Publisher edited successfully";
                $return_array["return_type"] = "success";
                $return_array["query"] = $dbquery;
            }
            else{
                $return_array["return_title"] = "Unknown Error";
                $return_array["return_message"] = "Could not change publisher name because of some unknown error";
                $return_array["return_type"] = "error";
                $return_array["query"] = $dbquery;        
            }
        }
    }
    else{
        $return_array["return_title"] = "Authentication Error";
        $return_array["return_message"] = "You must be logged in as admin to edit new publishers";
        $return_array["return_type"] = "error";
        $return_array["query"] = $dbprequery1;
    }
    echo json_encode($return_array);
?>