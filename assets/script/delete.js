var delete_element = document.querySelector(".delete-btn");

delete_element.addEventListener("click", (e) => {
    if (delete_element.style.backgroundColor === "yellow") {
        if (cur_username === false) {
            window.location = "/forum/assets/site/login.php?refer=" + cur_Id.replace("=", "-|-|-");
        }

        axios
            .post("/forum/assets/api/delete.php", cur_Id)
            .then((response) => {
                window.location = "/forum/";
            })
            .catch((error) => {
                throw new Error(error);
            })
    } else {
        delete_element.style.backgroundColor = "yellow";
    }
})
