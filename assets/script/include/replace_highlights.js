var article_page = document.getElementById("hpc");

function reset_highlights () {
    axios
        .post("/forum/assets/api/get_highlights.php")
        .then((resolve) => {
            set_highlights(resolve.data)
        }, (reject) => {console.debug(reject);})
        .catch((error) => {console.debug(error)})
}

function set_highlights (articles) {
    document.getElementById("highlight-block-scroll").innerHTML = "";
    document.getElementById("highlight-block-scroll").innerHTML = articles;
}

