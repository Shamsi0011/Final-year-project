<?php
    include_once("connection.php");
        $currentUser = $_POST['currentUser'];
    $currentPassHash = $_POST['currentPassHash'];
    $profileUsername = $_POST['profile_username'];
        $dbprequery1 = "SELECT * FROM users WHERE username = \"$currentUser\" AND passwordHash = \"$currentPassHash\";";
    $preresult1 = $conn->query($dbprequery1);
    $preresultArray1 = mysqli_fetch_assoc($preresult1);
        if($preresult1 && $preresult1->num_rows > 0 && ($preresultArray1['user_type']==1 || $preresultArray1['user_type']==3 || $currentUser == $profileUsername)){
                $dbprequery2 = "SELECT * FROM resume WHERE username = \"$profileUsername\";";
        $preresult2 = $conn->query($dbprequery2);
                if($preresult2 && $preresult2->num_rows > 0){
            $result_array = mysqli_fetch_assoc($preresult2);
            $resume = $result_array['resume'];
        }
                else{
            $resume = "<h1>You have not created an online resume yet. Click the Add/Edit link to create one...</h1>";
        }
        $return_array["resume"] = ($resume);
        $return_array["return_title"] = "Success";
        $return_array["return_message"] = "Applicant resume updated successfully";
        $return_array["return_type"] = "success";
        $return_array["query"] = addslashes($dbprequery2);
    }
    else{
                $return_array["return_title"] = "Authentication Error";
        $return_array["return_message"] = "An authentication error occured. ";
        $return_array["return_type"] = "error";
        $return_array["query"] = addslashes($dbprequery1);
    }
    echo json_encode($return_array);
?>