<?php

include "connection.php";

$search_term = $_POST['search_term'];
$category = $_POST['category'];
$direction = $_POST['direction'];
$sort = $_POST['sort'];

$dbquery = "SELECT items.id, items.title, items.category_id, item_categories.category_name, items.unit_price, items.description, items.stock_quantity, items.publisher_id, publishers.publisher_name, items.image_url, items.city, items.country From items, item_categories, publishers WHERE items.category_id = item_categories.category_id AND items.publisher_id = publishers.publisher_id AND items.visibility_status = 1";
if($category!=0){
    $dbquery .= " AND items.category_id = \"$category\"";
}
if($search_term!=""){
    $dbquery .= " AND items.title RLIKE \"$search_term\"";
}
$dbquery .= " ORDER BY $sort $direction";

$result = $conn->query($dbquery);

if($result && $result->num_rows>0){
    while($row = mysqli_fetch_assoc($result)){
        $resultArray['_' . $row['title']] = $row;
    }
    $return_array['result_array'] = $resultArray;
    $return_array["return_title"] = "Success";
    $return_array["return_message"] = "Book listings retrieved successfully";
    $return_array["return_type"] = "success";
    $return_array["query"] = $dbquery;
}
else{
    $return_array["return_title"] = "Operation Failed with $result->num_rows number of rows";
    $return_array["return_message"] = "The username and password did not match.";
    $return_array["return_type"] = "error";
    $return_array["query"] = $dbquery;
}
echo json_encode($return_array);

?>