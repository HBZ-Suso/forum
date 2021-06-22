var language = "";
var publicity = "";
var notifications = "";
var color = "";
var wVersClickCount = 0;

var settings_tab_loaded = false;

function set_settings_stuff () {
    document.querySelectorAll(".snb-element").forEach((element, index) => {
        element.addEventListener("click", (e) => {
            select_settings_page(e.target);
        })
    })

    select_settings_page(document.querySelector(".snb-language"));
    
    //document.querySelector(".settings-reload").addEventListener("click", (e) => {s_check_changes(); window.location.reload();})

    document.querySelectorAll(".option").forEach((element, index) => {element.addEventListener("click", (e) =>  {s_check_changes();})});


    document.querySelectorAll(".settings-profile-element").forEach((element, index) => {
        element.addEventListener("keyup", (e) => {
            changed = true;
            let inverted_internet_speed = 20 - connection.speedmbps;
            inverted_internet_speed = Math.min(...[10, inverted_internet_speed]);
            setTimeout(send_profile_axios, inverted_internet_speed * 200);
        })
    })

    if (getCookie("autle").length > 1) {
        document.getElementById("autotranslate-" + getCookie("autle")).checked = true;
    } else {
        document.cookie = "autle=off; sameSite=Lax; expires=Thu, 18 Dec 2024 12:00:00 UTC"; 
        document.getElementById("autotranslate-off").checked = true;
    }
}

function select_settings_page (snb_element) {
    if (snb_element === null) {return;}
    if (settings_tab_loaded) {localStorage.setItem("SettingsTab", snb_element.getAttribute("open").replace("settings-page-", ""));};
    
    document.querySelectorAll(".snb-element").forEach((element, index) => {
        if (element.classList.contains("snb-element-selected")) {
            element.classList.remove("snb-element-selected");
            document.querySelector("." + element.getAttribute("open")).style.display = "none";
        }
    })
    snb_element.classList.add("snb-element-selected");
    document.querySelector("." + snb_element.getAttribute("open")).style.display = "";
}





function s_check_changes () {
    let n_language = "";
    let n_publicity = "";
    let n_notifications = "";
    let n_color = "";
    document.querySelectorAll(".language_radio").forEach((element, index) => {
        if (element.checked) {
            n_language = element.id;
        }
    })
    document.querySelectorAll(".public_radio").forEach((element, index) => {
        if (element.checked) {
            n_publicity = element.id;
        }
    })
    document.querySelectorAll(".notification_radio").forEach((element, index) => {
        if (element.checked) {
            n_notifications = element.id;
        }
    })
    document.querySelectorAll(".user_color_radio").forEach((element, index) => {
        if (element.checked) {
            n_color = element.id;
        }
    })


    if (n_language !== language) {
        axios
            .post("/forum/assets/api/language.php?language=" + n_language)
            .then((response) => {
                if (response.data.indexOf("error") === -1) {
                    axios.post("/forum/assets/api/get_language.php").then((resolve) => {language_data = resolve.data;}, (reject) => {throw new Error()}).catch(console.debug)
                }
            })
            .catch((error) => {
                throw new Error(error);
            })
        language = n_language;
    }

    if (n_publicity !== publicity) {
        axios
            .post("/forum/assets/api/set_public.php?public=" + n_publicity.replace("i-", ""))
            .then((response) => {
            })
            .catch((error) => {
                throw new Error(error);
            })
        publicity = n_publicity;
    }

    if (n_notifications !== notifications) {
        axios
            .post("/forum/assets/api/set_notifications.php?level=" + n_notifications)
            .then((response) => {
            })
            .catch((error) => {
                throw new Error(error);
            })
        notifications = n_notifications;
    }

    if (n_color !== color) {
        axios
            .post("/forum/assets/api/set_color.php?color=" + n_color)
            .then((response) => {
            })
            .catch((error) => {
                throw new Error(error);
            })
        document.querySelectorAll(".user-profile-color-overlay-" + color).forEach((element, index) => {
            element.classList.remove("user-profile-color-overlay-" + color);
            element.classList.add("user-profile-color-overlay-" + n_color);
        })
        color = n_color;
    }


    if (logged_in && (user_type === "administrator" || user_type === "moderator")) {
        let w_version = "version-2";
        if (getCookie("wVers") === "version-old" && document.getElementById("version-old").checked && !document.getElementById("version-2").checked && wVersClickCount > 1) {
            window.location = "/forum/";
        }
        if (document.getElementById("version-2").checked) {w_version = "version-2"; wVersClickCount += 1;};
        if (document.getElementById("version-old").checked) {w_version = "version-old"; wVersClickCount += 1;};
        document.cookie = "wVers=" + w_version + "; expires=Thu, 18 Dec 2024 12:00:00 UTC"; 
    }


    document.querySelectorAll(".autotranslate_radio").forEach((element, index) => {
        if (element.checked) {
            document.cookie = "autle=" + element.getAttribute("autotranslate") + "; sameSite=Lax; expires=Thu, 18 Dec 2024 12:00:00 UTC"; 
        }
    })
}


function on_settings_window_open () {
    if (localStorage.getItem("SettingsTab") !== null) {
        select_settings_page(document.querySelector(".snb-" + localStorage.getItem("SettingsTab")));
        settings_tab_loaded = true;
    }

    if (logged_in) {
        axios
            .post("/forum/v2/assets/api/get_settings_profile.php")
            .then((resolve) => {
                try {
                    if (resolve.data.indexOf("error") !== -1) {
                        throw new Error(resolve.data)
                    }
                } catch (e) {};//JSON
                
                if (resolve.data.userMail !== undefined) {
                    document.querySelector(".settings-profile-mail").value = resolve.data.userMail;
                }
                if (resolve.data.userPhone !== undefined) {
                    document.querySelector(".settings-profile-phone").value = resolve.data.userPhone;
                }
                if (resolve.data.userEmployment !== undefined) {
                    document.querySelector(".settings-profile-employment").value = resolve.data.userEmployment;
                }
                if (resolve.data.userAge !== undefined) {
                    document.querySelector(".settings-profile-age").value = resolve.data.userAge;
                }
                if (resolve.data.userDescription !== undefined) {
                    document.querySelector(".settings-profile-description").value = resolve.data.userDescription;
                }
                document.querySelector(".settings-profile-mail").disabled = false;
                document.querySelector(".settings-profile-phone").disabled = false;
                document.querySelector(".settings-profile-age").disabled = false;
                document.querySelector(".settings-profile-employment").disabled = false;
                document.querySelector(".settings-profile-description").disabled = false;
            }, (reject) => {throw new Error(reject)})
            .catch(console.debug)

        if (user_type === "moderator" || user_type === "administrator") {
            if (getCookie("wVers").length > 0) {
                if (getCookie("wVers") === "version-2") {
                    document.getElementById("version-2").checked = true;
                } else if (getCookie("wVers") === "version-old") {
                    document.getElementById("version-old").checked = true;
                }
            } else {
                document.getElementById("version-2").checked = true;
                document.cookie = "wVers=" + w_version + "; expires=Thu, 18 Dec 2024 12:00:00 UTC"; 
            }
        }
    }
}


function get_profile_json_string () {
    let json = {};
    document.querySelectorAll(".settings-profile-element").forEach((element, index) => {
        json[element.getAttribute("elementName")] = element.value;
    })
    return JSON.stringify(json);
}

var changed = false;


function send_profile_axios () {
    if (changed === true) {
        changed = false;
        let post_req = "change_data=" + get_profile_json_string();
        axios
            .post("/forum/assets/api/change_data.php", post_req)
            .then((resolve) => {}, (reject) => {throw new Error(reject)})
            .catch((e) => console.debug)
    }
}