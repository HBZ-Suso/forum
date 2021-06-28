function show_settings () {
    /*
    let settings_window = document.createElement("div");
    settings_window.classList.add("settingsbox-container")
    document.body.appendChild(settings_window);
    */

    

    axios
        .post("/forum/assets/api/get_settings.php")
        .then((settings) => {
            // TRANSFORM API OUTPUT INTO USABLE FORMAT
            if (settings.data.public !== undefined && settings.data.public !== null) {
                if (settings.data.public === false) {
                    settings.data.public = "hidden";
                } else {
                    settings.data.public = "public";
                }
            }
            if (settings.data.privacy !== undefined && settings.data.privacy !== null) {
                if (settings.data.privacy === 0) {
                    settings.data.notification = "low";
                } else if (settings.data.privacy === 1) {
                    settings.data.notification = "medium";
                } else if (settings.data.privacy === 2) {
                    settings.data.notification = "high ";
                }
            }
            if (settings.data.color !== undefined && settings.data.color !== null) { 
                settings.data.user_color = settings.data.color;
            }
            if (getCookie("wVers").length > 0) {
                if (getCookie("wVers") === "version-2") {
                    settings.data.version = "2";
                } else if (getCookie("wVers") === "version-old") {
                    settings.data.version = "old";
                }
            } else {
                settings.data.version = "old";
                document.cookie = "wVers=" + w_version + "; sameSite=Lax; expires=Thu, 18 Dec 2024 12:00:00 UTC"; 
            }
            if (getCookie("autle").length > 0) {
                if (getCookie("autle") === "onlyarticles") {
                    settings.data.autotranslate = "onlyarticles";
                } else if (getCookie("autle") === "onlyprofiles") {
                    settings.data.version = "onlyprofiles";
                } else if (getCookie("autle") === "everything") {
                    settings.data.version = "everything";
                } else if (getCookie("autle") === "off") {
                    settings.data.version = "off";
                }
            } else {
                settings.data.version = "old";
                document.cookie = "autle=" + w_version + "; sameSite=Lax; expires=Thu, 18 Dec 2024 12:00:00 UTC"; 
            }
            if (getCookie("science").length > 0) {
                if (getCookie("science") === "off") {
                    settings.data.science = "off";
                } else {
                    settings.data.science = "on";
                }
            } else {
                settings.data.science = "on";
                document.cookie = "science=on; sameSite=Lax; expires=Thu, 18 Dec 2024 12:00:00 UTC"; 
            }
            if (getCookie("connectiontest").length > 0) {
                if (getCookie("connectiontest") === "off") {
                    settings.data.connectiontest = "off";
                } else if (getCookie("connectiontest") === "slow") {
                    settings.data.connectiontest = "slow";
                } else {
                    settings.data.connectiontest = "on";
                }
            } else {
                settings.data.connectiontest = "on";
                document.cookie = "connectiontest=on; sameSite=Lax; expires=Thu, 18 Dec 2024 12:00:00 UTC"; 
            }
            if (getCookie("constantrequest").length > 0) {
                if (getCookie("constantrequest") === "off") {
                    settings.data.constantrequest = "off";
                } else {
                    settings.data.constantrequest = "on";
                }
            } else {
                settings.data.constantrequest = "on";
                document.cookie = "constantrequest=on; sameSite=Lax; expires=Thu, 18 Dec 2024 12:00:00 UTC"; 
            }
            if (getCookie("loadcomments").length > 0) {
                if (getCookie("loadcomments") === "off") {
                    settings.data.loadcomments = "off";
                } else {
                    settings.data.loadcomments = "on";
                }
            } else {
                settings.data.loadcomments = "on";
                document.cookie = "loadcomments=on; sameSite=Lax; expires=Thu, 18 Dec 2024 12:00:00 UTC"; 
            }
            if (getCookie("loadauthors").length > 0) {
                if (getCookie("loadauthors") === "off") {
                    settings.data.loadauthors = "off";
                } else {
                    settings.data.loadauthors = "on";
                }
            } else {
                settings.data.loadauthors = "on";
                document.cookie = "loadauthors=on; sameSite=Lax; expires=Thu, 18 Dec 2024 12:00:00 UTC"; 
            }




            if(logged_in === true) {
                var logged_img = `
                <img src="/forum/assets/img/icon/padlock.png" class="snb-element snb-public" open="settings-page-public">
                <img src="/forum/assets/img/icon/notification.png" class="snb-element snb-notification" open="settings-page-notification">
                <img src="/forum/assets/img/icon/theme.png" class="snb-element snb-theme" open="settings-page-theme">
                <img src="/forum/assets/img/icon/connection.png" class="snb-element snb-connection" open="settings-page-connection">
                <img src="/forum/assets/img/icon/user.png" class="snb-element snb-profile" open="settings-page-profile">
                `;
                if (user_type === "moderator" || user_type === "administrator") {
                    var theme_allowed = `
                    <form class="setting">
                        <h1 class="setting-heading">${language_data["v2-settings-version-heading"]}</h1>
                        <p class="setting-notice">${language_data["v2-settings-version-notice"]}</p>
                        <button class="settings-link" onclick="window.location = '/forum/?redirect=${window.location}';">${language_data["v2-settings-version-visit"]}</button>
                        ${get_html("version", get_setting_values("version", settings.data))}
                    </form>
                    `;
                }
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
                        ${theme_allowed}
                        <form class="setting">
                            <h1 class="setting-heading">${language_data["v2-settings-theme-heading"]}</h1>
                            <p class="setting-notice">${language_data["v2-settings-theme-notice"]}</p>
                            ${get_html("user_color", get_setting_values("user_color", settings.data))}
                        </form>
                    </div>

                    <div class="settings-page settings-page-language" style="">
                        <form class="setting">
                            <h1 class="setting-heading">${language_data["v2-settings-language-heading"]}</h1>
                            <p class="setting-notice">${language_data["v2-settings-language-notice"]}</p>
                            ${get_html("language", get_setting_values("language", settings.data))}
                        </form>
                        <form class="setting">
                            <h1 class="setting-heading">${language_data["v2-settings-autotranslate-heading"]}</h1>
                            <p class="setting-notice">${language_data["v2-settings-autotranslate-warning"]}</p>
                            ${get_html("autotranslate", get_setting_values("autotranslate", settings.data))}
                        </form>
                    </div>


                    <div class="settings-page settings-page-public" style="display: none;">
                        <form class="setting">
                            <h1 class="setting-heading">${language_data["v2-settings-public-heading"]}</h1>
                            <p class="setting-notice">${language_data["v2-settings-public-notice"]}</p>
                            ${get_html("public", get_setting_values("public", settings.data))}
                        </form>
                        <form class="setting">
                            <h1 class="setting-heading">${language_data["v2-settings-science-heading"]}</h1>
                            <p class="setting-notice">${language_data["v2-settings-science-notice"]}</p>
                            ${get_html("science", get_setting_values("science", settings.data))}
                        </form>
                    </div>

                    <div class="settings-page settings-page-connection" style="display: none;">
                        <form class="setting">
                            <h1 class="setting-heading">${language_data["v2-settings-connectiontest-heading"]}</h1>
                            <p class="setting-notice">${language_data["v2-settings-connectiontest-notice"]}</p>
                            ${get_html("connectiontest", get_setting_values("connectiontest", settings.data))}
                        </form>
                        <form class="setting">
                            <h1 class="setting-heading">${language_data["v2-settings-constantrequest-heading"]}</h1>
                            <p class="setting-notice">${language_data["v2-settings-constantrequest-notice"]}</p>
                            ${get_html("constantrequest", get_setting_values("constantrequest", settings.data))}
                        </form>
                        <form class="setting">
                            <h1 class="setting-heading">${language_data["v2-settings-loadcomments-heading"]}</h1>
                            <p class="setting-notice">${language_data["v2-settings-loadcomments-notice"]}</p>
                            ${get_html("loadcomments", get_setting_values("loadcomments", settings.data))}
                        </form>
                        <form class="setting">
                            <h1 class="setting-heading">${language_data["v2-settings-loadauthors-heading"]}</h1>
                            <p class="setting-notice">${language_data["v2-settings-loadauthors-notice"]}</p>
                            ${get_html("loadauthors", get_setting_values("loadauthors", settings.data))}
                        </form>
                    </div>

                    <div class="settings-page settings-page-notification" style="display: none;">
                        <form class="setting">
                            <h1 class="setting-heading">${language_data["v2-settings-notification-heading"]}</h1>
                            <p class="setting-notice">${language_data["v2-settings-notification-notice"]}</p>
                            ${get_html("notification", get_setting_values("notification", settings.data))}
                        </form>
                    </div>


                    <div class="settings-page settings-page-profile" style="display: none;">
                        <form class="setting">
                            <h1 class="setting-heading">${language_data["v2-settings-profile-heading"]}</h1>
                            <p class="setting-notice">${language_data["v2-settings-profile-notice"]}</p>
                            <div class="settings-profile-container">
                                <input class="settings-profile-element settings-profile-employment" placeholder="${language_data["v2-settings-profile-employment"]}" type="text" disabled elementName="userEmployment">
                                <input class="settings-profile-element settings-profile-age" placeholder="${language_data["v2-settings-profile-age"]}" type="number" disabled elementName="userAge">
                                <input class="settings-profile-element settings-profile-mail" placeholder="${language_data["v2-settings-profile-mail"]}" type="text" disabled elementName="userMail">
                                <input class="settings-profile-element settings-profile-phone" placeholder="${language_data["v2-settings-profile-phone"]}" type="text" disabled elementName="userPhone">

                                <textarea class="settings-profile-element settings-profile-description" placeholder="${language_data["v2-settings-profile-description"]}" disabled elementName="userDescription"></textarea>
                            </div>
                        </form>
                    </div>
                </div>

                <link rel="stylesheet" href="/forum/v2/assets/style/settingsbox.css">
                `);

            if (window.mobileCheck() === true && document.body.innerHTML.indexOf("<link rel='stylesheet' href='/forum/v2/assets/style/mobile.settingsbox.css'></link>") === -1) {
                document.body.innerHTML += "<link rel='stylesheet' href='/forum/v2/assets/style/mobile.settingsbox.css'></link>"
            }

            set_settings_stuff()

            on_settings_window_open();
            


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
            })
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



function get_setting_values (setting, sdata) {
    let settings_d = {
        "user_color": ["red", "purple", "pink", "green", "yellow", "black", "blue", "turquoise"],
        "language": ["deutsch", "english"],
        "autotranslate": ["off", "onlyarticles", "onlyprofiles", "all"],
        "public": ["hidden", "public"],
        "notification": ["low", "medium", "high"],
        "version": ["old", "2"],
        "science": ["on", "off"],
        "connectiontest": ["on", "slow", "off"],
        "constantrequest": ["on", "off"],
        "loadcomments": ["on", "off"],
        "loadauthors": ["on", "off"]
    };

    if (setting in settings_d) {
        let data = settings_d[setting];
        if (setting in sdata && data.indexOf(sdata[setting]) !== -1) {
            data = data.removeA(sdata[setting]);
            data.unshift(sdata[setting]);
        }
        return data;
    } else {
        return [];
    }  
}