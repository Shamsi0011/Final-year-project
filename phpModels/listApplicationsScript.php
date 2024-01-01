<?php
    include_once("connection.php");
        $profileUsername = $_POST['profileUsername'];
    $currentUsername = $_POST['currentUsername'];
    $currentPassHash = $_POST['currentPassHash'];

        $dbprequery = "SELECT * FROM users WHERE username = \"$currentUsername\" AND passwordHash = \"$currentPassHash\";";
    $preresult = $conn->query($dbprequery);
        if($preresult && $preresult->num_rows > 0){
                $dbquery = "SELECT applications.id AS application_id, items.id AS post_id, applications.application, items.title, items.publisher_id, publishers.publisher_name, applications.time_stamp FROM applications, posts, publishers WHERE applications.post_id=items.id AND items.publisher_id=publishers.publisher_id AND user_id=\"$profileUsername\";";
        $result = $conn->query($dbquery);
                if($result && $result->num_rows > 0){
            while($row = mysqli_fetch_assoc($result)){
                $applicationsArray[$row['application_id']] = $row;
            }
            $return_array["result_array"] = $applicationsArray;
            $return_array["return_title"] = "Success";
            $return_array["return_message"] = "Items retrieved successfully. ";
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