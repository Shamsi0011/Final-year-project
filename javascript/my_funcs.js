var process = (formData, phpScript, redirect=false, showModal=false)=>{
    console.log("Form Processing started");
        var XHR = new XMLHttpRequest();
        XHR.open("POST", phpScript);
        XHR.onreadystatechange = ()=>{
                if(XHR.readyState == 4 && XHR.status == 200){
            console.log(XHR.responseText);
            
            var responseJSO = JSON.parse(XHR.responseText);
            
                        if (responseJSO.return_message && responseJSO.return_message!=""){
                if(showModal==true){
                    document.querySelector("#alertModal").querySelector(".modal-title").innerText = responseJSO.return_title;
                    if(responseJSO.return_type=="success") {
                        document.querySelector("#alertModal").querySelector(".modal-title").classList.add("text-success");
                    }
                    else if(responseJSO.return_type) document.querySelector("#alertModal").querySelector(".modal-title").classList.add("text-danger");
                    else document.querySelector("#alertModal").querySelector(".modal-title").classList.add("text-secondary");

                    document.querySelector("#alertModal").querySelector(".modal-body").innerText = responseJSO.return_message;

                    $(document.querySelector("#alertModal")).modal("show");
                }
                alert(responseJSO.return_message);
                if(responseJSO.return_type=="success"){
                    if (redirect==false) window.location.reload();
                    else window.location.replace(redirect);
                }
            }
        }
    }
                    XHR.send(formData);

} 
var validateAndSubmit = (formSelector, actionScript=null, errorAlert=false, redirect=false)=>{
    $(formSelector + " small.error").hide();
    var formElement = document.querySelector(formSelector);
    if(actionScript==null){
        actionScript = formElement.getAttribute("action");
    }
    console.log("validateAndSubmit() function: \n");
    console.log("formSelector is: " + formSelector);
    console.log("actionScript is: " + actionScript);
    console.log("errorAlert is: " + errorAlert);
        formElement.addEventListener("submit", (event)=>{
                formValid = true;

                var formData = new FormData();
        
                event.preventDefault();

                document.querySelectorAll("input, select, textarea").forEach((thisInput)=>{
            
                        if(thisInput.getAttribute("type")=="radio"){
                if(thisInput.checked)
                formData.append(thisInput.name, thisInput.id);
            }
                        else if(thisInput.getAttribute("type")=="checkbox"){
                                var checkedBoxes = [];
                                document.getElementsByName(thisInput.name).forEach((thisCheckbox)=>{
                    if(thisCheckbox.checked){
                        checkedBoxes.push(thisCheckbox.id);
                    }
                });
                                checkedBoxes = JSON.stringify(checkedBoxes);
                formData.append(thisInput.name, checkedBoxes);
            }
                        else if(thisInput.getAttribute("type")=="text" || thisInput.getAttribute("type")=="password"){
                console.log("Appending input text " + thisInput.value);
                                if(thisInput.getAttribute("type")=="text") {
                    formData.append(thisInput.id, thisInput.value);
                    if(thisInput.getAttribute("aria-localStore")) {
                        localStorage.setItem(thisInput.getAttribute("aria-localStore") + "/" + thisInput.id, thisInput.value);
                        
                        
                    };
                }
                                if(thisInput.getAttribute("type")=="password") {
                    formData.append(thisInput.id + "Hash", $.md5(thisInput.value));
                    if(thisInput.getAttribute("aria-localStore")) {
                        localStorage.setItem(thisInput.getAttribute("aria-localStore") + "/" + thisInput.id + "Hash", $.md5(thisInput.value));
                    }
                }
                                var thisRegex = new RegExp(thisInput.getAttribute("aria-regex"));
                console.log("Regex for this input is: ", thisRegex);
                                if(thisInput.getAttribute("aria-regex") && thisInput.value.match(thisRegex)){
                    console.log("Input valid. Hiding error. ");
                    $(thisInput.parentElement.querySelector("small.error")).hide();
                }
                                else if(thisInput.getAttribute("aria-regex") && !thisInput.value.match(thisRegex)){
                    formValid = false;
                    console.log("Input invalid. Showing error");
                    $(thisInput.parentElement.querySelector("small.error")).show(500);
                }
            }
            else if(thisInput.getAttribute("type")=="file"){
                formData.append(thisInput.id, thisInput.files[0]);
            }
            else if(thisInput.tagName == "TEXTAREA"){
                                if(window.parent.tinyMCE.get(thisInput.id)){
                    var thisValue = window.parent.tinyMCE.get(thisInput.id).getContent();
                    formData.append(thisInput.id, thisValue);
                    console.log("Text area value is: " + thisValue + " with id: " + thisInput.id);
                }
                else{
                    formData.append(thisInput.id, thisInput.value);
                    console.log("Text area value is: " + thisInput.value + " with id: " + thisInput.id);
                }
            }
                        else{
                formData.append(thisInput.id, thisInput.value);
            }
        }); 
                if(formElement.querySelectorAll("input[type=password]").length>1){
            var totalPasswordFields = formElement.querySelectorAll("input[type=password]").length;
            if(formElement.querySelectorAll("input[type=password]")[totalPasswordFields-2].value != formElement.querySelectorAll("input[type=password]")[totalPasswordFields-1].value) {
                $(formElement.querySelectorAll("input[type=password]")[totalPasswordFields-1].parentElement.querySelector(".error")).show(500);
                formValid = false;
            }
            else{
                $(formElement.querySelectorAll("input[type=password]")[1].parentElement.querySelector(".error")).hide(500);
            }
        }

        var currentUser = localStorage.getItem("books_buying_selling/username");
        var currentPassHash = localStorage.getItem("books_buying_selling/passwordHash");
        formData.append("currentUser", currentUser);
        formData.append("currentPassHash", currentPassHash);
        
        
                if(formValid) process(formData, actionScript, redirect);
                else {
                console.error("Invalid information entered. Please check and correct errors");
                if(errorAlert==true){
                document.querySelector("#alertModal").querySelector(".modal-title").innerText = "Error!!!";
                document.querySelector("#alertModal").querySelector(".modal-title").classList.add("text-danger");
                document.querySelector("#alertModal").querySelector(".modal-body").innerText = "Invalid information entered. Please check and correct errors";
                $("#alertModal").modal("show");
            }
        }
        
    }); }



var onLoadAuthentication = (domainName)=>{
    var returnValue = true;
    if(localStorage.getItem(domainName + "/username") && localStorage.getItem(domainName + "/passwordHash")){
        var username = localStorage.getItem(domainName + "/username");
        var passwordHash = localStorage.getItem(domainName + "/passwordHash");
        var formData = new FormData();
        var JSONStrings = `{"username": "${username}", "passwordHash": "${passwordHash}"}`;
        formData.append("username", username);
        formData.append("passwordHash", passwordHash);
        var XHR = new XMLHttpRequest();
        XHR.open("POST", "./phpModels/loginScript.php", false);
        XHR.onreadystatechange = ()=>{
            if(XHR.readyState == 4 && XHR.status == 200){
                
                
                var JSO = JSON.parse(XHR.responseText);
                
                if(JSO.return_type=="success") {
                    
                    localStorage.setItem(domainName + "/username", username);
                    localStorage.setItem(domainName + "/passwordHash", passwordHash);
                    returnValue = true;
                }
                if(JSO.return_type=="error") {
                    localStorage.removeItem(domainName + "/username");
                    localStorage.removeItem(domainName + "/passwordHash");
                    
                    returnValue = false;
                }
            }
        }
                XHR.send(formData);
    }
    else{
        
        returnValue = false;
    }
    return returnValue;
}




var logout = (domainName)=>{
    localStorage.removeItem(domainName + "/username");
    localStorage.removeItem(domainName + "/passwordHash");
    window.location.reload();
}



var generateListings = (JSONStr, containerSelector) => {
    var JSO = JSON.parse(JSONStr);
    
    var containerElement = document.querySelector(containerSelector);
    var innerHTMLString = "";
    for(post in JSO){
        innerHTMLString += `
        <div class="p-3 col-12">
            
            <div class="card col-12 flex-row flex-wrap p-0">
                <div class="card-header border-0 p-0" style="width: 25vh;">
                    <img src="${JSO[post].img}" width="100%" alt="">
                </div>
                <div class="card-block p-2">
                    <h4 class="card-title">${JSO[post].title}</h4>
                    <div class="text-link text-secondary"><a href="?category=${JSO[post].category_id}">${JSO[post].category}</a></div>
                    <p class="card-text">${JSO[post].description}</p>
                </div>
                <div class="w-100"></div>
                <div class="card-footer w-100 text-muted p-1 justify-content-end text-right">
                    <a href="post_details?postid=${JSO[post].id}" class="btn btn-outline-primary btn-sm">More Info</a>
                </div>
            </div>
        </div>
        `;
    }
    containerElement.innerHTML += innerHTMLString;
    
}



var JSON2navbar = (JSONStr, navSelector, userTitle="")=>{
    var navItem = document.querySelector(navSelector);
    var JSO = JSON.parse(JSONStr);
    var innerHTMLString = "";
    
    innerHTMLString += `<a class="navbar-brand" href="index.php">${JSO.brand}</a>`;

    innerHTMLString += `
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#${JSO.id}" aria-controls="${JSO.id}" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="${JSO.id}">
    <ul class="navbar-nav mr-auto">
    `;
    for(item in JSO.data){
        if(JSO.data[item].submenu){
            innerHTMLString += `
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="${JSO.data[item].id}" href="${JSO.data[item].link}" data-toggle="dropdown">${JSO.data[item].label}</a>
                <div class="dropdown-menu dropdown-primary">`;

                for(subitem in JSO.data[item].submenu){
                    innerHTMLString += `<a class="dropdown-item" href="${JSO.data[item].submenu[subitem].link}">${JSO.data[item].submenu[subitem].label}</a>`;
                }

            innerHTMLString +=`
                </div>
            </li>
            `;
        }
        else{
            innerHTMLString += `
            <li class="nav-item">
                <a class="nav-link" href="${JSO.data[item].link}" ${(JSO.data[item].onclick)?"onclick=\"" + JSO.data[item].onclick + "\"":""}>${JSO.data[item].label}</a>
            </li>
            `;
        }
    }
    if(userTitle!=""){
        innerHTMLString += `
        <li class="nav-item">
            <a class="nav-link" href="#?">Logged in as: <strong>${userTitle}</strong></a>
        </li>
        `;
    }
    innerHTMLString += `
    </ul>
    </div>
    `;
    
    navItem.innerHTML = innerHTMLString;
    navItem.classList.add("navbar", "navbar-expand-lg", "navbar-dark", "bg-light");
    navItem.setAttribute("style", "background-color: #191927 !important;");
    
}



var getUserObj = (domainName)=>{
    var returnValue;
    var username = localStorage.getItem(domainName + "/username");
    var passwordHash = localStorage.getItem(domainName + "/passwordHash");
    if(!username) returnValue = {username: "visitor", user_type: 0, user_type_title: "visitor"};
    else{
        var XHR = new XMLHttpRequest();
        XHR.open("POST", "./phpModels/getRole.php", false);
        XHR.onreadystatechange = ()=>{
            if(XHR.readyState == 4 && XHR.status == 200){
                console.log("Response text of getUserObj() function: " + XHR.responseText);
                var JSO = JSON.parse(XHR.responseText);
                returnValue = JSO;
            }
        }
        XHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        XHR.send("username=" + username + "&passwordHash=" + passwordHash);
    }
    return returnValue;
}



var renderSlider = (carouselContainerSelector)=>{
    var carouselContainer = document.querySelector(carouselContainerSelector);
            var JSONStr = "";
    var XHR = new XMLHttpRequest();
    XHR.open("GET", "./phpModels/carouselItemsScript.php", false);
    XHR.onreadystatechange = ()=>{
        if(XHR.readyState == 4 && XHR.status == 200){
            JSONStr = XHR.responseText;
            JSO = JSON.parse(JSONStr);
                        var innerHTMLString = "";
            innerHTMLString += `
            
            <!--Carousel Wrapper-->
            <div id="${JSO.id}" class="carousel slide carousel-fade" data-ride="carousel">
                <!--Indicators-->
                <ol class="carousel-indicators">`;
                var carouselIndex = 0;
                for(item in JSO.data){
                    innerHTMLString += `<li data-target="#${JSO.id}" data-slide-to="${carouselIndex}" ${(carouselIndex==0)?"class=\"active\"":""}></li>`;
                    carouselIndex++;
                }
        
                innerHTMLString += `</ol>
                <!--/.Indicators-->
                <!--Slides-->
                <div class="carousel-inner" role="listbox">`;
        
                carouselIndex = 0;
                for(item in JSO.data){
                    innerHTMLString += `
                    
                    <div class="carousel-item ${(carouselIndex==0)?"active":""}">
                        <div class="view">
                        <img class="d-block w-100" src="${JSO.data[item].imgUrl}"
                            alt="${JSO.data[item].title}">
                        <div class="mask rgba-black-light"></div>
                        </div>
                        <div class="carousel-caption">
                        <h4>${JSO.data[item].title}</h4>
                        <a class="btn btn-secondary" href="book_details.php?book_id=${JSO.data[item].item_id}">More Info</a>
                        
                        </div>
                    </div>
                    
                    `;
                    carouselIndex++;
                }
                innerHTMLString += `
                </div>
                <!--/.Slides-->
        
                <!--Controls-->
                <a class="carousel-control-prev" href="#${JSO.id}" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#${JSO.id}" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
                </a>
                <!--/.Controls-->
            </div>
            <!--/.Carousel Wrapper-->
            
            `;
                        carouselContainer.innerHTML = innerHTMLString;       
        }
    }
    XHR.send();
}

var JSON2Carousel = (carouselContainerSelector, JSONStr)=>{
    var carouselContainer = document.querySelector(carouselContainerSelector);
    JSO = JSON.parse(JSONStr);
    var innerHTMLString = "";
    innerHTMLString += `
    
    <!--Carousel Wrapper-->
    <div id="${JSO.id}" class="carousel slide carousel-fade" data-ride="carousel">
        <!--Indicators-->
        <ol class="carousel-indicators">`;
        var carouselIndex = 0;
        for(item in JSO.data){
            innerHTMLString += `<li data-target="#${JSO.id}" data-slide-to="${carouselIndex}" ${(carouselIndex==0)?"class=\"active\"":""}></li>`;
            carouselIndex++;
        }

        innerHTMLString += `</ol>
        <!--/.Indicators-->
        <!--Slides-->
        <div class="carousel-inner" role="listbox">`;

        carouselIndex = 0;
        for(item in JSO.data){
            innerHTMLString += `
            
            <div class="carousel-item ${(carouselIndex==0)?"active":""}">
                <div class="view">
                <img class="d-block w-100" src="${JSO.data[item].imgUrl}"
                    alt="${JSO.data[item].title}">
                <div class="mask rgba-black-light"></div>
                </div>
                <div class="carousel-caption">
                <h4>${JSO.data[item].title}</h4>
                <a class="btn btn-secondary" href="bookDetails.php?${JSO.data[item].link}">More Info</a>
                
                </div>
            </div>
            
            `;
            carouselIndex++;
        }
        innerHTMLString += `
        </div>
        <!--/.Slides-->

        <!--Controls-->
        <a class="carousel-control-prev" href="#${JSO.id}" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#${JSO.id}" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
        </a>
        <!--/.Controls-->
    </div>
    <!--/.Carousel Wrapper-->
    
    `;
    carouselContainer.innerHTML = innerHTMLString;
}


var addUserSearch = ()=>{
    var innerHTMLString = "";
    innerHTMLString += `
    
    
        <div class="md-form bg-dark my-0">
        <input class="form-control mr-sm-2 px-3" type="text" placeholder="Search Users" aria-label="Search" id="search_term">

        <!--Accordion wrapper-->
        <div class="accordion md-accordion" id="sortFilter" role="tablist" aria-multiselectable="true">

        <!-- Accordion card -->
        <div class="card">

        <!-- Card header -->
        <div class="card-header py-1 bg-dark mt-0" role="tab" id="headingOne1">
            <a data-toggle="collapse" data-parent="#sortFilter" href="#collapseOne1" aria-expanded="true"
            aria-controls="collapseOne1">
            <div class="m-0 p-0 text-light text-sm">
                Sort & Filter <i class="fas fa-angle-down rotate-icon"></i>
            </div>
            </a>
        </div>

        <!-- Card body -->
        <div id="collapseOne1" class="collapse" role="tabpanel" aria-labelledby="headingOne1"
            data-parent="#sortFilter">
            <div class="card-body row">
                
                <select id="user_type_title" name="user_type_title" class="browser-default custom-select mdb-select form-control md-form col-lg">
                    <option disabled selected value="">Filter by User Type</option>
                    <option value="">All</option>
                    <option value="admin">Administrator</option>
                    <option value="buyer">Buyer</option>
                </select>
                <select id="sort" name="sort" class="browser-default custom-select mdb-select form-control md-form col-lg">
                    <option disabled selected value="username">Sort Users By</option>
                    <option value="username">Username</option>
                    <option value="fullname">Full Name</option>
                    <option value="join_on">Date joined</option>
                    <option value="user_type_title">User Type</option>

                </select>
                <select id="sortDirection" name="sortDirection" class="browser-default custom-select mdb-select form-control md-form col-lg">
                    <option disabled selected value="asc">Sort Direction</option>
                    <option value="asc">Ascending</option>
                    <option value="desc">Descending</option>
                </select>
                
            </div>
            <button type="submit" class="btn btn-default btn-sm">Search</button>
        </div>
        </div>
        <!-- Accordion card -->
        
        </div>
        <!-- Accordion wrapper -->

        </div>

    `;

    
    document.querySelector(".searchForm").setAttribute("id", "searchUser");
    document.querySelector(".searchForm").innerHTML = innerHTMLString;


    document.querySelector("#searchUser").addEventListener("submit", (event)=>{
        event.preventDefault();
        console.log("Search function ran");
        getUserListings();
    });

}


var featuredListing = (containerSelector)=>{
    console.log("featuredListing() function ran...");
    var container = document.querySelector(containerSelector);
    var innerHTMLString = "";
    var XHR = new XMLHttpRequest();

    XHR.open("GET", "./phpModels/featuredItemsScript.php", false);
    XHR.onreadystatechange = ()=>{
        console.log("JSON2Carousel state changed");
        if(XHR.readyState == 4 && XHR.status == 200){
            JSONStr = XHR.responseText;
            console.log("Response Text of featuredItemsScript.php is: " + JSONStr);
            console.log("Response Text from featuredItemsScript: ", XHR.responseText);
            var JSO = JSON.parse(JSONStr);
            console.log("Response Object from featuredItemsScript: ", JSO);
            for(item in JSO.data){
                innerHTMLString += `
            
                <!-- Card -->
                    <div class="col-lg-4 col-md-6 col-sm-12 p-3 ${(JSO.class)?"class=\"" + JSO.class + "\"":""}">
                        <div class="card">
                            <!-- Card image -->
                            <img class="card-img-top" src="${JSO.data[item].imgUrl}" alt="Card image cap">
                        
                            <!-- Card content -->
                            <div class="card-body">
                        
                            <!-- Title -->
                            <h4 class="card-title"><a>${JSO.data[item].title}</a></h4>
                            <!-- Text -->
                            <p class="card-text">Category: ${JSO.data[item].category}</p>
                            <p class="card-text">Price per unit: ${JSO.data[item].price}</p>
                            <p class="card-text">Units in Stock: ${JSO.data[item].stock_quantity}</p>
                            <!-- Button -->
                            <a href="book_details.php?book_id=${JSO.data[item].item_id}" class="btn btn-secondary">More Info</a>
                        
                            </div>
                        
                        </div>
                    </div>
                <!-- Card -->
            
                `;
            }
        }
    }
    XHR.send();
    container.innerHTML = innerHTMLString;
}

var JSON2featuredListing = (JSONStr, containerSelector)=>{
    var JSO = JSON.parse(JSONStr);
    var container = document.querySelector(containerSelector);
    var innerHTMLString = "";
    for(item in JSO.data){
        innerHTMLString += `
    
        <!-- Card -->
            <div class="col-lg-4 col-md-6 col-sm-12 p-3 ${(JSO.class)?"class=\"" + JSO.class + "\"":""}">
                <div class="card">
                    <!-- Card image -->
                    <img class="card-img-top" src="${JSO.data[item].imgUrl}" alt="Card image cap">
                
                    <!-- Card content -->
                    <div class="card-body">
                
                    <!-- Title -->
                    <h4 class="card-title"><a>${JSO.data[item].title}</a></h4>
                    <!-- Text -->
                    <p class="card-text">Category: ${JSO.data[item].category}</p>
                    <p class="card-text">Itemps In Stock: ${JSO.data[item].stock_quantity}</p>
                    <p class="card-text">Company Name: ${JSO.data[item].publisher}</p>
                    <!-- Button -->
                    <a href="book_details.php?${JSO.data[item].link}" class="btn btn-secondary">More Info</a>
                
                    </div>
                
                </div>
            </div>
        <!-- Card -->
    
        `;
    }
    container.innerHTML = innerHTMLString;
}

var updateImg = (thumbnailID, inputID) =>{
    var thumbnail = document.querySelector(thumbnailID);
    var input = document.querySelector(inputID);
    document.querySelector(thumbnailID).src = URL.createObjectURL(input.files[0]);
}


var getUserProfile = (targetSelector, profileID, currentUser, currentPassHash) =>{
    var userObj = getUserObj("books_buying_selling");
    if((userObj.user_type_title != 'admin' && userObj.user_type_title != 'seller') && profileID!=currentUser){
        window.location.replace("user_profile.php");
    }
    else{
        var targetTable = document.querySelector(targetSelector);
        var XHR = new XMLHttpRequest();
        XHR.open("POST", "./phpModels/getUserProfileScript.php");
        XHR.onreadystatechange = ()=>{
            if(XHR.readyState==4 && XHR.status==200){
                JSO = JSON.parse(XHR.responseText);
                console.log("Response object of getUserProfile() function: ", JSO);
                var innerHTMLString = "";
                innerHTMLString += `
                
                <thead>
                    <tr>
                        <th scope="col" class="p-0 m-0"><img src="${(JSO.result_array.display_pic_url)?(JSO.result_array.display_pic_url):('img/svg/user_solid.png')}" alt="" srcset="" class="img-round"></th>
                        <th scope="col"><span class="h2">${JSO.result_array["First Name"] + " " + JSO.result_array["Last Name"]}</span> <span class="h3">(${JSO.result_array["User Type"]})</span></th>
                    </tr>
                    ${(profileID==currentUser)?('<tr><th colspan="2" scope="col" class="p-0 m-0 text-center"><a class="text-link text-secondary" href="change_password.php">Change Password</a></th></tr>'):("")}
                </thead>
                <tbody>

                    <tr>
                        <td scope="col">Username</td>
                        <td scope="col">${JSO.result_array.username}</td>
                    </tr>
                    <tr>
                        <td scope="row">Full Name</td>
                        <td>${JSO.result_array["First Name"] + " " + JSO.result_array["Last Name"]}</td>
                    </tr>
                    <tr>
                        <td scope="row">User Type</td>
                        <td>${JSO.result_array["User Type"]}</td>
                    </tr>`;
                innerHTMLString += `
                    
                    <tr>
                        <td scope="row">Joining Date</td>
                        <td>${JSO.result_array["Joining Date"]}</td>
                    </tr>
                    <tr>
                        <td scope="row">Email Alerts</td>
                        <td>${(JSO.result_array["email_alerts"]==1)?("On"):("Off")}</td>
                    </tr>
                    <tr>
                        <td scope="row">Date of Birth</td>
                        <td>${JSO.result_array["Date of Birth"]}</td>
                    </tr>
                    <tr>
                        <td scope="row">CNIC Number</td>
                        <td>${JSO.result_array["CNIC Number"]}</td>
                    </tr>

                    <tr>
                        <td scope="row">Street Address</td>
                        <td>${JSO.result_array["Street Address"]}</td>
                    </tr>
                    <tr>
                        <td scope="row">City</td>
                        <td>${titleCase(JSO.result_array["City"])}</td>
                    </tr>
                    <tr>
                        <td scope="row">Country</td>
                        <td>${titleCase(JSO.result_array["Country"])}</td>
                    </tr>
                    <tr>
                        <td scope="row">Approval Status</td>
                        <td>${(JSO.result_array["Approval"]==1)?("Yes"):("No")}</td>
                    </tr>
                    <tr>
                        <!-- Edit user button for both admin and applicant personal view -->
                        <td colspan='2' class='text-center'>
                            <div class="btn-group">`;
                                if(userObj.user_type_title=='admin'||profileID==currentUser){
                                    innerHTMLString += `<a href="edit_profile.php?username=${JSO.result_array.username}"><button class="btn btn-secondary">Edit User</button></a>`;
                                }
                                if(userObj.user_type_title=='admin'&&profileID!=currentUser){
                                    innerHTMLString += `<button class='btn btn-warning' onclick='deactivateUser("${JSO.result_array.username}", "${localStorage.getItem("books_buying_selling/username")}", "${localStorage.getItem("books_buying_selling/passwordHash")}")'>Deactivate User</button>`;
                                }
                                if(userObj.user_type_title=='admin'&&profileID!=currentUser){
                                    innerHTMLString += `<button class='btn btn-danger' onclick='deleteUser("${JSO.result_array.username}", "${localStorage.getItem("books_buying_selling/username")}", "${localStorage.getItem("books_buying_selling/passwordHash")}")'>Delete User</button>`;
                                }
                            innerHTMLString += `</div>
                        </td>
                        
                    </tr>
                </tbody>
                
                `;
                targetTable.innerHTML = innerHTMLString;
            }
        }
        XHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        console.log("Sendig post: " + "profileID=" + profileID + ", username=" + currentUser + ", passwordHash=" + currentPassHash)
        XHR.send("profileID=" + profileID + "&username=" + currentUser + "&passwordHash=" + currentPassHash);
    }
}

var listCartItems = (targetSelector, cartUsername, currentUsername, currentPassHash)=>{
    var targetElement = document.querySelector(targetSelector);
    var innerHTMLString = "";
    var XHR = new XMLHttpRequest();
    XHR.open("POST", "./phpModels/getCartItemsScript.php", false);
    XHR.onreadystatechange = ()=>{
        if(XHR.readyState==4 && XHR.status==200){
            console.log("listCartItems() response text:" + XHR.responseText);
            var JSO = JSON.parse(XHR.responseText);
            console.log(JSO);
            var grandTotal = 0;
            if(JSO.return_type == "success"){
                for(item in JSO.result_array){
                    innerHTMLString += `
                    
                    <div class="p-3 col-12">
                        <div class="card col-12 flex-row flex-wrap p-0">
                            <div class="card-header border-0 p-0" style="width: 25vh;">
                                <img src="${JSO.result_array[item].image_url}" width="100%" alt="">
                            </div>
                            <div class="card-block p-2">
                                <h4 class="card-title">${JSO.result_array[item].title}</h4>
                                <div class="text-link text-secondary"><a href="product.php?product_id=${JSO.result_array[item].item_id}">Product ID: ${JSO.result_array[item].item_id}</a></div>
                                <p class="card-text">In ${JSO.result_array[item].category_name} Section</p>
                                <p class="card-text">Items in Cart: ${JSO.result_array[item].quantity}</p>
                                <p class="card-text">Unit Price: ${JSO.result_array[item].unit_price}</p>
                                <p class="card-text">Total Price: ${JSO.result_array[item].quantity*JSO.result_array[item].unit_price}</p>
                            </div>
                            <div class="w-100"></div>
                            <div class="card-footer w-100 text-muted p-1 justify-content-end text-right">
                                <a href="#?" onclick="removeFromCart(${JSO.result_array[item].id}, '${localStorage.getItem("books_buying_selling/username")}', '${localStorage.getItem("books_buying_selling/passwordHash")}')" class="btn btn-danger btn-sm">Remove From Cart</a>
                            </div>
                        </div>
                    </div>
                    
                    `;
                    grandTotal += JSO.result_array[item].quantity*JSO.result_array[item].unit_price;
                }
            }
            else{
                innerHTMLString += "<h4 class='card-title p-3'>" + JSO.return_message + "</h4>";
            }
            innerHTMLString += `<div class="d-flex justify-content-center"><h3>Grand Total = ${grandTotal}</h3></div>`;
            targetElement.innerHTML = innerHTMLString;
        }
    }
    XHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    XHR.send("cartUsername="+cartUsername+"&currentUsername="+currentUsername+"&currentPassHash="+currentPassHash);
}

var listOrders = (targetSelector, ordersUsername, currentUsername, currentPassHash)=>{
    var targetElement = document.querySelector(targetSelector);
    var innerHTMLString = "";
    var XHR = new XMLHttpRequest();
    XHR.open("POST", "./phpModels/getOrdersScript.php", false);
    XHR.onreadystatechange = ()=>{
        if(XHR.readyState==4 && XHR.status==200){
            console.log(XHR.responseText);
            var JSO = JSON.parse(XHR.responseText);
            console.log(JSO);
            var grandTotal = 0;
            for(order in JSO.result_array){
                innerHTMLString += `
                <tr>
                    <th>${JSO.result_array[order].order_id}</th>
                    <td>${JSO.result_array[order].title}</td>
                    <td>${JSO.result_array[order].item_id}</td>
                    <td>${JSO.result_array[order].buyer_id}</td>
                    <td>${JSO.result_array[order].unit_price}</td>
                    <td>${JSO.result_array[order].quantity}</td>
                    <td>${JSO.result_array[order].unit_price*JSO.result_array[order].quantity}</td>
                    <td>${JSO.result_array[order].time_stamp}</td>
                    <td>${JSO.result_array[order].invoice_id}</td>
                    <td>`;
                    if(userObj.user_type_title == "seller"){
                        innerHTMLString += `
                            <select id="order_status_${JSO.result_array[order].order_id}">
                                <option selected disabled value="${JSO.result_array[order].status}">${(JSO.result_array[order].status==1)?("Awaiting Confirmation"):(JSO.result_array[order].status==2)?("Confirmed"):("Cencelled")}</option>
                                <option value="1">Awaiting Confirmation</option>
                                <option value="2">Confirmed</option>
                                <option value="3">Cencelled</option>
                            </select>
                            <input type="button" value="Update" class="btn btn-secondary btn-sm" onclick="updateOrderStatus(${JSO.result_array[order].order_id});" />
                        `;
                    }
                    else{
                        innerHTMLString += `
                            ${(JSO.result_array[order].status==1)?("Awaiting Confirmation"):(JSO.result_array[order].status==2)?("Confirmed"):("Cencelled")}
                        `;
                    }
                innerHTMLString += `
                        
                    </td>
                </tr>
                
                `;
                if(userObj.user_type_title == "seller"){
                    innerHTMLString += `</form>`;
                }
                grandTotal += JSO.result_array[order].quantity*JSO.result_array[order].unit_price;
            }
            targetElement.innerHTML = innerHTMLString;
        }
    }
    XHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    XHR.send("ordersUsername="+ordersUsername+"&currentUsername="+currentUsername+"&currentPassHash="+currentPassHash);
}

var updateOrderStatus = (orderId)=>{
    var currentUsername = localStorage.getItem("books_buying_selling/username");
    var currentPassHash = localStorage.getItem("books_buying_selling/passwordHash");;
    var orderStatus = document.querySelector("#order_status_"+orderId).value;
    alert("Gonig to update order number " + orderId + "'s status to " + orderStatus);
    var xhr
}

function titleCase(str) {
    var splitStr = str.toLowerCase().split(' ');
    for (var i = 0; i < splitStr.length; i++) {
                        splitStr[i] = splitStr[i].charAt(0).toUpperCase() + splitStr[i].substring(1);     
    }
        return splitStr.join(' '); 
}


var listPendingUsers = (container, currentUser, currentPassHash)=>{
        var container = document.querySelector(container);
        var innerHTMLString = "";
        var XHR = new XMLHttpRequest();
    XHR.open("POST", "./phpModels/pendingUsersScript.php");
    XHR.onreadystatechange = ()=>{
        if(XHR.readyState==4 && XHR.status==200){
                        var JSO = JSON.parse(XHR.responseText);
            if(JSO.error == "No pending users"){
                innerHTMLString += `<h4>${JSO.return_message}</h4>`;
            }
            for(item in JSO.result_array){
                innerHTMLString += `<div class="p-3 col-12">        
                    <div class="card col-12 flex-row flex-wrap p-0">
                        <div class="card-header border-0 p-0" style="width: 25vh;">
                            <img src="${(JSO.result_array[item].display_pic_url)?JSO.result_array[item].display_pic_url:"./img/svg/user-solid.svg"}" width="100%" alt="">
                        </div>
                        <div class="card-block p-2">
                            <h4 class="card-title">${JSO.result_array[item].firstname + ' ' + JSO.result_array[item].lastname}</h4>
                            <div class="text-link text-secondary"><a href="user_profile.php?username=${JSO.result_array[item].username}">@${JSO.result_array[item].username}</a></div>
                            <p class="card-text">${JSO.result_array[item].user_type_title}</p>
                        </div>
                        <div class="w-100"></div>
                        <div class="card-footer w-100 text-muted p-1 justify-content-end text-right">
                            <a href="#?" class="btn btn-secondary btn-sm" onclick='activateUser("${JSO.result_array[item].username}", "${localStorage.getItem("books_buying_selling/username")}", "${localStorage.getItem("books_buying_selling/passwordHash")}")'>Activate User</a>
                            <a href="user_profile.php?username=${JSO.result_array[item].username}" class="btn btn-outline-primary btn-sm">More Info</a>
                        </div>
                    </div>
                </div>`;
            }
                        container.innerHTML = innerHTMLString;
        }
    }
    XHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    XHR.send("currentUser="+currentUser+"&currentPassHash="+currentPassHash);
}

var listPendingPosts = (outputContainer)=>{
    console.log("listPendingPosts() function ran");
    var outputContainerElement = document.querySelector(outputContainer);
    var innerHTMLString = "";
        var XHR = new XMLHttpRequest();
        XHR.open("POST", "./phpModels/pendingPostsScript.php");
    XHR.onreadystatechange = ()=>{
        if(XHR.readyState == 4 && XHR.status == 200){
            console.log("pendingPostsScript response text: " , XHR.responseText);
            var JSO = JSON.parse(XHR.responseText);
            console.log("listPendingPosts() function response object: ", JSO);
            if((JSO.return_type) == "error"){
                innerHTMLString += `<h4>${JSO.return_message}</h4>`;
            }
            else{
                for(item in JSO.result_array){
                    innerHTMLString += `
                        <div class="p-3 col-12">
                            
                            <div class="card col-12 flex-row flex-wrap p-0">
                                <div class="card-header border-0 p-0" style="width: 25vh;">
                                    <img src="${(JSO.result_array[item].image_url)?JSO.result_array[item].image_url:"./img/svg/book-open-solid.svg"}" width="100%" alt="">
                                </div>
                                <div class="card-block p-2">
                                    <h4 class="card-title">${JSO.result_array[item].title}</h4><h5>Publishing Company/Firm ${JSO.result_array[item].publisher_name}</h5>
                                    <div class="text-link text-secondary"><a href="book_details.php?book_id=${JSO.result_array[item].id}">Book ID: ${JSO.result_array[item].id}</a></div>
                                    <p class="card-text">Category: ${JSO.result_array[item].category_name}</p>
                                    <p class="card-text">City: ${JSO.result_array[item].city}</p>
                                    <p class="card-text">City: ${JSO.result_array[item].country}</p>
                                    <p class="card-text">${JSO.result_array[item].description}</p>
                                </div>
                                <div class="w-100"></div>
                                <div class="card-footer w-100 text-muted p-1 justify-content-end text-right">
                                    <a href="#?" class="btn btn-secondary btn-sm" onclick='approvePost("${JSO.result_array[item].id}", "${localStorage.getItem("books_buying_selling/username")}", "${localStorage.getItem("books_buying_selling/passwordHash")}")'>Approve Post</a>
                                    <a href="book_details.php?book_id=${JSO.result_array[item].id}" class="btn btn-outline-primary btn-sm">More Info</a>
                                </div>
                            </div>
                        </div>
                        `;
                }
            }
            outputContainerElement.innerHTML = innerHTMLString;
        }
    }
    XHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    XHR.send();
}

var getCategories = ()=>{
    var XHR = new XMLHttpRequest();
    XHR.open("POST", "./phpModels/getCategoriesScript.php", false);
    var JSO;
    XHR.onreadystatechange = ()=>{
        if(XHR.readyState == 4 && XHR.status == 200){
            console.log(XHR.responseText);
            JSO = JSON.parse(XHR.responseText);
        }
    }
    XHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    XHR.send();
    return JSO;
}

var getCities = ()=>{
    var XHR = new XMLHttpRequest();
    XHR.open("POST", "./phpModels/getCitiesScript.php", false);
    var JSO;
    XHR.onreadystatechange = ()=>{
        if(XHR.readyState == 4 && XHR.status == 200){
            console.log(XHR.responseText);
            JSO = JSON.parse(XHR.responseText);
        }
    }
    XHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    XHR.send();
    return JSO;
}

var addBookSearch = (searchContainer, outputContainer)=>{
        var categories = getCategories();
        console.log(categories);
    console.log("Search form function ran with a container named: " , searchContainer);
    var searchForm = document.querySelector(searchContainer);
    var outputContainerElement = document.querySelector(outputContainer);
    var innerHTMLString = "";
    innerHTMLString += `
    
    
        <div class="md-form bg-dark my-0">
        <input class="form-control mr-sm-2 px-3" type="text" placeholder="Search Books" aria-label="Search" id="search_term">

        <!--Accordion wrapper-->
        <div class="accordion md-accordion" id="sortFilter" role="tablist" aria-multiselectable="true">

        <!-- Accordion card -->
        <div class="card">

        <!-- Card header -->
        <div class="card-header py-1 bg-dark mt-0" role="tab" id="headingOne1">
            <a data-toggle="collapse" data-parent="#sortFilter" href="#collapseOne1" aria-expanded="true"
            aria-controls="collapseOne1">
            <div class="m-0 p-0 text-light text-sm">
                Sort & Filter <i class="fas fa-angle-down rotate-icon"></i>
            </div>
            </a>
        </div>

        <!-- Card body -->
        <div id="collapseOne1" class="collapse" role="tabpanel" aria-labelledby="headingOne1"
            data-parent="#sortFilter">
            <div class="card-body row">
                <select id="category" name="category" class="browser-default custom-select mdb-select md-form col-lg">
                    <option disabled selected value="0">Filter by Category</option>`;
                    for(item in categories.result_array){
                        innerHTMLString += `<option value=${categories.result_array[item].category_id}>${categories.result_array[item].category_name}</option>`;
                    }
                innerHTMLString += `</select>
                <select id="sort" name="sort" class="browser-default custom-select mdb-select md-form col-lg">
                    <option disabled selected value="title">Sort Books By</option>
                    <option value="title">Title</option>
                    <option value="category_id">Category</option>
                </select>
                <select id="sortDirection" name="sortDirection" class="browser-default custom-select mdb-select md-form col-lg">
                    <option disabled selected value="asc">Sort Direction</option>
                    <option value="asc">Ascending</option>
                    <option value="desc">Descending</option>
                </select>
            </div>
            <button type="submit" class="btn btn-default btn-sm">Search</button>
        </div>
        </div>
        <!-- Accordion card -->
        
        </div>
        <!-- Accordion wrapper -->

        </div>

    `;
    document.querySelector(".searchForm").setAttribute("id", "searchBook");
    searchForm.innerHTML = innerHTMLString;

    searchForm.addEventListener("submit", (event)=>{
        event.preventDefault();
        getBookListings(outputContainer);
    });
}

var getBookListings = (outputContainer)=>{
    var outputContainerElement = document.querySelector(outputContainer);
    var search_term = document.querySelector("#search_term").value;
    var category = document.querySelector("#category").value;
    var direction = document.querySelector("#sortDirection").value;
    var sort = document.querySelector("#sort").value;
    var innerHTMLString = "";
        var XHR = new XMLHttpRequest();
    XHR.open("POST", "./phpModels/getBookListingsScript.php");
    XHR.onreadystatechange = ()=>{
        if(XHR.readyState == 4 && XHR.status == 200){
            console.log("getBookListingsScript response text: " , XHR.responseText);
            var JSO = JSON.parse(XHR.responseText);
            for(item in JSO.result_array){
                innerHTMLString += `
                    <div class="p-3 col-12">
                        
                        <div class="card col-12 flex-row flex-wrap p-0">
                            <div class="card-header border-0 p-0" style="width: 25vh;">
                                <img src="${(JSO.result_array[item].image_url)?JSO.result_array[item].image_url:"./img/svg/book-open-solid.svg"}" width="100%" alt="">
                            </div>
                            <div class="card-block p-2">
                                <h4 class="card-title">${JSO.result_array[item].title}</h4><h5>Publishing Company ${JSO.result_array[item].publisher_name}</h5>
                                <div class="text-link text-secondary"><a href="book_details.php?book_id=${JSO.result_array[item].id}">Book ID: ${JSO.result_array[item].id}</a></div>
                                <p class="card-text">Category: ${JSO.result_array[item].category_name}</p>
                                <p class="card-text">City: ${JSO.result_array[item].city}</p>
                                <p class="card-text">City: ${JSO.result_array[item].country}</p>
                                <p class="card-text">${JSO.result_array[item].description}</p>
                            </div>
                            <div class="w-100"></div>
                            <div class="card-footer w-100 text-muted p-1 justify-content-end text-right">
                                <a href="book_details.php?book_id=${JSO.result_array[item].id}" class="btn btn-outline-primary btn-sm">More Info</a>
                            </div>
                        </div>
                    </div>
                    `;
            }
            outputContainerElement.innerHTML = innerHTMLString;
        }
    }
    XHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    XHR.send("search_term=" + search_term + "&category=" + category + "&sort=" + sort + "&direction=" + direction);
}

var checkOut = (currentUsername, currentPassHash)=>{
            var XHR = new XMLHttpRequest();
    XHR.open("POST", "./phpModels/checkOutScript.php");
    XHR.onreadystatechange = ()=>{
        if(XHR.readyState==4 && XHR.status==200){
            console.log(XHR.responseText);
            var JSO = JSON.parse(XHR.responseText);
            alert(JSO.return_message);
            window.location.replace("orders.php");
        }
    }
    XHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    XHR.send("currentUsername="+currentUsername+"&currentPassHash="+currentPassHash);
                                            }

var removeFromCart = (cartItemId, currentUser, currentPassHash)=>{
    if(confirm("Are you sure you want to remove this item from the cart? ")){
        var XHR = new XMLHttpRequest();
        XHR.open("POST", "./phpModels/removeCartItemScript.php");
        XHR.onreadystatechange = ()=>{
            if(XHR.readyState==4 && XHR.status==200){
                console.log(XHR.responseText);
                var JSO = XHR.responseText;
                alert("Item removed successfully");
                window.location.reload();
            }
        }
        XHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        XHR.send("cartItemId="+cartItemId+"&currentUser="+currentUser+"&currentPassHash="+currentPassHash);
    }
}

var deleteUser = (username, currentUser, currentPassHash) => {
    console.log(username, currentUser, currentPassHash);
    if(confirm("Are you sure you want to delete this user?")){
        var XHR = new XMLHttpRequest();
        XHR.open("POST", "./phpModels/deleteUserScript.php");
        XHR.onreadystatechange = ()=>{
            if(XHR.readyState == 4 && XHR.status == 200){
                console.log(XHR.responseText);
                var JSO = JSON.parse(XHR.responseText);
                if(JSO.return_type=="success"){
                    alert(JSO.return_message);
                    window.location.replace("members_area.php");
                }
                else{
                    alert(JSO.return_message);
                }
            }
        }
        XHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        XHR.send("username="+username+"&currentUser="+currentUser+"&currentPassHash="+currentPassHash);
    }
}

var deactivateUser = (username, currentUser, currentPassHash) => {
    console.log(username, currentUser, currentPassHash);
    if(confirm("Are you sure you want to deactivate this user?")){
        var XHR = new XMLHttpRequest();
        XHR.open("POST", "./phpModels/deactivateUserScript.php");
        XHR.onreadystatechange = ()=>{
            if(XHR.readyState == 4 && XHR.status == 200){
                console.log(XHR.responseText);
                var JSO = JSON.parse(XHR.responseText);
                if(JSO.return_type=="success"){
                    alert(JSO.return_message);
                    window.location.replace("members_area.php");
                }
                else{
                    alert(JSO.return_message);
                }
            }
        }
        XHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        XHR.send("username="+username+"&currentUser="+currentUser+"&currentPassHash="+currentPassHash);
    }
}

var addToCart = (id, currentUser, currentPassHash)=>{
    var qty = document.querySelector("#qty").value;
    var XHR = new XMLHttpRequest();
    XHR.open("POST", "./phpModels/addToCartScript.php");
    XHR.onreadystatechange = ()=>{
        if(XHR.readyState==4 && XHR.status==200){
            console.log(XHR.responseText);
            var JSO = JSON.parse(XHR.responseText);
            if(JSO.return_type=="success"){
                alert(JSO.return_message);
                if(confirm("Do you want to move to cart?")){
                    window.location.replace("cart.php");
                }
            }
            else{
                alert(JSO.return_message);
            }
        }
    }
    XHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    XHR.send("id="+id+"&qty="+qty+"&currentUser="+currentUser+"&currentPassHash="+currentPassHash);
}

var deleteBook = (id, currentUser, currentPassHash)=>{
    if(confirm("Are you sure you want to delete this book? ")){
        var XHR = new XMLHttpRequest();
        XHR.open("POST", "./phpModels/deleteBookScript.php");
        XHR.onreadystatechange = ()=>{
            if(XHR.readyState == 4 && XHR.status == 200){
                console.log(XHR.responseText);
                var JSO = JSON.parse(XHR.responseText);
                if(JSO.return_type == 'success') {
                    alert(JSO.return_message);
                    window.location.replace("book_listings.php");
                }
                else{
                    alert(JSO.return_message);
                }

            }
        }
        XHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        XHR.send("id="+id+"&currentUser="+currentUser+"&currentPassHash="+currentPassHash);
    }
}

var addToFeaturedSlide = (bookID, currentUsername, currentPassHash) =>{
    if(confirm("Are you sure you want to add this post to featured slides?")){
        var XHR = new XMLHttpRequest();
        XHR.open("POST", "./phpModels/addToFeaturedSlideScript.php");
        XHR.onreadystatechange = ()=>{
            if(XHR.readyState==4&&XHR.status==200){
                console.log(XHR.responseText);
                var JSO = JSON.parse(XHR.responseText);
                alert(JSO.return_message);
                window.location.reload();
            }
        }
        XHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        XHR.send("bookID="+bookID+"&currentUsername="+currentUsername+"&currentPassHash="+currentPassHash);
    }
}
var removeFromFeaturedSlide = (bookID, currentUsername, currentPassHash) =>{
    if(confirm("Are you sure you want to remove this post from featured slides?")){
        var XHR = new XMLHttpRequest();
        XHR.open("POST", "./phpModels/removeFromFeaturedSlideScript.php");
        XHR.onreadystatechange = ()=>{
            if(XHR.readyState==4&&XHR.status==200){
                console.log(XHR.responseText);
                var JSO = JSON.parse(XHR.responseText);
                alert(JSO.return_message);
                window.location.reload();
            }
        }
        XHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        XHR.send("bookID="+bookID+"&currentUsername="+currentUsername+"&currentPassHash="+currentPassHash);
    }
}
var addToFeaturedPosts = (bookID, currentUsername, currentPassHash) =>{
    if(confirm("Are you sure you want to add this book to featured posts?")){
        var XHR = new XMLHttpRequest();
        XHR.open("POST", "./phpModels/addToFeaturedPostsScript.php");
        XHR.onreadystatechange = ()=>{
            if(XHR.readyState==4&&XHR.status==200){
                console.log(XHR.responseText);
                var JSO = JSON.parse(XHR.responseText);
                alert(JSO.return_message);
                window.location.reload();
            }
        }
        XHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        XHR.send("bookID="+bookID+"&currentUsername="+currentUsername+"&currentPassHash="+currentPassHash);
    }
}
var removeFromFeaturedPosts = (bookID, currentUsername, currentPassHash) =>{
    if(confirm("Are you sure you want to remove this book from featured posts?")){
        var XHR = new XMLHttpRequest();
        XHR.open("POST", "./phpModels/removeFromFeaturedPostsScript.php");
        XHR.onreadystatechange = ()=>{
            if(XHR.readyState==4&&XHR.status==200){
                console.log(XHR.responseText);
                var JSO = JSON.parse(XHR.responseText);
                alert(JSO.return_message);
                window.location.reload();
            }
        }
        XHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        XHR.send("bookID="+bookID+"&currentUsername="+currentUsername+"&currentPassHash="+currentPassHash);
    }
}

var sendAlerts = (bookID, currentUsername, currentPassHash) =>{
    if(confirm("Are you sure you want to add this book to featured posts?")){
        var XHR = new XMLHttpRequest();
        XHR.open("POST", "./phpModels/sendAlertsScript.php");
        XHR.onreadystatechange = ()=>{
            if(XHR.readyState==4&&XHR.status==200){
                console.log(XHR.responseText);
                var JSO = JSON.parse(XHR.responseText);
                alert(JSO.return_message);
            }
        }
        XHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        XHR.send("bookID="+bookID+"&currentUsername="+currentUsername+"&currentPassHash="+currentPassHash);
    }
}

var activateUser = (username, currentUser, currentPassHash) => {
    if(confirm("Are you sure you want to activate this user?")){
        var XHR = new XMLHttpRequest();
        XHR.open("POST", "./phpModels/activateUserScript.php");
        XHR.onreadystatechange = ()=>{
            if(XHR.readyState == 4 && XHR.status == 200){
                console.log(XHR.responseText);
                var JSO = JSON.parse(XHR.responseText);
                if(JSO.return_type=="success"){
                    alert(JSO.return_message);
                    window.location.replace("members_area.php");
                }
                else{
                    alert(JSO.return_message);
                }
            }
        }
        XHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        XHR.send("username="+username+"&currentUser="+currentUser+"&currentPassHash="+currentPassHash);
    }
}

var approvePost = (postId, currentUser, currentPassHash) => {
    if(confirm("Are you sure you want to approve this post?")){
        var XHR = new XMLHttpRequest();
        XHR.open("POST", "./phpModels/approvePostScript.php");
        XHR.onreadystatechange = ()=>{
            if(XHR.readyState == 4 && XHR.status == 200){
                console.log(XHR.responseText);
                var JSO = JSON.parse(XHR.responseText);
                if(JSO.return_type=="success"){
                    alert(JSO.return_message);
                    window.location.replace("members_area.php");
                }
                else{
                    alert(JSO.return_message);
                }
            }
        }
        XHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        XHR.send("postId="+postId+"&currentUser="+currentUser+"&currentPassHash="+currentPassHash);
    }
}

var getUserListings = ()=>{
    var search_term = document.querySelector("#search_term").value;
    var user_type = document.querySelector("#user_type_title").value;
    var sort = document.querySelector("#sort").value;
    var direction = document.querySelector("#sortDirection").value;
    XHR = new XMLHttpRequest();
    XHR.open("POST", "./phpModels/list_users.php");



    XHR.onreadystatechange = ()=>{
            if(XHR.readyState == 4 && XHR.status == 200){
            var JSO = JSON.parse(XHR.responseText);
            console.log("After Parsing: ", JSO);
            var innerHTMLString = "";
            if(JSO.error) {
                innerHTMLString += "<h4>No Records Found</h4>";
            }
            else{
                for(user in JSO){
                    innerHTMLString += `
                    <div class="p-3 col-12">
                        
                        <div class="card col-12 flex-row flex-wrap p-0">
                            <div class="card-header border-0 p-0" style="width: 25vh;">
                                <img src="${(JSO[user].display_pic_url)?JSO[user].display_pic_url:"./img/svg/user-solid.svg"}" width="100%" alt="">
                            </div>
                            <div class="card-block p-2">
                                <h4 class="card-title">${JSO[user].fullname}</h4>
                                <div class="text-link text-secondary"><a href="user_profile.php?username=${JSO[user].username}">@${JSO[user].username}</a></div>
                                <p class="card-text">${JSO[user].user_type_title}</p>
                            </div>
                            <div class="w-100"></div>
                            <div class="card-footer w-100 text-muted p-1 justify-content-end text-right">
                                <a href="user_profile.php?username=${JSO[user].username}" class="btn btn-outline-primary btn-sm">More Info</a>
                            </div>
                        </div>
                    </div>
                    `;
                }
            }
            document.querySelector("#userList").innerHTML = innerHTMLString;
        }
    }
    XHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    XHR.send("search_term=" + search_term + "&user_type_title=" + user_type + "&sort=" + sort + "&direction=" + direction);
}

var addCategory = () =>{
    var category_name = document.querySelector("#categoryName").value;
    var currentUser = localStorage.getItem("books_buying_selling/username");
    var currentPassHash = localStorage.getItem("books_buying_selling/passwordHash");
                                var XHR = new XMLHttpRequest();
    XHR.open("POST", "./phpModels/addCategoryScript.php");
    XHR.onreadystatechange = ()=>{
        if(XHR.readyState==4&&XHR.status==200){
            console.log(XHR.responseText);
            var JSO = JSON.parse(XHR.responseText);
            alert(JSO.return_message);
            document.querySelector("#categoryName").value = "";
            listCategories();
        }
    }
    XHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    XHR.send("category_name="+category_name+"&currentUser="+currentUser+"&currentPassHash="+currentPassHash);
}

var listCategories = () =>{
        var categories = getCategories();
        var innerHTMLString = "<table class='table col-6 mx-auto'>";
    for(item in categories.result_array){
        innerHTMLString += `
            <tr>
                <td>${categories.result_array[item].category_name}</td>
                <td><a href='#?' onclick='editCategory(${categories.result_array[item].category_id})' class="text-sm text-warning">Edit Category</a></td>
                <td><a href='#?' onclick='removeCategory(${categories.result_array[item].category_id})' class="text-sm text-danger">Remove Category</a></td>
            </tr>`;
    }
    innerHTMLString += "</table>";
    document.querySelector("#category_list").innerHTML = innerHTMLString;
}

var editCategory = (category_id) =>{
        var category_name = prompt("Enter the new name for this category");
    if(category_name && category_name!=""){
                var currentUser = localStorage.getItem("books_buying_selling/username");
        var currentPassHash = localStorage.getItem("books_buying_selling/passwordHash");
                                                    var XHR = new XMLHttpRequest();
        XHR.open("POST", "./phpModels/editCategoryScript.php");
        XHR.onreadystatechange = ()=>{
            if(XHR.readyState==4&&XHR.status==200){
                console.log(XHR.responseText);
                var JSO = JSON.parse(XHR.responseText);
                alert(JSO.return_message);
                listCategories();
            }
        }
        XHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        XHR.send("category_id="+category_id+"&category_name="+category_name+"&currentUser="+currentUser+"&currentPassHash="+currentPassHash);
    }
}

var removeCategory = (category_id) =>{
    if(confirm("Are you sure you want to remove this category? ")){
                var currentUser = localStorage.getItem("books_buying_selling/username");
        var currentPassHash = localStorage.getItem("books_buying_selling/passwordHash");
                                                    var XHR = new XMLHttpRequest();
        XHR.open("POST", "./phpModels/removeCategoryScript.php");
        XHR.onreadystatechange = () =>{
            if(XHR.readyState==4 && XHR.status==200){
                console.log(XHR.responseText);
                var JSO = JSON.parse(XHR.responseText);
                alert(JSO.return_message);
                listCategories();
            }
        }
        XHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        XHR.send("category_id="+category_id+"&currentUser="+currentUser+"&currentPassHash="+currentPassHash);
    }
}


var getPublishers = ()=>{
    var XHR = new XMLHttpRequest();
    XHR.open("POST", "./phpModels/getPublishersScript.php", false);
    var JSO;
    XHR.onreadystatechange = ()=>{
        if(XHR.readyState == 4 && XHR.status == 200){
            console.log("getPublishers() responseText: " + XHR.responseText);
            JSO = JSON.parse(XHR.responseText);
        }
    }
    XHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    XHR.send();
    return JSO;
}

var listPublishers = ()=>{
        var publishers = getPublishers();
        var innerHTMLString = "<table class='table col-6 mx-auto'>";
    for(item in publishers.result_array){
        innerHTMLString += `
            <tr>
                <td>${publishers.result_array[item].publisher_name}</td>
                <td><a href='#?' onclick='editPublisher(${publishers.result_array[item].publisher_id})' class="text-sm text-warning">Edit Publisher</a></td>
                <td><a href='#?' onclick='removePublisher(${publishers.result_array[item].publisher_id})' class="text-sm text-danger">Remove Publisher</a></td>
            </tr>`;
    }
    innerHTMLString += "</table>";
    document.querySelector("#publisher_list").innerHTML = innerHTMLString;
}

var addPublisher = ()=>{
    var publisher_name = document.querySelector("#publisherName").value;
    var currentUser = localStorage.getItem("books_buying_selling/username");
    var currentPassHash = localStorage.getItem("books_buying_selling/passwordHash");
    var XHR = new XMLHttpRequest();
    XHR.open("POST", "./phpModels/addPublisherScript.php");
    XHR.onreadystatechange = ()=>{
        if(XHR.readyState==4&&XHR.status==200){
            console.log("addPublisher() responseText: " + XHR.responseText);
            var JSO = JSON.parse(XHR.responseText);
            alert(JSO.return_message);
            document.querySelector("#publisherName").value = "";
            listPublishers();
        }
    }
    XHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    XHR.send("publisher_name="+publisher_name+"&currentUser="+currentUser+"&currentPassHash="+currentPassHash);
}

var editPublisher = (publisher_id)=>{
        var publisher_name = prompt("Enter the new name for this publisher");
    if(publisher_name && publisher_name!=""){
                var currentUser = localStorage.getItem("books_buying_selling/username");
        var currentPassHash = localStorage.getItem("books_buying_selling/passwordHash");
                                                    var XHR = new XMLHttpRequest();
        XHR.open("POST", "./phpModels/editPublisherScript.php");
        XHR.onreadystatechange = ()=>{
            if(XHR.readyState==4&&XHR.status==200){
                console.log(XHR.responseText);
                var JSO = JSON.parse(XHR.responseText);
                alert(JSO.return_message);
                listPublishers();
            }
        }
        XHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        XHR.send("publisher_id="+publisher_id+"&publisher_name="+publisher_name+"&currentUser="+currentUser+"&currentPassHash="+currentPassHash);
    }
}

var removePublisher = (publisher_id)=>{
    if(confirm("Are you sure you want to remove this publisher? ")){
                var currentUser = localStorage.getItem("books_buying_selling/username");
        var currentPassHash = localStorage.getItem("books_buying_selling/passwordHash");
                                                    var XHR = new XMLHttpRequest();
        XHR.open("POST", "./phpModels/removePublisherScript.php");
        XHR.onreadystatechange = () =>{
            if(XHR.readyState==4 && XHR.status==200){
                console.log(XHR.responseText);
                var JSO = JSON.parse(XHR.responseText);
                alert(JSO.return_message);
                listPublishers();
            }
        }
        XHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        XHR.send("publisher_id="+publisher_id+"&currentUser="+currentUser+"&currentPassHash="+currentPassHash);
    }
}


var getColors = ()=>{
    var XHR = new XMLHttpRequest();
    XHR.open("POST", "./phpModels/getColorsScript.php", false);
    var JSO;
    XHR.onreadystatechange = ()=>{
        if(XHR.readyState == 4 && XHR.status == 200){
            JSO = JSON.parse(XHR.responseText);
        }
    }
    XHR.setRequestHeader("Content-type", "applicatiqon/x-www-form-urlencoded");
    XHR.send();
    return JSO;
}

var listColors = ()=>{
        var colors = getColors();
        var innerHTMLString = "<table class='table col-6 mx-auto'>";
    for(item in colors.result_array){
        innerHTMLString += `
            <tr>
                <td>${colors.result_array[item].color_name}</td>
                <td><input type="color" value="${colors.result_array[item].color_code}" /></td>
                <td><a href='#?' onclick='editColor(${colors.result_array[item].color_id})' class="text-sm text-warning">Edit Color</a></td>
                <td><a href='#?' onclick='removeColor(${colors.result_array[item].color_id})' class="text-sm text-danger">Remove Color</a></td>
            </tr>`;
    }
    innerHTMLString += "</table>";
    document.querySelector("#color_list").innerHTML = innerHTMLString;
}

var addColor = ()=>{
    var color_name = document.querySelector("#colorName").value;
    var color_code = document.querySelector("#colorCode").value;
    var currentUser = localStorage.getItem("books_buying_selling/username");
    var currentPassHash = localStorage.getItem("books_buying_selling/passwordHash");
    var XHR = new XMLHttpRequest();
    XHR.open("POST", "./phpModels/addColorScript.php");
    XHR.onreadystatechange = ()=>{
        if(XHR.readyState==4&&XHR.status==200){
            console.log(XHR.responseText);
            var JSO = JSON.parse(XHR.responseText);
            alert(JSO.return_message);
            document.querySelector("#colorName").value = "";
            listColors();
        }
    }
    XHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    XHR.send("color_name="+color_name+"&color_code="+color_code+"&currentUser="+currentUser+"&currentPassHash="+currentPassHash);
}

var editColor = (color_id)=>{
        var color_name = prompt("Enter the new name for this color");
    if(color_name && color_name!=""){
                var currentUser = localStorage.getItem("books_buying_selling/username");
        var currentPassHash = localStorage.getItem("books_buying_selling/passwordHash");
                                                    var XHR = new XMLHttpRequest();
        XHR.open("POST", "./phpModels/editColorScript.php");
        XHR.onreadystatechange = ()=>{
            if(XHR.readyState==4&&XHR.status==200){
                console.log(XHR.responseText);
                var JSO = JSON.parse(XHR.responseText);
                alert(JSO.return_message);
                listColors();
            }
        }
        XHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        XHR.send("color_id="+color_id+"&color_name="+color_name+"&currentUser="+currentUser+"&currentPassHash="+currentPassHash);
    }
}

var removeColor = (color_id)=>{
    if(confirm("Are you sure you want to remove this color? ")){
                var currentUser = localStorage.getItem("books_buying_selling/username");
        var currentPassHash = localStorage.getItem("books_buying_selling/passwordHash");
                                                    var XHR = new XMLHttpRequest();
        XHR.open("POST", "./phpModels/removeColorScript.php");
        XHR.onreadystatechange = () =>{
            if(XHR.readyState==4 && XHR.status==200){
                console.log(XHR.responseText);
                var JSO = JSON.parse(XHR.responseText);
                alert(JSO.return_message);
                listColors();
            }
        }
        XHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        XHR.send("color_id="+color_id+"&currentUser="+currentUser+"&currentPassHash="+currentPassHash);
    }
}

var editUserProfile = (targetSelector, profileID, currentUser, currentPassHash) =>{
    var userObj = getUserObj("books_buying_selling");
    if(userObj.user_type_title != 'admin' && profileID!=currentUser){
        window.location.replace("user_profile.php");
    }
    else{
        var targetTable = document.querySelector(targetSelector);
        var XHR = new XMLHttpRequest();
        XHR.open("POST", "./phpModels/getUserProfileScript.php", false);
        XHR.onreadystatechange = ()=>{
            console.log("State changed to " + XHR.readyState);
            if(XHR.readyState==4 && XHR.status==200){
                console.log("Code block triggered");
                console.log("Response text of getUserProfile() function: ", XHR.responseText);
                JSO = JSON.parse(XHR.responseText);
                console.log("Response object of getUserProfile() function: ", JSO);
                var innerHTMLString = "";
                innerHTMLString += `
                <table id="profile_info" class="table table-hover col-md-8 mx-auto mt-5">
                <thead>
                <tr>
                    <th scope="col" class="p-0 m-0"><img src="${(JSO.result_array.display_pic_url)?(JSO.result_array.display_pic_url):('img/svg/user_solid.png')}" alt="" srcset="" class="img-round"></th>
                    <th scope="col"><h2>Edit Profile</h2></th>
                </tr>
                </thead>
                <tbody>
                    
                    <tr>
                        <td scope="col">Username</td>
                        <td scope="col">
                            ${JSO.result_array.username}
                            <input type="hidden" class="form-control" id="username" aria-regex="^[a-zA-Z0-9_]{3,100}$" value="${JSO.result_array.username}" />
                        </td>
                    </tr>`;

                innerHTMLString += `
                    <tr>
                        <td scope="row">User Type</td>
                        <td>`;
                        if((userObj.user_type_title=="admin")){
                            innerHTMLString += `
                            <select class="form-control" id="user_type_id">
                                <option selected disabled value="${JSO.result_array["user_type_id"]}">${JSO.result_array["User Type"]}</option>
                                <option value="1">admin</option>
                                <option value="2">buyer</option>
                        </select>
                            `;
                        }
                        else{
                            innerHTMLString += `
                                ${JSO.result_array["User Type"]}
                                <input type="hidden" id="user_type_id" value="${JSO.result_array["user_type_id"]}" />
                            `;
                        }
                innerHTMLString += `                            
                                <input type="hidden" id="user_type" value="${userObj.user_type}" />
                        </td>
                    </tr>
                    <tr>
                        <td scope="row">First Name</td>
                        <td>
                            <input type="text" class="form-control" id="firstname" aria-regex = "^[a-zA-Z ]{2,16}$" value="${JSO.result_array["First Name"]}" />
                            <small class="error text-danger">"The name field can only contain capital or small alphabetic characters"</small>
                        </td>
                    </tr>
                    <tr>
                        <td scope="row">Last Name</td>
                        <td>
                            <input type="text" class="form-control" id="lastname" aria-regex = "^[a-zA-Z ]{2,16}$" value="${JSO.result_array["Last Name"]}" />
                            <small class="error text-danger">"The name field can only contain capital or small alphabetic characters"</small>
                        </td>
                    </tr>
                    <tr>
                        <td scope="row">Date of Birth</td>
                        <td><input type="date" class="form-control" id="date_of_birth" value="${JSO.result_array["Date of Birth"]}" /></td>
                    </tr>

                    <tr>
                        <td scope="row">CNIC Number</td>
                        <td>
                            <input type="text" class="form-control" id="cnic" aria-regex = "^[0-9]{13}$" value="${JSO.result_array["CNIC Number"]}" />
                            <small class="error text-danger">"The CNIC should consist of 13 numeric digits and without a hyphen (-)"</small>
                        </td>
                    </tr>

                    <tr>
                        <td scope="row">Street Address</td>
                        <td><input type="text" class="form-control" id="street_address" value="${JSO.result_array["Street Address"]}" /></td>
                    </tr>

                    <tr>
                    <td scope="row">City and Country</td>
                    <td>
                        <select class="form-control" id="city_country">
                            <option selected disabled value="${titleCase(JSO.result_array["City"]) + "," + titleCase(JSO.result_array["Country"])}">${titleCase(JSO.result_array["City"]) + ", " + titleCase(JSO.result_array["Country"])}</option>`;
                            
                                var cities = getCities();
                for(city in cities.result_array){
                    innerHTMLString += `<option value="${cities.result_array[city].name}">${cities.result_array[city].name}</option>`;
                }

                innerHTMLString += `
                        </select>
                    </td>
                    </tr>

                    <tr>
                        <!-- Edit user button for both admin and applicant personal view -->
                        <td colspan='2' class='text-center'>
                            <div class="btn-group">
                                <a href="user_profile.php?username=${JSO.result_array.username}">
                                    <button type="button" class="btn btn-sm btn-secondary" onclick="return false;">Cancel</button>
                                </a>
                                <button type="submit" class="btn btn-sm btn-success">Save</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
                </table>
                `;
                targetTable.innerHTML = innerHTMLString;
                $("small.error").hide();
            }
        }
        XHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        console.log("Sendig post: " + "profileID=" + profileID + ", username=" + currentUser + ", passwordHash=" + currentPassHash)
        XHR.send("profileID=" + profileID + "&username=" + currentUser + "&passwordHash=" + currentPassHash);
    }
}

var getResume = (targetSelector, profile_username)=>{
    var targetElement = document.querySelector(targetSelector);
    var currentUser = localStorage.getItem("books_buying_selling/username");
    var currentPassHash = localStorage.getItem("books_buying_selling/passwordHash");
    var XHR = new XMLHttpRequest();
    XHR.open("POST", "./phpModels/getResumeScript.php");
    XHR.onreadystatechange = ()=>{
        if(XHR.readyState==4&&XHR.status==200){
            var JSO = JSON.parse(XHR.responseText);
            if(targetElement.tagName == "TEXTAREA"){
                targetElement.value = JSO.resume;
            }
            else{
                targetElement.innerHTML = JSO.resume;
            }
        }
    }
    XHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    XHR.send("currentUser="+currentUser+"&currentPassHash="+currentPassHash+"&profile_username="+profile_username);
}



function renderForm(JSONStr, formSelector){
        var formElement = document.querySelector(formSelector);
        var JSO = JSON.parse(JSONStr);
        var innerHTMLString = "";

        innerHTMLString = `<fieldset>`;
    innerHTMLString += `<div class="card-header col-12">`;
        innerHTMLString += `<legend>${JSO.legend}</legend>`;
    innerHTMLString += `</div>`;
    innerHTMLString += `<div class="card-body row p-5">`;

        for(inPut in JSO.data){
                if(JSO.data[inPut].type=="text"){
            innerHTMLString += (`
            <div class="md-form ${(JSO.data[inPut].classes)?JSO.data[inPut].classes:""}">
                <label for="${JSO.data[inPut].id}" id="${JSO.data[inPut].id}Lbl" class="${JSO.class}Lbl">${JSO.data[inPut].label}</label>
                <input type="${JSO.data[inPut].type}" id="${JSO.data[inPut].id}" ${(JSO.data[inPut].regex)? "aria-regex=\"" + JSO.data[inPut].regex + "\"":""} ${(JSO.data[inPut].localStore)?"aria-localStore=\"" + JSO.data[inPut].localStore + "\"":""} class="${JSO.class} form-control" ${(JSO.data[inPut].required)?"required":""}>
                <small style="display: none;" class="text-danger error">${(JSO.data[inPut].error)?(JSO.data[inPut].error):""}</small>
            </div>
            `);
        }
                else if(JSO.data[inPut].type=="password"){
            innerHTMLString += (`
            <div class="md-form ${(JSO.data[inPut].classes)?JSO.data[inPut].classes:""}">
                <label for="${JSO.data[inPut].id}" id="${JSO.data[inPut].id}Lbl" class="${JSO.class}Lbl">${JSO.data[inPut].label}</label>
                <input type="${JSO.data[inPut].type}" id="${JSO.data[inPut].id}" ${(JSO.data[inPut].regex)? "aria-regex=\"" + JSO.data[inPut].regex + "\"":""} ${(JSO.data[inPut].localStore)?"aria-localStore=\"" + JSO.data[inPut].localStore + "\"":""} class="${JSO.class} form-control" ${(JSO.data[inPut].required)?"required":""}>
                <small style="display: none;" class="text-danger error">${(JSO.data[inPut].error)?(JSO.data[inPut].error):""}</small>
            </div>
            `);
        }
                else if(JSO.data[inPut].type=="radiogroup"){
            innerHTMLString += `
            <div class="${JSO.data[inPut].classes} row my-3">
            <label id="${JSO.data[inPut].id}Lbl col" class="${JSO.class}Lbl">${JSO.data[inPut].label}</label>
            `;
            JSO.data[inPut].values.forEach((thisRadio)=>{
                innerHTMLString += `
                <div class="form-check-inline col justify-content-center">
                    <input type="radio" id="${thisRadio.id}" name="${JSO.data[inPut].id}" class="form-check-input col" ${(JSO.data[inPut].required)?"required":""}/>
                    <label for="${thisRadio.id}" id="${thisRadio.id}Lbl" class="${JSO.class}Lbl form-check-label">${thisRadio.label}</label>
                </div>`;
            });
            innerHTMLString += `</div>`;
        }
                else if(JSO.data[inPut].type=="checkgroup"){
            innerHTMLString += `
            <div class="${JSO.data[inPut].classes} row my-3">
            <label id="${JSO.data[inPut].id}Lbl col" class="${JSO.class}Lbl">${JSO.data[inPut].label}</label>
            `;
            JSO.data[inPut].values.forEach((thisCheck)=>{
                innerHTMLString += `
                <div class="form-check-inline col justify-content-center">
                    <input type="checkbox" id="${thisCheck.id}" name="${JSO.data[inPut].id}" class="form-check-input" ${(JSO.data[inPut].required)?"required":""}/>
                    <label for="${thisCheck.id}" id="${thisCheck.id}Lbl" class="${JSO.class}Lbl form-check-label">${thisCheck.label}</label>
                </div>`;
            });
            innerHTMLString += "</div>";
        }
                else if(JSO.data[inPut].type=="selection"){
            if(JSO.data[inPut].values=="dynamic"){
                innerHTMLString += `<div class="${JSO.data[inPut].classes}">
                <label style="display: none;" for= "${JSO.data[inPut].id}" id="${JSO.data[inPut].id}Lbl" class="${JSO.class}Lbl">${JSO.data[inPut].label}</label>    
                `;
                innerHTMLString += `<select id="${JSO.data[inPut].id}" name="${JSO.data[inPut].id}" class="mdb-select md-form col" ${(JSO.data[inPut].required)?"required":""} ${(JSO.data[inPut].onclick)? "onclick=\"" + JSO.data[inPut].onclick + "\"":""}>`;
                innerHTMLString += `<option value="" disabled selected>${JSO.data[inPut].label}</option>`;
                var XHRSelect = new XMLHttpRequest();
                XHRSelect.open("POST", "./phpModels/selectorScript.php", false);
                XHRSelect.onreadystatechange = ()=>{
                    if(XHRSelect.readyState == 4 && XHRSelect.status == 200){
                        console.log("Response text of getSelectionValues() : " , XHRSelect.responseText);
                        var JSO = JSON.parse(XHRSelect.responseText);
                        for(option in JSO.values){
                            innerHTMLString += `<option value='${JSO.values[option]}'>${option}</option>`;
                        }
                    }
                    innerHTMLString += `</select>`;
                    innerHTMLString += `</div>`;
                }
                var formData = new FormData();
                formData.append("table", JSO.data[inPut].source.table);
                formData.append("label", JSO.data[inPut].source.label);
                formData.append("value", JSO.data[inPut].source.value);
                if(JSO.data[inPut].source.filter) formData.append("filter", JSO.data[inPut].source.filter);
                if(JSO.data[inPut].source.filter_by) formData.append("filter_by", JSO.data[inPut].source.filter_by);
                XHRSelect.send(formData);
            }
            else{
                innerHTMLString += `
                <div class="${JSO.data[inPut].classes}">
                <label style="display: none;" for= "${JSO.data[inPut].id}" id="${JSO.data[inPut].id}Lbl" class="${JSO.class}Lbl">${JSO.data[inPut].label}</label>    
                `;
                innerHTMLString += `<select id="${JSO.data[inPut].id}" name="${JSO.data[inPut].id}" class="mdb-select md-form col" ${(JSO.data[inPut].required)?"required":""} ${(JSO.data[inPut].onclick)? "onclick=\"" + JSO.data[inPut].onclick + "\"":""}>`;
                innerHTMLString += `<option value="" disabled selected>${JSO.data[inPut].label}</option>`;
                JSO.data[inPut].values.forEach((thisValue)=>{
                    innerHTMLString += `
                        <option value="${thisValue.value}">${thisValue.label}</option>
                    `;
                });
                innerHTMLString += `</select>`;
                innerHTMLString += `</div>`;
            }
    }

        else if(JSO.data[inPut].type=="image"){
            innerHTMLString += `
                <div class="input-group">
                    <div class="col-md-12 mx-auto mb-5 text-center" style="height:100px !important;">
                        <img class="rounded mb-2" style="height: 100%" id="${JSO.data[inPut].id}Img" src="img/svg/user-solid.svg"/>
                    </div>
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="${JSO.data[inPut].id}Lbl">${JSO.data[inPut].label}</span>
                    </div>
                    <div class="custom-file">
                        <input type="file" accept="image/*" class="custom-file-input" id="${JSO.data[inPut].id}"
                        aria-describedby="inputGroupFileAddon01" onchange="updateImg('#${JSO.data[inPut].id}Img', '#${JSO.data[inPut].id}')">
                        <label class="custom-file-label" for="${JSO.data[inPut].id}">${JSO.data[inPut].label}</label>
                    </div>
                </div>
                `;
        }
        else if(JSO.data[inPut].type=="file"){
            innerHTMLString += `
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="${JSO.data[inPut].id}Lbl">${JSO.data[inPut].label}</span>
                    </div>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="${JSO.data[inPut].id}"
                        aria-describedby="inputGroupFileAddon01">
                        <label class="custom-file-label" for="${JSO.data[inPut].id}">${JSO.data[inPut].label}</label>
                    </div>
                </div>
                `;
        }
        else if(JSO.data[inPut].type=="textarea"){
            innerHTMLString += `
                <div class="md-form ${JSO.data[inPut].classes}">
                    <textarea id="${JSO.data[inPut].id}" class="md-textarea form-control ${JSO.class}" rows="3"></textarea>
                    <label for="${JSO.data[inPut].id}">${JSO.data[inPut].label}</label>
                </div>
                `;
        }
        

        else{
            innerHTMLString += (`
            <div class="md-form ${(JSO.data[inPut].classes)?JSO.data[inPut].classes:""}">
                <label for="${JSO.data[inPut].id}" id="${JSO.data[inPut].id}Lbl" class="${JSO.class}Lbl">${JSO.data[inPut].label}</label>
                <input type="${JSO.data[inPut].type}" id="${JSO.data[inPut].id}" ${(JSO.data[inPut].regex)? "aria-regex=\"" + JSO.data[inPut].regex + "\"":""} ${(JSO.data[inPut].localStore)?"aria-localStore=\"" + JSO.data[inPut].localStore + "\"":""} class="${JSO.class} form-control" ${(JSO.data[inPut].required)?"required":""}>
                <small style="display: none;" class="text-danger error">${(JSO.data[inPut].error)?(JSO.data[inPut].error):""}</small>
            </div>
            `);
        }
    } 
        innerHTMLString += "</fieldset>";
    innerHTMLString += `</div>`;
    innerHTMLString += `<div class="card-footer">`;
        innerHTMLString += `<div class="btn-group">`;
                    innerHTMLString += `<button type='reset' class='btn btn-md btn-danger' id='${JSO.class}_cancel'>${JSO.reset}</button>`;
            innerHTMLString += `<button type='submit' class='btn btn-md btn-secondary' id='${JSO.class}_submit'>${JSO.submit}</button>`;
        innerHTMLString += `</div>`;
    innerHTMLString += `</div">`;

        formElement.innerHTML = innerHTMLString;



    validateAndSubmit(formSelector, JSO.actionScript, false, "login.php");
    

} // End of renderForm() routine