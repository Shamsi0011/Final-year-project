<?php

include "connection.php";

$queryString = "SELECT featured_items.feature_id, featured_items.item_id, items.image_url AS imgUrl, items.title, items.unit_price, items.description, items.category_id, item_categories.category_name, items.id FROM featured_items, items, item_categories WHERE items.category_id = item_categories.category_id AND featured_items.item_id = items.id AND featured_items.slider_visibility=1;";

$result = $conn->query($queryString);

$resultArray = [];

if($result && $result->num_rows > 0){
    while($row = mysqli_fetch_assoc($result)){
        $resultArray[$row["feature_id"]] = $row;
    }
}

$returnArray["id"] = "featuredCarousel";
$returnArray["data"] = $resultArray;
$returnArray["query"] = $queryString;
echo json_encode($returnArray);



?>