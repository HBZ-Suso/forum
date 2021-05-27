var articleIds = {};
var articleList = {};
var users = {};

window.onload = () => {
    categories.forEach((element, index) => {
        axios
            .post("/forum/v2/assets/api/get_articleIds_by_category.php?category=" + element)
            .then((resolve) => {
                if (resolve.data === false) {
                    articleIds[element] = [];
                } else {
                    articleIds[element] = resolve.data;
                    resolve.data.forEach((element, index) => {
                        articleList[element["articleId"]] = element;
                    })
                    update_articles(element);
                }
            }, (reject) => {console.debug(reject)})
            .catch((e) => {
                console.debug(e);
            })
    })

    axios
        .post("/forum/v2/assets/api/get_usernames.php")
        .then((resolve) => {
            if (resolve.data === false) {
                users = {};
            } else {
                resolve.data.forEach((element, index) => {
                    users[element["userId"]] = element;
                })
                update_authors();
            }
        }, (reject) => {console.debug(reject)})
        .catch((e) => {
            console.debug(e);
        })
}


function get_article_entry_html (article_data) {
    return `
    <div class="selectbar-article-element selectbar-article-element-${article_data["articleId"]}" onclick="window.location.hash=\'#Article?articleId=${article_data["articleId"]}\'">
        <img src="/forum/assets/img/icon/article.svg">
        <h1>${article_data["articleTitle"]}</h1>
        <div>
            <p>Geschrieben von <a onclick="event.stopPropagation();" href="#Profile?userId=${article_data["userId"]}" class="findings-article-author" authorId="${article_data["userId"]}">${article_data["userName"]}</a></p>
            <!--TOO COMPLICATED????<p>14 Kommentare</a> •</p>
            <p>Letzte Antwort um 17 Uhr</p>-->
        </div>
    </div>
    `;
}


function update_articles (category) {
    let search = document.querySelector(".selectbar-" + category + "-search").value;
    let container = document.querySelector(".selectbar-" + category + "-article-container");
    let use_array = [];
    let special_array = [];
    articleIds[category].forEach((element, index) => {
        use_array.push(element["articleTitle"]);
        special_array.push(element["articleId"])
    })
    let listed = find_matching(search, use_array, 120, special_args=special_array);
    container.innerHTML = "";

    listed.forEach((element, index) => {
        if (index < 30 && element["prox"] > 0.2) {
            container.innerHTML += get_article_entry_html(articleList[element.special]);
        }
    })

    // Performance improvement: only check best results of last search?

    try {update_authors();} catch (e) {console.debug(e);}
}

function update_authors () {
    document.querySelectorAll(".findings-article-author").forEach((element, index) => {
        element.innerText = users[element.getAttribute("authorId")]["userName"];
    })
}