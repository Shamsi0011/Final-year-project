<?php
    include_once("connection.php");
    $editAboutUs = $_POST['editAboutUs'];
    $editAboutUs = addslashes($editAboutUs);
    $currentUser = $_POST["currentUser"];
    $currentPassHash = $_POST["currentPassHash"];
    $dbprequery = "SELECT * FROM users WHERE username = \"$currentUser\" AND passwordHash = \"$currentPassHash\" AND user_type = 1";
    $preresult = $conn->query($dbprequery);
    if($preresult && $preresult->num_rows > 0){
        $dbquery = "UPDATE articles SET text = \"$editAboutUs\" WHERE article_name = \"about_us\";";
        $result = $conn->query($dbquery);
        if($result){
            $return_array["return_title"] = "Success";
            $return_array["return_message"] = "About Us article updated successfully";
            $return_array["return_type"] = "success";
            $return_array["query"] = addslashes($dbquery);
        }
        else{
            $return_array["return_title"] = "Error";
            $return_array["return_message"] = "Unknown error occured";
            $return_array["return_type"] = "error";
            $return_array["query"] = addslashes($dbquery);
        }
    }
    else{
        $return_array["return_title"] = "Authentication Error";
        $return_array["return_message"] = "You need to be logged in as admin to be able to modify this page. ";
        $return_array["return_type"] = "error";
        $return_array["query"] = addslashes($dbprequery);
    }
    echo json_encode($return_array);

?>