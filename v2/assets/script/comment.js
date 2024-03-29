function set_comment_html (articleId) {
    axios
        .post("/forum/assets/api/get_comments.php?articleId=" + articleId)
        .then((resolve) => {
            if (document.querySelector(".viewbar-content-comments").classList.contains("comment-section-id-" + articleId)) {
                document.querySelector(".viewbar-content-comments").innerHTML = "";

                if (logged_in) {
                    document.querySelector(".viewbar-content-comments").innerHTML += `
                    <div class="createcomment-container">
                        <input class="createcomment-title" type="text" placeholder="${language_data["v2-comment-title"]}"></input>
                        <textarea class="createcomment-text" placeholder="${language_data["v2-comment-text"]}"></textarea>
                        <div class="createcomment-send-container"><img src="/forum/assets/img/icon/send.png" class="createcomment-send"></div>
                    </div>
                `;
                }

                if (resolve.data !== false) {
                    resolve.data.forEach((element, index) => {
                        document.querySelector(".viewbar-content-comments").innerHTML += convert_comment_data_to_html(element);

                        /* RATELIMITED
                        if (getCookie("autle") !== "onlyprofiles" && getCookie("autle") !== "off") {
                            try {translate(element.commentTitle).then((text) => {document.querySelector(".comment-title-id-" + element.commentId).innerHTML = text;})} catch (e) {console.debug(e)}
                            try {translate(element.commentText).then((text) => {document.querySelector(".comment-text-id-" + element.commentId).innerHTML = text;})} catch (e) {console.debug(e)}
                        } */
                    })
                }

                document.querySelector(".createcomment-send-container").addEventListener("click", (e) => {
                    axios
                        .post("/forum/assets/api/comment.php?articleId=" + articleId + "&title=" + document.querySelector(".createcomment-title").value + "&text=" + document.querySelector(".createcomment-text").value)
                        .then((resolve) => {set_comment_html(articleId); articleList[articleId].articleComments += 1;}, (reject) => {throw new Error()})
                        .catch((error) => {console.debug(error);})
                })
            } else {
                // Already opened another article or closed old one - exit
                throw new Error();
            }
        }, (reject) => {
            throw new Error()
        })
        .catch((error) => {console.debug(error);})
}


function convert_comment_data_to_html (data) {
    let creation_date = new Date(data.commentCreated * 1000);
    let comment_delete = ``;
    if (logged_in && user_type == "administrator") {
        comment_delete = `<div class="comment-delete" onclick="delete_comment('${data.articleId}', '${data.commentId}')"><img src="/forum/assets/img/icon/delete.png"></div>`
    }
    return `
    <div class="comment-container">
        <div class="comment-header">
            <div class="comment-title comment-title-id-${data.commentId}">${data.commentTitle}</div>
            <div class="comment-author">
                <img src="${profilePictureUrlByUserId(data.userId)}" class="">
                <div class="comment-author-info">
                    ${language_data["v2-author-message-1"]}<a href="#Profile?userId=1">${data.userName}</a><br>
                    ${language_data["v2-author-message-2"]}<p>${ordinal_suffix_of(creation_date.getDate())} ${get_month_name(creation_date.getMonth() + 1)} ${creation_date.getFullYear()}</p>
                </div>
            </div>
        </div>
        <div class="comment-text comment-text-id-${data.commentId}">${data.commentText}</div>
        ${comment_delete}
    </div>
    `;
}


function delete_comment (articleId, commentId) {
    // ArticleId is only to show that the comment is meant for articles and not users
    if (confirm(language_data["v2-comment-delete"])) {
        axios
            .post("/forum/assets/api/delete_comment.php?articleId=1&commentId=" + commentId)
            .then((resolve) => {set_comment_html(articleId);}, (reject) => {throw new Error(reject)})
            .catch((e) => console.debug)
    }
}