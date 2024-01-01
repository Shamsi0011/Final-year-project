<?php

    include "connection.php";

    $category_id = $_POST['category_id'];
    $currentUser = $_POST['currentUser'];
    $currentPassHash = $_POST['currentPassHash'];

        $dbprequery1 = "SELECT * FROM users WHERE username = \"$currentUser\" AND passwordHash = \"$currentPassHash\" AND user_type = 1;";
    $preresult1 = $conn->query($dbprequery1);
    if($preresult1->num_rows > 0){
                $dbprequery2 = "SELECT * FROM items WHERE post_category_id = \"$category_id\"";
        $preresult2 = $conn->query($dbprequery2);
        if($preresult2 && $preresult2->num_rows > 0){
            $return_array["return_title"] = "Failed to Remove Category";
            $return_array["return_message"] = "This category already has items associated with it. To remove the category, first disassociate items associated with it. ";
            $return_array["return_type"] = "error";
            $return_array["query"] = $dbprequery2;
        }
                else{
            $dbquery = "DELETE FROM item_categories WHERE category_id = $category_id";
            $result = $conn->query($dbquery);
            if($result){
                $return_array["return_title"] = "Success";
                $return_array["return_message"] = "Category removed successfully";
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
        $return_array["return_message"] = "You must be logged in as admin to add new categories";
        $return_array["return_type"] = "error";
        $return_array["query"] = $dbprequery1;
    }
    echo json_encode($return_array);
?>