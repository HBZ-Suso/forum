var language = "";
var publicity = "";
var notifications = "";
var color = "";

function set_settings_stuff () {
    document.querySelectorAll(".snb-element").forEach((element, index) => {
        element.addEventListener("click", (e) => {
            select_settings_page(e.target);
        })
    })

    select_settings_page(document.querySelector(".snb-language"));
    
    document.querySelector(".settings-reload").addEventListener("click", (e) => {s_check_changes(); window.location.reload();})

    document.querySelectorAll(".option").forEach((element, index) => {element.addEventListener("click", (e) =>  {s_check_changes();})});
}

function select_settings_page (snb_element) {
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
}
