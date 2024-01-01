<?php

include_once("connection.php");


$username = $_POST['username'];
$passwordHash = $_POST['passwordHash'];
$user_type = $_POST['user_type'];
$publisher_name = $_POST['publisher_name'];
$approval = 0; 
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$gender = $_POST['gender'];
$date_of_birth = $_POST['dob'];
$email = $_POST['email'];
$cell_no = $_POST['cell_no'];
$cnic = $_POST['cnic'];
$street_address = $_POST['street_address'];
$city_country = $_POST['city_country'];
$city = explode(",",$city_country)[0];
$country = explode(",",$city_country)[1];


if(isset($_FILES['display_pic'])){
    $display_pic = $_FILES['display_pic'];
}
else{
    $display_pic = NULL;
}

if(isset($_FILES['resume'])){
    $resume = $_FILES['resume'];
}
else{
    $resume = NULL;
}

$dbprequery1 = "SELECT * FROM users WHERE `username` = \"$username\"";
$pre_result1 = $conn->query($dbprequery1);
$dbprequery2 = "SELECT * FROM user_info WHERE `username` = \"$username\"";
$pre_result2 = $conn->query($dbprequery2);

if($pre_result1->num_rows || $pre_result2->num_rows){
    $return_array["return_title"] = "Error";
    $return_array["return_message"] = "Username already exists";
    $return_array["query"] = $dbprequery1 . " and " . $dbprequery2;
    $return_array["return_type"] = "error";
}
else{
        define("MAX_FILE_SIZE",5242880);
        $ACCEPTED_FILE_TYPES = ["image/jpg", "image/png", "image/jpeg"];
        if($display_pic){
                if(!(in_array(getimagesize($display_pic['tmp_name'])["mime"], $ACCEPTED_FILE_TYPES))){
                                $return_array["return_title"] = "Invalid File Type";
                $return_array["return_message"] = "The image uploaded is not of a valid type.";
                $return_array["return_type"] = "error";
                $display_pic = false;
        }
                elseif(getimagesize($display_pic['tmp_name'])["mime"]!=$display_pic["type"]){
                                $return_array["return_title"] = "Invalid File Extension";
                $return_array["return_message"] = "The extension of the image file does not match with it's name";
                $return_array["return_type"] = "error";
                $display_pic = false;
        }
                elseif(getimagesize($display_pic['tmp_name'])["mime"]>MAX_FILE_SIZE){
                        $return_array["return_title"] = "File Size Too Large";
            $return_array["return_message"] = "The image file size exeeds the maximum file size limit of 5 MB.";
            $return_array["return_type"] = "error";
            $display_pic = false;
        }
                else {
                        if($display_pic["type"]=="image/png") $extension = "png";
            else if($display_pic["type"]=="image/jpg") $extension = "jpg";
            else if($display_pic["type"]=="image/jpeg") $extension = "jpg";
            $display_pic_url = "uploads/display_pics/" . $username . "." . $extension;
                        $upload_status = move_uploaded_file($_FILES["display_pic"]["tmp_name"], "../" . $display_pic_url);
        }
    }
    else{
        $display_pic_url = NULL;
    }

    if($resume){
        
        
                if($resume["type"]=="application/pdf") $extension = "pdf";
        else if($resume["type"]=="application/msword") $extension = "doc";
        else if($resume["type"]=="application/vnd.openxmlformats-officedocument.wordprocessingml.document") $extension = "docx";
        $resume_url = "uploads/resumes/" . $username . "." . $extension;
                $upload_status = move_uploaded_file($_FILES["resume"]["tmp_name"], "../" . $resume_url);
        
    }
    else{
        $resume_url = NULL;
    }

        $dbquery1 = "INSERT INTO users (`username`, `passwordHash`, `user_type`, `approval`) VALUES (\"$username\", \"$passwordHash\", $user_type, $approval)";

        $result1 = $conn->query($dbquery1);

        $dbquery2 = "INSERT INTO user_info (`username`, `firstname`, `lastname`, `gender`, `date_of_birth`, `email`, `cell_no`, `cnic`, `street_address`, `city`, `country`";
    if($display_pic) $dbquery2 .= ", `display_pic_url`";
    $dbquery2 .=  ") VALUES (\"$username\", \"$firstname\", \"$lastname\", \"$gender\", \"$date_of_birth\", \"$email\", \"$cell_no\", \"$cnic\", \"$street_address\", \"$city\", \"$country\"";
    if($display_pic_url) $dbquery2 .= ", \"$display_pic_url\"";
    $dbquery2 .= ");";

        $result2 = $conn->query($dbquery2);

        $dbquery3 = "SELECT * FROM publishers WHERE seller_id = \"$username\";";
    $result3 = $conn->query($dbquery3);
    if($result3 && $result3->num_rows > 0) $dbquery4 = "UPDATE publishers SET publisher_name = \"$publisher_name\" WHERE seller_id = \"$username\";";
    else $dbquery4 = "INSERT INTO publishers (publisher_name, seller_id) VALUES (\"$publisher_name\", \"$username\");";
    $result4 = $conn->query($dbquery4);

        $return_array = ["query" => $dbquery1 . "\n" . $dbquery2, "return_title" => "print_r", "return_message" => "Query Generated Successfully", "return_type" => "success"];
    

    if($result1 && $result2) {
        $return_array["return_title"] = "Success";
        $return_array["return_type"] = "success";
        $return_array["return_message"] = "User registered successfully";
    }
    else{
        $return_array["return_title"] = "Error";
        $return_array["return_message"] = "Something went wrong";
        $return_array["query"] = $dbprequery1 . " and " . $dbprequery2 . " and " . $dbquery1 . " and " . $dbquery2;
        $return_array["return_type"] = "error";
    }
}

$return_JSON = json_encode($return_array);

echo $return_JSON;
?>