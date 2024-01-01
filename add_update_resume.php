<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "styles.php"; ?>
    <title>Add/Update Resume - Online Books Buying & Selling Store</title>
</head>
<body class="card col-lg-10 col-md-11 mx-auto p-0 bg-dark">
    <?php include "header.php"; ?>
    <aside></aside>
    <article class="mb-5">
        <form id="update_resume_form" class="card col-lg-10 mx-auto mt-3 p-0" action="./phpModels/addUpdateResumeScript.php" method="post">
            <div class="btn-group">
                <a href="resume.php"><button type="button" class="btn btn-danger btn-sm">Cancel</button></a>
                <button type="submit" class="btn btn-secondary btn-sm">Save</button>
            </div>
            <textarea id="resume" class="form-control"></textarea>
            <div class="btn-group">
                <a href="resume.php"><button type="button" class="btn btn-danger btn-sm">Cancel</button></a>
                <button type="submit" class="btn btn-secondary btn-sm">Save</button>
            </div>
            <input type="hidden" id="profile_username" value="" />
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

                        document.querySelector("#profile_username").value = profile_username;

                        getResume("#resume", profile_username);

                        tinymce.init({
                selector: '#resume',
                height: 600,
                theme: 'modern',
                plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools'
                ],
                toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                toolbar2: 'print preview media | forecolor backcolor emoticons',
                image_advtab: true
            });

                        validateAndSubmit("#update_resume_form", null, false, "resume.php");

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


