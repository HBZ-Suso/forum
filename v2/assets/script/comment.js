function set_comment_html (articleId) {
    axios
        .post("/forum/assets/api/get_comments.php?articleId=" + articleId)
        .then((resolve) => {
            if (document.querySelector(".viewbar-content-comments").classList.contains("comment-section-id-" + articleId)) {
                document.querySelector(".viewbar-content-comments").innerHTML = "";

                document.querySelector(".viewbar-content-comments").innerHTML += `
                    <div class="createcomment-container">
                        <input class="createcomment-title" type="text" placeholder="Title"></input>
                        <textarea class="createcomment-text" placeholder="Your comment..."></textarea>
                        <div class="createcomment-send-container"><img src="/forum/assets/img/icon/send.png" class="createcomment-send"></div>
                    </div>
                `;

                if (resolve.data !== false) {
                    resolve.data.forEach((element, index) => {
                        document.querySelector(".viewbar-content-comments").innerHTML += convert_comment_data_to_html(element);
                    })
                }

                document.querySelector(".createcomment-send-container").addEventListener("click", (e) => {
                    axios
                        .post("/forum/assets/api/comment.php?articleId=" + articleId + "&title=" + document.querySelector(".createcomment-title").value + "&text=" + document.querySelector(".createcomment-text").value)
                        .then((resolve) => {set_comment_html(articleId)}, (reject) => {throw new Error()})
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
    let creation_date = new Date(data.commentCreated);
    return `
    <div class="comment-container">
        <div class="comment-header">
            <div class="comment-title">${data.commentTitle}</div>
            <div class="comment-author">
                <img src="/forum/assets/img/icon/user.svg" class="author-profile-color-overlay-${data.userColor}">
                <div class="comment-author-info">
                    Created by <a href="#Profile?userId=1">${data.userName}</a><br>
                    on <p>${ordinal_suffix_of(creation_date.getDate())} ${get_month_name(creation_date.getMonth() + 1)} ${creation_date.getFullYear()}</p>
                </div>
            </div>
        </div>
        <div class="comment-text">${data.commentText}</div>
    </div>
    `;
}