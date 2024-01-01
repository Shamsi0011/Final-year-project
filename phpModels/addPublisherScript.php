<?php

    include "connection.php";

    $publisher_name = $_POST['publisher_name'];
    $currentUser = $_POST['currentUser'];
    $currentPassHash = $_POST['currentPassHash'];

    $return_array["return_title"] = "--";
    $return_array["return_message"] = "---";
    $return_array["return_type"] = "--";
    $return_array["query"] = "----";

        $dbprequery1 = "SELECT * FROM users WHERE username = \"$currentUser\" AND passwordHash = \"$currentPassHash\" AND user_type = 1;";
    $preresult1 = $conn->query($dbprequery1);
    if($preresult1 && $preresult1->num_rows > 0){

                $dbprequery2 = "SELECT * FROM publishers WHERE publisher_name = \"$publisher_name\"";

        $preresult2 = $conn->query($dbprequery2);
        if($preresult2 && $preresult2->num_rows > 0){
            $return_array["return_title"] = "Publisher Already Exists";
            $return_array["return_message"] = "The publisher name you entered already exists in the database";
            $return_array["return_type"] = "error";
            $return_array["query"] = $dbprequery2;
        }
                else{
    
            $dbquery = "INSERT INTO publishers (publisher_name) VALUES (\"$publisher_name\")";
            $result = $conn->query($dbquery);
            if($result){
                $return_array["return_title"] = "Success";
                $return_array["return_message"] = "Publisher added successfully";
                $return_array["return_type"] = "success";
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