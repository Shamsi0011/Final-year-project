<?php
    include_once("connection.php");
        $resume = $_POST['resume'];
    $resume = addslashes($resume);
    $currentUser = $_POST['currentUser'];
    $currentPassHash = $_POST['currentPassHash'];
    $profileUsername = $_POST['profile_username'];
        $dbprequery1 = "SELECT * FROM users WHERE username = \"$currentUser\" AND passwordHash = \"$currentPassHash\";";
    $preresult1 = $conn->query($dbprequery1);
    $preresultArray1 = mysqli_fetch_assoc($preresult1);
        if($preresult1 && $preresult1->num_rows > 0 && ($preresultArray1['user_type']==1 || $currentUser == $profileUsername)){
                $dbprequery2 = "SELECT * FROM resume WHERE username = \"$profileUsername\";";
        $preresult2 = $conn->query($dbprequery2);
                if($preresult2 && $preresult2->num_rows > 0){
            $dbquery = "UPDATE resume SET resume = \"$resume\" WHERE username = \"$profileUsername\";";
        }
                else{
            $dbquery = "INSERT INTO resume (resume, username) VALUES (\"$resume\", \"$profileUsername\");";
        }
        $result = $conn->query($dbquery);
        if($result){
            $return_array["return_title"] = "Success";
            $return_array["return_message"] = "Applicant resume updated successfully";
            $return_array["return_type"] = "success";
            $return_array["query"] = addslashes($dbquery);
        }
        else{
            $return_array["return_title"] = "Failed";
            $return_array["return_message"] = "Applicant resume could not be updated successfully";
            $return_array["return_type"] = "error";
            $return_array["query"] = addslashes($dbquery);
        }
    }
    else{
                $return_array["return_title"] = "Authentication Error";
        $return_array["return_message"] = "An authentication error occured. ";
        $return_array["return_type"] = "error";
        $return_array["query"] = addslashes($dbquery);
    }
    echo json_encode($return_array);
?>