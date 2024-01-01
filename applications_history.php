<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "styles.php"; ?>
    <title>Applications History - Online Books Buying & Selling Store</title>
</head>
<body class="card col-lg-10 col-md-11 mx-auto p-0 bg-dark">
    <?php include "header.php"; ?>
    <aside></aside>
    <article class="" style="min-height: 90vh">
        <h1 class="m-3">Applications History</h1>
        <div id="applicationsList"></div>
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
                if(userObj){
            if(userObj.user_type_title=="buyer" || userObj.user_type_title=="admin") {

                                var getMatch = window.location.href.match(/\?(username)=(.*)$/mi);
                console.log(getMatch);
                var profile_username;
                if(getMatch && userObj.user_type_title == "admin"){
                    profile_username = getMatch[2];
                }
                else{
                    profile_username = localStorage.getItem("books_buying_selling/username");
                }
                console.log("#applicationsList", profile_username, localStorage.getItem("books_buying_selling/username"), localStorage.getItem("books_buying_selling/passwordHash"));
                                listApplications("#applicationsList", profile_username, localStorage.getItem("books_buying_selling/username"), localStorage.getItem("books_buying_selling/passwordHash"));

            }
            else{
                if(window.location.href.match(/\?(.*?)=(.*?)$/)){
                if(window.location.href.match(/\?(.*?)=(.*?)$/)[1]=='redirect') var redirect = (window.location.href.match(/\?(.*?)=(.*?)$/)[2]);
                }
                if(redirect) window.location.href=redirect;
                else window.location.href="index.php";
            }
        }


    </script>
</body>
</html>
