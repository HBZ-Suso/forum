function send_ajax_request (title, text, tags) {
    axios
        .post("/forum/assets/site/create_article.php", "form=true&title=" + title + "&text=" +  text + "&tags=" + tags)
        .then((response) => {
            window.location = "/forum/?articleTitle=" + document.querySelector(".title").value;
        })
        .catch((error) => {
            throw new Error(error);
        })
}

document.getElementById("submit-article").addEventListener("click", (e) => {
    e.preventDefault();

    if (document.querySelector(".title").value !== "" && document.querySelector(".text").value !== "") {
        send_ajax_request(document.querySelector(".title").value, document.querySelector(".text").value, document.querySelector(".tags").value);
    }
})