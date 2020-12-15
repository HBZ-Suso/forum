document.getElementById("theme-switcher").addEventListener("click", () => {
    get_text("theme-switcher-question").then(function (result) {
        let answer = prompt(result);

        axios
            .post("/forum/assets/api/theme.php", "theme=" + answer)
            .then((response) => {
                document.getElementById("theme-box").innerHTML = "";
                document.getElementById("theme-box").innerHTML = '<link rel="stylesheet" href="/forum/assets/theme/' + response.data + '.css">';
            })
            .catch((error) => {
                throw new Error(error);
            })
    })
})