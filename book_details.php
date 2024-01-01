<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "styles.php"; ?>
    <title>More Info - Online Books Buying & Selling Store</title>
</head>
<body class="card col-lg-10 col-md-11 mx-auto p-0 bg-dark">
    
    <?php
        include "header.php"; 
        include_once("phpModels/connection.php");
        include_once("phpModels/getBookScript.php");
    ?>
    <aside></aside>
    <article class="">
    <table class="table table-hover col-md-8 mx-auto mt-5 text-light">
        <thead>
            <tr>
                <th scope="col" colspan="2"><h2><?php echo $resultArray["title"]; ?></h2></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td scope="col" colspan="2" class="p-0 m-0"><img src="<?php echo $resultArray["image_url"]; ?>" alt="" srcset="" class="img-round"></td>
            </tr>
            <tr>
                <td scope="col">Book Post ID</td>
                <td scope="col"><?php echo $resultArray["id"]; ?></td>
            </tr>
            <tr>
                <td scope="row">Book Title</td>
                <td><?php echo $resultArray["title"]; ?></td>
            </tr>
            <tr>
                <td scope="row">Book Genre</td>
                <td><?php echo $resultArray["category_name"]; ?></td>
            </tr>
            <tr>
                <td scope="row">Unit price</td>
                <td><?php echo $resultArray["unit_price"]; ?></td>
            </tr>
            <tr>
                <td scope="row">Stock Quantity</td>
                <td><?php echo $resultArray["stock_quantity"]; ?></td>
            </tr>
            <tr>
                <td scope="row">Publisher</td>
                <td><?php echo $resultArray["publisher_name"]; ?></td>
            </tr>
            <tr>
                <td scope="row">Description</td>
                <td><p><?php echo $resultArray["description"]; ?></p></td>
            </tr>
            <tr>
                <td scope="row">Seller City</td>
                <td><?php echo $resultArray["city"]; ?></td>
            </tr>
            <tr>
                <td scope="row">Seller Country</td>
                <td><?php echo $resultArray["country"]; ?></td>
            </tr>
            <tr>
                
                <td id="controls" colspan="2">
                
                </td>
            </tr>
        </tbody>
    </table>
    </article>
    
    <?php include "footer.php"; ?>
    <?php include "scripts.php"; ?>
    <script>

        var userObj = getUserObj("books_buying_selling");
    console.log(userObj);
    var login_result = onLoadAuthentication("books_buying_selling");
    console.log("Login result: " + login_result);
    var current_user = localStorage.getItem("books_buying_selling/username");
    var current_passHash = localStorage.getItem("books_buying_selling/passwordHash");

        if(userObj){
        if(userObj.user_type_title=="admin"){
            JSON2navbar(navbar_items_admin, "#mainNav");
        }
        else if(userObj.user_type_title=="buyer"){
            JSON2navbar(navbar_items_buyer, "#mainNav");
        }
        else if(userObj.user_type_title=="seller"){
            JSON2navbar(navbar_items_seller, "#mainNav");
        }
        else{
            JSON2navbar(navbar_items_visitor, "#mainNav");
        }
    }
    else{
            JSON2navbar(navbar_items_visitor, "#mainNav");
    }

        var innerHTMLString = "";
        if(userObj.user_type_title=='buyer'){
        innerHTMLString+= `<div class="input-group">`;
        innerHTMLString+= `<input id="qty" type="number" class="form-control col-1" value=1 />`;
        innerHTMLString += (`<button type="button" onclick="addToCart(<?php echo $_GET["book_id"] ?>, '${localStorage.getItem("books_buying_selling/username")}', '${localStorage.getItem("books_buying_selling/passwordHash")}')" class="btn btn-secondary btn-md mx-auto">Add To Cart </button></td>`);
        innerHTMLString+= `</div>`;
    }
        if(login_result==false){
        innerHTMLString += (`<a href="login.php" class="btn btn-sm btn-success">Log in to Add To Cart</a>`);
    }
         if(userObj.user_type_title=='admin' || (userObj.user_type_title=="seller" && current_user == "<?php echo $resultArray["seller_id"]; ?>")){
        innerHTMLString += (`<a href="edit_book.php?book_id=<?php echo $resultArray["id"]; ?>" class="btn btn-sm btn-warning">Edit Book</a>`);
        innerHTMLString += (`<a href="#?" onclick="deleteBook(<?php echo $_GET["book_id"] ?>, '${localStorage.getItem("books_buying_selling/username")}', '${localStorage.getItem("books_buying_selling/passwordHash")}')" class="btn btn-sm btn-danger">Remove Book</a>`); 
    }
    if(userObj.user_type_title=='admin'){
        <?php if($resultArray['slider_visibility']==1){ ?>
        innerHTMLString += (`<a href="#?" onclick="removeFromFeaturedSlide(<?php echo $_GET["book_id"] ?>, '${localStorage.getItem("books_buying_selling/username")}', '${localStorage.getItem("books_buying_selling/passwordHash")}')" class="btn btn-sm btn-secondary">Remove From Featured Slide</a>`); 
        <?php } else{ ?>
        innerHTMLString += (`<a href="#?" onclick="addToFeaturedSlide(<?php echo $_GET["book_id"] ?>, '${localStorage.getItem("books_buying_selling/username")}', '${localStorage.getItem("books_buying_selling/passwordHash")}')" class="btn btn-sm btn-success">Add to Featured Slide</a>`);
        <?php } ?>
        
        <?php if($resultArray['landing_page_visibility']==1){?>
        innerHTMLString += (`<a href="#?" onclick="removeFromFeaturedPosts(<?php echo $_GET["book_id"] ?>, '${localStorage.getItem("books_buying_selling/username")}', '${localStorage.getItem("books_buying_selling/passwordHash")}')" class="btn btn-sm btn-secondary">Remove From Featured Posts</a>`); 
        <?php } else{ ?>
        innerHTMLString += (`<a href="#?" onclick="addToFeaturedPosts(<?php echo $_GET["book_id"] ?>, '${localStorage.getItem("books_buying_selling/username")}', '${localStorage.getItem("books_buying_selling/passwordHash")}')" class="btn btn-sm btn-success">Add to Featured Posts</a>`); 
        <?php } ?>
        innerHTMLString += (`<a href="#?" onclick="sendAlerts(<?php echo $_GET["book_id"] ?>, '${localStorage.getItem("books_buying_selling/username")}', '${localStorage.getItem("books_buying_selling/passwordHash")}')" class="btn btn-sm btn-success">Send Email Alerts for This Post</a>`); 
    }
    document.querySelector("#controls").innerHTML = (innerHTMLString);

    </script>
</body>
</html>


