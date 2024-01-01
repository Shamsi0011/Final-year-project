<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "styles.php"; ?>
    <title>Write Book Application - Online Books Buying & Selling Store</title>
</head>
<body class="card col-lg-10 col-md-11 mx-auto p-0 bg-dark">
    
    <?php
        include "header.php"; 
        include_once("phpModels/connection.php");
        include_once("phpModels/getBookScript.php");
    ?>
    <aside></aside>
    <article class="">
        <form id="book_application_form" action="./phpModels/addToApplications.php">
            <fieldset>
                <legend class="p-3">Write Your Book Application</legend>
                <textarea id="book_application" class="form-control"></textarea>
            </fieldset>
            <input type="hidden" id="currentUser" value="" />
            <input type="hidden" id="currentPassHash" value="" />
            <input type="hidden" id="book_id" value="<?php echo $_GET['book_id']; ?>" />
            <div class="btn-group">
                <a href="book_details.php?book_id=<?php echo $_GET['book_id']; ?>"><button type="button" class="btn btn-danger btn-sm">Cancel</button></a>
                <button type="submit" class="btn btn-success btn-sm">Send Application</button>
            </div>
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
    console.log(userObj.user_type_title);
        if(userObj.user_type_title=="buyer") {

                        var innerHTMLString = "";
        innerHTMLString+= `<div class="input-group">`;
                innerHTMLString += (`<a href="book_application.php?book_id=<?php echo $_GET['book_id']; ?>" class="btn btn-secondary btn-md mx-auto">Apply </a></td>`);
        innerHTMLString+= `</div>`;

                document.querySelector("#currentUser").value = localStorage.getItem("books_buying_selling/username");
        document.querySelector("#currentPassHash").value = localStorage.getItem("books_buying_selling/passwordHash");

                tinymce.init({
            selector: '#book_application',
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

                validateAndSubmit("#book_application_form", null, false, "applications_history.php");
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


