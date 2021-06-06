var content_displayed = false;
function show_article (custum_html=false, heading="", content_html="") {

    if (custum_html == false) {
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

            let logged_in_tools = "";

            if (logged_in) {
                logged_in_tools += `<button class="viewbar-content-toolbar-like" onclick="like_article('${articleId}')">${language_data["v2-share-like"]}</button>`;
            }

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
                    ${logged_in_tools}
                    <button class="viewbar-content-toolbar-share" onclick="share('HBZ-Forum: ${resolve.data.articleTitle}', '${window.location.toString().replace(window.location.hash, "") + "#Article?articleId=" + resolve.data.articleId}')">${language_data["v2-share-share"]}</button>
                    <button class="viewbar-content-toolbar-copy" onclick="article_copy_handler('Article?articleId=${resolve.data.articleId}')"/>${language_data["v2-share-link"]}</button>
                    <button class="viewbar-content-toolbar-report" onclick="window.location.hash='#Report?articleId=${resolve.data.articleId}';">${language_data["v2-share-report"]}</button>
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

            if (logged_in) {
                if (resolve.data.liked) {
                    document.querySelector(".viewbar-content-toolbar-like").style.backgroundColor = "var(--liked-color)";
                }
            }

            axios.post("/forum/v2/assets/api/view.php?articleId=" + articleId).then((resolve) => {if (resolve.data.indexOf("error") === -1) {articleList[articleId].articleViews += 1;}}, (reject) => {throw new Error(reject)}).catch((e) => console.debug)

            set_comment_html(resolve.data.articleId);
        }, (reject) => {
            console.debug("Error whilst trying to get article data from api.");
        })
    } else {
        document.querySelector(".viewbar-empty").style.display = "none";
        document.querySelector(".viewbar-content").innerHTML = `
            <div class="viewbar-content-heading">${heading}</div>
            ${content_html}
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
    }
}



function article_copy_handler (hash) {
    copyToClipboard(window.location.toString().replace(window.location.hash, "") + "#" + hash)
}

function close_article () {
    if (document.querySelector(".viewbar-content").innerHTML.length <= 0) {
        return;
    }

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

    /* Sets hash back to last stable view before view */
    let current_hash = window.location.hash;
    let found = false;
    hash_history.reverse().forEach((element, index) => {
        if (element.state !== current_hash && found === false) {
            let usable = false;
            categories.concat(["Article"]).forEach((category, c_index) => {
                if (element.state.replace("#", "").indexOf(category) !== -1) {
                    usable = true;
                }
            })


            if (usable == true) {
                hash_history.reverse();
                window.location.hash=element.state;
                found = true;
            }
            
        }
    })
    if (found === false) {
        hash_history.reverse();
        window.location.hash="Home";
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

    if (window.location.hash.indexOf("#Article") !== -1) {
        show_article();
    }

    document.querySelector(".viewbar-close").addEventListener("click", (e) => {close_article();});
});




function like_article (articleId) {
    axios
        .post("/forum/assets/api/like.php?articleId=" + articleId)
        .then((resolve) => {if (document.querySelector(".viewbar-content-toolbar-like").style.backgroundColor == "var(--liked-color)") {document.querySelector(".viewbar-content-toolbar-like").style.backgroundColor = ""; articleList[articleId].articleLikes -= 1;} else {document.querySelector(".viewbar-content-toolbar-like").style.backgroundColor = "var(--liked-color)"; articleList[articleId].articleLikes += 1;};})
}