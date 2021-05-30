var content_displayed = false;
function show_article () {
    document.querySelectorAll(".selectbar-article-element").forEach((element, index) => {
        try {
            element.classList.remove("selectbar-article-element-selected");
        } catch (e) {
            console.debug(e);
        }
    })

    let articleId = window.location.toString().slice(window.location.toString().indexOf("articleId=") + 10);
    if (articleId.indexOf("&") != -1) {
        articleId.slice(0, articleId.indexOf("&"));
    }
    try {
        articleId = parseInt(articleId);
    } catch (e) {
        console.debug("Error whilst trying to parse articleId");
    }

    axios
        .post("/forum/assets/api/get_article.php?articleId=" + articleId)
        .then((resolve) => {
            try {
                document.querySelector(".selectbar-article-element-" + articleId).classList.add("selectbar-article-element-selected");
            } catch (e) {
                console.debug(e);
            }

            let creation_date = new Date(resolve.data.articleCreated);

            document.querySelector(".viewbar-empty").style.display = "none";
            document.querySelector(".viewbar-content").innerHTML = `
                <div class="viewbar-content-heading">${resolve.data.articleTitle}</div>
                <div class="viewbar-content-author">
                    <img src="/forum/assets/img/icon/user.svg" class="author-profile-color-overlay-${resolve.data.userColor}">
                    <div class="viewbar-content-author-info">
                        ${language_data["v2-author-message-1"]}<a href="#Profile?userId=1">${resolve.data.userName}</a><br>
                        ${language_data["v2-author-message-2"]}<p>${ordinal_suffix_of(creation_date.getDate())} ${get_month_name(creation_date.getMonth() + 1)} ${creation_date.getFullYear()}</p>
                    </div>
                </div>
                <div class="viewbar-content-text">${resolve.data.articleText}</div>
                <div class="viewbar-content-toolbar">
                    <button class="viewbar-content-toolbar-share" onclick="share('HBZ-Forum: ${resolve.data.articleTitle}', '${window.location.toString().replace(window.location.hash, "") + "#Article?articleId=" + resolve.data.articleId}')">${language_data["v2-share-share"]}</button>
                    <button class="viewbar-content-toolbar-copy" onclick="article_copy_handler('Article?articleId=${resolve.data.articleId}')"/>${language_data["v2-share-link"]}</button>
                    <button class="viewbar-content-toolbar-report">${language_data["v2-share-report"]}</button>
                </div>
                <div class="viewbar-content-comments comment-section-id-${resolve.data.articleId}">
                </div>
            `;
            if (window.innerWidth < 1500 || window.mobileCheck() == true) {
                document.querySelector(".viewbar-container").style.display = "";
                content_displayed = true;
            }
            if (window.innerWidth > 1500  && window.mobileCheck() == false) {
                document.querySelector(".viewbar-container").style.display = "";
                content_displayed = false;
            }
            set_comment_html(resolve.data.articleId)
        }, (reject) => {
            console.debug("Error whilst trying to get article data from api.");
        })
}



function article_copy_handler (hash) {
    copyToClipboard(window.location.toString().replace(window.location.hash, "") + "#" + hash)
}

function close_article () {
    document.querySelector(".viewbar-container").style.display = "none";
    document.querySelector(".viewbar-content").innerHTML = "";
    document.querySelector(".viewbar-empty").style.display = "";
    content_displayed = false;
    document.querySelectorAll(".selectbar-article-element").forEach((element, index) => {
        try {
            element.classList.remove("selectbar-article-element-selected");
        } catch (e) {
            console.debug(e);
        }
    })

    /* Sets hash back to last before article view */
    let iter = 0;
    while (categories.indexOf(window.location.hash.slice(1)) === -1) {
        window.location.hash = hash_history[hash_history - 1 - iter * 2];
        hash_history.pop();
        hash_history.pop();
        /* Fallback if hash_history empty */
        if (hash_history.length < 1) {
            window.location.hash = "Home";
        }
    }
}

function close_article_if_not_side_by_side () {
    if (window.innerWidth < 1500 || window.mobileCheck() == true) {
        close_article()
    }
}

window.onresize = function () {
    if (window.innerWidth < 1500 || window.mobileCheck() == true) {
        if (document.querySelector(".viewbar-content").innerHTML.length <= 0) {
            document.querySelector(".viewbar-container").style.display = "none";
        }
    } else {
        document.querySelector(".viewbar-container").style.display = "";
    }
}

window.addEventListener("load", () => {
    if (window.innerWidth > 1500  && window.mobileCheck() == false) {
        document.querySelector(".viewbar-container").style.display = "";
        content_displayed = false;
    }

    document.querySelector(".viewbar-close").addEventListener("click", (e) => {
        if (window.innerWidth < 1500 || window.mobileCheck() == true) {
            close_article();
        }
    })

    if (window.location.hash.indexOf("#Article") !== -1) {
        show_article();
    }

    document.querySelector(".viewbar-close").addEventListener("click", (e) => {close_article();});
});
