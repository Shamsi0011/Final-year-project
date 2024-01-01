<?php
    include_once "connection.php";
    $dbquery = "SELECT text FROM articles WHERE article_name = \"about_us\";";
    $result = $conn->query($dbquery);
    if($result && $result->num_rows > 0){
        $resultArray = mysqli_fetch_assoc($result);
        echo $resultArray['text'];
    }
    else{
        echo "<h4>Nothing to show here</h4>";
    }
?>