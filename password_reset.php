<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "styles.php"; ?>
    <title>Generate OTP to Reset Your Password - Online Books Buying & Selling Store</title>
</head>
<body class="card col-lg-10 col-md-11 mx-auto p-0 bg-dark">
    <?php include "header.php"; ?>
    
    <form class="row p-3 card col-md-6 mx-auto mt-3" id="password_reset_form"></form>

    <div class="text-center mt-1 pt-1">Already have password reset OTP?<br /><a class="h5" href="password_reset_otp.php">Click here</a><br />to enter OTP and reset password</div>

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
        renderForm(password_reset_form, "#password_reset_form");
    }

    </script>
</body>
</html>

