<?php
    include "connection.php";
        $postID = $_POST['postId'];
    $currentUser = $_POST['currentUser'];
    $currentPassHash = $_POST['currentPassHash'];
    $dbprequery = "SELECT * FROM users WHERE username = \"$currentUser\" AND passwordHash = \"$currentPassHash\"";
    $preresult = $conn->query($dbprequery);
    if($preresult->num_rows > 0){
                $row = mysqli_fetch_assoc($preresult);
        if($row['user_type']==1){
                        $dbquery = "UPDATE items SET visibility_status=1 WHERE id=$postID;";
            $result = $conn->query($dbquery);
            if($result){
                $return_array["return_title"] = "Success";
                $return_array["return_message"] = "Post activated successfully";
                $return_array["query"] = addslashes($dbprequery) . " and " . addslashes($dbquery);
                $return_array["return_type"] = "success";
            }
            else{
                $return_array["return_title"] = "Could not activate post";
                $return_array["return_message"] = "An unknown error has occured";
                $return_array["query"] = addslashes($dbprequery) . " and " . addslashes($dbquery);
                $return_array["return_type"] = "error";
            }
        }
        else{
                        $return_array["return_title"] = "Authentication Error";
            $return_array["return_message"] = "User could not be authenticated as admin";
            $return_array["query"] = addslashes($dbprequery);
            $return_array["return_type"] = "error";
        }
    }
    else{
                        $return_array["return_title"] = "Authentication Error";
        $return_array["return_message"] = "Username could not be authenticated. Make sure you are registered and logged in. ";
        $return_array["query"] = addslashes($dbprequery);
        $return_array["return_type"] = "error";
    }
    echo json_encode($return_array);
?>