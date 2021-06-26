var language = "";
var publicity = "";
var notifications = "";
var color = "";
var wVersClickCount = 0;
var setting_names = ["language", "autotranslate", "public", "notification", "user_color", "version"];

var settings_tab_loaded = false;

function set_settings_stuff () {
    document.querySelectorAll(".snb-element").forEach((element, index) => {
        element.addEventListener("click", (e) => {
            select_settings_page(e.target);
        })
    })
    
    //document.querySelector(".settings-reload").addEventListener("click", (e) => {s_check_changes(); window.location.reload();})

    document.querySelectorAll(".option").forEach((element, index) => {element.addEventListener("click", (e) =>  {s_check_changes(e.target);})});


    document.querySelectorAll(".settings-profile-element").forEach((element, index) => {
        element.addEventListener("keyup", (e) => {
            changed = true;
            let inverted_internet_speed = 20 - connection.speedmbps;
            inverted_internet_speed = Math.min(...[10, inverted_internet_speed]);
            setTimeout(send_profile_axios, inverted_internet_speed * 200);
        })
    })
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





function s_check_changes (element) {
    if (setting_names.indexOf(element.getAttribute("name")) !== -1) {
        let name = element.getAttribute("name");
        let value = element.getAttribute(element.getAttribute("name"));
        switch (name) {
            case "language":
                axios
                .post("/forum/assets/api/language.php?language=" + value)
                .then((response) => {
                    if (response.data.indexOf("error") === -1) {
                        axios.post("/forum/assets/api/get_language.php").then((resolve) => {language_data = resolve.data;}, (reject) => {throw new Error()}).catch(console.debug)
                    }
                })
                .catch((error) => {
                    throw new Error(error);
                })
                break;
            case "public":
                axios
                    .post("/forum/assets/api/set_public.php?public=" + value)
                    .then((response) => {
                    })
                    .catch((error) => {
                        throw new Error(error);
                    })
                break;
            case "notification":
                axios
                    .post("/forum/assets/api/set_notifications.php?level=" + value)
                    .then((response) => {
                    })
                    .catch((error) => {
                        throw new Error(error);
                    })
                break;
            case "user_color": 
                axios
                    .post("/forum/assets/api/set_color.php?color=" + value)
                    .then((response) => {
                    })
                    .catch((error) => {
                        throw new Error(error);
                    })
                    document.querySelectorAll(".user-profile-picture").forEach((element, index) => {
                        element.className = ""; 
                        element.classList.add("user-profile-picture");
                        element.classList.add("user-profile-color-overlay-" + value);
                    })
                break;
            case "autotranslate":
                document.cookie = "autle=" + value + "; sameSite=Lax; expires=Thu, 18 Dec 2024 12:00:00 UTC"; 
                break;
            case "version":
                if (value === "old") {
                    document.cookie = "wVers=version-old; sameSite=Lax; expires=Thu, 18 Dec 2024 12:00:00 UTC"; 
                } else {
                    document.cookie = "wVers=version-2; sameSite=Lax; expires=Thu, 18 Dec 2024 12:00:00 UTC"; 
                }
                break;
        }
    }
}






function on_settings_window_open () {
    if (localStorage.getItem("SettingsTab") !== null) {
        select_settings_page(document.querySelector(".snb-" + localStorage.getItem("SettingsTab")));
    } else {
        select_settings_page(document.querySelector(".snb-language"));
    }
    settings_tab_loaded = true;

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