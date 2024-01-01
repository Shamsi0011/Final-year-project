<?php
    include "connection.php";
        $username = $_POST["username"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $user_type = $_POST["user_type"];
    $user_type_id = $_POST["user_type_id"];
    $date_of_birth = $_POST["date_of_birth"];
    $cnic = $_POST["cnic"];
    $street_address = $_POST["street_address"];
    $city_country = $_POST['city_country'];
    $city = explode(",",$city_country)[0];
    $country = explode(",",$city_country)[1];
    $currentUser = $_POST["currentUser"];
    $currentPassHash = $_POST["currentPassHash"];

    
    $dbprequery = "SELECT * FROM users WHERE username = \"$currentUser\" AND passwordHash = \"$currentPassHash\";";

    $preresult = $conn->query($dbprequery);

    $preresultArray = mysqli_fetch_assoc($preresult);

    if($preresult && $preresult->num_rows > 0 && ($preresultArray['user_type']==1 || $username == $currentUser)){
        $dbquery = "UPDATE user_info SET firstname = \"$firstname\", lastname = \"$lastname\", date_of_birth = \"$date_of_birth\", cnic = \"$cnic\", street_address = \"$street_address\", city = \"$city\", country = \"$country\" WHERE username = \"$username\";";
        $dbquery2 = "UPDATE users SET user_type = $user_type_id WHERE username = \"$username\";";
        $result = $conn->query($dbquery);
        $result2 = $conn->query($dbquery2);
        if($result && $result2){
            $return_array["return_title"] = "Success";
            $return_array["return_message"] = "Profile information updated successfully";
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
        $return_array["return_title"] = "Authentication Error";
        $return_array["return_message"] = "You need to be logged in as admin to be able to update information.";
        $return_array["return_type"] = "error";
        $return_array["query"] = addslashes($dbprequery);
    }

    echo json_encode($return_array);


?>