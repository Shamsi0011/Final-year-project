<?php
    include_once("connection.php");
        $currentUsername = $_POST['currentUsername'];
    $currentPassHash = $_POST['currentPassHash'];

            $dbprequery = "SELECT * FROM `user_details_t` WHERE username = \"$currentUsername\" AND passwordHash = \"$currentPassHash\";";
    $preresult = $conn->query($dbprequery);
        if($preresult && $preresult->num_rows > 0){
        $publisher_id = mysqli_fetch_assoc($preresult)['publisher_id'];
                $dbquery = "SELECT `applications`.`id` AS application_id, `applications`.`post_id`, `posts`.`title`, `applications`.`user_id`, `posts`.`publisher_id`, `publishers`.`publisher_name`, `applications`.`time_stamp`, `applications`.`application`, `user_info`.`firstname`, `user_info`.`lastname`, `user_info`.`cell_no` FROM `applications`, `user_info`, `posts`, `publishers` WHERE `applications`.`user_id` = `user_info`.`username` AND `applications`.`post_id`=`posts`.`id` AND `posts`.`publisher_id` = `publishers`.`publisher_id`";
        if($publisher_id!=null){
            $dbquery .= " AND publishers.publisher_id = $publisher_id;";
        }
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