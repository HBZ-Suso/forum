var age_value = 0;
function show_signup () {
    if (window.mobileCheck() == true) {
        var add_mobile_signup_stylesheet = '<link rel="stylesheet" href="/forum/v2/assets/style/mobile.signup.css">';
    } else {
        var add_mobile_signup_stylesheet = "";
    }

    

    show_article(custum_html=true, heading=language_data["v2-signup-heading"], content_html=`
        <div class="signup">
        <div class="signup-innerContainer">
            <p class="signup-notice">${language_data["v2-signup-notice"]}</p>

            <input type="text" placeholder="${language_data["signup-username"]}" class="signup-username"></input>
            <input type="password" placeholder="${language_data["signup-pwd"]}" class="signup-password signup-password1"></input>
            <input type="password" placeholder="${language_data["signup-pwd-again"]}" class="signup-password signup-password2"></input>
            <input type="text" placeholder="${language_data["signup-age"]}" class="signup-age" id="ageInput"></input>
            <input type="text" placeholder="${language_data["signup-phone"]}" class="signup-phone"></input>
            <input type="text" placeholder="${language_data["signup-employment"]}" class="signup-employment"></input>
            <input type="text" placeholder="${language_data["signup-mail"]}" class="signup-mail"></input>
            <input type="text" placeholder="${language_data["signup-mail-2"]}" class="signup-mail2"></input>

            <textarea type="text" placeholder="${language_data["signup-description"]}" class="signup-description"></textarea>

            <input type="text" placeholder="${language_data["signup-code"]}" class="signup-code"></input>

            <input type="submit" class="signup-submit">
        </div>
        
        <link rel="stylesheet" href="/forum/v2/assets/style/signup.css">
        ${add_mobile_signup_stylesheet}
        </div>`);

    /*
    document.querySelector(".signup-age").addEventListener("keyup", (e) => {
        try {
            if (isNaN(e.target.value)) {throw new Error("Nan")};
            age_value = e.target.value;
        } catch (l) {
            e.target.value = age_value;
        }
    });*/

    const ageDatePicker = MCDatepicker.create({ 
        el: '#ageInput',
        dateFormat: 'MMM-DD-YYYY',
        bodyType: 'modal',
        maxDate: new Date(new Date().getTime() - 1000*60*60*24*365*5) // Going onwards from 5 Years ago
    })

    document.querySelector(".signup-submit").addEventListener("click", (e) => {
        let username = document.querySelector(".signup-username").value;
        let password1 = document.querySelector(".signup-password1").value;
        let password2 = document.querySelector(".signup-password2").value;

        let age = ageDatePicker.getFullDate();

        let mail = document.querySelector(".signup-mail").value;
        let mail2 = document.querySelector(".signup-mail2").value;
        let employment = document.querySelector(".signup-employment").value;
        let phone = document.querySelector(".signup-phone").value;
        let code = document.querySelector(".signup-code").value;
        let description = document.querySelector(".signup-description").value;
        
        
        if (password1 !== password2) {alert("Passwords do not match!"); return;}
        if (mail !== mail2) {alert("Mails do not match!"); return;}
        
        let formData = new FormData();

        formData.append("username", username);
        formData.append("password", password1);
        formData.append("password_2", password2);
        formData.append("age", age);
        formData.append("mail", mail);
        formData.append("employment", employment);
        formData.append("phone", phone);
        formData.append("code", code);
        formData.append("description", description);

        if (username.length > 0 && password1.length > 2) {
            axios
                .post("/forum/v2/assets/api/signup.php", formData)
                .then((resolve) => {
                    if (resolve.data === "Success") {
                        window.location.hash = "Login";
                        setTimeout(function () {window.location.reload();}, 5);
                    }
                }, (reject) => {console.debug(reject)})
        } else {
            alert(language_data["v2-login-alert"])
        }
    })

    document.querySelector(".hashLoadedPage").innerText = "Signup";
}