<?php


    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'src/Exception.php';
    require 'src/PHPMailer.php';
    require 'src/SMTP.php';


    include_once "connection.php";

        $username = $_POST['username'];
    $email = $_POST['email'];


        $dbprequery1 = "SELECT * FROM user_info WHERE username = \"$username\" AND email = \"$email\";";
    $preresult1 = $conn->query($dbprequery1);
    $dbprequery2 = "SELECT * FROM password_reset_otp WHERE username = \"$username\";";
    $preresult2 = $conn->query($dbprequery2);

        if($preresult1 && $preresult1->num_rows > 0){
                $otp = mt_rand(100000000,999999999);
                if($preresult2 && $preresult2->num_rows > 0){
            $dbquery = "UPDATE password_reset_otp SET otp = $otp WHERE username = \"$username\";";
        }
        else{
            $dbquery = "INSERT INTO password_reset_otp (username, otp) VALUES (\"$username\", $otp);";
        }
        $result = $conn->query($dbquery);
                if($result){
            $return_array["return_title"] = "Success";
            $return_array["return_message"] = "OTP Generated Successfully. Please enter OTP in the next screen to set a new password.";
            $return_array["return_type"] = "success";
            $return_array["query"] = $dbquery;

                        $message = "
                <h1>Hello $username</h1>
                <p>
                    The OTP code for recovery for your account is: $otp
                </p>
            ";

            $mail = new PHPMailer(true);
            $mail->IsSMTP(); 
                        $mail->Host = "smtp.gmail.com"; 
            $mail->Port = "465"; 
            $mail->SMTPSecure = 'ssl'; 
            $mail->SMTPAuth = true;
            $mail->Username = "storebook046@gmail.com";
            $mail->Password = "03043631416";
            $mail->setFrom("storebook046@gmail.com", "Online Books Buying & Selling Store");
            $mail->addAddress("$email", "$username");
            $mail->addAddress("najan41459@specialistblog.com", "Somo Anon");
            $mail->Subject = 'OTP for password recovery';
            $mail->msgHTML("$message"); 
            $mail->AltBody = 'HTML not supported';
            

            try{
                $mail->Send();
                $return_array["email_status"] = "Success";
            } catch(Exception $e){
                                $return_array["email_status"] = "Fail - " . $mail->ErrorInfo;
            }


        }
                else{
            $return_array["return_title"] = "Unknown Error";
            $return_array["return_message"] = "An unknown error occured. Check console log for errors";
            $return_array["return_type"] = "error";
            $return_array["query"] = $dbquery;
        }
    }
        else{
        $return_array["return_title"] = "Authentication Error";
        $return_array["return_message"] = "The provided email address and username do not match";
        $return_array["return_type"] = "error";
        $return_array["query"] = $dbprequery1;
    }

    echo json_encode($return_array);
?>