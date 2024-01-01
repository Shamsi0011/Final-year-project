<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "styles.php"; ?>
    <title>About Us - Online Books Buying & Selling Store</title>
</head>
<body class="card col-lg-10 col-md-11 mx-auto p-0 bg-dark">
    <?php include "header.php"; ?>

    <div class="card-header">
        <h1 class="card-title p-3">About Us</h1>
    </div>
    <article class="row p-4 m-0 card-body" id="featuredItems">
        <div id="controls"></div>
        <?php include "./phpModels/aboutUsScript.php"; ?>
    </article>

    <?php include "footer.php"; ?>
    <?php include "scripts.php"; ?>
    
    <script>
    
        var userObj = getUserObj("books_buying_selling");
    console.log(userObj);

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

    if(userObj.user_type_title == "admin"){
        document.querySelector("#controls").innerHTML = `<a href="edit_about_us.php" class='btn btn-light btn-sm'><i class="fas fa-edit"></i> Edit</a>`;
    }


    </script>
</body>
</html>

