document.querySelectorAll(".snb-element").forEach((element, index) => {
    element.addEventListener("click", (e) => {
        select_settings_page(e.target);
    })
})






select_settings_page(document.querySelector(".snb-language"));
var theme = "";
var language = "";
var publicity = "";
var notifications = "";

function s_check_changes () {
    let c_theme = false;
    let c_language = false;
    let c_publicity = false;
    let c_notifications = false;
    let n_language = "";
    let n_theme = "";
    let n_publicity = "";
    let n_notifications = "";
    document.querySelectorAll(".language_radio").forEach((element, index) => {
        if (element.checked) {
            n_language = element.id;
        }
    })
    document.querySelectorAll(".theme_radio").forEach((element, index) => {
        if (element.checked) {
            n_theme = element.id;
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

    // THEME
    if (n_theme !== theme) {
        axios
            .post("/forum/assets/api/theme.php", "theme=" + n_theme)
            .then((response) => {
                if (response.data === theme) {
                    document.getElementById("theme-box").innerHTML = "";
                    document.getElementById("theme-box").innerHTML = '<link rel="stylesheet" href="/forum/assets/theme/' + response.data + '.css">';
                }
            })
            .catch((error) => {
                throw new Error(error);
            })
        theme = n_theme;
    }

    if (n_language !== language) {
        axios
            .post("/forum/assets/api/language.php?language=" + n_language)
            .then((response) => {
                if (response.data.indexOf("error") === -1) {
                    
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
}

document.querySelector(".settings-reload").addEventListener("click", (e) => {s_check_changes(); window.location.reload();})

document.querySelectorAll(".option").forEach((element, index) => {element.addEventListener("click", (e) =>  {s_check_changes();})});



document.querySelector(".scheme-switch").addEventListener("click", (e) => {
    if (document.querySelector(".scheme-switch-box").checked) {
        document.querySelector(".scheme-box").innerHTML = "";
        document.querySelector(".scheme-box").innerHTML = '<link rel="stylesheet" href="/forum/assets/style/scheme-dark-file.css">';
        axios
            .post("/forum/assets/api/scheme.php", "scheme=dark")
            .then((response) => {
            })
            .catch((error) => {
                throw new Error(error);
            })
    } else {
        document.querySelector(".scheme-box").innerHTML = "";
        document.querySelector(".scheme-box").innerHTML = '<link rel="stylesheet" href="/forum/assets/style/scheme-light-file.css">';
        axios
            .post("/forum/assets/api/scheme.php", "scheme=light")
            .then((response) => {
            })
            .catch((error) => {
                throw new Error(error);
            })
    }
})