<?php

    include_once("connection.php");

            $username = $_POST['username'];
    $passwordHash = $_POST['passwordHash'];
    $profileID = $_POST['profileID'];

        $prequery = "SELECT `users`.`username`, `users`.`user_type`, `user_types`.`user_type_title` FROM `users`, `user_types` WHERE `users`.`user_type` = `user_types`.`user_type_id` AND `users`.`username` = \"$username\" AND `users`.`passwordHash`=\"$passwordHash\";";

        $preresult = $conn->query($prequery);

    if($preresult && $preresult->num_rows > 0){
        $user_type = mysqli_fetch_assoc($preresult)['user_type'];
        $dbquery = "SELECT * FROM user_details_t WHERE username = \"$profileID\"";
        $result = $conn->query($dbquery);
        if($result && $result->num_rows > 0){
            $resultArray = mysqli_fetch_assoc($result);
            $return_array["result_array"] = $resultArray;
            $return_array["return_title"] = "Success";
            $return_array["return_message"] = "Username found";
                        $return_array["return_type"] = "success";

            $returnJSON = json_encode($return_array);
            echo $returnJSON;
        }
        else{
            $return_array["return_title"] = "Error";
            $return_array["return_message"] = "Username not found";
            $return_array["query"] = $prequery . " and " . $dbquery;
            $return_array["return_type"] = "error";

            $returnJSON = json_encode($return_array);
            echo $returnJSON;
        }
    }
    else{
        
    }
    
?>