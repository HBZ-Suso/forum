function send_ajax_request (title, text, tags) {
    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            window.location = "/forum/?articleTitle=" + document.querySelector(".title").value;
        }
    };

    xhttp.open("POST", "/forum/assets/site/create_article.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("form=true&title=" + title + "&text=" +  text + "&tags=" + tags);
}

document.getElementById("submit-article").addEventListener("click", (e) => {
    e.preventDefault();

    if (document.querySelector(".title").value !== "" && document.querySelector(".text").value !== "") {
        send_ajax_request(document.querySelector(".title").value, document.querySelector(".text").value, document.querySelector(".tags").value);
    }
})