<?php
    include "connection.php";
            $oldPasswordHash = $_POST["oldPasswordHash"];
    $newPasswordHash = $_POST["newPasswordHash"];
    $confirmPasswordHash = $_POST["confirmPasswordHash"];
    $currentUser = $_POST["currentUser"];
    $currentPassHash = $_POST["currentPassHash"];
    if(isset($_POST["username"])){
        $username = $_POST["username"];
    }
    else{
        $username = $currentUser;
    }

        $dbprequery = "SELECT * FROM users WHERE username = \"$currentUser\" AND passwordHash = \"$currentPassHash\";";

    $preresult = $conn->query($dbprequery);

    $preresultArray = mysqli_fetch_assoc($preresult);

        if($preresult && $preresult->num_rows > 0 && ($preresultArray['user_type']==1 || $username == $currentUser)){
        $dbprequery2 = "SELECT * FROM users WHERE username = \"$username\" AND passwordHash = \"$oldPasswordHash\";";
        $preresult2 = $conn->query($dbprequery2);
        if($preresult2 && $preresult2->num_rows>0){
            $dbquery = "UPDATE users SET passwordHash = \"$newPasswordHash\" WHERE username = \"$username\";";
            $result = $conn->query($dbquery);
            if($result){
                $return_array["return_title"] = "Success";
                $return_array["return_message"] = "Password updated successfully";
                $return_array["return_type"] = "success";
                $return_array["query"] = addslashes($dbquery);
            }
            else{
                $return_array["return_title"] = "Error";
                $return_array["return_message"] = "An unknown error";
                $return_array["return_type"] = "error";
                $return_array["query"] = addslashes($dbquery);
            }
        }
        else{
            $return_array["return_title"] = "Error";
            $return_array["return_message"] = "The old password you entered is incorrect.";
            $return_array["return_type"] = "error";
            $return_array["query"] = addslashes($dbprequery2);
        }
    }
    else{
        $return_array["return_title"] = "Authentication Error";
        $return_array["return_message"] = "You need to be logged in to be able to change password.";
        $return_array["return_type"] = "error";
        $return_array["query"] = addslashes($dbprequery);
    }

    echo json_encode($return_array);


?>