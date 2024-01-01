<?php
    include "connection.php";
    
    $currentUser = $_POST["currentUser"];
    $currentPassHash = $_POST["currentPassHash"];
    $id = $_POST["id"];
    $title = $_POST["title"];
    $category_id = $_POST["category_id"];
    $price = $_POST["unit_price"];
    $description = addslashes($_POST["description"]);
    $stock_quantity = $_POST["stock_quantity"];
    $publisher_id = $_POST["publisher_id"];
    $city_country = $_POST["city_country"];
    $city = explode(",", $city_country)[0];
    $country = explode(",", $city_country)[1];
    $currentUser = $_POST["currentUser"];
    $currentPassHash = $_POST["currentPassHash"];
        
    
    $dbprequery = "SELECT * FROM users WHERE username = \"$currentUser\" AND passwordHash = \"$currentPassHash\" AND (user_type = 1 OR user_type = 3)";

    $preresult = $conn->query($dbprequery);

    if($preresult && $preresult->num_rows > 0){
        $dbquery = "UPDATE items SET id = $id, title = \"$title\", category_id = $category_id, unit_price = $price, description = \"$description\", stock_quantity = $stock_quantity, publisher_id = $publisher_id, city = \"$city\", country = \"$country\" WHERE id=$id;";
        $result = $conn->query($dbquery);
        if($result){
            $return_array["return_title"] = "Success";
            $return_array["return_message"] = "Product information updated successfully";
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