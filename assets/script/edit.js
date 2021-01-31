var change_article = false;
var content_el = document.getElementById("article-content");

document.querySelector(".edit-btn").addEventListener("click", (e) => {
    if (content_el.disabled === false) {
        content_el.disabled = true;
        document.getElementById("userSubmit").style.display = "none";
        change_article = false;
    } else {
        content_el.disabled = false;
        document.getElementById("userSubmit").style.display = "";
        change_article = true;
    }
})


var send_article_data = () => {
    axios
        .post("/forum/assets/api/change_article.php?" + cur_Id + "&articleText=" + old_article_content)
        .then((response) => {
            document.getElementById("userSubmit").style.backgroundColor = "green";
            setTimeout(() => {document.getElementById("userSubmit").style.backgroundColor = ""}, 1500);
        })
        .catch((error) => {
            console.debug(error);
        })
}

var save = false;
var old_article_content = content_el.value;
content_el.addEventListener("keyup", (e) => {
    if (content_el.innerText !== old_article_content) {
        old_article_content = content_el.value;
        if (save === false) {
            save = true;
            setTimeout(() => {save = false; send_article_data();}, 3000);
        }
    }
})

document.querySelector(".submitButton").addEventListener("click", (e) => {
    console.log(old_article_content);
    old_article_content = content_el.value;
    save = false; send_article_data();
})