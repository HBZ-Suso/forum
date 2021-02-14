var article_page = document.getElementById("hpc");

function reset_highlights () {
    axios
        .post("/forum/assets/api/get_highlights.php")
        .then((resolve) => {
            set_highlights(resolve.data);
        }, (reject) => {console.debug(reject);})
        .catch((error) => {console.debug(error)})
}

function set_highlights (highlights) {
    document.getElementById("highlight-block-scroll").innerHTML = "";
    document.getElementById("highlight-block-scroll").innerHTML = highlights;
    document.querySelectorAll(".highlights-block-entry").forEach((element, index) => {
        element.addEventListener("click", (e) => {
            view(e.target.getAttribute("ref"));
        })
    })
}

