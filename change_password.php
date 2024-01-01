<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "styles.php"; ?>
    <title>Change Password - Online Books Buying & Selling Store</title>
</head>
<body class="card col-lg-10 col-md-11 mx-auto p-0 bg-dark">
    
    <?php
        include "header.php"; 
        include_once("phpModels/connection.php");
        
    ?>



    <aside></aside>
    <article class="">
        <form id='change_password' action='./phpModels/changePasswordScript.php' method='post'>
            <table id="profile_info" class="table table-hover col-md-8 mx-auto mt-5">
                <thead>
                    <tr>
                        <th scope="col" class="p-0 m-0"><img src="${(JSO.result_array.display_pic_url)?(JSO.result_array.display_pic_url):('img/svg/user_solid.png')}" alt="" srcset="" class="img-round"></th>
                        <th scope="col"><h2>Change Password</h2></th>
                    </tr>
                </thead>
                <tbody>
                    
                    <tr>
                        <td scope="col">Username</td>
                        <td scope="col" id="username">
                            
                        </td>
                    </tr>
                    <tr>
                        <td scope="row">Old Password</td>
                        <td>
                            <input type="password" class="form-control" id="oldPassword" required value="" />
                        </td>
                    </tr>
                    <tr>
                        <td scope="row">New Password</td>
                        <td>
                            <input type="password" class="form-control" id="newPassword" value="" required aria-regex="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[~!@#$%^&*()_\+\-=]).{8,}$" , aria-localStore = "books_buying_selling"/>
                            <small class="error text-danger">Choose a complex password with atleast one uppercase, lowercase, number and special character</small>
                        </td>
                    </tr>
                    <tr>
                        <td scope="row">Confirm New Password</td>
                        <td>
                            <input type="password" class="form-control" id="confirmPassword" required value="" />
                            <small class="error text-danger">Password in both fields does not match</small>
                        </td>
                    </tr>

                    <tr>
                        <td colspan='2' class='text-center'>
                            <div class="btn-group">
                                <a href="user_profile.php">
                                    <button type="button" class="btn btn-sm btn-secondary" id="cancelBtn" onclick="return false;">Cancel</button>
                                </a>
                                <button type="submit" class="btn btn-sm btn-success">Save</button>
                            </div>
                        </td>
                    </tr>

                </tbody>
            </table>
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

        if(userObj && userObj.user_type_title!="visitor") {
                document.querySelector("#username").innerText = localStorage.getItem("books_buying_selling/username");
                validateAndSubmit("#change_password", null, true, "user_profile.php");

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


