<?php

include_once("connection.php");

$ordersUsername = $_POST["ordersUsername"];
$currentUsername = $_POST["currentUsername"];
$currentPassHash = $_POST["currentPassHash"];

$dbprequery = "SELECT * FROM users WHERE username = \"$currentUsername\" AND passwordHash = \"$currentPassHash\";";
$preresult = $conn->query($dbprequery);
$current_credentials = mysqli_fetch_assoc($preresult);
if($preresult && $preresult->num_rows > 0 && ($current_credentials['user_type']==1 || $ordersUsername==$currentUsername)){

                    if($current_credentials && ($current_credentials["user_type"]==1 || $currentUsername == $ordersUsername)){
                $dbquery = "SELECT orders.order_id, items.title, orders.item_id, orders.buyer_id, items.unit_price, items.seller_id, orders.quantity, orders.time_stamp, orders.invoice_id, orders.status FROM orders, items WHERE orders.item_id = items.id";
        if($current_credentials["user_type"]==2 || $currentUsername != $ordersUsername){
            $dbquery .= " AND buyer_id = \"$ordersUsername\"";
        }
        elseif($current_credentials["user_type"]==3 || $currentUsername != $ordersUsername){
            $dbquery .= " AND seller_id = \"$ordersUsername\"";
        }
                $result = $conn->query($dbquery);
                while($row = mysqli_fetch_assoc($result)){
            $result_array["_".$row["item_id"]] = $row;
        }
                $return_array["query"] = addslashes($dbquery);
        $return_array["result_array"] = $result_array;
        $return_array["return_title"] = "Items found";
        $return_array["return_message"] = "Items found in db";
        $return_array["return_type"] = "success";
                echo json_encode($return_array);
    }
    else{
                    $return_array["result_array"] = null;
        $return_array["query"] = addslashes($dbprequery);
        $return_array["return_title"] = "Authentication Error";
        $return_array["return_message"] = "Something went wrong";
        $return_array["return_type"] = "error";
                echo json_encode($return_array);
    }
}
else{
    $current_credentials = false;
    echo "Current Username & Password could not be verified";
    echo $dbprequery;
    var_dump($preresult);
    echo $preresult->num_rows;
}


?>