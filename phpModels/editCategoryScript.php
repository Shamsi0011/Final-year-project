<?php

    include "connection.php";
    $category_id = $_POST['category_id'];
    $category_name = $_POST['category_name'];
    $currentUser = $_POST['currentUser'];
    $currentPassHash = $_POST['currentPassHash'];

        $dbprequery1 = "SELECT * FROM users WHERE username = \"$currentUser\" AND passwordHash = \"$currentPassHash\" AND user_type = 1;";
    $preresult1 = $conn->query($dbprequery1);
    if($preresult1->num_rows > 0){
                $dbprequery2 = "SELECT * FROM item_categories WHERE category_name = \"$category_name\"";
        $preresult2 = $conn->query($dbprequery2);
        if($preresult2 && $preresult2->num_rows > 0){
            $return_array["return_title"] = "Category Already Exists";
            $return_array["return_message"] = "The category name you entered already exists in the database. Please choose a different one";
            $return_array["return_type"] = "error";
            $return_array["query"] = $dbprequery2;
        }
                else{
            $dbquery = "UPDATE item_categories SET category_name = \"$category_name\" WHERE category_id = $category_id;";
            $result = $conn->query($dbquery);
            if($result){
                $return_array["return_title"] = "Success";
                $return_array["return_message"] = "Category edited successfully";
                $return_array["return_type"] = "success";
                $return_array["query"] = $dbquery;
            }
            else{
                $return_array["return_title"] = "Unknown Error";
                $return_array["return_message"] = "Could not change category name because of some unknown error";
                $return_array["return_type"] = "error";
                $return_array["query"] = $dbquery;        
            }
        }
    }
    else{
        $return_array["return_title"] = "Authentication Error";
        $return_array["return_message"] = "You must be logged in as admin to edit new categories";
        $return_array["return_type"] = "error";
        $return_array["query"] = $dbprequery1;
    }
    echo json_encode($return_array);
?>