<?php
    include_once("connection.php");
    $bookID = $_POST['bookID'];
    $currentUsername = $_POST['currentUsername'];
    $currentPassHash = $_POST['currentPassHash'];
    $dbprequery = "SELECT * FROM users WHERE username = \"$currentUsername\" AND passwordHash = \"$currentPassHash\";";
    $preresult = $conn->query($dbprequery);
    if($preresult && $preresult->num_rows > 0){
        $dbprequery2 = "SELECT * FROM featured_items WHERE item_id = $bookID";
        $preresult2 = $conn->query($dbprequery2);
        if($preresult2 && $preresult2->num_rows > 0) $dbquery = "UPDATE featured_items SET slider_visibility = 1 WHERE item_id = $bookID;";
        else $dbquery = "INSERT INTO featured_items (item_id, landing_page_visibility, slider_visibility) VALUES ($bookID, 0, 1)";
        $result = $conn->query($dbquery);
        if($result){
            $return_array["return_title"] = "Success";
            $return_array["return_message"] = "The item added to featured slider successfully. ";
            $return_array["return_type"] = "success";
            $return_array["query"] = addslashes($dbquery);
        }
        else{
            $return_array["return_title"] = "Unknown Error";
            $return_array["return_message"] = "Something went wrong....";
            $return_array["return_type"] = "error";
            $return_array["query"] = addslashes($dbquery);    
        }
    }
    else{
        $return_array["return_title"] = "Authentication Error";
        $return_array["return_message"] = "An authentication error occured. ";
        $return_array["return_type"] = "error";
        $return_array["query"] = addslashes($dbprequery);
    }
    echo json_encode($return_array);
?>