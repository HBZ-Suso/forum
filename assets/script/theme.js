function set_theme () {
    get_text("theme-switcher-question").then(function (result) {
        axios
            .post("/forum/assets/api/get_themes.php")
            .then((themes) => {
                if (themes.data.length > 1) {
                    var theme_str = themes.data.join(", ");
                } else {
                    var theme_str = themes.data.join("");
                }
                window.c_prompt(result, theme_str).then(() => {
                    var theme_prompt_answer = document.getElementById("q-input").value;
        
                    if (theme_prompt_answer !== "") {
                        axios
                        .post("/forum/assets/api/theme.php", "theme=" + theme_prompt_answer)
                        .then((response) => {
                            if (response.data === theme_prompt_answer) {
                                document.getElementById("theme-box").innerHTML = "";
                                document.getElementById("theme-box").innerHTML = '<link rel="stylesheet" href="/forum/assets/theme/' + response.data + '.css">';
                            }
                        })
                        .catch((error) => {
                            throw new Error(error);
                        })
                    }
                }).catch(() => {
                    console.debug("Prompt error");
                })
            })
            .catch((error) => {
                throw new Error(error);
            })
    })
}

if (document.getElementById("theme-switcher") !== null) {
    document.getElementById("theme-switcher").addEventListener("click", set_theme)
}

window.addEventListener("keydown", (e) => {
    if ((e.key === "t" || e.key === "T") && e.altKey === true) {
        e.preventDefault();
        set_theme();
    }
})
