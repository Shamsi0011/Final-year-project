<?php
    include_once("connection.php");
            $book_application = $_POST["book_application"];
    $currentUser = $_POST["currentUser"];
    $currentPassHash = $_POST["currentPassHash"];
    $book_id = $_POST["book_id"];
        $dbprequery = "SELECT * FROM users WHERE username = \"$currentUser\" AND passwordHash = \"$currentPassHash\";";
    $preresult = $conn->query($dbprequery);
        if($preresult && $preresult->num_rows > 0){
                $dbquery = "INSERT INTO applications (post_id, user_id, application) VALUES ($book_id, \"$currentUser\", \"$book_application\")";
        $result = $conn->query($dbquery);
                if($result){
            $return_array["return_title"] = "Success";
            $return_array["return_message"] = "Application submitted successfully";
            $return_array["return_type"] = "success";
            $return_array["query"] = addslashes($dbquery);
        }
                else{
            $return_array["return_title"] = "Error";
            $return_array["return_message"] = "An unknown error occured. ";
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