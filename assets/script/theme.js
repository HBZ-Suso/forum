document.getElementById("theme-switcher").addEventListener("click", () => {
    get_text("theme-switcher-question").then(function (result) {
        let answer = prompt(result);
        let xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                document.getElementById("theme-box").innerHTML = "";
                document.getElementById("theme-box").innerHTML = '<link rel="stylesheet" href="/forum/assets/theme/' + this.responseText + '.css">';
            }
        }

        xhttp.open("POST", "/forum/assets/api/theme.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("theme=" + answer);
    })
})