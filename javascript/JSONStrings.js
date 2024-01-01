var login_form = `{
    "legend": "Sign-in", "class": "login_credentials", "submit":"Login", "reset": "Clear", "method": "post", "actionScript": "./phpModels/loginScript.php", 
    "data": {
        "input1": {"type": "text", "id":"username", "label": "Enter Your Username", "classes": "col-md-12", "regex": "^[a-zA-Z0-9_]{3,100}$", "error": "The username is not valid", "required": "true", "localStore":"books_buying_selling"},
        "input2": {"type": "password", "id": "password", "label": "Enter Password", "classes": "col-md-12", "regex": "^.{8,20}$", "error": "The username and/or password does not match", "required": "true", "localStore":"books_buying_selling"}
    }
}`;

var password_reset_form = `{
    "legend": "Enter username and associated email address to request OTP", "class": "reset_password", "submit":"Request OTP", "reset": "Clear", "method": "post", "actionScript": "./phpModels/generateOTPScript.php", "redirect": "password_reset_otp.php", 
    "data": {
        "input1": {"type": "text", "id":"username", "label": "Enter Your Username", "classes": "col-md-12", "regex": "^[a-zA-Z0-9_]{3,100}$", "error": "The username is not valid", "required": "true"},
        "input2": {"type": "email", "id": "email", "label": "Enter Associated Email", "classes": "col-md-12", "regex": "^[a-zA-Z0-9_]{3,100}\\\\@[a-zA-Z0-9\\\\.]{2,20}\\\\.[a-zA-Z0-9]{1,10}$", "error": "The email address should be in the form of johndoe@abc.xyz", "required": "true"}
    }
}`;

var password_reset_otp_form = `{
    "legend": "Enter the generated One-Time-Password (OTP) and new account password", "class": "reset_password_otp", "submit":"Update Password", "reset": "Clear", "method": "post", "actionScript": "./phpModels/resetPasswordScript.php", "redirect": "login.php", 
    "data": {
        "input1": {"type": "text", "id":"otp", "label": "Enter OTP", "classes": "col-md-12", "regex": "^[0-9]{9}$", "error": "The OTP should be an integer between 0 and 999999999", "required": "true"},
        "input2": {"type": "password", "id":"password", "label": "Pick a Password", "regex": "^(?=.*\\\\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[~!@#$%^&*()_\\\\+\\\\-=]).{8,}$", "error": "Choose a complex password with atleast one uppercase, lowercase, number and special character", "classes": "col-md-12", "required": "true"},
        "input3": {"type": "password", "id":"confirmpass", "label": "Confirm Password", "classes": "col-md-12", "required": "true", "error": "Password in both fields does not match"}
    }
}`;

var new_book_form = `{
    "legend": "Add New Book", "class": "book_info", "submit": "+ Add", "reset": "Clear", "method": "post", "actionScript": "./phpModels/addBookScript.php", "errorAlert": "true", "data": {
        "input0": {"type": "image", "id": "image", "label": "Pick a title image for the book post (optional)", "classes": "col-md-6"}, 
        "input1": {"type": "text", "id": "title", "label": "Book Title", "classes": "col-md-6", "regex": "^[a-zA-Z0-9 \-]{3,100}$", "error": "The book title must be between 3 and 100 characters long and without any special characters", "required": "true"},
        "input2": {"type": "text", "id": "author", "label": "Book Author", "classes": "col-md-6", "regex": "^[a-zA-Z0-9 \-]{3,100}$", "error": "The book author name must be between 3 and 100 characters long and without any special characters", "required": "true"},
        "input3": {"type": "selection", "id": "category_id", "label": "Category of the offered book", "classes": "col-md-6", "values": "dynamic", "source":{"table":"item_categories", "label":"category_name", "value":"category_id"}, "required": "true"},
        "input4": {"type": "text", "id": "unit_price", "label": "Unit price", "classes": "col-md-6", "regex": "^[0-9]{1,7}$", "error": "The product price must be between the range of 1 and 10 Million", "required": "true"},
        "input5": {"type": "text", "id": "stock_quantity", "label": "Quantity in Stock", "classes": "col-md-6", "regex": "^[0-9]{1,7}$", "error": "The book quantity available must be between the range of 1 and 10 Million", "required": "true"},
        "input6": {"type": "selection", "id": "city_country", "label": "Seller Location Location", "classes": "col-md-6", "values": "dynamic", "source":{"table":"cities", "label":"name", "value":"name"}, "required": "true"},
        "input7": {"type": "selection", "id": "publisher_id", "label": "Book Publisher", "classes": "col-md-6", "values": "dynamic", "source":{"table":"publishers", "label":"publisher_name", "value":"publisher_id"}, "required": "true"},
        "input8": {"type": "textarea", "id": "description", "label": "Book Description", "classes": "col-md-12"}
    }
}`;

var navbar_items_visitor = `{
    "brand": "<i class='fas fa-home'></i> Home", "id": "mainNavBar", "data":{
        "item1": {"label": "<i class='fas fa-user-tie'> </i>Find a Book", "link":"book_listings.php"},
        "item2": {"label": "<i class='fas fa-sign-in-alt'></i> Login", "link": "login.php"},
        "item3": {"label": "<i class='fas fa-user-plus'></i> Register", "link": "registration.php"},
        "item4": {"label": "<i class='fas fa-address-card'></i> About Us", "link":"about_us.php"}
    }
}`;

var navbar_items_admin = `{
    "brand": "<i class='fas fa-home'></i> Home", "id": "mainNavBar", "data":{
        "item1": {"label": "<i class='fas fa-user-tie'></i> Browse Book Posts", "link":"book_listings.php"},
        "item2": {
            "label": "<i class='fas fa-user'></i> Admin Panel", "link": "#?", "submenu" : {
                "subitem1": {"label": "<i class='fas fa-user'></i> My Profile", "link": "user_profile.php"},
                "subitem2": {"label": "<i class='fas fa-users'></i> Search Users", "link": "members_area.php"},
                "subitem3": {"label": "<i class='fas fa-user-shield'></i> Registrations Pending Approval", "link": "pending_registrations.php"},
                "subitem4": {"label": "<i class='fas fa-plus-square'></i> Post a Book", "link": "add_new_post.php"},
                "subitem5": {"label": "<i class='fas fa-mail-bulk'></i> Posts Pending Approval", "link": "pending_posts.php"},
                "subitem6": {"label": "<i class='fas fa-plus-square'></i> Manage Categories", "link": "manage_categories.php"},
                "subitem7": {"label": "<i class='fas fa-plus-square'></i> Manage Publishers", "link": "manage_publishers.php"}
            }
        },
        "item3": {"label": "<i class='fas fa-sign-out-alt'></i> Logout", "link":"#!", "onclick": "logout('books_buying_selling')"},
        "item4": {"label": "<i class='fas fa-address-card'></i> About Us", "link":"about_us.php"}
        
    }
}`;

var navbar_items_seller = `{
    "brand": "<i class='fas fa-home'></i> Home", "id": "mainNavBar", "data":{
        "item1": {"label": "<i class='fas fa-user-tie'></i> Browse Other Book Posts", "link":"book_listings.php"},
        "item2": {
            "label": "<i class='fas fa-user'></i> Control Panel", "link": "#?", "submenu" : {
                "subitem1": {"label": "<i class='fas fa-user'></i> My Profile", "link": "user_profile.php"},
                "subitem2": {"label": "<i class='fas fa-plus-square'></i> Post a Book", "link": "add_new_post.php"},
                "subitem3": {"label": "<i class='fas fa-plus-square'></i> Received Orders", "link": "orders.php"}
            }
        },
        "item3": {"label": "<i class='fas fa-sign-out-alt'></i> Logout", "link":"#!", "onclick": "logout('books_buying_selling')"},
        "item4": {"label": "<i class='fas fa-address-card'></i> About Us", "link":"about_us.php"}
        
    }
}`;

var navbar_items_buyer = `{
    "brand": "<i class='fas fa-home'></i> Home", "id": "mainNavBar", "data":{
        "item1": {"label": "<i class='fas fa-user-tie'></i> Find a Book", "link":"book_listings.php"},
        "item2": {"label": "<i class='fas fa-user'></i> My Orders", "link": "orders.php"},
        "item3": {"label": "<i class='fas fa-user'></i> My Cart", "link": "cart.php"},
        "item4": {"label": "<i class='fas fa-sign-out-alt'></i> Logout", "link":"#!", "onclick": "logout('books_buying_selling')"},
        "item5": {"label": "<i class='fas fa-address-card'></i> About Us", "link":"about_us.php"}
    }
}`;

var registration_form = `{
    "legend": "New Buyer Registration", "class": "reg_info", "submit":"Sign-up", "reset": "Clear" , "method": "post", "actionScript": "./phpModels/registrationScript.php", "errorAlert": "true", "data": {
        "input0": {"type": "image", "id":"display_pic", "label": "Pick a Photo", "classes": "col-md-6"},
        "input1": {"type": "radiogroup", "id":"user_type", "label": "Sign-up As Seller or Book Buyer: ", "values": [{"id": "3", "label": "Seller"}, {"id": "2", "label": "Book Buyer"}], "classes": "col-md-12", "required": "true"},
        "input1.1": {"type": "text", "id":"publisher_name", "label": "Enter the name of the publisher you represent", "classes": "col-md-12", "regex": "^[a-zA-Z0-9_ \-]{3,100}$", "error": "The publisher name must be between 8 and 100 characters long and without any special characters"},
        "input2": {"type": "text", "id":"username", "label": "Pick a Username", "classes": "col-md-12", "regex": "^[a-zA-Z0-9_]{3,100}$", "error": "The username must be between 8 and 100 characters long and without any special characters", "required": "true"},
        "input3": {"type": "password", "id":"password", "label": "Pick a Password", "regex": "^(?=.*\\\\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[~!@#$%^&*()_\\\\+\\\\-=]).{8,}$", "error": "Choose a complex password with atleast one uppercase, lowercase, number and special character", "classes": "col-md-6", "required": "true"},
        "input4": {"type": "password", "id":"confirmpass", "label": "Confirm Password", "classes": "col-md-6", "required": "true", "error": "Password in both fields does not match"},
        "input5": {"type": "text", "id":"firstname", "label": "Enter First Name", "classes": "col-md-6", "regex": "^[a-zA-Z ]{2,16}$", "error": "The name field can only contain capital or small alphabetic characters", "required": "true"},
        "input6": {"type": "text", "id":"lastname", "label": "Enter Last Name", "classes": "col-md-6", "regex": "^[a-zA-Z ]{2,16}$", "error": "The name field can only contain capital or small alphabetic characters", "required": "true"},
        "input7": {"type": "radiogroup", "id":"gender", "label": "Select Gender", "values": [{"id": "male", "label": "Male"}, {"id": "female", "label": "Female"}], "classes": "col-md-12", "required": "true"},
        "input8": {"type": "text", "id":"cnic", "label": "Enter Your CNIC Number", "classes": "col-md-12", "regex": "^[0-9]{13}$", "error": "The CNIC should consist of 13 numeric digits and without a hyphen (-)", "required": "true"},
        "input9": {"type": "date", "id": "dob", "label": "Select your date of birth", "classes": "col-md-12", "required": "true"},
        "input10": {"type": "email", "id": "email", "label": "Enter your email..", "classes": "col-md-12", "regex": "^[a-zA-Z0-9_]{3,100}\\\\@[a-zA-Z0-9\\\\.]{2,20}\\\\.[a-zA-Z0-9]{1,10}$", "error": "The email address should be in the form of johndoe@abc.xyz", "required": "true"},
        "input11": {"type": "text", "id": "cell_no", "label": "Enter your mobile number", "classes": "col-md-12", "regex": "^03[0-4][0-9]{8}$", "error": "The phone number should be in the form of 03121234567", "required": "true"},
        "input12": {"type": "text", "id": "street_address", "label": "Enter your street address and house number (if any)", "classes": "col-md-12", "required": "true"},
        "input13": {"type": "selection", "id": "city_country", "label": "Choose Your City", "classes": "col-md-6", "values": "dynamic", "source":{"table":"cities", "label":"name", "value":"name"}, "required": "true"}
    }
}`;