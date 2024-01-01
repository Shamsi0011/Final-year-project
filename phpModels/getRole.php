<?php

    include_once("connection.php");

        $username = $_POST['username'];
    $passwordHash = $_POST['passwordHash'];

        $dbquery = "SELECT `users`.`username`, `users`.`user_type`, `user_types`.`user_type_title` FROM `users`, `user_types` WHERE `users`.`user_type` = `user_types`.`user_type_id` AND `users`.`username` = \"$username\" AND `users`.`passwordHash`=\"$passwordHash\";";

        $result = $conn->query($dbquery);

    if($result){
        $resultArray = mysqli_fetch_assoc($result);
        $returnJSON = json_encode($resultArray);
        echo $returnJSON;
    }
    else{
                var_dump($result);
    }
?>