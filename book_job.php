<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "styles.php"; ?>
    <title>Edit Book Details - Online Books Buying & Selling Store</title>
</head>
<body class="card col-lg-10 col-md-11 mx-auto p-0 bg-dark">
    
    <?php
        include "header.php"; 
        include_once("phpModels/connection.php");
        include_once("phpModels/getBookScript.php");
    ?>
    <aside></aside>
    <form class="card" method="post" action="./phpModels/updateBookScript.php" id="edit_book">

        <table class="table table-hover col-md-8 mx-auto mt-5">
            <thead>
                <tr class="card-header">
                    <th scope="col" colspan="2"><h2>Edit Book Details</h2></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td scope="col" colspan="2" class="p-0 m-0"><img src="<?php echo $resultArray["image_url"]; ?>" alt="" srcset="" class="img-round"></td>
                </tr>
                <tr>
                    <td scope="col">Book Post ID</td>
                    <td scope="col">
                        <?php echo $resultArray["id"]; ?>
                        <input type="hidden" id="id" value="<?php echo $resultArray["id"]; ?>" />
                    </td>
                </tr>
                <tr>
                    <td scope="row">Book Title</td>
                    <td><input id="title" class="form-control" type="text" value="<?php echo $resultArray["title"]; ?>" /></td>
                </tr>
                <tr>
                    <td scope="row">Category</td>
                    <td>
                        <select class="form-control" id="category_id">
                        <?php
                            $current_category_id=$resultArray['category_id'];
                            $current_category_name=$resultArray['category_name'];
                            echo "<option selected disabled value=\"$current_category_id\">$current_category_name</option>";
                            foreach ($resultArray["item_categories"] as $category_id => $category) {
                                $category_name = $category['category_name'];
                                echo "<option value=\"$category_id\">$category_name</option>";
                            }
                        ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td scope="row">Unit Price</td>
                    <td><input id="unit_price" class="form-control" type="text" value="<?php echo $resultArray["unit_price"]; ?>" /></td>
                </tr>
                <tr>
                    <td scope="row">Book Description</td>
                    <td><textarea id="description" class="form-control" style="font-family: sans-serif;"><?php echo $resultArray["description"]; ?></textarea></td>
                </tr>
                <tr>
                    <td scope="row">Stock Quantity</td>
                    <td><input id="stock_quantity" class="form-control" type="number" value="<?php echo $resultArray["stock_quantity"]; ?>" /></td>
                </tr>
                <tr>
                    <td scope="row">Publishing Company</td>
                    <td>
                        <select class="form-control" id="publisher_id">
                            <?php
                                $current_publisher_id=$resultArray['publisher_id'];
                                $current_publisher_name=$resultArray['publisher_name'];
                                echo "<option selected disabled value=\"$current_publisher_id\">$current_publisher_name</option>";
                                foreach ($resultArray["publishers"] as $publisher_id => $publisher) {
                                    $publisher_name = $publisher['publisher_name'];
                                    echo "<option value=\"$publisher_id\">$publisher_name</option>";
                                }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td scope="row">City</td>
                    <td>
                        <select class="form-control" id="city_country">
                        <?php
                            $current_city = $resultArray['city'];
                            $current_country = $resultArray['country'];
                            echo "<option selected disabled value=\"$current_city,$current_country\">$current_city,$current_country</option>";
                            foreach ($resultArray["cities"] as $city_id => $city) {
                                $city_name = $city['name'];
                                echo "<option value=\"$city_name\">$city_name</option>";
                            }
                        ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td id="controls" colspan="2">
                        <div class="btn-group">
                            <a href="book_details.php?book_id=<?php echo $_GET['book_id']; ?>"><button type="button" class="btn btn-sm btn-danger">Cancel</button></a>
                            <button class="btn btn-sm btn-success" type="submit">Save</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
    
    <?php include "footer.php"; ?>
    <?php include "scripts.php"; ?>
    <script>


                var userObj = getUserObj("books_buying_selling");
        console.log(userObj);
        var login_result = onLoadAuthentication("books_buying_selling");
        console.log("Login result: " + login_result);
        var current_user = localStorage.getItem("books_buying_selling/username");
        var current_passHash = localStorage.getItem("books_buying_selling/passwordHash");

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

                if(userObj.user_type_title=="admin" || (userObj.user_type_title=="seller" && current_user == "<?php echo $resultArray["seller_id"]; ?>")) {
            tinymce.init({
            selector: '#description',
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
        
                        validateAndSubmit("#edit_book", null, true, "book_details.php?book_id=<?php echo $resultArray["id"]; ?>");

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


