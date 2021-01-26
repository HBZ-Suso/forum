var lock_element = document.querySelector(".lock-user");

lock_element.addEventListener("click", (e) => {
    if (cur_username === false) {
        window.location = "/forum/assets/site/login.php?refer=" + cur_Id.replace("=", "-|-|-");
    }

    axios
        .post("/forum/assets/api/lock.php?" + cur_Id)
        .then((response) => {
            console.log("Success...");
            if (document.getElementById("locked").style.display !== "none") {
                document.getElementById("locked").style.display = "none";
            } else {
                document.getElementById("locked").style.display = "block";
            }
            
            lock_element.style.backgroundColor = "";
        })
        .catch((error) => {
            console.debug(error);
        })
})