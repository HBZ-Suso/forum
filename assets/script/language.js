function set_language () {
    get_text("language-switcher-question").then(function (result) {
        var language_prompt_answer = prompt(result);

        axios
            .post("/forum/assets/api/language.php?language=" + language_prompt_answer)
            .then((response) => {
                window.location.reload();
            })
            .catch((error) => {
                throw new Error(error);
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