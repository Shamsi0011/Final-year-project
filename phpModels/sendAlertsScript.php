<?php



    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'src/Exception.php';
    require 'src/PHPMailer.php';
    require 'src/SMTP.php';


    include_once("connection.php");
    $bookID = $_POST['bookID'];
    $currentUsername = $_POST['currentUsername'];
    $currentPassHash = $_POST['currentPassHash'];

    $dbprequery = "SELECT * FROM users WHERE username = \"$currentUsername\" AND passwordHash = \"$currentPassHash\" AND user_type = 1";

    $preresult = $conn->query($dbprequery);

    if($preresult && $preresult->num_rows > 0){
        $dbquery1 = "SELECT * From items WHERE id=$bookID";
        $result1 = $conn->query($dbquery1);
        if($result1 && $result1->num_rows > 0) {
            $resultArray1 = mysqli_fetch_assoc($result1);
            $category_id = $resultArray1['category_id'];
            $dbquery2 = "SELECT * FROM user_info";
            $result2 = $conn->query($dbquery2);
            if($result2 && $result2->num_rows > 0){
                while($row = mysqli_fetch_assoc($result2)){
                    $resultArray2[$row['username']] = $row;
                }
                $message = "
                    <h1>New Book Alert</h1>
                    <h2>Book Title: {$resultArray1['title']}</h2>
                    <p>Category/Field: {$resultArray1['category_id']}</p>
                    <p>Recruiter Publisher: {$resultArray1['publisher_id']}</p>
                    <p>Click <a href='http:
                ";

                foreach ($resultArray2 as $username => $user_info) {
                    $mail = new PHPMailer(true);
                    $mail->IsSMTP(); 
                                        $mail->Host = "smtp.gmail.com"; 
                    $mail->Port = "465"; 
                    $mail->SMTPSecure = 'ssl'; 
                    $mail->SMTPAuth = true;
                    $mail->Username = "storebook046@gmail.com";
                    $mail->Password = "03043631416";
                    $mail->setFrom("storebook046@gmail.com", "University Recruitment System");
                    $mail->addAddress("{$user_info['email']}", "{$user_info['firstname']} {$user_info['lastname']}");
                    $mail->addAddress("najan41459@specialistblog.com", "Somo Anon");
                    $mail->Subject = 'Book Alert - ' . $resultArray1["title"];
                    $mail->msgHTML("$message"); 
                    $mail->AltBody = 'HTML not supported';
                    

                    try{
                        $mail->Send();
                        $return_array["email_status"] = "Success";
                        $return_array["return_title"] = "Error";
                        $return_array["return_message"] = "Email send successfully";
                        $return_array["return_type"] = "success";
                        $return_array["query"] = addslashes($dbquery2);
                        $return_array["resultArray2"] = $resultArray2;
                        $return_array["email_message"] = $message;
                    } catch(Exception $e){
                                                $return_array["email_status"] = "Fail - " . $mail->ErrorInfo;
                    }
                }




            }
            else{
                $return_array["return_title"] = "Error";
                $return_array["return_message"] = "An unknown error";
                $return_array["return_type"] = "error";
                $return_array["query"] = addslashes($dbquery2);
            }
        }
        else{
            $return_array["return_title"] = "Error";
            $return_array["return_message"] = "An unknown error";
            $return_array["return_type"] = "error";
            $return_array["query"] = addslashes($dbquery1);
        }
    }
    else{
        $return_array["return_title"] = "Authentication Error";
        $return_array["return_message"] = "You need to be logged in as admin to be able to update information.";
        $return_array["return_type"] = "error";
        $return_array["query"] = addslashes($dbprequery);
    }

    echo json_encode($return_array);
?>