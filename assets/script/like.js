var like_element = document.querySelector(".like-btn");

like_element.addEventListener("click", (e) => {
    if (cur_username === false) {
        window.location = "/forum/assets/site/login.php?refer=" + cur_Id.replace("=", "-|-|-");
    }

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            if (like_element.classList.contains("liked")) {
                like_element.classList.remove("liked");
            } else {
                like_element.classList.add("liked");
            }
        }
    }

    xhttp.open("POST", "/forum/assets/api/like.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(cur_Id.replace("userId", "targetUserId"));
})