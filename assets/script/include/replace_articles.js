var article_page = document.getElementById("apc");

function reset_articles () {
    axios
        .post("/forum/assets/api/get_articles.php")
        .then((resolve) => {
            set_articles(resolve.data)
        }, (reject) => {console.debug(reject);})
        .catch((error) => {console.debug(error)})
}

function set_articles (articles) {
    document.getElementById("article-block-scroll").innerHTML = "";
    document.getElementById("article-block-scroll").innerHTML = articles;
    document.querySelectorAll(".article-block-entry").forEach((element, index) => {
        element.addEventListener("click", (e) => {
            view(e.target.getAttribute("ref"));
        })
    })
}

