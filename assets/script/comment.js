var delete_comment = (cur_Id, commentId) => {
    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText)
            document.getElementById("comment-id-" + this.responseText).remove();
        }
    };

    xhttp.open("POST", "/forum/assets/site/delete_comment.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(cur_Id + "&commentId=" + commentId);
}


function create_new_comment () {
    let element =  '<div class="comment theme-main-color-1" id="comment-id-' + new_comments[new_comments.length - 1]["id"] + '">' + 
    '<h3 class="comment-title theme-main-color-1">' + 
    new_comments[new_comments.length - 1]["title"] + 
    '</h3>' +
    '<h3 class="comment-author theme-main-color-1">' +
    cur_username +
    '</h3>' +
    '<textarea class="comment-text theme-main-color-1" disabled>' + new_comments[new_comments.length - 1]["text"] + '</textarea>' + 
    '<button class="comment-delete" commentId=' + new_comments[new_comments.length - 1]["id"] + ' id="comment-element-' + new_comments[new_comments.length - 1]["id"] * 1342 + 234 + '">Delete</button>' +
    '</div>'

    document.getElementById("new_comments").insertAdjacentHTML("afterbegin", element);

    document.getElementById("comment-element-" + new_comments[new_comments.length - 1]["id"] * 1342 + 234).addEventListener("click", (e) => { delete_comment(cur_id, e.target.getAttribute("commentId"));});
}

let new_comments = [];

function submit_comment_ajax (title, text) {
    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            new_comments.push({title: document.querySelector(".comment-title").value, text: document.querySelector(".comment-text").value, id: this.responseText})
            create_new_comment();

            document.querySelector(".comment-title").value = "";
            document.querySelector(".comment-text").value = "";
        }
    };

    xhttp.open("POST", "/forum/assets/site/comment.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(cur_id + "&title=" + title + "&text=" +  text);
}

document.getElementById("submit-comment").addEventListener("click", (e) => {
    e.preventDefault();

    if (document.querySelector(".comment-text").value !== "" && document.querySelector(".comment-title").value !== "") {
        submit_comment_ajax(document.querySelector(".comment-text").value, document.querySelector(".comment-title").value);
    }
})
