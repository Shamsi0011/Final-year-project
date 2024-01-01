<?php

include "connection.php";

$dbquery = "SELECT items.id, items.title, items.category_id, item_categories.category_name, items.unit_price, items.description, items.stock_quantity, items.publisher_id, publishers.publisher_name, items.image_url, items.city, items.country From items, item_categories, publishers WHERE items.category_id = item_categories.category_id AND items.publisher_id = publishers.publisher_id AND items.visibility_status = 0";

$result = $conn->query($dbquery);

if($result && $result->num_rows>0){
    while($row = mysqli_fetch_assoc($result)){
        $resultArray['_' . $row['title']] = $row;
    }
    $return_array['result_array'] = $resultArray;
    $return_array["return_title"] = "Success";
    $return_array["return_message"] = "Categories retrieved successfully";
    $return_array["return_type"] = "success";
    $return_array["query"] = $dbquery;
}
else{
    $return_array["return_title"] = "Operation Failed with $result->num_rows number of rows";
    $return_array["return_message"] = "There are currenctly no pending posts to be approved. ";
    $return_array["return_type"] = "error";
    $return_array["query"] = $dbquery;
}
echo json_encode($return_array);

?>