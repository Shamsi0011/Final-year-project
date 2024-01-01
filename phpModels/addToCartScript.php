<?php
    include "connection.php";
    $productID = $_POST['id'];
    $currentUser = $_POST['currentUser'];
    $currentPassHash = $_POST['currentPassHash'];
    $qty = $_POST['qty'];
    $dbprequery = "SELECT * FROM users WHERE username = \"$currentUser\" AND passwordHash = \"$currentPassHash\"";
    $preresult = $conn->query($dbprequery);
    if($preresult && $preresult->num_rows > 0){
        $dbquery = "INSERT INTO cart_items (user_id, item_id, quantity) VALUES (\"$currentUser\", $productID, $qty);";
        $result = $conn->query($dbquery);
        if($result){
            $return_array["return_title"] = "Success";
            $return_array["return_message"] = "Product added to the cart successfully";
            $return_array["query"] = addslashes($dbquery);
            $return_array["return_type"] = "success";
        }
        else{
            $return_array["return_title"] = "Failed to add to cart";
            $return_array["return_message"] = "Product could not be added to the cart";
            $return_array["query"] = addslashes($dbquery);
            $return_array["return_type"] = "error";
        }
    }
    else{
        $return_array["return_title"] = "Authentication Error";
        $return_array["return_message"] = "Request could not be authenticated";
        $return_array["query"] = addslashes($dbprequery);
        $return_array["return_type"] = "error";
    }
    echo json_encode($return_array);
?>