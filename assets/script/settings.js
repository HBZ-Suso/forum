document.querySelector(".settings-save").addEventListener("click", () => {
    var theme = "";
    var language = "";
    document.querySelectorAll(".language_radio").forEach((element, index) => {
        if (element.checked) {
            language = element.id;
        }
    })
    document.querySelectorAll(".theme_radio").forEach((element, index) => {
        if (element.checked) {
            theme = element.id;
        }
    })

    // THEME
    axios
        .post("/forum/assets/api/theme.php", "theme=" + theme)
        .then((response) => {
            if (response.data === theme) {
                document.getElementById("theme-box").innerHTML = "";
                document.getElementById("theme-box").innerHTML = '<link rel="stylesheet" href="/forum/assets/theme/' + response.data + '.css">';
            }
        })
        .catch((error) => {
            throw new Error(error);
        })
    
    axios
        .post("/forum/assets/api/language.php?language=" + language)
        .then((response) => {
            if (response.data.indexOf("error") === -1) {
                window.location.reload();
            }
        })
        .catch((error) => {
            throw new Error(error);
        })
})