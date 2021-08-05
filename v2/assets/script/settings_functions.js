var language = "";
var publicity = "";
var notifications = "";
var color = "";
var wVersClickCount = 0;
var setting_names = ["language", "autotranslate", "public", "notification", "user_color", "version", "science", "connectiontest", "constantrequest", "loadcomments", "loadauthors", "messages"];

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


    document.querySelector(".settings-profile-passwordreset").addEventListener("click", (e) => {
        let old_pwd = document.querySelector(".settings-profile-passwordold").value;
        let pwd1 = document.querySelector(".settings-profile-password1").value;
        let pwd2 = document.querySelector(".settings-profile-password2").value;

        if (pwd1 !== pwd2) {
            alert("Passwords to not match...");
            return;
        }

        if (old_pwd.length > 0 && pwd1.length > 0 && pwd2.length > 0) {
            let post_req = "change_data=" + JSON.stringify({"userPassword": pwd1, "passwordold": old_pwd});
            axios
                .post("/forum/assets/api/change_data.php", post_req)
                .then((resolve) => {
                    document.querySelector(".settings-profile-passwordold").value = '';
                    document.querySelector(".settings-profile-password1").value = '';
                    document.querySelector(".settings-profile-password2").value = '';
                }, (reject) => {throw new Error(reject)})
                .catch((e) => console.debug)
        }
    })




}

function select_settings_page (snb_element) {
    if (snb_element === null) {return;}
    if (settings_tab_loaded) {localStorage.setItem("SettingsTab", snb_element.getAttribute("open").replace("settings-page-", ""));};
    if (localStorage.getItem("logs") !== null) {add_log({"type": "settingsPage", "data": {"time": Date.now(), "page": snb_element.getAttribute("open").replace("settings-page-", "")}});}

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
        
        // Set visible label
        document.querySelectorAll(".select-box__input-" + name).forEach((element, index) => {element.style.display = "";})
        document.querySelector(`.select-box__input-${name}-${value}`).style.display = "block";
        
        switch (name) {
            case "language":
                set_language(value);
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
                    /*document.querySelectorAll(".user-profile-picture").forEach((element, index) => {
                        element.className = ""; 
                        element.classList.add("user-profile-picture");
                        //element.classList.add("user-profile-color-overlay-" + value);
                    })*/
                break;
            case "autotranslate":
                document.cookie = "autle=" + value + "; sameSite=Lax; expires=Thu, 18 Dec 2024 12:00:00 UTC"; 
                break;
            case "science":
                document.cookie = "science=" + value + "; sameSite=Lax; expires=Thu, 18 Dec 2024 12:00:00 UTC"; 
                break;
            case "connectiontest":
                document.cookie = "connectiontest=" + value + "; sameSite=Lax; expires=Thu, 18 Dec 2024 12:00:00 UTC"; 
                break;
            case "constantrequest":
                document.cookie = "constantrequest=" + value + "; sameSite=Lax; expires=Thu, 18 Dec 2024 12:00:00 UTC"; 
                break;
            case "loadcomments":
                document.cookie = "loadcomments=" + value + "; sameSite=Lax; expires=Thu, 18 Dec 2024 12:00:00 UTC"; 
                break;
            case "loadauthors":
                document.cookie = "loadauthors=" + value + "; sameSite=Lax; expires=Thu, 18 Dec 2024 12:00:00 UTC"; 
                break;
            case "messages":
                axios
                    .post("/forum/assets/api/set_messages.php?messages=" + value)
                    .then((response) => {
                        document.cookie = "messages=" + value + "; sameSite=Lax; expires=Thu, 18 Dec 2024 12:00:00 UTC"; 
                    })
                    .catch((error) => {
                        throw new Error(error);
                    })
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




var ageDatePicker = false;

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
                    document.querySelector(".settings-profile-age").value = '';
                    ageDatePicker = new MCDatepicker.create({
                        el: '#settings-profile-age',
                        selectedDate: new Date(resolve.data.userAge),
                        dateFormat: 'MMM-DD-YYYY',
                        bodyType: 'modal'
                    });


                    ageDatePicker.onClose(() => {
                        changed = true;
                        let inverted_internet_speed = 20 - connection.speedmbps;
                        inverted_internet_speed = Math.min(...[10, inverted_internet_speed]);
                        setTimeout(send_profile_axios, inverted_internet_speed * 200);
                    })
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

        axios
            .post("/forum/v2/assets/api/get_setting_changes.php")
            .then((resolve) => {
                document.querySelector(".tbl-content-space").innerHTML = ``;

                let fwidth = document.querySelector(".tbl-header").clientWidth / 4 - 8;

                resolve.data.forEach((element, index) => {
                    document.querySelector(".tbl-content-space").innerHTML += `
                        <tr>
                            <td style="width: ${fwidth}; padding: 4px;">${element["settingChangeType"].slice(0, 15)}</td>
                            <td style="width: ${fwidth}; padding: 4px;">${element["settingChangeDate"]}</td>
                            <td style="width: ${fwidth}; padding: 4px;">${element["settingChangeFrom"].slice(0, 15)}</td>
                            <td style="width: ${fwidth}; padding: 4px;">${element["settingChangeTo"].slice(0, 15)}</td>
                        </tr>
                    `;
                });
            }, (reject) => {throw new Error(reject)})
            .catch((e) => console.debug)
    }
}


function get_profile_json_string () {
    let json = {};
    document.querySelectorAll(".settings-profile-element").forEach((element, index) => {
        if (element.classList.contains("settings-profile-age")) {
            json[element.getAttribute("elementName")] = ageDatePicker.getFullDate();
        } else {
            json[element.getAttribute("elementName")] = element.value;
        }
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






function download_personal_data () {
    axios
        .post("/forum/v2/assets/api/get_data.php")
        .then((resolve) => {
            document.querySelector('.settings-download-personal-data').style.display = ''; 
            document.querySelector('.settings-download-personal-data-prepare').style.display = 'none';
            document.querySelector('.settings-download-personal-data').addEventListener("click", () => {
                window.download(resolve.data);
                delete resolve.data;
                document.querySelector('.settings-download-personal-data-prepare').style.display = ''; 
                document.querySelector('.settings-download-personal-data-prepare').innerHTML = language_data["v2-settings-personaldatadownload-prepare"];
                document.querySelector('.settings-download-personal-data').style.display = 'none';
            });
        }, (reject) => {throw new Error(reject)})
        .catch((e) => console.debug)
    
}