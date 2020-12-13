document.getElementById("language-switcher").addEventListener("click", () => {
    get_text("language-switcher-question").then(function (result) {
        let answer = prompt(result);
        let xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                window.location.reload();
            }
        }

        xhttp.open("POST", "/forum/assets/api/language.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("language=" + answer);
    })
})