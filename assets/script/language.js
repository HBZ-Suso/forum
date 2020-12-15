document.getElementById("language-switcher").addEventListener("click", () => {
    get_text("language-switcher-question").then(function (result) {
        let answer = prompt(result);

        axios
            .post("/forum/assets/api/language.php", "language=" + answer)
            .then((response) => {
                window.location.reload();
            })
            .catch((error) => {
                throw new Error(error);
            })
    })
})