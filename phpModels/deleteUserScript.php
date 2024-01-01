<?php
    include "connection.php";
    $username = $_POST['username'];
    $currentUser = $_POST['currentUser'];
    $currentPassHash = $_POST['currentPassHash'];
    $dbprequery = "SELECT * FROM users WHERE username = \"$currentUser\" AND passwordHash = \"$currentPassHash\"";
    $preresult = $conn->query($dbprequery);
    if($preresult->num_rows > 0){
                $row = mysqli_fetch_assoc($preresult);
        if($row['user_type']==1){
                        $dbquery = "DELETE FROM users WHERE username=\"$username\";";
            $dbquery2 = "DELETE FROM user_info WHERE username=\"$username\";";
            $result = $conn->query($dbquery);
            $result2 = $conn->query($dbquery2);
            if($result & $result2){
                $return_array["return_title"] = "Success";
                $return_array["return_message"] = "User deleted successfully";
                $return_array["query"] = addslashes($dbprequery) . " and " . addslashes($dbquery) . " and " . addslashes($dbquery2);
                $return_array["return_type"] = "success";
            }
            else{
                $return_array["return_title"] = "Could not delete product";
                $return_array["return_message"] = "An unknown error has occured";
                $return_array["query"] = addslashes($dbprequery) . " and " . addslashes($dbquery) . " and " . addslashes($dbquery2);
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