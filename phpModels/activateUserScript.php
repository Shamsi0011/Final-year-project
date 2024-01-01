<?php
    include "connection.php";
    $username = $_POST['username'];
    $currentUser = $_POST['currentUser'];
    $currentPassHash = $_POST['currentPassHash'];
    $dbprequery = "SELECT * FROM users WHERE username = \"$currentUser\" AND passwordHash = \"$currentPassHash\"";
    $preresult = $conn->query($dbprequery);
    if($preresult->num_rows > 0){
        // username found
        $row = mysqli_fetch_assoc($preresult);
        if($row['user_type']==1){
            // authentication successful. user is admin
            $dbquery = "UPDATE users SET approval=1 WHERE username=\"$username\";";
            $result = $conn->query($dbquery);
            if($result){
                $return_array["return_title"] = "Success";
                $return_array["return_message"] = "User activated successfully";
                $return_array["query"] = addslashes($dbprequery) . " and " . addslashes($dbquery);
                $return_array["return_type"] = "success";
            }
            else{
                $return_array["return_title"] = "Could not activate user";
                $return_array["return_message"] = "An unknown error has occured";
                $return_array["query"] = addslashes($dbprequery) . " and " . addslashes($dbquery);
                $return_array["return_type"] = "error";
            }
        }
        else{
            // user does not have the authority to delete the user
            $return_array["return_title"] = "Authentication Error";
            $return_array["return_message"] = "User could not be authenticated as admin";
            $return_array["query"] = addslashes($dbprequery);
            $return_array["return_type"] = "error";
        }
    }
    else{
        // username not found
        // user does not have the authority to delete the user
        $return_array["return_title"] = "Authentication Error";
        $return_array["return_message"] = "Username could not be authenticated. Make sure you are registered and logged in. ";
        $return_array["query"] = addslashes($dbprequery);
        $return_array["return_type"] = "error";
    }
    echo json_encode($return_array);
?>