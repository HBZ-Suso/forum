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
    if (article_data === undefined || article_data == null) {
        return "";
    }

    if (article_data["articleComments"] == false) {
        article_data["articleComments"] = 0;
    }
    
    let icon = ``;
    if (article_data["articlePinned"] == 1) {
        icon = `<img src="/forum/assets/img/icon/pinned.png">`;
    } else {
        icon = `<img src="/forum/assets/img/icon/article.svg">`;
    }
    return `
    <div class="selectbar-article-element selectbar-article-element-${article_data["articleId"]}" onclick="window.location.hash=\'#Article?articleId=${article_data["articleId"]}\'">
        ${icon}
        <h1>${article_data["articleTitle"]}</h1>
        <div>
            <p>${language_data["v2-article-by"]}<a onclick="event.stopPropagation();" href="#Profile?userId=${article_data["userId"]}" class="findings-article-author" authorId="${article_data["userId"]}">${article_data["userName"]}</a> •</p>
            <p>${article_data["articleComments"]}${language_data["v2-article-comments"]}</a> •</p>
            <p>${article_data["articleViews"]}${language_data["v2-article-views"]}</a> •</p>
            <p>${article_data["articleLikes"]}${language_data["v2-article-likes"]}</p>
        </div>
    </div>
    `;
}


function update_articles (category, max=500) {
    let search = document.querySelector(".selectbar-" + category + "-search").value;
    let container = document.querySelector(".selectbar-" + category + "-article-container");
    let use_array = [];
    let special_array = [];
    articleIds[category].forEach((element, index) => {
        use_array.push(element["articleTitle"]);
        special_array.push([element["articleId"], element["articleCreated"], element["articlePinned"]]);
    })
    let listed = find_matching(search, use_array, 120, special_args=special_array);
    container.innerHTML = "";
    let final_array = [];
    listed.forEach((element, index) => {
        final_array.push({"prox": element["prox"], "articleTitle": element["string"], "articleCreated": element["special"][1], "articleId": element["special"][0], "articlePinned": element["special"][2]})
    })
    final_array = final_array.filter((element, index) => {return element["prox"] >= 0.4;});
    final_array.sort((a, b) => {
        try {
            if (a["articlePinned"] == 1 && !b["articlePinned"] == 1) {
                return -1;
            } else if (b["articlePinned"] == 1 && !a["articlePinned"] == 1) {
                return 1;
            } else if (b["articlePinned"] == 1 && a["articlePinned"] == 1) {
                return 0;
            }


            if (get_sort(category)["conv"] == "articleCreated") {
                a = new Date(a["articleCreated"]).getTime()
                b = new Date(b["articleCreated"]).getTime();
            } else {
                a = articleList[a["articleId"]][get_sort(category)["conv"]];
                b = articleList[b["articleId"]][get_sort(category)["conv"]];
            }
            if (get_sort(category)["down"]) {
                return b - a;
            } else {
                return a - b;
            }
        } catch (e) {
            return 1;
        }
        
    })
    final_array.splice(max);

    document.querySelector(".selectbar-" + category + "-article-container").innerHTML = "";

    final_array.map((element) => {document.querySelector(".selectbar-" + category + "-article-container").innerHTML += get_article_entry_html(articleList[element["articleId"]]);})

    // Performance improvement: only check best results of last search?

    try {update_authors();} catch (e) {console.debug(e);}
}

function update_authors () {
    document.querySelectorAll(".findings-article-author").forEach((element, index) => {
        element.innerText = users[element.getAttribute("authorId")]["userName"];
    })
}


function set_sort (element, category) {
    if (!element.classList.contains("selectbar-sort-toggled")) {
        document.querySelectorAll(".selectbar-" + category + "-sort").forEach((element, index) => {element.classList.remove("selectbar-sort-toggled");})
        element.classList.add("selectbar-sort-toggled");
    } else {
        if (element.classList.contains("selectbar-sort-down")) {
            element.classList.remove("selectbar-sort-down");
            element.classList.add("selectbar-sort-up");
        } else {
            element.classList.add("selectbar-sort-down");
            element.classList.remove("selectbar-sort-up");
        }
    }

    update_articles(category);
}

function get_sort (category) {
    let sort = "created";
    let down = true;
    document.querySelectorAll(".selectbar-" + category + "-sort").forEach((element, index) => {if (element.classList.contains("selectbar-sort-toggled")) {sort = element.getAttribute("sortname"); down = element.classList.contains("selectbar-sort-down")}})
    let sort_conv = {"created": "articleCreated", "comments": "articleComments", "views": "articleViews", "likes": "articleLikes"}[sort];
    return {"sort": sort, "down": down, "conv": sort_conv};
}