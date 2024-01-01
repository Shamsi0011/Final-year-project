<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "styles.php"; ?>
    <title>Manage Featured Items - Online Books Buying & Selling Store</title>
</head>
<body class="card col-lg-10 col-md-11 mx-auto p-0 bg-dark">
    <?php include "header.php"; ?>
    <!--Carousel Wrapper-->
    <div id="carouselContainer" class="p-0 m-0"></div>
    <!--/.Carousel Wrapper-->
    <h4 class="pt-5 mt-5 pb-0 mb-0 ml-3">Some Featured Recommendations</h4>
    <div id="page_body" class="card col-lg-10 mx-auto mt-3 p-0"></div>
    <article class="row p-3" id="featuredItems"></article>

    <?php include "footer.php"; ?>
    
    <?php include "scripts.php"; ?>
    
    <script>

    var userObj = getUserObj("books_buying_selling");
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

    JSON2Carousel("#carouselContainer");
    
        $(document).ready(function() {
            });

    featuredListing("#featuredItems");

    addProductSearch(".searchForm", "#carouselContainer");

    </script>
</body>
</html>

