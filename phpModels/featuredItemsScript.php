<?php

include "connection.php";

$dbquery = "SELECT featured_items.feature_id, featured_items.item_id, items.image_url AS imgUrl, items.title, items.category_id, item_categories.category_name AS category, items.unit_price, items.stock_quantity FROM featured_items, items, item_categories WHERE featured_items.item_id = items.id AND items.category_id = item_categories.category_id AND items.visibility_status = 1 AND featured_items.landing_page_visibility = 1;";

$result = $conn->query($dbquery);


if($result && $result->num_rows > 0){
    while($row = mysqli_fetch_assoc($result)){
        $resultArray[$row["item_id"]] = $row;
    }
    $return_array["id"] = "featuredItems";
    $return_array["class"] = "featuredItem";
    $return_array["data"] = $resultArray;
    $return_array["return_title"] = "Success";
    $return_array["return_message"] = "Featured items retrieved successfully";
    $return_array["return_type"] = "success";
    $return_array["query"] = $dbquery;
}
else{
    $return_array["data"] = "none";
    $return_array["return_title"] = "Operation Failed with 0 number of rows";
    $return_array["return_message"] = "No featured posts found";
    $return_array["return_type"] = "error";
    $return_array["query"] = $dbquery;
}
echo json_encode($return_array);

/*

var featuredItems = `{
    "id": "featuredItems", "class": "featuredItem", "data":{
        "item1":{"imgUrl":"uploads/postImages/p1.png", "product_name":"Playstation 4", "category":"Gaming Consoles", "unit_price":"14,500", "units":"", "link":""},
        "item2":{"imgUrl":"uploads/postImages/p2.png", "product_name":"Haier Washing Machine", "category":"Home Appliances", "unit_price":"44,000", "units":"", "link":""},
        "item3":{"imgUrl":"uploads/postImages/p3.png", "product_name":"Sony Vaio Notebook", "category":"Computers & Accessories", "unit_price":"220,000", "units":"", "link":""},
        "item4":{"imgUrl":"uploads/postImages/p4.png", "product_name":"Samsung Galaxy Note 11+", "category":"Mobile & Tablets", "unit_price":"120,000", "units":"", "link":""},
        "item5":{"imgUrl":"uploads/postImages/p5.png", "product_name":"Kenwood Induction Stove", "category":"Home Appliances", "unit_price":"17,000", "units":"", "link":""},
        "item6":{"imgUrl":"uploads/postImages/p6.png", "product_name":"Dawlance Refrigerator", "category":"Home Appliances", "unit_price":"117,000", "units":"", "link":""}
    }
}`;

*/

?>