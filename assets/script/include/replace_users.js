var user_page = document.getElementById("upc");

function reset_users () {
    axios
        .post("/forum/assets/api/get_users.php")
        .then((resolve) => {
            set_users(resolve.data)
        }, (reject) => {console.debug(reject);})
        .catch((error) => {console.debug(error)})
}

function set_users (users) {
    document.getElementById("user-block-scroll").innerHTML = "";
    document.getElementById("user-block-scroll").innerHTML = users;
    document.querySelectorAll(".user-block-entry").forEach((element, index) => {
        element.addEventListener("click", (e) => {
            view(e.target.getAttribute("ref"));
        })
    })
}

