<?php

include_once("connection.php");

$cartUsername = $_POST["cartUsername"];
$currentUsername = $_POST["currentUsername"];
$currentPassHash = $_POST["currentPassHash"];

$dbprequery = "SELECT * FROM users WHERE username = \"$currentUsername\" AND passwordHash = \"$currentPassHash\";";
$preresult = $conn->query($dbprequery);
if($preresult && $preresult->num_rows > 0){
    $current_credentials = mysqli_fetch_assoc($preresult);
        if($current_credentials && ($current_credentials["user_type"]==1 || $currentUsername == $cartUsername)){
                $dbquery = "SELECT cart_items.id, cart_items.user_id, items.image_url, cart_items.item_id, items.title, item_categories.category_name, cart_items.quantity, items.unit_price FROM cart_items, items, item_categories WHERE cart_items.item_id = items.id AND items.category_id = item_categories.category_id AND cart_items.user_id=\"$cartUsername\";";
                $result = $conn->query($dbquery);
        if($result && $result->num_rows > 0){
                        while($row = mysqli_fetch_assoc($result)){
                $result_array["_".$row["id"]] = $row;
            }
                        $return_array["query"] = addslashes($dbquery);
            $return_array["result_array"] = $result_array;
            $return_array["return_title"] = "Items found";
            $return_array["return_message"] = "Items found in db";
            $return_array["return_type"] = "success";
                    }
        else{
            addslashes($dbquery);
            $return_array["return_title"] = "No Items Found";
            $return_array["return_message"] = "There are currently no items in your cart.";
            $return_array["return_type"] = "error";
        }
    }
    else{
                    $return_array["dbprequery"] = $dbprequery;
        $return_array["dbquery"] = $dbquery;
        $return_array["return_title"] = "Error";
        $return_array["return_message"] = "Something went wrong";
        $return_array["return_type"] = "error";
            }
}
else{
    $current_credentials = false;
    echo "Current Username & Password could not be verified";
    echo $dbprequery;
    var_dump($preresult);
    echo $preresult->num_rows;
}
echo json_encode($return_array);


?>