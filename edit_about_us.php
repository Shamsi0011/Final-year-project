<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "styles.php"; ?>
    <title>Edit About Us - Online Books Buying & Selling Store</title>
</head>
<body class="card col-lg-10 col-md-11 mx-auto p-0 bg-dark">
    <?php include "header.php"; ?>

    <div class="card-header">
        <h1 class="card-title p-3">About Us</h1>
    </div>
    <form class="row p-4 m-0 card-body" id="editAboutUsForm" action="./phpModels/editAboutUsScript.php">
        <textarea id="editAboutUs" class="form-control">
            <?php include "./phpModels/aboutUsScript.php"; ?>
        </textarea>
        <div class="btn-group mb-3"><button class="btn btn-sm btn-danger" type="button">Cancel </button><button class="btn btn-sm btn-secondary" type="submit">Save</button></div>
    </form>

    <?php include "footer.php"; ?>
    <?php include "scripts.php"; ?>
    
    <script>
    
        var userObj = getUserObj("books_buying_selling");
    console.log(userObj);

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
        tinymce.init({
            selector: '#editAboutUs',
            height: 600,
            width: '100%',
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

            validateAndSubmit("#editAboutUsForm", null, true, "about_us.php");
    }
    else {
        if(window.location.href.match(/\?(.*?)=(.*?)$/)){
            if(window.location.href.match(/\?(.*?)=(.*?)$/)[1]=='redirect') var redirect = (window.location.href.match(/\?(.*?)=(.*?)$/)[2]);
        }
        if(redirect) window.location.href=redirect;
        else window.location.href="about_us.php";
    }

    </script>
</body>
</html>

