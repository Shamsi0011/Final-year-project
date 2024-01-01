<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https:    <link rel="stylesheet" href="https:    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/mdb.min.css">
    <link rel="shortcut icon" href="./img/mono.png" type="image/png">
    <!-- Plugin file -->
    <link rel="stylesheet" href="./css/addons/datatables.min.css">
    <link rel="stylesheet" href="css/compiled-4.19.2.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Orders - Online Books Buying & Selling Store</title>
</head>
<body class="card col-lg-10 col-md-11 mx-auto p-0">
    <?php include "header.php"; ?>

    <aside></aside>
    <article class="" style="min-height: 90vh">
        <div id="registration_form" class="card col-lg-5 mx-auto mt-3 p-0"></div>
        <!-- <div class="d-flex col-5 mx-auto mt-3 justify-content-center text-center"><a class="text-secondary h4" style="display: block;">Welcome to Member's Area</a></div>
        <h4 class="d-flex col-5 mx-auto mt-3 justify-content-center text-center">Type something in the search bar to list users</h4> -->
        <h3 class="p-3">Orders List</h3>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Order#</th>
                    <th scope="col">Product</th>
                    <th scope="col">Product#</th>
                    <th scope="col">Ordered By</th>
                    <th scope="col">Unit Price</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Total Price</th>
                    <th scope="col">Ordered On</th>
                    <th scope="col">Invoice#</th>
                    <th scope="col">Order Status</th>
                </tr>
            </thead>
            <tbody id="ordersList">

            </tbody>
        </table>
        </div>
    </article>
    
    <?php include "footer.php"; ?>
    
    <script type="text/javascript" src="javascript/jquery.min.js"></script>
    <script type="text/javascript" src="javascript/jquery.md5.js"></script>
    <script type="text/javascript" src="javascript/popper.min.js"></script>
    <script type="text/javascript" src="javascript/bootstrap.min.js"></script>
    <script type="text/javascript" src="javascript/mdb.min.js"></script>
    <!-- <script type="module" src="javascript/material-design-bootstrap.js"></script> -->
    <!-- Plugin file -->
    <script src="./javascript/addons/datatables.min.js"></script>
    <script src="javascript/JSONStrings.js"></script>
    <script src="javascript/my_funcs.js"></script>
    <script>
        var login_result = onLoadAuthentication("books_buying_selling");
        if(login_result == true) {
            console.log("Already Logged in");
        }
        else {
            window.location.href="login.php";
        }

        var userObj = getUserObj("books_buying_selling");

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

        var getMatch = window.location.href.match(/\?(orders_username)=(.*)$/mi);
        console.log(getMatch);
        var orders_username;
        if(getMatch){
            orders_username = getMatch[2];
        }
        else{
            orders_username = localStorage.getItem("books_buying_selling/username");
        }

        listOrders("#ordersList", orders_username, localStorage.getItem("books_buying_selling/username"), localStorage.getItem("books_buying_selling/passwordHash"));


                $(document).ready(function() {
                    });
    </script>
</body>
</html>
