<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "styles.php"; ?>
    <title>User Profile - Online Books Buying & Selling Store</title>
</head>
<body class="card col-lg-10 col-md-11 mx-auto p-0 bg-dark">
    
    <?php
        include "header.php"; 
        include_once("phpModels/connection.php");
        
    ?>

    <aside></aside>
    <article class="">
    <form id='edit_profile' action='./phpModels/updateProfileScript.php' method='post'>

    </form>
    </article>
    
    <?php include "footer.php"; ?>
    <?php include "scripts.php"; ?>
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

                if(userObj.user_type_title=="buyer" || userObj.user_type_title=="admin" || userObj.user_type_title=="seller") {

                        var getMatch = window.location.href.match(/\?(username)=(.*)$/mi);
            console.log(getMatch);
            var profile_username;
            if(getMatch && userObj.user_type_title == "admin"){
                profile_username = getMatch[2];
            }
            else{
                profile_username = localStorage.getItem("books_buying_selling/username");
            }

                        editUserProfile("#edit_profile", profile_username, localStorage.getItem("books_buying_selling/username"), localStorage.getItem("books_buying_selling/passwordHash"));
                        validateAndSubmit("#edit_profile", null, true, "user_profile.php?username=" + profile_username);
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


