<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "styles.php"; ?>
    <title>Registration - Online Books Buying & Selling Store</title>
</head>
<body class="col-lg-10 col-md-11 mx-auto p-0">
    <?php include "header.php"; ?>
    
    
    <form class="card" id="registration_form"></form>

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

        if(login_result == true) {
        console.log("Already Logged in");
        if(window.location.href.match(/\?(.*?)=(.*?)$/)){
            if(window.location.href.match(/\?(.*?)=(.*?)$/)[1]=='redirect') var redirect = (window.location.href.match(/\?(.*?)=(.*?)$/)[2]);
        }
        if(redirect) window.location.href=redirect;
        else window.location.href="index.php";
    }
    else {
        renderForm(registration_form, "#registration_form");
                $("#publisher_name").parent().hide();
        document.querySelectorAll("[name=user_type]").forEach((thisInput)=>{
            thisInput.addEventListener("change",(e)=>{
                console.log(e.currentTarget.id);
                if(e.currentTarget.id == 3){
                    $("#publisher_name").parent().show(300);
                }
                else{
                    $("#publisher_name").parent().hide(300);
                    $("#publisher_name").val("null");
                }
            });
        });
    }

    </script>
</body>
</html>

