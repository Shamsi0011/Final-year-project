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
    <title>Pending Registrations - Online Books Buying & Selling Store</title>
</head>
<body class="card col-lg-10 col-md-11 mx-auto p-0 bg-dark">
    <?php include "header.php"; ?>
    <div class="card-header">
        <!-- Title -->
        <h4 class="card-title"><a>Pending Registrations</a></h4>
    </div>
    <!-- Card content -->
    <div class="card-body" id="pending_users">
    


    </div><!-- /.card-body -->

    <?php include "footer.php"; ?>
    <script type="text/javascript" src="javascript/jquery.min.js"></script>
    <script type="text/javascript" src="javascript/jquery.md5.js"></script>
    <script type="text/javascript" src="javascript/popper.min.js"></script>
    <script type="text/javascript" src="javascript/bootstrap.min.js"></script>
    <script type="text/javascript" src="javascript/mdb.min.js"></script>
    

    <!-- Plugin file -->
    <script src="./javascript/addons/datatables.min.js"></script>
    <script src="javascript/JSONStrings.js"></script>
    <script src="javascript/my_funcs.js"></script>
    <script>


                var userObj = getUserObj("books_buying_selling");
        console.log(userObj);
        var login_result = onLoadAuthentication("books_buying_selling");
        console.log("Login result: " + login_result);

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

                if(userObj.user_type_title=="admin") {

                        listPendingUsers("#pending_users", localStorage.getItem("books_buying_selling/username"), localStorage.getItem("books_buying_selling/passwordHash"));

        }
                else {
            if(window.location.href.match(/\?(.*?)=(.*?)$/)){
                if(window.location.href.match(/\?(.*?)=(.*?)$/)[1]=='redirect') var redirect = (window.location.href.match(/\?(.*?)=(.*?)$/)[2]);
            }
            if(redirect) window.location.href=redirect;
            else window.location.href="index.php";
        }

    </script>
</body>
</html>