var delete_comment = async (commentId) => {
    if (document.getElementById(commentId).style.backgroundColor === "yellow") {
        axios
        .post("/forum/assets/api/delete_comment.php", cur_Id + "&commentId=" + commentId.replace("comment-element-", ""))
        .then((response) => {
            let comments = refresh_comments();
            return comments;
        })
        .catch((error) => {
            throw new Error(error);
        })
    } else {
        document.getElementById(commentId).style.backgroundColor = "yellow";
    }
}

let delete_button;

async function create_new_comment (title, text, id, user) {
    delete_button = "";
    if (cur_username !== false) {
        var delete_button = '<button class="comment-delete" id="comment-element-' + id + '">Delete</button>'
    }

    let element =  '<div class="comment theme-main-color-1" id="comment-id-' + id + '">' + 
    '<h3 class="comment-title theme-main-color-1">' + 
    title + 
    '</h3>' +
    '<h3 class="comment-author theme-main-color-1">' +
    user +
    '</h3>' +
    '<textarea class="comment-text theme-main-color-1" disabled>' + text + '</textarea>' + 
    delete_button +
    '</div>'

    document.getElementById("js_comments").insertAdjacentHTML("afterbegin", element);

    if (cur_username !== false) {
        document.getElementById("comment-element-" + id).addEventListener("click", (e) => { delete_comment(e.target.id);});
    }

    return true;
}


var refresh_comments = async () => {
    axios
        .post("/forum/assets/api/get_comments.php", cur_Id)
        .then((response) => {
            console.log(response)
            let comments = response.data;
            if (comments.length > 0) {
                comments.reverse();
            }
            document.getElementById("js_comments").innerHTML = "";
            for (let key in comments) {
                let element = comments[key];
                create_new_comment(element["commentTitle"], element["commentText"], element["commentId"], element["username"])
            }
            return true;
        })
        .catch((error) => {
            throw new Error(error);
        })
}


async function submit_comment_ajax (title, text) {
    if (cur_username === false) {
        throw new Error("Not logged in");
    }

    axios
        .post("/forum/assets/api/comment.php", cur_Id + "&title=" + title + "&text=" +  text)
        .then((response) => {
            console.log(response)
            if (response.data === "Timeouterror") {
                let styling = [".comment-form", ".comment-text", ".comment-title", ".comment-author"]
                styling.forEach((element, index) => {
                    document.querySelector(element).style.transition = "0.5s all ease-out";
                    document.querySelector(element).style.backgroundColor = "red";
                    document.querySelector(element).style.transition = "none";
                    
                })
                setTimeout((e) => {
                    let styling = [".comment-form", ".comment-text", ".comment-title", ".comment-author"]
                    styling.forEach((element, index) => {
                        document.querySelector(element).style.transition = "1s all ease-out";
                        document.querySelector(element).style.backgroundColor = "";
                        document.querySelector(element).style.transition = "none";
                        
                    }) 
                }, 1000);
            }
        })
        .catch((error) => {
            throw new Error(error);
        })
    return true;
}

if (cur_username !== false) {
    document.getElementById("submit-comment").addEventListener("click", (e) => {
        e.preventDefault();

        if (document.querySelector(".comment-text").value !== "" && document.querySelector(".comment-title").value !== "") {
            submit_comment_ajax(document.querySelector(".comment-title").value, document.querySelector(".comment-text").value);
        }
    })
}




var reload_loop = () => {
    refresh_comments().then(() => {try {document.getElementById("loading-comments-info").remove();} catch (e) {console.log(e);}}, () => {try {document.getElementById("loading-comments-info").innerText = "Failed to load comments";} catch (e) {console.log(e);}});
    setTimeout(() => {
        reload_loop();
    }, 10000);
}

reload_loop();