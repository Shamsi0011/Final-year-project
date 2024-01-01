<?php


include_once("connection.php");


$title = $_POST['title'];
$category_id = $_POST['category_id'];
$unit_price = $_POST['unit_price'];
$stock_quantity = $_POST['stock_quantity'];
$publisher_id = $_POST['publisher_id'];
$city_country = $_POST['city_country'];
$city = explode(",",$city_country)[0];
$country = explode(",",$city_country)[1];
$description = addslashes($_POST['description']);
$author = $_POST['author'];
$visibility_status = 0;
$seller_id = $_POST['currentUser'];

if(isset($_FILES['image'])){
    $image = $_FILES['image'];
}


define("MAX_FILE_SIZE",5242880);
$ACCEPTED_FILE_TYPES = ["image/jpg", "image/png", "image/jpeg"];
if(isset($image)){
        if(!(in_array(getimagesize($image['tmp_name'])["mime"], $ACCEPTED_FILE_TYPES))){
                        $return_array["return_title"] = "Invalid File Type";
            $return_array["return_message"] = "The image uploaded is not of a valid type.";
            $return_array["return_type"] = "error";
            $image = false;
    }
        elseif(getimagesize($image['tmp_name'])["mime"]!=$image["type"]){
                        $return_array["return_title"] = "Invalid File Extension";
            $return_array["return_message"] = "The extension of the image file does not match with it's name";
            $return_array["return_type"] = "error";
            $image = false;
    }
        elseif(getimagesize($image['tmp_name'])["mime"]>MAX_FILE_SIZE){
                $return_array["return_title"] = "File Size Too Large";
        $return_array["return_message"] = "The image file size exeeds the maximum file size limit of 5 MB.";
        $return_array["return_type"] = "error";
        $image = false;
    }
        else {
                if($image["type"]=="image/png") $extension = "png";
        else if($image["type"]=="image/jpg") $extension = "jpg";
        else if($image["type"]=="image/jpeg") $extension = "jpg";
        $image_url = "uploads/posts/post_img_" . mt_rand(1,99999999) . "." . $extension;
                $upload_status = move_uploaded_file($_FILES["image"]["tmp_name"], "../" . $image_url);
    }
}

$dbquery = "INSERT INTO items (visibility_status, title, category_id, unit_price, stock_quantity, publisher_id, city, country, description, seller_id";
if(isset($image)) $dbquery .= ", `image_url`";
$dbquery .= ") VALUES ($visibility_status, \"$title\", $category_id, $unit_price, $stock_quantity, $publisher_id, \"$city\", \"$country\", \"$description\", \"$seller_id\"";
if(isset($image)) $dbquery .= ", \"$image_url\"";
$dbquery .= ");";

$result = $conn->query($dbquery);

if($result) {
    $return_array["return_message"] = "Post added successfully";
    $return_array["return_type"] = "success";
    $return_array["return_title"] = "Done";
    $return_array["return_query"] = addslashes($dbquery);
}
else{
    $return_array["return_message"] = "Post could not be added";
    $return_array["return_type"] = "error";
    $return_array["return_title"] = "Sorry";
    $return_array["return_query"] = addslashes($dbquery);
}

$return_JSON = json_encode($return_array);

echo $return_JSON;
?>