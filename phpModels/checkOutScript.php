<?php

    include "connection.php";

    $currentUsername = $_POST['currentUsername'];
    $currentPassHash = $_POST['currentPassHash'];

    $dbprequery = "SELECT * FROM users WHERE username = \"$currentUsername\" AND passwordHash = \"$currentPassHash\";";
    $preresult = $conn->query($dbprequery);
    if($preresult->num_rows > 0){
        $dbquery = "SELECT * FROM cart_items";
        $cartItems = $conn->query($dbquery);
        if($cartItems && $cartItems->num_rows > 0){
            while($row = mysqli_fetch_assoc($cartItems)){
                $cartItemsArray[$row['id']] = $row;
            }
            $success = true;
            foreach ($cartItemsArray as $cartItemId => $cartItem) {
                                $item_id = $cartItem['item_id'];
                $buyer_id = $cartItem['user_id'];
                $quantity = $cartItem['quantity'];
                $invoice_id = random_int(100000, 999999);
                $dbquery2 = "INSERT INTO orders (item_id, buyer_id, quantity, invoice_id, status) VALUES ($item_id, \"$buyer_id\", $quantity, $invoice_id, 1);";
                $dbquery3 = "DELETE FROM cart_items WHERE id=$cartItemId";
                $result[$cartItemId] = $conn->query($dbquery2);
                if($result[$cartItemId]){
                    $result['del'.$cartItemId] = $conn->query($dbquery3);
                    $return_array["query"] = addslashes($dbquery);
                    $return_array["result_array"] = $result;
                }
                else{
                    echo "Something went wrong.. ";
                    $success = false;
                }
            }
            if($success){
                $return_array["return_title"] = "Items found in db";
                $return_array["return_message"] = "Ordered placed successfully. The order will be delivered to you via Cash on Delivery. Please make sure to have appropriate cash on hand. ";
                $return_array["return_type"] = "success";
            }
        }
        else{
            $return_array["query"] = addslashes($dbquery2) . " " . addslashes($dbquery3);
            $return_array["return_title"] = "Operation Failed";
            $return_array["return_message"] = "Ordered placed could not be placed. ";
            $return_array["return_type"] = "error";
        }
    }
    else{
                $return_array["query"] = addslashes($dbquery);
        $return_array["return_title"] = "Authentication Error";
        $return_array["return_message"] = "Authentication Error. ";
        $return_array["return_type"] = "error";
    }
    echo json_encode($return_array);

?>