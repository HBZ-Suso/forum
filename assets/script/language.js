function set_language () {
    get_text("language-switcher-question").then(function (result) {
        window.prompt(result).then(() => {
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