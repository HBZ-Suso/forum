var change_article = false;
var content_el = document.getElementById("article-content");
var heading_el = document.querySelector(".article-block-title");

document.querySelector(".edit-btn").addEventListener("click", (e) => {
    if (content_el.disabled === false) {
        content_el.disabled = true;
        document.getElementById("userSubmit").style.display = "none";
        document.querySelector(".article-block-title").contentEditable = "false";
        change_article = false;
    } else {
        content_el.disabled = false;
        document.getElementById("userSubmit").style.display = "";
        change_article = true;
        document.querySelector(".article-block-title").contentEditable = "true";
    }
    document.querySelector(".user-settings-menu").style.display = "none";
})


var send_article_data = () => {
    let post_json = {"articleText": old_article_content, "articleTitle": old_article_heading.replace("\n", "")}
    let post_data = cur_Id + "&articleData=" + JSON.stringify(post_json);
    axios
        .post("/forum/assets/api/change_article.php", post_data)
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
var old_article_heading = heading_el.innerText;
content_el.addEventListener("keyup", (e) => {
    if (content_el.innerText !== old_article_content) {
        old_article_content = content_el.value;
        if (save === false) {
            save = true;
            setTimeout(() => {save = false; send_article_data();}, 3000);
        }
    }
})

heading_el.addEventListener("keyup", (e) => {
    if (heading_el.innerText !== old_article_heading) {
        old_article_heading = heading_el.innerText;
        if (save === false) {
            save = true;
            setTimeout(() => {save = false; send_article_data();}, 3000);
        }
    }
})

document.querySelector(".submitButton").addEventListener("click", (e) => {
    old_article_content = content_el.value;
    old_article_heading = heading_el.innerText;
    save = false; send_article_data();
})