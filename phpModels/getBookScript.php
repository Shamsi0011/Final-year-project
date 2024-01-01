<?php

    include_once("connection.php");

        if($_GET["book_id"]){
        $book_id = $_GET['book_id'];
    }
            $dbquery1 = "SELECT items.id, items.title, items.category_id, item_categories.category_name, items.unit_price, items.description, items.stock_quantity, items.publisher_id, featured_items.feature_id, featured_items.landing_page_visibility, featured_items.slider_visibility, publishers.publisher_name, items.seller_id, items.image_url, items.city, items.country FROM (items, item_categories, publishers) LEFT OUTER JOIN featured_items ON items.id = featured_items.item_id WHERE items.category_id = item_categories.category_id AND items.publisher_id = publishers.publisher_id AND items.visibility_status = 1 AND items.id = $book_id;";
    $dbquery2 = "SELECT * FROM item_categories;";
    $dbquery3 = "SELECT * FROM publishers;";
    $dbquery4 = "SELECT * FROM cities";
    

        $result1 = $conn->query($dbquery1);
    $result2 = $conn->query($dbquery2);
    $result3 = $conn->query($dbquery3);
    $result4 = $conn->query($dbquery4);
    
    

    if($result1 && $result2 && $result3 && $result4){
        $resultArray = mysqli_fetch_assoc($result1);
        while($row = mysqli_fetch_assoc($result2)){
            $item_categories[$row['category_id']] = $row;
        }
        $resultArray['item_categories'] = $item_categories;
        while($row = mysqli_fetch_assoc($result3)){
            $publishers[$row['publisher_id']] = $row;
        }
        $resultArray['publishers'] = $publishers;
        while($row = mysqli_fetch_assoc($result4)){
            $cities[$row['id']] = $row;
        }
        $resultArray['cities'] = $cities;
    }
    else{
        var_dump($result1);
    }
    
?>