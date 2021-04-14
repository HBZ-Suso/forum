function show_login_and_logout () {
    axios
        .post("/forum/assets/api/logout.php")
        .then((resolve) => {
            let login_window = document.createElement("div");
            login_window.classList.add("loginbox-container")
            document.body.appendChild(login_window);

            if (window.mobileCheck() == true) {
                var add_mobile_loginbox_stylesheet = '<link rel="stylesheet" href="/forum/v2/assets/style/mobile.loginbox.css">';
            } else {
                var add_mobile_loginbox_stylesheet = "";
            }

            login_window.innerHTML = `
            <div class="loginbox-innerContainer">
                <a class="loginbox-close">X</a>
                <h3 class="loginbox-heading">Login</h3>
                <p class="loginbox-description">Enter your username and password. They will be sent to the server and you will be logged in. If the Login was successfull, this page will be reloaded.</p>

                <input type="text" placeholder="Username" class="loginbox-username"></input>
                <input type="password" placeholder="Password" class="loginbox-password"></input>
                <input type="submit" value="Login" class="loginbox-submit">

                <link rel="stylesheet" href="/forum/v2/assets/style/loginbox.css">
                ${add_mobile_loginbox_stylesheet}
            </div>
                `;

            

            document.querySelector(".loginbox-submit").addEventListener("click", (e) => {
                let username = document.querySelector(".loginbox-username");
                let password = document.querySelector(".loginbox-password");

                let formData = new FormData();

                formData.append("username", username.value);
                formData.append("password", password.value);

                if (username.value.length > 0 && password.value.length) {
                    axios
                        .post("/forum/assets/api/login.php", formData)
                        .then((resolve) => {
                            if (resolve.data === "Success") {
                                window.location.hash = "Home";
                                setTimeout(function () {window.location.reload();}, 5);
                            }
                        }, (reject) => {console.debug(reject)})
                } else {
                    alert("Please enter a Username and Password.")
                }
            })

            document.querySelector(".loginbox-close").addEventListener("click", (e) => {
                let counter = -2;
                while (window.location.hash === "#Login") {
                    window.location.hash = hash_history[hash_history.length + counter]["state"].slice(1);
                    counter--;
                }
                login_window.remove();
            })
        }, (reject) => {
            console.debug("Error whilst trying to logout.")
        })
}