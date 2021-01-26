function set_language () {
    get_text("language-switcher-question").then(function (result) {
        axios
            .post("/forum/assets/api/get_languages.php")
            .then((languages) => {
                if (languages.data.length > 1) {
                    var language_str = languages.data.join(", ");
                } else {
                    var language_str = languages.data.join("");
                }
                window.prompt(result, language_str).then(() => {
                var language_prompt_answer = document.getElementById("q-input").value;

                if (language_prompt_answer.length > 0) {
                    axios
                    .post("/forum/assets/api/language.php?language=" + language_prompt_answer)
                    .then((response) => {
                        if (response.data.indexOf("error") === -1) {
                            window.location.reload();
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
        .catch((e) => {throw new Error(e)});
    });
}

if (document.getElementById("language-switcher") !== null) {
    document.getElementById("language-switcher").addEventListener("click", set_language);
}


window.addEventListener("keyup", (e) => {
    if ((e.key === "r" || e.key === "R") && e.altKey === true) {
        e.preventDefault();
        set_language();
    }
})