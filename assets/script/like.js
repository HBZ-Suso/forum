function like (event) {
    axios
        .post("/forum/assets/api/like.php", event.target.getAttribute("el_Id").replace("userId", "targetUserId"))
        .then((response) => {
            if (response.data == "Permissionerror") {
                window.location = "/forum/assets/site/login.php?refer=" + event.target.getAttribute("el_Id").replace("=", "-|-|-");
            }
            if (event.target.classList.contains("liked")) {
                event.target.classList.remove("liked");
            } else {
                event.target.classList.add("liked");
            }}
        )
        .catch((error) => {
            console.debug(error);
        })
}

