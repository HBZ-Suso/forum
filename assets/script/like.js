var like_element = document.querySelector(".like-btn");

like_element.addEventListener("click", (e) => {
    if (cur_username === false) {
        window.location = "/forum/assets/site/login.php?refer=" + cur_Id.replace("=", "-|-|-");
    }

    axios
        .post("/forum/assets/api/like.php", cur_Id.replace("userId", "targetUserId"))
        .then((response) => {
            if (like_element.classList.contains("liked")) {
                like_element.classList.remove("liked");
            } else {
                like_element.classList.add("liked");
            }}
        )
        .catch((error) => {
            console.debug(error);
        })
})