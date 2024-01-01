<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "styles.php"; ?>
    <title>Manage Categories - Online Books Buying & Selling Store</title>
</head>
<body class="card col-lg-10 col-md-11 mx-auto p-0 bg-dark">
    <?php include "header.php"; ?>
    <aside></aside>
    <article id="category_management" class="card col-lg-12 mx-auto mt-3 p-0" style="min-height: 90vh">
        <div class="card-header"><h4>Manage Categories</h4></div>
        <form id="addCategoryForm">
            <div class="input-group my-3 mx-auto col-5">
                <input type="text" class="form-control" placeholder="Category Name" id="categoryName">
                <div class="input-group-append">
                    <button class="btn btn-md btn-outline-default m-0 px-3 py-2 z-depth-0 waves-effect" type="submit" id="addCategory">Add</button>
                </div>
            </div>
        </form>
        <div id="category_list"></div>
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

                if(userObj.user_type_title=="admin") {

            document.querySelector("#addCategoryForm").addEventListener("submit",(event)=>{
            event.preventDefault();
            addCategory();
            });

            listCategories();

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

