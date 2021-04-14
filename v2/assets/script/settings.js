function show_settings () {
    let settings_window = document.createElement("div");
    settings_window.classList.add("settingsbox-container")
    document.body.appendChild(settings_window);

    if(logged_in === true) {
        var logged_img = `<img src="/forum/assets/img/icon/padlock.png" class="snb-element snb-public" open="settings-page-public">
        <img src="/forum/assets/img/icon/notification.png" class="snb-element snb-notification" open="settings-page-notification">`;
    } else {
        var logged_img = "";
    }

    settings_window.innerHTML = `
    <div class="settingsbox-innerContainer">
        <a class="settingsbox-close">X</a>

        <h3 class="settingsbox-heading">Settings</h3>
        
        <div class="settings-navigation-bar">
            <img src="/forum/assets/img/icon/translation.png" class="snb-element snb-language snb-element-selected" open="settings-page-language">
            ${logged_img}
        </div>
        <img src="/forum/assets/img/icon/reload.png" class="settings-reload" alt="Reload Page">

            <div class="settings-page settings-page-language" style="">
                <form class="setting">
                    <h1 class="setting-heading">Sprache</h1>
                    <div class="container">
                        <div class="option">
                            <input class="language_radio" type="radio" name="language" id="english" value="language">
                            <label for="english" aria-label="english">
                            <span></span>
                            English
                            </label>
                        </div>
                    
                        <div class="option">
                            <input class="language_radio" type="radio" name="language" id="deutsch" value="language">
                            <label for="deutsch" aria-label="deutsch">
                            <span></span>
                    
                            Deutsch
                            </label>
                        </div>

                        <div class="option">
                            <input class="language_radio" type="radio" name="language" id="français" value="language">
                            <label for="français" aria-label="français">
                            <span></span>
                            Français
                            </label>
                        </div>
                    </div>
                </form>
            </div>


            <div class="settings-page settings-page-public" style="display: none;">
                <form class="setting">
                    <h1 class="setting-heading">Profil-Öffentlichkeit</h1>
                    <div class="container">
                        <div class="option">
                            <input class="public_radio" type="radio" name="public" id="i-hidden" value="public">
                            <label for="i-hidden" aria-label="i-hidden">
                            <span></span>
                            Versteckt
                            </label>
                        </div>
                    
                        <div class="option">
                            <input class="public_radio" type="radio" name="public" id="i-public" value="public">
                            <label for="i-public" aria-label="i-public">
                            <span></span>
                            Öffentlich
                            </label>
                        </div>
                    </div>
                </form>
            </div>

            <div class="settings-page settings-page-notification" style="display: none;">
                <form class="setting">
                    <h1 class="setting-heading">Benachrichtigungen</h1>
                    <div class="container">
                        <div class="option">
                            <input class="notification_radio" type="radio" name="notification" id="low" value="low">
                            <label for="low" aria-label="low">
                            <span></span>
                            Keine
                            </label>
                        </div>
                    
                        <div class="option">
                            <input class="notification_radio" type="radio" name="notification" id="medium" value="medium">
                            <label for="medium" aria-label="medium">
                            <span></span>
                            Manche
                            </label>
                        </div>

                        <div class="option">
                            <input class="notification_radio" type="radio" name="notification" id="high" value="high">
                            <label for="high" aria-label="high">
                            <span></span>
                            Alle
                            </label>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <link rel="stylesheet" href="/forum/v2/assets/style/settingsbox.css">
    </div>
        `;

    axios
        .post("/forum/assets/api/get_settings.php")
        .then((resolve) => {
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
        })

    set_settings_stuff();

    document.querySelector(".settingsbox-close").addEventListener("click", (e) => {
        let counter = -2;
        while (window.location.hash === "#Settings") {
            window.location.hash = hash_history[hash_history.length + counter]["state"].slice(1);
            counter--;
        }
        settings_window.remove();
    })
}