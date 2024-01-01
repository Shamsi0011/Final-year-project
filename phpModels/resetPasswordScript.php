<?php
    include_once("connection.php");
        $otp = $_POST['otp'];
    $passwordHash = $_POST['passwordHash'];
    
        $dbprequery = "SELECT * FROM password_reset_otp WHERE otp = $otp";
    $preresult = $conn->query($dbprequery);
        if($preresult && $preresult->num_rows > 0){
        $preresultArray = mysqli_fetch_assoc($preresult);
        $username = $preresultArray["username"];
        $dbquery1 = "UPDATE users SET passwordHash = \"$passwordHash\" WHERE username = \"$username\";";
        $result = $conn->query($dbquery1);
                if($result){
            $return_array["return_title"] = "Success";
            $return_array["return_message"] = "Password reset successfully";
            $return_array["return_type"] = "success";
            $return_array["query"] = $dbquery1;
            $dbquery2 = "DELETE FROM password_reset_otp WHERE otp = $otp;";
            $conn->query($dbquery2);
        }
                else{
            $return_array["return_title"] = "Unknown Error";
            $return_array["return_message"] = "An unknown error occured resetting your password. Check console log for details";
            $return_array["return_type"] = "error";
            $return_array["query"] = $dbquery1;
        }
    }
        else{
        $return_array["return_title"] = "Authentication Error";
        $return_array["return_message"] = "The provided OTP is not valid";
        $return_array["return_type"] = "error";
        $return_array["query"] = $dbprequery1;
    }
    echo json_encode($return_array);
?>