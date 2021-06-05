function show_settings () {
    /*
    let settings_window = document.createElement("div");
    settings_window.classList.add("settingsbox-container")
    document.body.appendChild(settings_window);
    */

    if(logged_in === true) {
        var logged_img = `
        <img src="/forum/assets/img/icon/padlock.png" class="snb-element snb-public" open="settings-page-public">
        <img src="/forum/assets/img/icon/notification.png" class="snb-element snb-notification" open="settings-page-notification">
        <img src="/forum/assets/img/icon/theme.png" class="snb-element snb-theme" open="settings-page-theme">
        `;
    } else {
        var logged_img = "";
    }

    show_article(custum_html=true, heading=language_data["v2-settings-heading"], content_html=`  
        <div class="settings-navigation-bar">
            <img src="/forum/assets/img/icon/translation.png" class="snb-element snb-language snb-element-selected" open="settings-page-language">
            ${logged_img}
        </div>
        <!--<img src="/forum/assets/img/icon/reload.png" class="settings-reload" alt="Reload Page">-->

            <div class="settings-page settings-page-theme" style="display: none;">
                <form class="setting">
                    <h1 class="setting-heading">${language_data["v2-settings-theme-heading"]}</h1>
                    <div class="container">
                        <div class="option">
                            <input class="user_color_radio" type="radio" name="user-color" id="red" value="user-color">
                            <label for="red" aria-label="red">
                            <span></span>
                            ${language_data["v2-red"]}
                            </label>
                        </div>
                    
                        <div class="option">
                            <input class="user_color_radio" type="radio" name="user-color" id="purple" value="user-color">
                            <label for="purple" aria-label="purple">
                            <span></span>
                            ${language_data["v2-purple"]}
                            </label>
                        </div>

                        <div class="option">
                            <input class="user_color_radio" type="radio" name="user-color" id="pink" value="user-color">
                            <label for="pink" aria-label="pink">
                            <span></span>
                            ${language_data["v2-pink"]}
                            </label>
                        </div>

                        <div class="option">
                            <input class="user_color_radio" type="radio" name="user-color" id="green" value="user-color">
                            <label for="green" aria-label="green">
                            <span></span>
                            ${language_data["v2-green"]}
                            </label>
                        </div>

                        <div class="option">
                            <input class="user_color_radio" type="radio" name="user-color" id="yellow" value="user-color">
                            <label for="yellow" aria-label="yellow">
                            <span></span>
                            ${language_data["v2-yellow"]}
                            </label>
                        </div>

                        <div class="option">
                            <input class="user_color_radio" type="radio" name="user-color" id="black" value="user-color">
                            <label for="black" aria-label="black">
                            <span></span>
                            ${language_data["v2-black"]}
                            </label>
                        </div>

                        <div class="option">
                            <input class="user_color_radio" type="radio" name="user-color" id="blue" value="user-color">
                            <label for="blue" aria-label="blue">
                            <span></span>
                            ${language_data["v2-blue"]}
                            </label>
                        </div>

                        <div class="option">
                            <input class="user_color_radio" type="radio" name="user-color" id="turquoise" value="user-color">
                            <label for="turquoise" aria-label="turquoise">
                            <span></span>
                            ${language_data["v2-turquoise"]}
                            </label>
                        </div>
                    </div>
                </form>
            </div>

            <div class="settings-page settings-page-language" style="">
                <form class="setting">
                    <h1 class="setting-heading">${language_data["v2-settings-language-heading"]}</h1>
                    <div class="container">
                        <div class="option">
                            <input class="language_radio" type="radio" name="language" id="english" value="language">
                            <label for="english" aria-label="english">
                            <span></span>
                            ${language_data["v2-english"]}
                            </label>
                        </div>
                    
                        <div class="option">
                            <input class="language_radio" type="radio" name="language" id="deutsch" value="language">
                            <label for="deutsch" aria-label="deutsch">
                            <span></span>
                            ${language_data["v2-german"]}
                            </label>
                        </div>

                        <!--<div class="option">
                            <input class="language_radio" type="radio" name="language" id="français" value="language">
                            <label for="français" aria-label="français">
                            <span></span>
                            ${language_data["v2-french"]}
                            </label>
                        </div>-->
                    </div>
                </form>
            </div>


            <div class="settings-page settings-page-public" style="display: none;">
                <form class="setting">
                    <h1 class="setting-heading">${language_data["v2-settings-public-heading"]}</h1>
                    <div class="container">
                        <div class="option">
                            <input class="public_radio" type="radio" name="public" id="i-hidden" value="public">
                            <label for="i-hidden" aria-label="i-hidden">
                            <span></span>
                            ${language_data["v2-hidden"]}
                            </label>
                        </div>
                    
                        <div class="option">
                            <input class="public_radio" type="radio" name="public" id="i-public" value="public">
                            <label for="i-public" aria-label="i-public">
                            <span></span>
                            ${language_data["v2-public"]}
                            </label>
                        </div>
                    </div>
                </form>
            </div>

            <div class="settings-page settings-page-notification" style="display: none;">
                <form class="setting">
                    <h1 class="setting-heading">${language_data["v2-settings-notification-heading"]}</h1>
                    <div class="container">
                        <div class="option">
                            <input class="notification_radio" type="radio" name="notification" id="low" value="low">
                            <label for="low" aria-label="low">
                            <span></span>
                            ${language_data["v2-none"]}
                            </label>
                        </div>
                    
                        <div class="option">
                            <input class="notification_radio" type="radio" name="notification" id="medium" value="medium">
                            <label for="medium" aria-label="medium">
                            <span></span>
                            ${language_data["v2-some"]}
                            </label>
                        </div>

                        <div class="option">
                            <input class="notification_radio" type="radio" name="notification" id="high" value="high">
                            <label for="high" aria-label="high">
                            <span></span>
                            ${language_data["v2-all"]}
                            </label>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <link rel="stylesheet" href="/forum/v2/assets/style/settingsbox.css">
        `);

    axios
        .post("/forum/assets/api/get_settings.php")
        .then((resolve) => {
            try {
                if ("language" in resolve.data) {
                    document.getElementById(resolve.data.language).checked = true;
                }
                if ("privacy" in resolve.data) {
                    if (resolve.data.privacy == "0") {
                        document.getElementById("low").checked = true;
                    }
                    if (resolve.data.privacy == "1") {
                        document.getElementById("medium").checked = true;
                    }
                    if (resolve.data.privacy == "2") {
                        document.getElementById("high").checked = true;
                    }
                }
                if ("public" in resolve.data) {
                    if (resolve.data.public === true) {
                        document.getElementById("i-public").checked = true;
                    }
                    if (resolve.data.public == false) {
                        document.getElementById("i-hidden").checked = true;
                    }
                }
                if ("color" in resolve.data) {
                    document.getElementById(resolve.data.color).checked = true;
                }
            } catch (e) {console.debug(e);}
        })

    if (window.mobileCheck() === true && document.body.innerHTML.indexOf("<link rel='stylesheet' href='/forum/v2/assets/style/mobile.settingsbox.css'></link>") === -1) {
        document.body.innerHTML += "<link rel='stylesheet' href='/forum/v2/assets/style/mobile.settingsbox.css'></link>"
    }

    set_settings_stuff()

    /*
    document.querySelector(".settingsbox-close").addEventListener("click", (e) => {
        let counter = -2;
        try {
            while (window.location.hash === "#Settings") {
                window.location.hash = hash_history[hash_history.length + counter]["state"].slice(1);
                counter--;
                if (hash_history.length + counter < 1) { // Fallback
                    window.location.hash = "Home";
                }
            }
        } catch (e) {
            console.debug(e);
        }
        settings_window.remove();
    })
    */
}

function close_settings_window () {
    let counter = -2;
        try {
            while (window.location.hash === "#Settings") {
                window.location.hash = hash_history[hash_history.length + counter]["state"].slice(1);
                counter--;
                if (hash_history.length + counter < 1) { // Fallback
                    window.location.hash = "Home";
                }
            }
        } catch (e) {
            console.debug(e);
        }
        settings_window.remove();
}